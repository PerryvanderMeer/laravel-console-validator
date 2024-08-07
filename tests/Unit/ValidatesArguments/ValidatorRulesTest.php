<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Artisan;
use PerryvanderMeer\LaravelConsoleValidator\Tests\TestCommands\ValidatesArguments\FakeCommandWithRule;
use PerryvanderMeer\LaravelConsoleValidator\Tests\TestCommands\ValidatesArguments\FakeCommandWithRules;
use PerryvanderMeer\LaravelConsoleValidator\Tests\TestCommands\ValidatesArguments\FakeCommandWithRulesAndArgumentPreparation;
use Symfony\Component\Console\Command\Command;

use function Pest\Laravel\artisan;

test('that the validator validates a single argument', function () : void
{
    Artisan::registerCommand(new FakeCommandWithRule);

    artisan(FakeCommandWithRule::class, ['foo' => 'foo'])
        ->expectsOutput('The foo field must be at least 4 characters.')
        ->expectsOutput('The foo field must end with one of the following: bop.')
        ->assertExitCode(Command::INVALID)
        ->assertFailed();

    artisan(FakeCommandWithRule::class, ['foo' => 'foo-bax'])
        ->doesntExpectOutput('The foo field must be at least 4 characters.')
        ->expectsOutput('The foo field must end with one of the following: bop.')
        ->assertExitCode(Command::INVALID)
        ->assertFailed();

    artisan(FakeCommandWithRule::class, ['foo' => 'foo-bop'])
        ->doesntExpectOutput('The foo field must be at least 4 characters.')
        ->doesntExpectOutput('The foo field must end with one of the following: bop.')
        ->assertSuccessful();
});

test('that the validator validates multiple arguments', function () : void
{
    Artisan::registerCommand(new FakeCommandWithRules);

    artisan(FakeCommandWithRules::class, ['foo' => 'foo', 'bar' => 'bar'])
        ->expectsOutput('The foo field must be at least 4 characters.')
        ->expectsOutput('The foo field must end with one of the following: bop.')
        ->expectsOutput('The bar field must be at least 5 characters.')
        ->expectsOutput('The bar field must end with one of the following: bop.')
        ->assertExitCode(Command::INVALID)
        ->assertFailed();

    artisan(FakeCommandWithRules::class, ['foo' => 'foo-bax', 'bar' => 'bar-bax'])
        ->doesntExpectOutput('The foo field must be at least 4 characters.')
        ->expectsOutput('The foo field must end with one of the following: bop.')
        ->doesntExpectOutput('The bar field must be at least 5 characters.')
        ->expectsOutput('The bar field must end with one of the following: bop.')
        ->assertExitCode(Command::INVALID)
        ->assertFailed();

    artisan(FakeCommandWithRules::class, ['foo' => 'foo-bop', 'bar' => 'bar-bop'])
        ->doesntExpectOutput('The foo field must be at least 4 characters.')
        ->doesntExpectOutput('The foo field must end with one of the following: bop.')
        ->doesntExpectOutput('The bar field must be at least 5 characters.')
        ->doesntExpectOutput('The bar field must end with one of the following: bop.')
        ->assertSuccessful();
});

test('that the validator performs the argument preparation before validating the arguments', function () : void
{
    Artisan::registerCommand(new FakeCommandWithRulesAndArgumentPreparation);

    artisan(FakeCommandWithRulesAndArgumentPreparation::class, ['foo' => 'foo', 'bar' => 'bar'])
        ->expectsOutput('The foo field must be at least 7 characters.')
        ->doesntExpectOutput('The foo field must end with one of the following: bop.')
        ->expectsOutput('The bar field must be at least 7 characters.')
        ->expectsOutput('The bar field must end with one of the following: bop.')
        ->assertExitCode(Command::INVALID)
        ->assertFailed();

    artisan(FakeCommandWithRulesAndArgumentPreparation::class, ['foo' => 'foo-', 'bar' => 'bar-'])
        ->doesntExpectOutput('The foo field must be at least 7 characters.')
        ->doesntExpectOutput('The foo field must end with one of the following: bop.')
        ->expectsOutput('The bar field must be at least 7 characters.')
        ->expectsOutput('The bar field must end with one of the following: bop.')
        ->assertExitCode(Command::INVALID)
        ->assertFailed();

    artisan(FakeCommandWithRulesAndArgumentPreparation::class, ['foo' => 'foo-', 'bar' => 'bar-bop'])
        ->doesntExpectOutput('The foo field must be at least 7 characters.')
        ->doesntExpectOutput('The foo field must end with one of the following: bop.')
        ->doesntExpectOutput('The bar field must be at least 7 characters.')
        ->doesntExpectOutput('The bar field must end with one of the following: bop.')
        ->assertSuccessful();
});
