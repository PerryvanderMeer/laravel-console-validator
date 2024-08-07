<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Artisan;
use PerryvanderMeer\LaravelConsoleValidator\Tests\TestCommands\ResolveValidationLogic\FakeCommandWithAttributesMethod;
use PerryvanderMeer\LaravelConsoleValidator\Tests\TestCommands\ResolveValidationLogic\FakeCommandWithAttributesProperty;
use PerryvanderMeer\LaravelConsoleValidator\Tests\TestCommands\ResolveValidationLogic\FakeCommandWithAttributesPropertyAndMethod;

use function Pest\Laravel\artisan;

test('that the validator registers attributes from the attributes property', function () : void
{
    Artisan::registerCommand(new FakeCommandWithAttributesProperty);

    artisan(FakeCommandWithAttributesProperty::class)
        ->assertSuccessful();

    expect((new FakeCommandWithAttributesProperty)->getExtractedValidationAttributesForCommand())
        ->toBeArray()
        ->toBe([
            'foo' => 'bar',
            'bar' => 'baz',
        ]);
});

test('that the validator registers attributes from the attributes method', function () : void
{
    Artisan::registerCommand(new FakeCommandWithAttributesMethod);

    artisan(FakeCommandWithAttributesMethod::class)
        ->assertSuccessful();

    expect((new FakeCommandWithAttributesMethod)->getExtractedValidationAttributesForCommand())
        ->toBeArray()
        ->toEqual([
            'baz' => 'bax',
            'bap' => 'qux',
        ]);
});

test('that the validator registers attributes from the both the attributes property and the attributes method', function () : void
{
    Artisan::registerCommand(new FakeCommandWithAttributesPropertyAndMethod);

    artisan(FakeCommandWithAttributesPropertyAndMethod::class)
        ->assertSuccessful();

    expect((new FakeCommandWithAttributesPropertyAndMethod)->getExtractedValidationAttributesForCommand())
        ->toBeArray()
        ->toEqual([
            'foo' => 'bar',
            'bar' => 'baz',
            'baz' => 'bax',
            'bap' => 'qux',
        ]);
});
