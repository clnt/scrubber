<?php

namespace ClntDev\Scrubber\Tests\Unit;

use ClntDev\Scrubber\Contracts\DatabaseUpdate;
use ClntDev\Scrubber\Contracts\Logger;
use ClntDev\Scrubber\Exceptions\ValueNotFound;
use ClntDev\Scrubber\Scrubber;
use ClntDev\Scrubber\Tests\Support\Fakes\Database;
use ClntDev\Scrubber\Tests\TestCase;

class ScrubberTest extends TestCase
{
    protected DatabaseUpdate $database;

    protected Logger $logger;

    protected string $configPath;

    protected function setUp(): void
    {
        $this->database = new Database;
        $this->configPath = __DIR__ . '/../Support/config.php';

        parent::setUp();
    }

    /** @test */
    public function it_can_instantiate_the_scrubber_with_deps_through_static_make_method(): void
    {
        try {
            Scrubber::make($this->configPath, $this->database, $this->logger);
        } catch (\Throwable $exception) {
            $this->fail($exception->getMessage());
        }

        $this->assertTrue(true);
    }

    /** @test */
    public function it_can_run_the_scrubber_using_the_test_config_and_get_the_expected_entries(): void
    {
        $scrubber = Scrubber::make($this->configPath, $this->database, $this->logger);

        $scrubber->run();

        $this->assertCount(16, $this->database->entries);
        $this->assertEquals([
            [
                'table' => 'users',
                'field' => 'first_name',
                'value' => 'Keyshawn',
                'primaryKeyValue' => 1,
                'primaryKey' => 'id',
            ],
            [
                'table' => 'users',
                'field' => 'first_name',
                'value' => 'Brandyn',
                'primaryKeyValue' => 2,
                'primaryKey' => 'id',
            ],
            [
                'table' => 'users',
                'field' => 'last_name',
                'value' => 'Mitchell',
                'primaryKeyValue' => 1,
                'primaryKey' => 'id',
            ],
            [
                'table' => 'users',
                'field' => 'last_name',
                'value' => 'Stiedemann',
                'primaryKeyValue' => 2,
                'primaryKey' => 'id',
            ],
            [
                'table' => 'users',
                'field' => 'email',
                'value' => 'qjones@yahoo.com',
                'primaryKeyValue' => 1,
                'primaryKey' => 'id',
            ],
            [
                'table' => 'users',
                'field' => 'email',
                'value' => 'brandon05@gmail.com',
                'primaryKeyValue' => 2,
                'primaryKey' => 'id',
            ],
            [
                'table' => 'users',
                'field' => 'toggle',
                'value' => '1',
                'primaryKeyValue' => 1,
                'primaryKey' => 'id',
            ],
            [
                'table' => 'users',
                'field' => 'toggle',
                'value' => '1',
                'primaryKeyValue' => 2,
                'primaryKey' => 'id',
            ],
            [
                'table' => 'admins',
                'field' => 'first_name',
                'value' => 'Liza',
                'primaryKeyValue' => 1,
                'primaryKey' => 'id',
            ],
            [
                'table' => 'admins',
                'field' => 'first_name',
                'value' => 'Presley',
                'primaryKeyValue' => 2,
                'primaryKey' => 'id',
            ],
            [
                'table' => 'admins',
                'field' => 'last_name',
                'value' => 'Schulist',
                'primaryKeyValue' => 1,
                'primaryKey' => 'id',
            ],
            [
                'table' => 'admins',
                'field' => 'last_name',
                'value' => 'Legros',
                'primaryKeyValue' => 2,
                'primaryKey' => 'id',
            ],
            [
                'table' => 'admins',
                'field' => 'email',
                'value' => 'austin83@hotmail.com',
                'primaryKeyValue' => 1,
                'primaryKey' => 'id',
            ],
            [
                'table' => 'admins',
                'field' => 'email',
                'value' => 'zhermiston@murphy.com',
                'primaryKeyValue' => 2,
                'primaryKey' => 'id',
            ],
            [
                'table' => 'admins',
                'field' => 'company',
                'value' => 'string handler',
                'primaryKeyValue' => 1,
                'primaryKey' => 'id',
            ],
            [
                'table' => 'admins',
                'field' => 'company',
                'value' => 'string handler',
                'primaryKeyValue' => 2,
                'primaryKey' => 'id',
            ],
        ], $this->database->entries);
    }

    /** @test */
    public function it_logs_any_errors_thrown_during_runtime(): void
    {
        Scrubber::make(
            __DIR__ . '/../Support/config-invalid-handler-value.php',
            $this->database,
            $this->logger
        )->run();

        $this->assertEquals('ThrowableTestObject exception message', $this->logger->getLastEntry());
    }

    /** @test */
    public function an_exception_is_thrown_if_the_config_is_invalid_on_run(): void
    {
        $this->expectException(ValueNotFound::class);

        Scrubber::make(
            __DIR__ . '/../Support/config-invalid.php',
            $this->database,
            $this->logger
        )->run();
    }

    /** @test */
    public function it_can_get_the_field_list_for_the_given_type_as_array(): void
    {
        $scrubber = Scrubber::make($this->configPath, $this->database, $this->logger);

        $this->assertEquals(
            [
                'first_name',
                'last_name',
                'email',
                'first_name',
                'last_name',
                'email',
            ],
            $scrubber->getFieldList('pid')
        );
    }

    /** @test */
    public function it_can_get_the_comma_separated_field_list_for_the_given_type(): void
    {
        $scrubber = Scrubber::make($this->configPath, $this->database, $this->logger);

        $this->assertEquals(
            'first_name,last_name,email,first_name,last_name,email',
            $scrubber->getFieldListAsString('pid')
        );
    }
}
