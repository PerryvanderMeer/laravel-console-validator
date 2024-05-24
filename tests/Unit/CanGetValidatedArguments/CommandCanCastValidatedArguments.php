<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Artisan;
use PerryvanderMeer\LaravelConsoleValidator\Tests\TestCommands\CanGetValidatedArguments\FakeCommandToCastASingleValidatedArgumentAsBool;
use PerryvanderMeer\LaravelConsoleValidator\Tests\TestCommands\CanGetValidatedArguments\FakeCommandToCastASingleValidatedArgumentAsString;

use function Pest\Laravel\artisan;

test('that the command can cast a validated argument as string', function () : void
{
    Artisan::registerCommand(new FakeCommandToCastASingleValidatedArgumentAsString());

    artisan(FakeCommandToCastASingleValidatedArgumentAsString::class, ['foo' => null])
        ->expectsOutput("Type: 'string'")
        ->expectsOutput("Value: ''")
        ->assertSuccessful();

    artisan(FakeCommandToCastASingleValidatedArgumentAsString::class, ['foo' => true])
        ->expectsOutput("Type: 'string'")
        ->expectsOutput("Value: '1'")
        ->assertSuccessful();

    artisan(FakeCommandToCastASingleValidatedArgumentAsString::class, ['foo' => 1])
        ->expectsOutput("Type: 'string'")
        ->expectsOutput("Value: '1'")
        ->assertSuccessful();

    artisan(FakeCommandToCastASingleValidatedArgumentAsString::class, ['foo' => 'foo'])
        ->expectsOutput("Type: 'string'")
        ->expectsOutput("Value: 'foo'")
        ->assertSuccessful();
});

test('that the command can cast a validated argument as boolean', function () : void
{
    Artisan::registerCommand(new FakeCommandToCastASingleValidatedArgumentAsBool());

    artisan(FakeCommandToCastASingleValidatedArgumentAsBool::class, ['foo' => null])
        ->expectsOutput("Type: 'boolean'")
        ->expectsOutput("Value: 'false'")
        ->assertSuccessful();

    artisan(FakeCommandToCastASingleValidatedArgumentAsBool::class, ['foo' => false])
        ->expectsOutput("Type: 'boolean'")
        ->expectsOutput("Value: 'false'")
        ->assertSuccessful();

    artisan(FakeCommandToCastASingleValidatedArgumentAsBool::class, ['foo' => 0])
        ->expectsOutput("Type: 'boolean'")
        ->expectsOutput("Value: 'false'")
        ->assertSuccessful();

    artisan(FakeCommandToCastASingleValidatedArgumentAsBool::class, ['foo' => 'foo'])
        ->expectsOutput("Type: 'boolean'")
        ->expectsOutput("Value: 'false'")
        ->assertSuccessful();

    artisan(FakeCommandToCastASingleValidatedArgumentAsBool::class, ['foo' => 'off'])
        ->expectsOutput("Type: 'boolean'")
        ->expectsOutput("Value: 'false'")
        ->assertSuccessful();

    artisan(FakeCommandToCastASingleValidatedArgumentAsBool::class, ['foo' => 'no'])
        ->expectsOutput("Type: 'boolean'")
        ->expectsOutput("Value: 'false'")
        ->assertSuccessful();

    artisan(FakeCommandToCastASingleValidatedArgumentAsBool::class, ['foo' => true])
        ->expectsOutput("Type: 'boolean'")
        ->expectsOutput("Value: 'true'")
        ->assertSuccessful();

    artisan(FakeCommandToCastASingleValidatedArgumentAsBool::class, ['foo' => 1])
        ->expectsOutput("Type: 'boolean'")
        ->expectsOutput("Value: 'true'")
        ->assertSuccessful();

    artisan(FakeCommandToCastASingleValidatedArgumentAsBool::class, ['foo' => 'on'])
        ->expectsOutput("Type: 'boolean'")
        ->expectsOutput("Value: 'true'")
        ->assertSuccessful();

    artisan(FakeCommandToCastASingleValidatedArgumentAsBool::class, ['foo' => 'yes'])
        ->expectsOutput("Type: 'boolean'")
        ->expectsOutput("Value: 'true'")
        ->assertSuccessful();
});
