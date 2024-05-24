<?php

declare(strict_types=1);

namespace PerryvanderMeer\LaravelConsoleValidator\Tests\TestCommands\ResolveValidationLogic;

use Illuminate\Console\Command;
use PerryvanderMeer\LaravelConsoleValidator\ValidatesArguments;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'fake-command-with-messages-method')]
final class FakeCommandWithMessagesMethod extends Command
{
    use ValidatesArguments;

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    protected function messages() : array
    {
        return [
            'baz' => 'bax',
            'bap' => 'qux',
        ];
    }

    /**
     * Execute the console command.
     */
    public function handle() : int
    {
        return Command::SUCCESS;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function getExtractedValidationMessagesForCommand() : array
    {
        return $this->getValidationMessagesForCommand();
    }
}
