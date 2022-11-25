<?php

namespace ClntDev\Scrubber\Tests\Support\Fakes;

use ClntDev\Scrubber\Contracts\Logger;
use Throwable;

class Log implements Logger
{
    public array $logs;

    public function __construct()
    {
        $this->logs = [];
    }

    public function log(Throwable $exception): void
    {
        $this->logs[] = $exception->getMessage();
    }

    public function getLastEntry(): ?string
    {
        return $this->logs[count($this->logs) - 1];
    }
}
