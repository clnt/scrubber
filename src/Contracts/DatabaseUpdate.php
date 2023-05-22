<?php

namespace ClntDev\Scrubber\Contracts;

interface DatabaseUpdate
{
    /** @return mixed[] */
    public function fetch(string $table, DatabaseKey $primaryKey): array;

    public function update(
        string $table,
        string $field,
        mixed $value,
        string|int|array $primaryKeyValue,
        DatabaseKey $primaryKey
    ): bool;
}
