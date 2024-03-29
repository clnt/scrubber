<?php

namespace ClntDev\Scrubber;

class DatabaseKey implements Contracts\DatabaseKey
{
    /** @var string[] */
    private array $columnNames;

    public static function createFromConfig(mixed $key): static
    {
        return new static($key);
    }

    public function __construct(array|string|int $columnName)
    {
        $this->columnNames = (array) $columnName;
    }

    public function isComposite(): bool
    {
        return $this->count() > 1;
    }

    public function count(): int
    {
        return count($this->columnNames);
    }

    public function getNames(): array
    {
        return $this->columnNames;
    }
}
