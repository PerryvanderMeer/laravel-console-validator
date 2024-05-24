<?php

declare(strict_types=1);

namespace PerryvanderMeer\LaravelConsoleValidator\Tests\TestCommands;

use Illuminate\Console\Command;
use PerryvanderMeer\LaravelConsoleValidator\ValidatesArguments;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'fake-command-with-validator')]
final class FakeCommandWithValidator extends Command
{
    use ValidatesArguments;

    /**
     * Execute the console command.
     */
    public function handle() : int
    {
        return Command::SUCCESS;
    }
}
