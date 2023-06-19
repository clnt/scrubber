<?php

namespace ClntDev\Scrubber\Tests\Support\Fakes;

use ClntDev\Scrubber\Contracts\DatabaseKey;

class DatabaseThatIgnoresCompositeKeys extends Database
{
    public function fetch(string $table, DatabaseKey $primaryKey): array //phpcs:ignore
    {
        return [1, 2];
    }
}
