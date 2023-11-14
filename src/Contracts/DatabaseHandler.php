<?php

namespace ClntDev\Scrubber\Contracts;

interface DatabaseHandler
{
    /** @return mixed[] */
    public function fetch(
        string $table,
        DatabaseKey $primaryKey
    ): array;

    public function update(
        string $table,
        string $field,
        mixed $value,
        string|int|array $primaryKeyValue,
        DatabaseKey $primaryKey
    ): bool;

    public function delete(
        string $table,
        string $field,
        string $value,
        string|int|array $primaryKeyValue,
        DatabaseKey $primaryKey
    ): bool;

    public function truncate(
        string $table
    ): bool;
}
