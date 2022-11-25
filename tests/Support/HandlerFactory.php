<?php

namespace ClntDev\Scrubber\Tests\Support;

use ClntDev\Scrubber\Handlers\Handler;

class HandlerFactory
{
    public function create(string $handlerClass, mixed $input): Handler
    {
        return new $handlerClass('test_table', 'test_field', $input);
    }
}
