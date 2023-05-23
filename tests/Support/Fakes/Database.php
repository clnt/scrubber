<?php

namespace ClntDev\Scrubber\Tests\Support\Fakes;

use ClntDev\Scrubber\Contracts\DatabaseKey;
use ClntDev\Scrubber\Contracts\DatabaseUpdate;

class Database implements DatabaseUpdate
{
    public array $entries;

    public function __construct()
    {
        $this->entries = [];
    }

    public function fetch(string $table, DatabaseKey $primaryKey): array //phpcs:ignore
    {
        print 'ARG: ' . $table;
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
}
