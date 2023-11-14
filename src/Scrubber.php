<?php

namespace ClntDev\Scrubber;

use ClntDev\Scrubber\Contracts\DatabaseHandler;
use ClntDev\Scrubber\Contracts\Logger;
use ClntDev\Scrubber\Contracts\ScrubHandler;
use ClntDev\Scrubber\Util\ConfigurationParser;
use Throwable;

class Scrubber
{
    private ConfigurationParser $parser;

    private DatabaseHandler $database;

    private Logger $logger;

    public function __construct(
        string $configPath,
        DatabaseHandler $database,
        Logger $logger
    ) {
        $this->database = $database;
        $this->logger = $logger;
        $this->parser = ConfigurationParser::make($configPath);
    }

    public static function make(string $configPath, DatabaseHandler $database, Logger $logger): self
    {
        return new self($configPath, $database, $logger);
    }

    public function run(): bool
    {
        $scrubHandlers = $this->parser->parse();

        try {
            foreach ($scrubHandlers as $scrubHandler) {
                $this->runHandler($scrubHandler);
            }
        } catch (Throwable $exception) {
            $this->logger->log($exception);

            return false;
        }

        return true;
    }

    public function getTableList(): array
    {
        return $this->parser->parseTables();
    }

    public function getIgnoredTableList(): array
    {
        return $this->parser->parseTables(false);
    }

    public function getFieldList(string $type = 'pid'): array
    {
        return array_values(array_filter(array_map(
            static fn (ScrubHandler $handler): ?string => $handler->getType() === $type ? $handler->getField() : null,
            array_values($this->parser->parse())
        )));
    }

    public function getFieldListAsString(string $type = 'pid'): string
    {
        return implode(',', $this->getFieldList($type));
    }

    protected function runHandler(ScrubHandler $handler): void
    {
        foreach ($this->database->fetch(
            $handler->getTable(),
            $handler->getPrimaryKey()
        ) as $primaryKeyValues) {
            $this->validatePrimaryKeyValues($handler, $primaryKeyValues);
            $handler->scrub($primaryKeyValues, $this->database);
        }
    }

    protected function validatePrimaryKeyValues(
        ScrubHandler $handler,
        mixed $primaryKeyValues
    ): void {
        $primaryKey = $handler->getPrimaryKey();

        if ($primaryKey->isComposite() === false) {
            return;
        }

        if (is_array($primaryKeyValues) === false) {
            throw new Exceptions\CompositePrimaryKeyError(<<<EOM
                The configuration file indicates {$handler->getTable()}.{$handler->getField()} has a composite
                primary key. but the database did not return an array ({$primaryKeyValues}).
                EOM);
        }

        $primaryKeyCount = $primaryKey->count();
        $valueCount = count($primaryKeyValues);

        if ($primaryKeyCount !== $valueCount) {
            throw new Exceptions\CompositePrimaryKeyError(<<<EOM
                The configuration file indicates {$handler->getTable()}.{$handler->getField()} has a composite
                primary key with {$primaryKeyCount} columns, but the database fetched {$valueCount} values.
                EOM);
        }
    }
}
