<?php

namespace ClntDev\Scrubber\Exceptions;

use RuntimeException;
use Throwable;

class HandlerNotFound extends RuntimeException
{
    public mixed $value = '';

    public function __construct(
        mixed $value,
        string $message = '',
        int $code = 0,
        ?Throwable $previous = null
    ) {
        $this->value = $value;
        $message = $message !== '' ? $message : 'Could not detect a handler for the given value';

        parent::__construct($message, $code, $previous);
    }
}
