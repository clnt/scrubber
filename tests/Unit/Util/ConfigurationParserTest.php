<?php

namespace ClntDev\Scrubber\Tests\Unit\Util;

use ClntDev\Scrubber\Contracts\ScrubHandler;
use ClntDev\Scrubber\Exceptions\HandlerNotFound;
use ClntDev\Scrubber\Exceptions\ValueNotFound;
use ClntDev\Scrubber\DataHandlers\CallableHandler;
use ClntDev\Scrubber\DataHandlers\FakerHandler;
use ClntDev\Scrubber\DataHandlers\StringHandler;
use ClntDev\Scrubber\ScrubHandlers\Update;
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
        /** @var ScrubHandler[] $result */
        $result = $this->parser->parse();

        $expectedScrubHandlers = [
            Update::class,
            Update::class,
            Update::class,
            Update::class,
            Update::class,
            Update::class,
            Update::class,
            Update::class,
        ];

        $expectedDataHandlers = [
            FakerHandler::class,
            FakerHandler::class,
            FakerHandler::class,
            CallableHandler::class,
            FakerHandler::class,
            FakerHandler::class,
            FakerHandler::class,
            StringHandler::class,
        ];

        $this->assertCount(9, $result);

        for ($i = 0, $iMax = count($expectedScrubHandlers); $i < $iMax; $i++) { //phpcs:ignore
            $this->assertInstanceOf($expectedScrubHandlers[$i], $result[$i]);
            $this->assertInstanceOf($expectedDataHandlers[$i], $result[$i]->getDataHandler());
        }
    }

    /** @test */
    public function it_returns_an_empty_array_if_parsed_config_is_empty(): void
    {
        $this->parser = ConfigurationParser::make(__DIR__ . '/../../Support/config-empty.php');

        $this->assertEquals([], $this->parser->parse());
    }

    /** @test */
    public function it_throws_a_handler_not_found_exception_if_the_value_key_is_not_defined(): void
    {
        $this->parser = ConfigurationParser::make(__DIR__ . '/../../Support/config-invalid.php');

        $this->expectException(HandlerNotFound::class);

        $this->parser->parse();
    }
}
