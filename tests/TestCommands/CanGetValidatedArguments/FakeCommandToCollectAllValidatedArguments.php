<?php

declare(strict_types=1);

namespace PerryvanderMeer\LaravelConsoleValidator\Tests\TestCommands\CanGetValidatedArguments;

use Illuminate\Console\Command;
use PerryvanderMeer\LaravelConsoleValidator\ValidatesArguments;

final class FakeCommandToCollectAllValidatedArguments extends Command
{
    use ValidatesArguments;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fake-command-to-collect-all-validated-arguments {foo} {bar} {baz}';

    /**
     * Get the validation rules that apply to the command.
     *
     * @var array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    protected array $rules = [
        'foo' => ['min:1'],
        'bar' => ['min:1'],
    ];

    /**
     * Execute the console command.
     */
    public function handle() : int
    {
        $type = get_class($this->collect());

        $this->line("Type: '{$type}'");
        $this->line("Value: '{$this->collect()->toJson()}'");

        return Command::SUCCESS;
    }
}
