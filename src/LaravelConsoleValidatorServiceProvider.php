<?php

declare(strict_types=1);

namespace PerryvanderMeer\LaravelConsoleValidator;

use Illuminate\Support\ServiceProvider;
use Illuminate\Testing\PendingCommand;
use PerryvanderMeer\LaravelConsoleValidator\Testing\PendingCommandMixin;

final class LaravelConsoleValidatorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot() : void
    {
        // Mixin with PendingCommand is only available
        // from laravel/framework version 11.9.0...
        if (method_exists(PendingCommand::class, 'mixin'))
        {
            PendingCommand::mixin(new PendingCommandMixin);
        }
    }
}
