<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Artisan;
use PerryvanderMeer\LaravelConsoleValidator\Tests\TestCommands\ValidatesArguments\FakeCommandWithRulesAndAttributes;
use Symfony\Component\Console\Command\Command;

use function Pest\Laravel\artisan;

test('that the validator supports custom attributes for an argument', function () : void
{
    Artisan::registerCommand(new FakeCommandWithRulesAndAttributes);

    artisan(FakeCommandWithRulesAndAttributes::class, ['foo' => 'foo', 'bar' => 'bar'])
        ->expectsOutput('The first field must be at least 4 characters.')
        ->expectsOutput('The first field must end with one of the following: bop.')
        ->expectsOutput('The bar field must be at least 5 characters.')
        ->expectsOutput('The bar field must end with one of the following: bop.')
        ->assertExitCode(Command::INVALID)
        ->assertFailed();
});
