<?php

namespace ClntDev\Scrubber\Tests\Handlers;

use ClntDev\Scrubber\DataHandlers\StringHandler;
use ClntDev\Scrubber\Tests\TestCase;
use Throwable;

class StringHandlerTest extends TestCase
{
    /** @test */
    public function the_string_handler_returns_the_expected_value(): void
    {
        $handler = $this->handlerFactory->create(StringHandler::class, 1);

        $this->assertEquals('1', $handler->getValue());
    }

    /** @test */
    public function the_string_handler_logs_exception_if_input_is_invalid(): void
    {
        $handler = $this->handlerFactory->create(StringHandler::class, ['one', 'two']);

        try {
            $handler->getValue();
        } catch (Throwable $exception) {
            $this->assertEquals('StringHandler input is not stringable, array given', $exception->getMessage());
            return;
        }

        $this->fail('Exception not thrown');
    }

    /** @test */
    public function it_can_use_a_detect_function_to_determine_if_the_given_value_can_be_handled(): void
    {
        $this->assertTrue(StringHandler::detect('test-string'));
        $this->assertFalse(StringHandler::detect(1));
    }
}
