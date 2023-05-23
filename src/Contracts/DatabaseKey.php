<?php

namespace ClntDev\Scrubber\Contracts;

interface DatabaseKey
{
    public function isComposite(): bool;

    public function count(): int;

    /** @return string[] */
    public function getNames(): array;
}
