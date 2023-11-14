<?php

namespace ClntDev\Scrubber\Contracts;

interface DataHandler
{
    public static function makeFromConfig(
        array $config
    ): self;

    public function getValue(): mixed;
}
