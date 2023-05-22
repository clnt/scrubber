<?php

namespace ClntDev\Scrubber;

use ClntDev\Scrubber\Contracts\DatabaseUpdate;
use ClntDev\Scrubber\Contracts\Logger;
use ClntDev\Scrubber\Handlers\Handler;
use ClntDev\Scrubber\Util\ConfigurationParser;
use Throwable;

class Scrubber
{
    private ConfigurationParser $parser;

    private DatabaseUpdate $database;

    private Logger $logger;

    public function __construct(
        string $configPath,
        DatabaseUpdate $database,
        Logger $logger
    ) {
        $this->database = $database;
        $this->logger = $logger;
        $this->parser = ConfigurationParser::make($configPath);
    }

    public static function make(string $configPath, DatabaseUpdate $database, Logger $logger): self
    {
        return new self($configPath, $database, $logger);
    }

    public function run(): bool
    {
        $handlers = $this->parser->parse();

        try {
            foreach ($handlers as $handler) {
                $this->runHandler($handler);
            }
        } catch (Throwable $exception) {
            $this->logger->log($exception);

            return false;
        }

        return true;
    }

    public function getFieldList(string $type = 'pid'): array
    {
        return array_values(array_filter(array_map(
            static fn (Handler $handler): ?string => $handler->getType() === $type ? $handler->getField() : null,
            array_values($this->parser->parse())
        )));
    }

    public function getFieldListAsString(string $type = 'pid'): string
    {
        return implode(',', $this->getFieldList($type));
    }

    protected function runHandler(Handler $handler): void
    {
        foreach ($this->database->fetch($handler->getTable(), $handler->getPrimaryKey()) as $primaryKeyValues) {
            if ($handler->getPrimaryKey()->isComposite() && is_array($primaryKeyValues) === false) {
                throw new Exceptions\TryingToUseCompositeKeyAsSingleKey($handler->getTable(), $handler->getField());
            }

            $this->database->update(
                $handler->getTable(),
                $handler->getField(),
                $handler->handle(),
                $primaryKeyValues,
                $handler->getPrimaryKey(),
            );
        }
    }
}
