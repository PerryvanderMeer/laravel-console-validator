<?php

declare(strict_types=1);

namespace PerryvanderMeer\LaravelConsoleValidator\Tests\TestCommands\ValidatesArguments;

use Illuminate\Console\Command;
use PerryvanderMeer\LaravelConsoleValidator\ValidatesArguments;

final class FakeCommandWithRulesAndMessages extends Command
{
    use ValidatesArguments;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fake-command-with-rules-and-messages {foo} {bar} {baz}';

    /**
     * Get the validation rules that apply to the command.
     *
     * @var array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    protected array $rules = [
        'foo' => ['min:4', 'ends_with:bop'],
        'bar' => ['min:5', 'ends_with:bop'],
        'baz' => ['min:6', 'ends_with:bop'],
    ];

    /**
     * Get the error messages for the defined validation rules.
     *
     * @var array<string, string>
     */
    protected array $messages = [
        'foo' => 'Whoo general message for foo argument..!',
        'bar.min' => 'Hmm the bar argument is very short..!',
    ];

    /**
     * Execute the console command.
     */
    public function handle() : int
    {
        return Command::SUCCESS;
    }
}
