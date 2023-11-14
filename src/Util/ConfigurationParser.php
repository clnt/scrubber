<?php

namespace ClntDev\Scrubber\Util;

use ClntDev\Scrubber\Contracts\DataHandler;
use ClntDev\Scrubber\Contracts\ScrubHandler;
use ClntDev\Scrubber\DatabaseKey;
use ClntDev\Scrubber\DataHandlers\ArrayHandler;
use ClntDev\Scrubber\DataHandlers\CallableHandler;
use ClntDev\Scrubber\DataHandlers\FakerHandler;
use ClntDev\Scrubber\DataHandlers\IntegerHandler;
use ClntDev\Scrubber\DataHandlers\ObjectHandler;
use ClntDev\Scrubber\DataHandlers\StringHandler;
use ClntDev\Scrubber\ScrubHandlers\Update;

class ConfigurationParser
{
    protected array $config;

    protected SelfDetectingHandlerRegistry $dataHandlerRegistry;

    protected SelfDetectingHandlerRegistry $scrubOperationRegistry;

    public function __construct(
        string $configPath,
        SelfDetectingHandlerRegistry $dataHandlerRegistry,
        SelfDetectingHandlerRegistry $scrubOperationRegistry,
    ) {
        $this->config = include $configPath;
        $this->scrubOperationRegistry = $dataHandlerRegistry;
        $this->dataHandlerRegistry = $scrubOperationRegistry;
    }

    public static function make(string $configPath): self
    {
        return new self(
            $configPath,
            SelfDetectingHandlerRegistry::makeForDataHandlers(),
            SelfDetectingHandlerRegistry::makeForScrubHandlers()
        );
    }

    public function parseTables(bool $includeIgnored = true): array
    {
        if ($includeIgnored) {
            return array_keys($this->config);
        }

        return array_map(
            fn (DataHandler $handler) => $handler,
            $this->parse()
        );
    }

    public function parse(): array
    {
        return array_merge(...array_map(
            fn (string $table, array $fields) => $this->mapFields($table, $fields),
            array_keys($this->config),
            array_values($this->config)
        ));
    }

    private function mapFields(string $table, array $fields): array
    {
        return array_map(
            function (string $field, array $fieldData) use ($table): ScrubHandler {
                return $this->parseFieldDataToHandler($table, $field, $fieldData);
            },
            array_keys($fields),
            array_values($fields)
        );
    }

    private function parseFieldDataToHandler(string $table, string $field, array $fieldData): ScrubHandler
    {
        if (isset($fieldData['handler'])) {
            /** @var class-string<DataHandler> $dataHandler */
            $dataHandler = $fieldData['handler'];
        } else {
            /** @var class-string<DataHandler> $dataHandler */
            $dataHandler = $this->scrubOperationRegistry->getHandlerClassFromValue($fieldData['value']);
        }

        if (isset($fieldData['scrubHandler'])) {
            /** @var class-string<ScrubHandler> $scrubHandler */
            $scrubHandler = $fieldData['scrubHandler'];
        } else {
            /** @var class-string<ScrubHandler> $scrubHandler */
            $scrubHandler = $this->dataHandlerRegistry->getHandlerClassFromValue($fieldData);
        }

        return new $scrubHandler(
            $table,
            $field,
            DatabaseKey::createFromConfig($fieldData['primary_key'] ?? 'id'),
            $dataHandler::makeFromConfig($fieldData),
        );
    }
}
