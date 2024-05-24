<?php

declare(strict_types=1);

namespace PerryvanderMeer\LaravelConsoleValidator\Tests\TestCommands\PrepareArgumentsForValidation;

use Illuminate\Console\Command;
use PerryvanderMeer\LaravelConsoleValidator\ValidatesArguments;

final class FakeCommandWithArgumentPreparation extends Command
{
    use ValidatesArguments;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fake-command-with-argument-preparation {foo}';

    /**
     * Execute the console command.
     */
    public function handle() : int
    {
        // Will be "foo-bar"...
        $this->line($this->argument('foo'));

        // Force to call prepareForValidation() again...
        $this->arguments();

        // Still needs to be "foo-bar"...
        $this->line($this->argument('foo'));

        return Command::SUCCESS;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation() : void
    {
        $this->input->setArgument(
            name: 'foo',
            value: "{$this->argument('foo')}-bar",
        );
    }
}
