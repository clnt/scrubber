<?php

namespace ClntDev\Scrubber\Tests\Handlers;

use ClntDev\Scrubber\DataHandlers\CallableHandler;
use ClntDev\Scrubber\Tests\TestCase;
use Closure;
use stdClass;
use Throwable;

class CallableHandlerTest extends TestCase
{
    protected Closure $callable;

    protected function setUp(): void
    {
        $this->callable = static fn (): string => 'Test Callable';

        parent::setUp();
    }

    /** @test */
    public function the_callable_handler_returns_the_expected_value(): void
    {
        $handler = $this->handlerFactory->create(CallableHandler::class, $this->callable);

        $this->assertEquals('Test Callable', $handler->getValue());
    }

    /** @test */
    public function the_callable_handler_throws_exception_if_input_is_not_an_object_or_callable(): void
    {
        $handler = $this->handlerFactory->create(CallableHandler::class, ['one', 'two']);

        try {
            $handler->getValue();
        } catch (Throwable $exception) {
            $this->assertEquals('CallableHandler input is not callable', $exception->getMessage());
            return;
        }

        $this->fail('Exception not thrown');
    }

    /** @test */
    public function it_can_use_a_detect_function_to_determine_if_the_given_value_can_be_handled(): void
    {
        $this->assertTrue(CallableHandler::detect(static fn (): string => 'test'));
        $this->assertFalse(CallableHandler::detect(new stdClass));
    }
}
