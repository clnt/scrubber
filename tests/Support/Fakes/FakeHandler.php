<?php

namespace ClntDev\Scrubber\Tests\Support\Fakes;

use ClntDev\Scrubber\DataHandlers\Handler;

class FakeHandler extends Handler
{
    public function getValue(): string //phpcs:ignore
    {
        return 'fake-handler';
    }

    public static function detect(mixed $value): bool //phpcs:ignore
    {
        return true;
    }
}
