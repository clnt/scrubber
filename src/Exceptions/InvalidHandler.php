<?php

namespace ClntDev\Scrubber\Exceptions;

use RuntimeException;
use Throwable;

class InvalidHandler extends RuntimeException
{
    public mixed $value = '';

    public function __construct(
        mixed $value,
        string $message = '',
        int $code = 0,
        ?Throwable $previous = null
    ) {
        $this->value = $value;
        $message = $message !== '' ? $message : 'Invalid handler.';

        parent::__construct($message, $code, $previous);
    }
}
