<?php

namespace ClntDev\Scrubber\Util;

use ClntDev\Scrubber\Exceptions\HandlerNotFound;
use ClntDev\Scrubber\Handlers\ArrayHandler;
use ClntDev\Scrubber\Handlers\CallableHandler;
use ClntDev\Scrubber\Handlers\FakerHandler;
use ClntDev\Scrubber\Handlers\IntegerHandler;
use ClntDev\Scrubber\Handlers\ObjectHandler;
use ClntDev\Scrubber\Handlers\StringHandler;

class HandlerRegistry
{
    private array $handlers;

    private array $coreHandlers = [
        FakerHandler::class,
        CallableHandler::class,
        ObjectHandler::class,
        StringHandler::class,
        IntegerHandler::class,
        ArrayHandler::class,
    ];

    private array $additionalHandlers = [];

    public function __construct(array $handlers = [])
    {
        $this->handlers = array_merge($this->getAvailableHandlers(), $handlers);
    }

    public function addHandler(string $handler): self
    {
        $this->handlers[] = $handler;

        return $this;
    }

    public function getAvailableHandlers(): array
    {
        return array_merge($this->coreHandlers, $this->additionalHandlers);
    }

    public function getHandlers(): array
    {
        return $this->handlers;
    }

    public function getHandlerClassFromValue(mixed $value): string
    {
        foreach ($this->handlers as $handler) {
            if ($handler::detect($value)) {
                return $handler;
            }
        }

        throw new HandlerNotFound($value);
    }
}
