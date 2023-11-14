<?php

namespace ClntDev\Scrubber\Tests\Support;

use ClntDev\Scrubber\DataHandlers\Handler;

class HandlerFactory
{
    /** @param class-string<Handler> $handlerClass */
    public function create(string $handlerClass, mixed $input): Handler
    {
        return new $handlerClass($input, null, 'scrubber');
    }
}
