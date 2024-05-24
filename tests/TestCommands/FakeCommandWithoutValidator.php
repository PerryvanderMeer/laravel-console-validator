<?php

declare(strict_types=1);

namespace PerryvanderMeer\LaravelConsoleValidator\Tests\TestCommands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'fake-command-without-validator')]
final class FakeCommandWithoutValidator extends Command
{
    /**
     * Execute the console command.
     */
    public function handle() : int
    {
        return Command::SUCCESS;
    }
}
