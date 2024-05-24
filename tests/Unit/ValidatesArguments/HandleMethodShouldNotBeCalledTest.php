<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;
use PerryvanderMeer\LaravelConsoleValidator\Tests\TestCommands\ValidatesArguments\FakeCommandToTestHandleMethod;
use Symfony\Component\Console\Command\Command;

use function Pest\Laravel\artisan;

test('that the handle method will not be called when the validator fails', function () : void
{
    Session::shouldReceive('put')->never();

    Artisan::registerCommand(new FakeCommandToTestHandleMethod());

    artisan(FakeCommandToTestHandleMethod::class, ['foo' => 'foo'])
        ->assertExitCode(Command::INVALID)
        ->assertFailed();
});

test('that the handle method will be called when the validator passes', function () : void
{
    Session::shouldReceive('put')->once();

    Artisan::registerCommand(new FakeCommandToTestHandleMethod());

    artisan(FakeCommandToTestHandleMethod::class, ['foo' => 'foo-bar'])
        ->assertSuccessful();
});
