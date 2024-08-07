<?php

declare(strict_types=1);

namespace PerryvanderMeer\LaravelConsoleValidator\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use PerryvanderMeer\LaravelConsoleValidator\LaravelConsoleValidatorServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            LaravelConsoleValidatorServiceProvider::class,
        ];
    }
}
