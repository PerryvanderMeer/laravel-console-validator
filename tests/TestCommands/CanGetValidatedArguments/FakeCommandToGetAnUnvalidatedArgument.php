<?php

declare(strict_types=1);

namespace PerryvanderMeer\LaravelConsoleValidator\Tests\TestCommands\CanGetValidatedArguments;

use Illuminate\Console\Command;
use PerryvanderMeer\LaravelConsoleValidator\ValidatesArguments;

final class FakeCommandToGetAnUnvalidatedArgument extends Command
{
    use ValidatesArguments;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fake-command-to-get-an-unvalidated-argument {foo}';

    /**
     * Execute the console command.
     */
    public function handle() : int
    {
        $this->line("Foo: '{$this->validated('foo')}'");

        return Command::SUCCESS;
    }
}
