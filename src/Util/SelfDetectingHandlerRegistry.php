<?php

namespace ClntDev\Scrubber\Util;

use ClntDev\Scrubber\Contracts\DetectsApplicability;
use ClntDev\Scrubber\DataHandlers\ArrayHandler;
use ClntDev\Scrubber\DataHandlers\CallableHandler;
use ClntDev\Scrubber\DataHandlers\FakerHandler;
use ClntDev\Scrubber\DataHandlers\IntegerHandler;
use ClntDev\Scrubber\DataHandlers\ObjectHandler;
use ClntDev\Scrubber\DataHandlers\StringHandler;
use ClntDev\Scrubber\Exceptions\HandlerNotFound;
use ClntDev\Scrubber\Exceptions\InvalidHandler;
use ClntDev\Scrubber\ScrubHandlers\Update;

/**
 * @template T
 */
class SelfDetectingHandlerRegistry
{
    private array $handlers;

    public static function makeForDataHandlers(): static
    {
        return new static([
            FakerHandler::class,
            CallableHandler::class,
            ObjectHandler::class,
            StringHandler::class,
            IntegerHandler::class,
            ArrayHandler::class,
        ]);
    }

    public static function makeForScrubHandlers(): static
    {
        return new static([
            Update::class,
        ]);
    }

    /** @param class-string<T&DetectsApplicability>[] $handlers */
    public function __construct(array $handlers = [])
    {
        array_walk($handlers, [$this, 'validateHandler']);

        $this->handlers = $handlers;
    }

    /** @param class-string<T&DetectsApplicability> $handler */
    public function addHandler(string $handler): self
    {
        $this->validateHandler($handler);

        $this->handlers[] = $handler;

        return $this;
    }

    /** @return class-string<T>[] */
    public function getHandlers(): array
    {
        return $this->handlers;
    }

    /** @return class-string<T> */
    public function getHandlerClassFromValue(mixed $value): string
    {
        foreach ($this->handlers as $handler) {
            if ($handler::detect($value)) {
                return $handler;
            }
        }

        throw new HandlerNotFound($value);
    }

    private function validateHandler(string $handler): void
    {
        $class = new \ReflectionClass($handler);
        if ($class->implementsInterface(DetectsApplicability::class) === false) {
            throw new InvalidHandler($handler);
        }
    }
}
