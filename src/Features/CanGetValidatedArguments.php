<?php

declare(strict_types=1);

namespace PerryvanderMeer\LaravelConsoleValidator\Features;

use Illuminate\Support\Collection;
use PerryvanderMeer\LaravelConsoleValidator\Exceptions\UnvalidatedArgumentException;

trait CanGetValidatedArguments
{
    /**
     * Return all validated arguments, or just the requested argument.
     *
     * @throws \PerryvanderMeer\LaravelConsoleValidator\Exceptions\UnvalidatedArgumentException
     */
    protected function validated(?string $argument = null) : mixed
    {
        if (filled($argument))
        {
            return array_key_exists($argument, $this->validator->validated())
                ? $this->validator->validated()[$argument]
                : throw new UnvalidatedArgumentException($argument);
        }

        return $this->validator->validated();
    }

    /**
     * Collect all validated arguments.
     */
    protected function collect() : Collection
    {
        return collect($this->validated());
    }

    /**
     * Cast the requested validated argument as string.
     */
    protected function string(string $argument) : string
    {
        return (string) $this->validated($argument);
    }

    /**
     * Cast the requested validated argument as boolean.
     */
    protected function bool(string $argument) : bool
    {
        return filter_var($this->validated($argument), FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Cast the requested validated argument as boolean.
     */
    protected function boolean(string $argument) : bool
    {
        return $this->bool($argument);
    }
}
