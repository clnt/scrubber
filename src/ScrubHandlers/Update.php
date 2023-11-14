<?php

namespace ClntDev\Scrubber\ScrubHandlers;

use ClntDev\Scrubber\Contracts\DatabaseHandler;

class Update extends Handler
{
    public static function detect(mixed $value): bool
    {
        return isset($value['value']);
    }

    public function scrub(
        mixed $primaryKeyValues,
        DatabaseHandler $database
    ): void {
        $database->update(
            $this->getTable(),
            $this->getField(),
            $this->dataHandler->getValue(),
            $primaryKeyValues,
            $this->getPrimaryKey(),
        );
    }
}