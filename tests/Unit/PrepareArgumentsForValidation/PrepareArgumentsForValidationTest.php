<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Artisan;
use PerryvanderMeer\LaravelConsoleValidator\Tests\TestCommands\PrepareArgumentsForValidation\FakeCommandWithArgumentPreparation;
use PerryvanderMeer\LaravelConsoleValidator\Tests\TestCommands\PrepareArgumentsForValidation\FakeCommandWithArgumentsPreparation;

use function Pest\Laravel\artisan;

test('that the validator prepares the argument for validation', function () : void
{
    Artisan::registerCommand(new FakeCommandWithArgumentPreparation);

    artisan(FakeCommandWithArgumentPreparation::class, ['foo' => 'foo'])
        ->expectsOutput('foo-bar')
        ->expectsOutput('foo-bar')
        ->doesntExpectOutput('foo-bar-bar')
        ->assertSuccessful();
});

test('that the validator prepares the arguments for validation', function () : void
{
    Artisan::registerCommand(new FakeCommandWithArgumentsPreparation);

    artisan(FakeCommandWithArgumentsPreparation::class, ['foo' => 'foo', 'bar' => 'bar'])
        ->expectsOutput('foo-bar')
        ->expectsOutput('bar-foo')
        ->expectsOutput('foo-bar')
        ->expectsOutput('bar-foo')
        ->doesntExpectOutput('foo-bar-bar')
        ->doesntExpectOutput('bar-foo-foo')
        ->assertSuccessful();
});
