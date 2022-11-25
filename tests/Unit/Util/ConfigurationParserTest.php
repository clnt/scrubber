<?php

namespace ClntDev\Scrubber\Tests\Unit\Util;

use ClntDev\Scrubber\Exceptions\ValueNotFound;
use ClntDev\Scrubber\Handlers\CallableHandler;
use ClntDev\Scrubber\Handlers\FakerHandler;
use ClntDev\Scrubber\Tests\TestCase;
use ClntDev\Scrubber\Util\ConfigurationParser;

class ConfigurationParserTest extends TestCase
{
    protected ConfigurationParser $parser;

    protected function setUp(): void
    {
        $this->parser = ConfigurationParser::make(__DIR__ . '/../../Support/config.php');

        parent::setUp();
    }

    /** @test */
    public function it_can_create_the_parser_from_a_static_make_method(): void
    {
        $this->assertInstanceOf(ConfigurationParser::class, $this->parser);
    }

    /** @test */
    public function it_can_parse_the_test_config_into_the_expected_handlers(): void
    {
        $result = $this->parser->parse();

        $expectedHandlers = [
            FakerHandler::class,
            FakerHandler::class,
            FakerHandler::class,
            CallableHandler::class,
        ];

        $this->assertCount(4, $result);

        for ($i = 0, $iMax = count($expectedHandlers); $i < $iMax; $i++) { //phpcs:ignore
            $this->assertInstanceOf($expectedHandlers[$i], $result[$i]);
        }
    }

    /** @test */
    public function it_returns_an_empty_array_if_parsed_config_is_empty(): void
    {
        $this->parser = ConfigurationParser::make(__DIR__ . '/../../Support/config-empty.php');

        $this->assertEquals([], $this->parser->parse());
    }

    /** @test */
    public function it_throws_a_value_not_found_exception_if_the_value_key_is_not_defined(): void
    {
        $this->parser = ConfigurationParser::make(__DIR__ . '/../../Support/config-invalid.php');

        $this->expectException(ValueNotFound::class);

        $this->parser->parse();
    }
}
