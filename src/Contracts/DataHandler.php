<?php

namespace ClntDev\Scrubber\Contracts;

interface DataHandler
{
    public function __construct(
        string $table,
        string $field,
        mixed $input,
        ?DatabaseKey $primaryKey = null,
        ?string $type = null,
        string $seed = 'scrubber',
    );

    public function handle(); //phpcs:ignore
}
