<?php

namespace ClntDev\Scrubber\Tests\Support\Fakes;

use RuntimeException;

class ThrowableTestObject
{
    public function handle(): string
    {
        throw new RuntimeException('ThrowableTestObject exception message');
    }
}
