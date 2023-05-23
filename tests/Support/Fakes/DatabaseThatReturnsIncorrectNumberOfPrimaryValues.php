<?php

namespace ClntDev\Scrubber\Tests\Support\Fakes;

use ClntDev\Scrubber\Contracts\DatabaseKey;

class DatabaseThatReturnsIncorrectNumberOfPrimaryValues extends Database
{
    public function fetch(string $table, DatabaseKey $primaryKey): array //phpcs:ignore
    {
        return [
            [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1],
        ];
    }
}
