<?php

namespace ClntDev\Scrubber\Util;

use ClntDev\Scrubber\DatabaseKey;
use ClntDev\Scrubber\Exceptions\ValueNotFound;
use ClntDev\Scrubber\Handlers\Handler;

class ConfigurationParser
{
    protected array $config;

    protected HandlerRegistry $handlerRegistry;

    public function __construct(string $configPath)
    {
        $this->config = include $configPath;
        $this->handlerRegistry = new HandlerRegistry;
    }

    public static function make(string $configPath): self
    {
        return new self($configPath);
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
            fn (string $field, array $fieldData): Handler => $this->parseFieldDataToHandler($table, $field, $fieldData),
            array_keys($fields),
            array_values($fields)
        );
    }

    private function parseFieldDataToHandler(string $table, string $field, array $fieldData): Handler
    {
        if (isset($fieldData['value']) === false) {
            throw new ValueNotFound($table, $field);
        }

        if (isset($fieldData['handler'])) {
            $handler = $fieldData['handler'];
        }

        $handler = $handler ?? $this->handlerRegistry->getHandlerClassFromValue($fieldData['value']);

        return new $handler(
            $table,
            $field,
            $fieldData['value'],
            $fieldData['seed'] ?? 'scrubber',
            DatabaseKey::createFromConfig($fieldData['primary_key'] ?? 'id'),
            $fieldData['type'] ?? null
        );
    }
}
