<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Artisan;
use PerryvanderMeer\LaravelConsoleValidator\Exceptions\UnvalidatedArgumentException;
use PerryvanderMeer\LaravelConsoleValidator\Tests\TestCommands\CanGetValidatedArguments\FakeCommandToCollectAllValidatedArguments;
use PerryvanderMeer\LaravelConsoleValidator\Tests\TestCommands\CanGetValidatedArguments\FakeCommandToGetAllValidatedArguments;
use PerryvanderMeer\LaravelConsoleValidator\Tests\TestCommands\CanGetValidatedArguments\FakeCommandToGetAnUnvalidatedArgument;
use PerryvanderMeer\LaravelConsoleValidator\Tests\TestCommands\CanGetValidatedArguments\FakeCommandToGetASingleValidatedArgument;

use function Pest\Laravel\artisan;

test('that the command can get a single validated argument', function () : void
{
    Artisan::registerCommand(new FakeCommandToGetASingleValidatedArgument());

    artisan(FakeCommandToGetASingleValidatedArgument::class, ['foo' => 'foo', 'bar' => 'bar', 'baz' => 'baz'])
        ->expectsOutput("Foo: 'foo'")
        ->expectsOutput("Bar: 'bar'")
        ->assertSuccessful();
});

test('that the command can get a validated nullable argument', function () : void
{
    Artisan::registerCommand(new FakeCommandToGetASingleValidatedArgument());

    artisan(FakeCommandToGetASingleValidatedArgument::class, ['foo' => 'foo', 'bar' => null, 'baz' => 'baz'])
        ->expectsOutput("Foo: 'foo'")
        ->expectsOutput("Bar: ''")
        ->assertSuccessful();
});

test('that the command can not get an unvalidated argument', function () : void
{
    $this->expectException(UnvalidatedArgumentException::class);
    $this->expectExceptionMessage('The requested argument [foo] is not validated.');

    Artisan::registerCommand(new FakeCommandToGetAnUnvalidatedArgument());

    artisan(FakeCommandToGetAnUnvalidatedArgument::class, ['foo' => 'foo'])
        ->assertSuccessful();
});

test('that the command can get all validated argument', function () : void
{
    Artisan::registerCommand(new FakeCommandToGetAllValidatedArguments());

    artisan(FakeCommandToGetAllValidatedArguments::class, ['foo' => 'foo', 'bar' => 'bar', 'baz' => 'baz'])
        ->expectsOutput('{"foo":"foo","bar":"bar"}')
        ->assertSuccessful();
});

test('that the command can collect all validated argument', function () : void
{
    Artisan::registerCommand(new FakeCommandToCollectAllValidatedArguments());

    artisan(FakeCommandToCollectAllValidatedArguments::class, ['foo' => 'foo', 'bar' => 'bar', 'baz' => 'baz'])
        ->expectsOutput("Type: 'Illuminate\Support\Collection'")
        ->expectsOutput("Value: '{\"foo\":\"foo\",\"bar\":\"bar\"}'")
        ->assertSuccessful();
});
