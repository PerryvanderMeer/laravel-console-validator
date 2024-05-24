<?php

declare(strict_types=1);

namespace PerryvanderMeer\LaravelConsoleValidator\Tests\TestCommands\PrepareArgumentsForValidation;

use Illuminate\Console\Command;
use PerryvanderMeer\LaravelConsoleValidator\ValidatesArguments;

final class FakeCommandWithArgumentsPreparation extends Command
{
    use ValidatesArguments;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fake-command-with-arguments-preparation {foo} {bar}';

    /**
     * Execute the console command.
     */
    public function handle() : int
    {
        // Will be "foo-bar" and "bar-foo"...
        $this->line($this->argument('foo'));
        $this->line($this->argument('bar'));

        // Force to call prepareForValidation() again...
        $this->arguments();

        // Still needs to be "foo-bar" and "bar-foo"...
        $this->line($this->argument('foo'));
        $this->line($this->argument('bar'));

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

        $this->input->setArgument(
            name: 'bar',
            value: "{$this->argument('bar')}-foo",
        );
    }
}
