<?php

namespace ClntDev\Scrubber\Tests\Support\Fakes;

use ClntDev\Scrubber\Contracts\DatabaseUpdate;

class Database implements DatabaseUpdate
{
    public array $entries;

    public function __construct()
    {
        $this->entries = [];
    }

    public function fetch(string $table, string $primaryKey): array //phpcs:ignore
    {
        return [1, 2];
    }

    public function update(
        string $table,
        string $field,
        mixed $value,
        string|int $primaryKeyValue,
        string $primaryKey = 'id'
    ): bool {
        $this->entries[] = [
            'table' => $table,
            'field' => $field,
            'value' => $value,
            'primaryKeyValue' => $primaryKeyValue,
            'primaryKey' => $primaryKey,
        ];

        return true;
    }

    public function hasEntry(string $table, string $field, mixed $value, string|int $primaryKeyValue): array
    {
        return array_filter($this->entries, static fn (array $entry): bool => $entry === [
            'table' => $table,
            'field' => $field,
            'value' => $value,
            'primaryKeyValue' => $primaryKeyValue,
            'primaryKey' => 'id',
        ]);
    }
}
