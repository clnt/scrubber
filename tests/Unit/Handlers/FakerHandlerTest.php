<?php

namespace ClntDev\Scrubber\Tests\Handlers;

use ClntDev\Scrubber\Handlers\FakerHandler;
use ClntDev\Scrubber\Tests\TestCase;
use Faker\Factory as Faker;
use Throwable;

class FakerHandlerTest extends TestCase
{
    protected function setUp(): void
    {
        $this->faker = Faker::create();
        $this->faker->seed('scrubber');

        parent::setUp();
    }

    /** @test */
    public function the_faker_handler_returns_the_expected_value(): void
    {
        $handler = $this->handlerFactory->create(FakerHandler::class, 'faker.sentence');

        $this->assertNotEmpty($handler->handle());
    }

    /** @test */
    public function the_faker_handler_throws_exception_if_input_is_invalid(): void
    {
        $handler = $this->handlerFactory->create(FakerHandler::class, 'fakerinvalid.string');

        try {
            $handler->handle();
        } catch (Throwable $exception) {
            $this->assertEquals('FakerHandler invalid faker input format given', $exception->getMessage());
            return;
        }

        $this->fail('Exception not thrown');
    }

    /** @test */
    public function it_can_use_a_detect_function_to_determine_if_the_given_value_can_be_handled(): void
    {
        $this->assertTrue(FakerHandler::detect('faker.first_name'));
        $this->assertFalse(FakerHandler::detect('test-slug'));
    }
}
