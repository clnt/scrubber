<?php

namespace ClntDev\Scrubber\Tests\Support\Fakes;

use ClntDev\Scrubber\Contracts\DatabaseKey;
use ClntDev\Scrubber\Contracts\DatabaseHandler;

class Database implements DatabaseHandler
{
    public array $entries = [];

    public array $deletedEntries = [];

    public array $truncatedEntries = [];

    public function __construct()
    {
        $this->entries = [];
    }

    public function fetch(string $table, DatabaseKey $primaryKey): array //phpcs:ignore
    {
        if ($primaryKey->isComposite()) {
            return [
                [1, 1, 1, 1],
                [2, 2, 2, 2],
            ];
        }

        return [1, 2];
    }

    public function update(
        string $table,
        string $field,
        mixed $value,
        string|int|array $primaryKeyValue,
        DatabaseKey $primaryKey
    ): bool {
        $this->entries[] = [
            'table' => $table,
            'field' => $field,
            'value' => $value,
            'primaryKeyValue' => $primaryKeyValue,
            'primaryKey' => $primaryKey->getNames(),
        ];

        return true;
    }

    public function delete(
        string $table,
        string $field,
        string $value,
        array|int|string $primaryKeyValue,
        DatabaseKey $primaryKey
    ): bool {
        $this->deletedEntries[] = [
            'table' => $table,
            'field' => $field,
            'value' => $value,
            'primaryKeyValue' => $primaryKeyValue,
            'primaryKey' => $primaryKey->getNames(),
        ];

        return true;
    }

    public function truncate(string $table): bool
    {
        $this->truncatedEntries[] = [
            'table' => $table,
        ];

        return true;
    }
}
