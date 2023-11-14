<?php

namespace ClntDev\Scrubber\ScrubHandlers;

use ClntDev\Scrubber\Contracts\DatabaseHandler;
use ClntDev\Scrubber\Contracts\DatabaseKey;
use ClntDev\Scrubber\Contracts\DataHandler;
use ClntDev\Scrubber\Contracts\DetectsApplicability;
use ClntDev\Scrubber\Contracts\ScrubHandler;

abstract class Handler implements ScrubHandler, DetectsApplicability
{
    protected string $table;

    protected string $field;

    protected DatabaseKey $primaryKey;

    protected DataHandler $dataHandler;

    public ?string $type;

    public function __construct(
        string $table,
        string $field,
        DatabaseKey $primaryKey,
        DataHandler $dataHandler,
        ?string $type = 'pid'
    ) {
        $this->table = $table;
        $this->field = $field;
        $this->primaryKey = $primaryKey;
        $this->dataHandler = $dataHandler;
        $this->type = $type;
    }

    public function getTable(): string
    {
        return $this->table;
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function getPrimaryKey(): DatabaseKey
    {
        return $this->primaryKey;
    }

    public function getDataHandler(): DataHandler
    {
        return $this->dataHandler;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    abstract public static function detect(mixed $value): bool;

    abstract public function scrub(
        mixed $primaryKeyValues,
        DatabaseHandler $database
    ): void;
}
