<?php

namespace ClntDev\Scrubber\Contracts;

interface DatabaseUpdate
{
    public function fetch(string $table, string $primaryKey): array;

    public function update(
        string $table,
        string $field,
        mixed $value,
        string|int $primaryKeyValue,
        string $primaryKey = 'id'
    ): bool;
}
