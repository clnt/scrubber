<?php

namespace ClntDev\Scrubber\Contracts;

interface DataHandler
{
    public function __construct(
        string $table,
        string $field,
        mixed $input,
        string $seed = 'scrubber',
        ?DatabaseKey $primaryKey = null,
        ?string $type = null,
    );

    public function handle(); //phpcs:ignore
}
