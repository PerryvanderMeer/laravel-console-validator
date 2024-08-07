<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Artisan;
use Illuminate\Validation\Rule;
use PerryvanderMeer\LaravelConsoleValidator\Tests\TestCommands\ResolveValidationLogic\FakeCommandWithRulesMethod;
use PerryvanderMeer\LaravelConsoleValidator\Tests\TestCommands\ResolveValidationLogic\FakeCommandWithRulesProperty;
use PerryvanderMeer\LaravelConsoleValidator\Tests\TestCommands\ResolveValidationLogic\FakeCommandWithRulesPropertyAndMethod;

use function Pest\Laravel\artisan;

test('that the validator registers rules from the rules property', function () : void
{
    Artisan::registerCommand(new FakeCommandWithRulesProperty);

    artisan(FakeCommandWithRulesProperty::class)
        ->assertSuccessful();

    expect((new FakeCommandWithRulesProperty)->getExtractedValidationRulesForCommand())
        ->toBeArray()
        ->toBe([
            'foo' => ['bar'],
            'bar' => ['bap'],
            'bax' => ['bup'],
        ]);
});

test('that the validator registers rules from the rules method', function () : void
{
    Artisan::registerCommand(new FakeCommandWithRulesMethod);

    artisan(FakeCommandWithRulesMethod::class)
        ->assertSuccessful();

    expect((new FakeCommandWithRulesMethod)->getExtractedValidationRulesForCommand())
        ->toBeArray()
        ->toEqual([
            'foo' => [Rule::file()],
            'bar' => ['baz'],
            'bax' => ['qux'],
        ]);
});

test('that the validator registers rules from the both the rules property and the rules method', function () : void
{
    Artisan::registerCommand(new FakeCommandWithRulesPropertyAndMethod);

    artisan(FakeCommandWithRulesPropertyAndMethod::class)
        ->assertSuccessful();

    expect((new FakeCommandWithRulesPropertyAndMethod)->getExtractedValidationRulesForCommand())
        ->toBeArray()
        ->toEqual([
            'foo' => ['bar', Rule::file()],
            'bar' => ['bap', 'baz'],
            'bax' => ['bup', 'qux'],
        ]);
});
