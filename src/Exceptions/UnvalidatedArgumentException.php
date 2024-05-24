<?php

declare(strict_types=1);

namespace PerryvanderMeer\LaravelConsoleValidator\Exceptions;

use Exception;

final class UnvalidatedArgumentException extends Exception
{
    public function __construct(string $argument)
    {
        parent::__construct(
            "The requested argument [{$argument}] is not validated."
        );
    }
}
