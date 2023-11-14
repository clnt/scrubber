<?php

namespace ClntDev\Scrubber\DataHandlers;

use RuntimeException;

class CallableHandler extends Handler
{
    public function getValue(): ?string
    {
        if (is_callable($this->input) === false) {
            throw new RuntimeException('CallableHandler input is not callable');
        }

        return ($this->input)();
    }

    public static function detect(mixed $value): bool
    {
        return is_callable($value);
    }
}
