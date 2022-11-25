<?php

namespace ClntDev\Scrubber\Tests\Unit\Exceptions;

use ClntDev\Scrubber\Exceptions\HandlerNotFound;
use ClntDev\Scrubber\Tests\TestCase;

class HandlerNotFoundTest extends TestCase
{
    /** @test */
    public function it_gives_the_expected_error_message(): void
    {
        $exception = new HandlerNotFound([]);

        $this->assertEquals('Could not detect a handler for the given value', $exception->getMessage());
    }

    /** @test */
    public function the_error_message_can_be_overriden_if_required(): void
    {
        $exception = new HandlerNotFound([], 'Test message');

        $this->assertEquals('Test message', $exception->getMessage());
    }
}
