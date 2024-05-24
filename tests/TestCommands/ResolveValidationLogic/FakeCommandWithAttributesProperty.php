<?php

declare(strict_types=1);

namespace PerryvanderMeer\LaravelConsoleValidator\Tests\TestCommands\ResolveValidationLogic;

use Illuminate\Console\Command;
use PerryvanderMeer\LaravelConsoleValidator\ValidatesArguments;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'fake-command-with-attributes-property')]
final class FakeCommandWithAttributesProperty extends Command
{
    use ValidatesArguments;

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    protected array $attributes = [
        'foo' => 'bar',
        'bar' => 'baz',
    ];

    /**
     * Execute the console command.
     */
    public function handle() : int
    {
        return Command::SUCCESS;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function getExtractedValidationAttributesForCommand() : array
    {
        return $this->getValidationAttributesForCommand();
    }
}
