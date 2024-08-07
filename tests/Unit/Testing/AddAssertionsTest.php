<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Artisan;
use PerryvanderMeer\LaravelConsoleValidator\Tests\TestCommands\ValidatesArguments\FakeCommandWithRule;
use function Pest\Laravel\artisan;

test('that the assertFailedWithValidationError() assertion works', function () : void
{
    Artisan::registerCommand(new FakeCommandWithRule());

    artisan(FakeCommandWithRule::class, ['foo' => 'foo-bop'])
        ->assertSuccessful();

    artisan(FakeCommandWithRule::class, ['foo' => 'foo'])
        ->assertFailedWithValidationError();
})->skip(
    fn () : bool => version_compare(app()->version(), '11.9.0', '<'),
    'Mixin with PendingCommand is only available from 11.9.0',
);
