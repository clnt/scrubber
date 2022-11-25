<?php

namespace ClntDev\Scrubber\Handlers;

use RuntimeException;

class ObjectHandler extends Handler
{
    public function handle(): ?string
    {
        if (is_object($this->input) === false) {
            throw new RuntimeException('CallableHandler input is not an object');
        }

        return $this->handleObject();
    }

    public static function detect(mixed $value): bool
    {
        return is_object($value) && (method_exists(
            $value,
            '__invoke'
        ) || method_exists($value, 'handle'));
    }

    private function handleObject(): ?string
    {
        if (method_exists($this->input, '__invoke')) {
            return $this->input->__invoke();
        }

        if (method_exists($this->input, 'handle')) {
            return $this->input->handle();
        }

        throw new RuntimeException(
            'CallableHandler __invoke or handle method not found on ' . get_class($this->input)
        );
    }
}
