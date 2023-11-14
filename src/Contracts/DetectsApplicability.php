<?php

namespace ClntDev\Scrubber\Contracts;

interface DetectsApplicability
{
    public static function detect(mixed $value): bool;
}
