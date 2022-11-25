<?php

namespace ClntDev\Scrubber\Contracts;

use Throwable;

interface Logger
{
    public function log(Throwable $exception): void;
}
