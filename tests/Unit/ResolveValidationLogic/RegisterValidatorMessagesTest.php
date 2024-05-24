<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Artisan;
use PerryvanderMeer\LaravelConsoleValidator\Tests\TestCommands\ResolveValidationLogic\FakeCommandWithMessagesMethod;
use PerryvanderMeer\LaravelConsoleValidator\Tests\TestCommands\ResolveValidationLogic\FakeCommandWithMessagesProperty;
use PerryvanderMeer\LaravelConsoleValidator\Tests\TestCommands\ResolveValidationLogic\FakeCommandWithMessagesPropertyAndMethod;

use function Pest\Laravel\artisan;

test('that the validator registers messages from the messages property', function () : void
{
    Artisan::registerCommand(new FakeCommandWithMessagesProperty());

    artisan(FakeCommandWithMessagesProperty::class)
        ->assertSuccessful();

    expect((new FakeCommandWithMessagesProperty())->getExtractedValidationMessagesForCommand())
        ->toBeArray()
        ->toBe([
            'foo' => 'bar',
            'bar' => 'baz',
        ]);
});

test('that the validator registers messages from the messages method', function () : void
{
    Artisan::registerCommand(new FakeCommandWithMessagesMethod());

    artisan(FakeCommandWithMessagesMethod::class)
        ->assertSuccessful();

    expect((new FakeCommandWithMessagesMethod())->getExtractedValidationMessagesForCommand())
        ->toBeArray()
        ->toEqual([
            'baz' => 'bax',
            'bap' => 'qux',
        ]);
});

test('that the validator registers messages from the both the messages property and the messages method', function () : void
{
    Artisan::registerCommand(new FakeCommandWithMessagesPropertyAndMethod());

    artisan(FakeCommandWithMessagesPropertyAndMethod::class)
        ->assertSuccessful();

    expect((new FakeCommandWithMessagesPropertyAndMethod())->getExtractedValidationMessagesForCommand())
        ->toBeArray()
        ->toEqual([
            'foo' => 'bar',
            'bar' => 'baz',
            'baz' => 'bax',
            'bap' => 'qux',
        ]);
});
