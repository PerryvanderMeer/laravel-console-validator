<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Artisan;
use PerryvanderMeer\LaravelConsoleValidator\Tests\TestCommands\FakeCommandWithoutValidator;
use PerryvanderMeer\LaravelConsoleValidator\Tests\TestCommands\FakeCommandWithValidator;

use function Pest\Laravel\artisan;

test('that a normal command is working', function () : void
{
    Artisan::registerCommand(new FakeCommandWithoutValidator);

    artisan(FakeCommandWithoutValidator::class)
        ->assertSuccessful();
});

test('that a command with the validator is working', function () : void
{
    Artisan::registerCommand(new FakeCommandWithValidator);

    artisan(FakeCommandWithValidator::class)
        ->assertSuccessful();
});
