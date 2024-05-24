<?php

declare(strict_types=1);

namespace PerryvanderMeer\LaravelConsoleValidator\Tests\TestCommands\ResolveValidationLogic;

use Illuminate\Console\Command;
use Illuminate\Validation\Rule;
use PerryvanderMeer\LaravelConsoleValidator\ValidatesArguments;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'fake-command-with-rules-property-and-method')]
final class FakeCommandWithRulesPropertyAndMethod extends Command
{
    use ValidatesArguments;

    /**
     * Get the validation rules that apply to the command.
     *
     * @var array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    protected array $rules = [
        'foo' => ['bar'],
        'bar' => ['bap'],
        'bax' => 'bup',
    ];

    /**
     * Get the validation rules that apply to the command.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    protected function rules() : array
    {
        return [
            'foo' => Rule::file(),
            'bar' => ['baz'],
            'bax' => 'qux',
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
     * Get the validation rules that apply to the command.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function getExtractedValidationRulesForCommand() : array
    {
        return $this->getValidationRulesForCommand();
    }
}
