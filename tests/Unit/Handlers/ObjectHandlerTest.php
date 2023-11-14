<?php

namespace ClntDev\Scrubber\Tests\Handlers;

use ClntDev\Scrubber\DataHandlers\ObjectHandler;
use ClntDev\Scrubber\Tests\Support\Fakes\CallableTestObject;
use ClntDev\Scrubber\Tests\Support\Fakes\HandleTestObject;
use ClntDev\Scrubber\Tests\Support\Fakes\InvalidTestObject;
use ClntDev\Scrubber\Tests\Support\Fakes\InvokeTestObject;
use ClntDev\Scrubber\Tests\TestCase;
use Throwable;

class ObjectHandlerTest extends TestCase
{
    /** @test */
    public function the_object_handler_returns_the_expected_handle_test_object_value(): void
    {
        $handler = $this->handlerFactory->create(ObjectHandler::class, new HandleTestObject);

        $this->assertEquals('handle', $handler->getValue());
    }

    /** @test */
    public function the_object_handler_returns_the_expected_invoke_test_object_value(): void
    {
        $handler = $this->handlerFactory->create(ObjectHandler::class, new InvokeTestObject);

        $this->assertEquals('__invoke', $handler->getValue());
    }

    /** @test */
    public function the_object_handler_can_also_handle_a_callable_value(): void
    {
        $handler = $this->handlerFactory->create(ObjectHandler::class, new CallableTestObject);

        $this->assertEquals('callable', $handler->getValue());
    }

    /** @test */
    public function the_object_handler_logs_exception_if_input_is_not_an_object_or_object(): void
    {
        $handler = $this->handlerFactory->create(ObjectHandler::class, ['one', 'two']);

        try {
            $handler->getValue();
        } catch (Throwable $exception) {
            $this->assertEquals('CallableHandler input is not an object', $exception->getMessage());
            return;
        }

        $this->fail('Exception not thrown');
    }

    /** @test */
    public function the_object_handler_logs_exception_if_input_does_not_have_expected_object_methods(): void
    {
        $handler = $this->handlerFactory->create(ObjectHandler::class, new InvalidTestObject);

        try {
            $handler->getValue();
        } catch (Throwable $exception) {
            $this->assertEquals(
                'CallableHandler __invoke or handle method not found on '
                . 'ClntDev\Scrubber\Tests\Support\Fakes\InvalidTestObject',
                $exception->getMessage()
            );
            return;
        }

        $this->fail('Exception not thrown');
    }

    /** @test */
    public function it_can_use_a_detect_function_to_determine_if_the_given_value_can_be_handled(): void
    {
        $this->assertTrue(ObjectHandler::detect(new InvokeTestObject));
        $this->assertTrue(ObjectHandler::detect(new HandleTestObject));
        $this->assertFalse(ObjectHandler::detect([]));
    }
}
