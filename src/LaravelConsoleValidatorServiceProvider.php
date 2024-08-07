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
        PendingCommand::mixin(new PendingCommandMixin());
    }
}
