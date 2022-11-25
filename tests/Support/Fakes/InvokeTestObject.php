<?php

namespace ClntDev\Scrubber\Tests\Support\Fakes;

class InvokeTestObject
{
    public function __invoke(): string
    {
        return '__invoke';
    }
}
