<?php

namespace ClntDev\Scrubber\Tests\Unit\Util;

use ClntDev\Scrubber\Exceptions\HandlerNotFound;
use ClntDev\Scrubber\Handlers\ArrayHandler;
use ClntDev\Scrubber\Handlers\CallableHandler;
use ClntDev\Scrubber\Handlers\FakerHandler;
use ClntDev\Scrubber\Handlers\IntegerHandler;
use ClntDev\Scrubber\Handlers\ObjectHandler;
use ClntDev\Scrubber\Handlers\StringHandler;
use ClntDev\Scrubber\Tests\Support\Fakes\FakeHandler;
use ClntDev\Scrubber\Tests\Support\Fakes\InvalidTestObject;
use ClntDev\Scrubber\Tests\TestCase;
use ClntDev\Scrubber\Util\HandlerRegistry;

class HandlerRegistryTest extends TestCase
{
    protected HandlerRegistry $registry;

    protected function setUp(): void
    {
        $this->registry = new HandlerRegistry;

        parent::setUp();
    }

    /** @test */
    public function it_populates_handlers_with_all_expected_core_handlers(): void
    {
        $expectedHandlers = [
            FakerHandler::class,
            CallableHandler::class,
            ObjectHandler::class,
            StringHandler::class,
            IntegerHandler::class,
            ArrayHandler::class,
        ];

        $this->assertEquals($expectedHandlers, $this->registry->getHandlers());
    }

    /** @test */
    public function it_is_possible_to_add_an_additional_handler(): void
    {
        $expectedHandlers = [
            FakerHandler::class,
            CallableHandler::class,
            ObjectHandler::class,
            StringHandler::class,
            IntegerHandler::class,
            ArrayHandler::class,
            FakeHandler::class,
        ];

        $this->registry->addHandler(FakeHandler::class);

        $this->assertEquals($expectedHandlers, $this->registry->getHandlers());
    }

    /** @test */
    public function it_can_get_a_handler_class_from_value(): void
    {
        $value = 'faker.first_name';

        $handler = $this->registry->getHandlerClassFromValue($value);

        $this->assertEquals(FakerHandler::class, $handler);
    }

    /** @test */
    public function it_throws_handler_not_found_exception_if_none_detected(): void
    {
        $this->expectException(HandlerNotFound::class);

        $this->registry->getHandlerClassFromValue(new InvalidTestObject);
    }
}
