<?php

namespace ClntDev\Scrubber\Contracts;

interface DataHandler
{
    public function __construct(string $table, string $field, mixed $input, string $seed);

    public function handle(); //phpcs:ignore
}
