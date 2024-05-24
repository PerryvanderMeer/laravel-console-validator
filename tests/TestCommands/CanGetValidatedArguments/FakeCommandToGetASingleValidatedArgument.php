<?php

declare(strict_types=1);

namespace PerryvanderMeer\LaravelConsoleValidator\Tests\TestCommands\CanGetValidatedArguments;

use Illuminate\Console\Command;
use PerryvanderMeer\LaravelConsoleValidator\ValidatesArguments;

final class FakeCommandToGetASingleValidatedArgument extends Command
{
    use ValidatesArguments;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fake-command-to-get-a-single-validated-argument {foo} {bar} {baz}';

    /**
     * Get the validation rules that apply to the command.
     *
     * @var array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    protected array $rules = [
        'foo' => ['min:1'],
        'bar' => ['nullable'],
    ];

    /**
     * Execute the console command.
     */
    public function handle() : int
    {
        $this->line("Foo: '{$this->validated('foo')}'");
        $this->line("Bar: '{$this->validated('bar')}'");

        return Command::SUCCESS;
    }
}
