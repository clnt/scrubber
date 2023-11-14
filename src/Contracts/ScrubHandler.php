<?php

namespace ClntDev\Scrubber\Contracts;

interface ScrubHandler
{
    public function __construct(
        string $table,
        string $field,
        DatabaseKey $primaryKey,
        DataHandler $dataHandler,
        ?string $type = 'pid'
    );

    public function scrub(
        mixed $primaryKeyValues,
        DatabaseHandler $database
    ): void;

    public function getTable(): string;

    public function getField(): string;

    public function getPrimaryKey(): DatabaseKey;

    public function getDataHandler(): DataHandler;

    public function getType(): ?string;
}
