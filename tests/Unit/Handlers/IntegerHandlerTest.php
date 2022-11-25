<?php

namespace ClntDev\Scrubber\Tests\Handlers;

use ClntDev\Scrubber\Handlers\IntegerHandler;
use ClntDev\Scrubber\Tests\TestCase;
use Throwable;

class IntegerHandlerTest extends TestCase
{
    /** @test */
    public function the_integer_handler_returns_the_expected_value(): void
    {
        $handler = $this->handlerFactory->create(IntegerHandler::class, '1');

        $this->assertEquals(1, $handler->handle());
    }

    /** @test */
    public function the_integer_handler_throws_exception_if_input_is_invalid(): void
    {
        $handler = $this->handlerFactory->create(IntegerHandler::class, ['one', 'two']);

        try {
            $handler->handle();
        } catch (Throwable $exception) {
            $this->assertEquals('IntegerHandler input is not numeric, array given', $exception->getMessage());
            return;
        }

        $this->fail('Exception not thrown');
    }

    /** @test */
    public function it_can_use_a_detect_function_to_determine_if_the_given_value_can_be_handled(): void
    {
        $this->assertTrue(IntegerHandler::detect(1));
        $this->assertTrue(IntegerHandler::detect('1'));
        $this->assertFalse(IntegerHandler::detect('1A'));
    }
}
