<?php

namespace ClntDev\Scrubber\DataHandlers;

use RuntimeException;

class ArrayHandler extends Handler
{
    public function getValue(): string|bool
    {
        if (is_array($this->input) === false) {
            throw new RuntimeException(
                'ArrayHandler input is not an array, ' . get_debug_type($this->input) . ' given'
            );
        }

        return json_encode($this->input, JSON_THROW_ON_ERROR);
    }

    public static function detect(mixed $value): bool
    {
        return is_array($value);
    }
}
