<?php

namespace ClntDev\Scrubber\Handlers;

use RuntimeException;

class IntegerHandler extends Handler
{
    public function handle(): ?int
    {
        if (is_numeric($this->input) === false) {
            throw new RuntimeException(
                'IntegerHandler input is not numeric, ' . get_debug_type($this->input) . ' given'
            );
        }

        return (int) $this->input;
    }

    public static function detect(mixed $value): bool
    {
        return is_numeric($value);
    }
}
