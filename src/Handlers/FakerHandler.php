<?php

namespace ClntDev\Scrubber\Handlers;

use RuntimeException;

class FakerHandler extends Handler
{
    public function handle(): ?string
    {
        if (str_contains($this->input, 'faker.') === false) {
            throw new RuntimeException('FakerHandler invalid faker input format given');
        }

        $call = explode('faker.', $this->input)[1];

        return $this->faker->$call;
    }

    public static function detect(mixed $value): bool
    {
        return is_string($value) && str_contains($value, 'faker');
    }
}
