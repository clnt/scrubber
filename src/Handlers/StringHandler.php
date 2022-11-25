<?php

namespace ClntDev\Scrubber\Handlers;

use RuntimeException;

class StringHandler extends Handler
{
    public function handle(): ?string
    {
        if (is_string($this->input) === false && is_int($this->input) === false) {
            throw new RuntimeException(
                'StringHandler input is not stringable, ' . get_debug_type($this->input) . ' given'
            );
        }

        return (string) $this->input;
    }

    public static function detect(mixed $value): bool
    {
        return is_string($value);
    }
}
