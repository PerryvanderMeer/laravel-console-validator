<?php

declare(strict_types=1);

namespace PerryvanderMeer\LaravelConsoleValidator\Testing;

use Closure;
use Symfony\Component\Console\Command\Command;

/** @mixin \Illuminate\Testing\PendingCommand */
final class PendingCommandMixin
{
    /**
     * Assert that the current command fails with a validation error.
     */
    public function assertFailedWithValidationError() : Closure
    {
        return function () : self
        {
            $this->assertExitCode(Command::INVALID)
                ->assertFailed();

            return $this;
        };
    }
}
