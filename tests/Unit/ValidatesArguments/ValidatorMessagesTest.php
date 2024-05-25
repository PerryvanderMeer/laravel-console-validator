<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Lang;
use PerryvanderMeer\LaravelConsoleValidator\Tests\TestCommands\ValidatesArguments\FakeCommandWithRulesAndMessages;
use Symfony\Component\Console\Command\Command;

use function Pest\Laravel\artisan;

test('that the validator returns custom messages for a whole argument', function () : void
{
    Artisan::registerCommand(new FakeCommandWithRulesAndMessages());

    artisan(FakeCommandWithRulesAndMessages::class, ['foo' => 'foo', 'bar' => 'bar', 'baz' => 'baz'])
        ->expectsOutput('Whoo general message for foo argument..!')
        ->doesntExpectOutput('The foo field must be at least 4 characters.')
        ->doesntExpectOutput('The foo field must end with one of the following: bop.')
        ->assertExitCode(Command::INVALID)
        ->assertFailed();
});

test('that the validator returns custom messages for a specific rule', function () : void
{
    Artisan::registerCommand(new FakeCommandWithRulesAndMessages());

    artisan(FakeCommandWithRulesAndMessages::class, ['foo' => 'foo', 'bar' => 'bar', 'baz' => 'baz'])
        ->expectsOutput('Hmm the bar argument is very short..!')
        ->doesntExpectOutput('The bar field must be at least 5 characters.')
        ->expectsOutput('The bar field must end with one of the following: bop.')
        ->assertExitCode(Command::INVALID)
        ->assertFailed();
});

test('that the validator returns default messages ', function () : void
{
    Artisan::registerCommand(new FakeCommandWithRulesAndMessages());

    artisan(FakeCommandWithRulesAndMessages::class, ['foo' => 'foo', 'bar' => 'bar', 'baz' => 'baz'])
        ->expectsOutput('The baz field must be at least 6 characters.')
        ->expectsOutput('The baz field must end with one of the following: bop.')
        ->assertExitCode(Command::INVALID)
        ->assertFailed();
});

test('that the validator respects the app locale', function () : void
{
    config()->set('app.locale', 'nl');

    Artisan::registerCommand(new FakeCommandWithRulesAndMessages());

    Lang::addLines(
        lines: [
            'validation.min.string' => ':Attribute moet minimaal :min tekens zijn.',
            'validation.ends_with' => ':Attribute moet met één van de volgende waarden eindigen: :values.',
        ],
        locale: 'nl',
    );

    artisan(FakeCommandWithRulesAndMessages::class, ['foo' => 'foo', 'bar' => 'bar', 'baz' => 'baz'])
        ->expectsOutput('Baz moet minimaal 6 tekens zijn.')
        ->expectsOutput('Baz moet met één van de volgende waarden eindigen: bop.')
        ->assertExitCode(Command::INVALID)
        ->assertFailed();
});
