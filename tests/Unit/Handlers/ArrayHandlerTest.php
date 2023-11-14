<?php

namespace ClntDev\Scrubber\Tests\Handlers;

use ClntDev\Scrubber\DataHandlers\ArrayHandler;
use ClntDev\Scrubber\Tests\TestCase;
use stdClass;
use Throwable;

class ArrayHandlerTest extends TestCase
{
    /** @test */
    public function the_array_handler_returns_the_expected_value(): void
    {
        $handler = $this->handlerFactory->create(ArrayHandler::class, ['one', 'two']);

        $this->assertEquals(json_encode(['one', 'two'], JSON_THROW_ON_ERROR), $handler->getValue());
    }

    /** @test */
    public function the_array_handler_throws_exception_if_input_is_invalid(): void
    {
        $handler = $this->handlerFactory->create(ArrayHandler::class, 'string');

        try {
             $handler->getValue();
        } catch (Throwable $exception) {
            $this->assertEquals('ArrayHandler input is not an array, string given', $exception->getMessage());
            return;
        }

        $this->fail('Exception not thrown');
    }

    /** @test */
    public function it_can_use_a_detect_function_to_determine_if_the_given_value_can_be_handled(): void
    {
        $this->assertTrue(ArrayHandler::detect([]));
        $this->assertFalse(ArrayHandler::detect(new stdClass));
    }
}
