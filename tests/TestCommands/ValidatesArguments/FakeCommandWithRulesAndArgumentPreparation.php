<?php

declare(strict_types=1);

namespace PerryvanderMeer\LaravelConsoleValidator\Tests\TestCommands\ValidatesArguments;

use Illuminate\Console\Command;
use PerryvanderMeer\LaravelConsoleValidator\ValidatesArguments;

final class FakeCommandWithRulesAndArgumentPreparation extends Command
{
    use ValidatesArguments;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fake-command-with-rules-and-argument-preparation {foo} {bar}';

    /**
     * Get the validation rules that apply to the command.
     *
     * @var array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    protected array $rules = [
        'foo' => ['min:7', 'ends_with:bop'],
        'bar' => ['min:7', 'ends_with:bop'],
    ];

    /**
     * Execute the console command.
     */
    public function handle() : int
    {
        return Command::SUCCESS;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation() : void
    {
        $this->input->setArgument(
            name: 'foo',
            value: "{$this->argument('foo')}bop",
        );
    }
}
