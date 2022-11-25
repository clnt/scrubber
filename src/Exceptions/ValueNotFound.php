<?php

namespace ClntDev\Scrubber\Exceptions;

use RuntimeException;
use Throwable;

class ValueNotFound extends RuntimeException
{
    public function __construct(
        string $table,
        string $field,
        string $message = '',
        int $code = 0,
        ?Throwable $previous = null
    ) {
        $message = $message !== '' ? $message : $this->getErrorMessage($table, $field);

        parent::__construct($message, $code, $previous);
    }

    private function getErrorMessage(string $table, string $field): string
    {
        return "The 'value' key was not found for $field on $table in the configuration file";
    }
}
