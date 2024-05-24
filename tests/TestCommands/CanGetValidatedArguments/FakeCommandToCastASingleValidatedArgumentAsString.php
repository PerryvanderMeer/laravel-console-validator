<?php

declare(strict_types=1);

namespace PerryvanderMeer\LaravelConsoleValidator\Tests\TestCommands\CanGetValidatedArguments;

use Illuminate\Console\Command;
use PerryvanderMeer\LaravelConsoleValidator\ValidatesArguments;

final class FakeCommandToCastASingleValidatedArgumentAsString extends Command
{
    use ValidatesArguments;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fake-command-to-cast-a-single-validated-argument-as-string {foo}';

    /**
     * Get the validation rules that apply to the command.
     *
     * @var array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    protected array $rules = [
        'foo' => ['present'],
    ];

    /**
     * Execute the console command.
     */
    public function handle() : int
    {
        $type = gettype($this->string('foo'));

        $this->line("Type: '{$type}'");
        $this->line("Value: '{$this->string('foo')}'");

        return Command::SUCCESS;
    }
}
