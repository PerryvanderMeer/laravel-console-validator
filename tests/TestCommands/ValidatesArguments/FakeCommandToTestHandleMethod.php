<?php

declare(strict_types=1);

namespace PerryvanderMeer\LaravelConsoleValidator\Tests\TestCommands\ValidatesArguments;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Session;
use PerryvanderMeer\LaravelConsoleValidator\ValidatesArguments;

final class FakeCommandToTestHandleMethod extends Command
{
    use ValidatesArguments;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fake-command-to-test-handle-method {foo}';

    /**
     * Get the validation rules that apply to the command.
     *
     * @var array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    protected array $rules = [
        'foo' => ['min:4'],
    ];

    /**
     * Execute the console command.
     */
    public function handle() : int
    {
        Session::put('foo', 'bar');

        return Command::SUCCESS;
    }
}
