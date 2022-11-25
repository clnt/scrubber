<?php

namespace ClntDev\Scrubber\Tests\Support\Fakes;

class CallableTestObject
{
    public function __call(string $name, array $arguments): string //phpcs:ignore
    {
        return $this->__invoke();
    }

    public function __invoke(): string
    {
        return 'callable';
    }
}
