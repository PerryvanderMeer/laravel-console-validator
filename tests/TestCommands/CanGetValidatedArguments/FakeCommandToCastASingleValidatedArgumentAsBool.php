<?php

declare(strict_types=1);

namespace PerryvanderMeer\LaravelConsoleValidator\Tests\TestCommands\CanGetValidatedArguments;

use Illuminate\Console\Command;
use LogicException;
use PerryvanderMeer\LaravelConsoleValidator\ValidatesArguments;

final class FakeCommandToCastASingleValidatedArgumentAsBool extends Command
{
    use ValidatesArguments;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fake-command-to-cast-a-single-validated-argument-as-bool {foo}';

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
        if ($this->bool('foo') !== $this->boolean('foo'))
        {
            throw new LogicException();
        }

        $type = gettype($this->bool('foo'));
        $value = $this->bool('foo') ? 'true' : 'false';

        $this->line("Type: '{$type}'");
        $this->line("Value: '{$value}'");

        return Command::SUCCESS;
    }
}
