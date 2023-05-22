<?php

namespace ClntDev\Scrubber\Exceptions;

use RuntimeException;
use Throwable;

class TryingToUseCompositeKeyAsSingleKey extends RuntimeException
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
        return <<<EOM
        The configuration file indicates $field in $table has a composite primary key.
        The database object must return an array of values for each row.
        EOM;
    }
}
