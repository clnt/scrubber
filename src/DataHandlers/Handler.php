<?php

namespace ClntDev\Scrubber\DataHandlers;

use ClntDev\Scrubber\Contracts\DatabaseKey;
use ClntDev\Scrubber\Contracts\DataHandler;
use ClntDev\Scrubber\Contracts\DetectsApplicability;
use ClntDev\Scrubber\DatabaseKey as ScrubberDatabaseKey;
use Faker\Factory as Faker;
use Faker\Generator;

abstract class Handler implements DataHandler, DetectsApplicability
{
    public mixed $input;

    public ?string $type;

    protected Generator $faker;

    public static function makeFromConfig(array $config): DataHandler
    {
        return new static(
            $config['value'] ?? null,
            $config['type'] ?? null,
            $config['seed'] ?? 'scrubber'
        );
    }

    public function __construct(
        mixed $input,
        ?string $type,
        string $seed,
    ) {
        $this->input = $input;
        $this->type = $type;
        $this->faker = Faker::create();
        $this->faker->seed($seed);
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    abstract public function getValue(): mixed;

    abstract public static function detect(mixed $value): bool;
}
