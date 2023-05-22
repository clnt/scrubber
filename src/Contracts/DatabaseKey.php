<?php

namespace ClntDev\Scrubber\Contracts;

interface DatabaseKey
{
    public function isComposite(): bool;

    /** @return string[] */
    public function getNames(): array;
}
