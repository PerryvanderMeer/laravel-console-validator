<?php

declare(strict_types=1);

namespace PerryvanderMeer\LaravelConsoleValidator;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Validator as ConsoleValidator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

trait ValidatesArguments
{
    use Features\CanGetValidatedArguments;
    use Features\PrepareArgumentsForValidation;
    use Features\ResolveValidationLogic;

    /**
     * The validator instance for this command.
     */
    protected ConsoleValidator $validator;

    /**
     * Execute the console command.
     */
    #[\Override]
    protected function execute(InputInterface $input, OutputInterface $output) : int
    {
        $this->prepareForValidation();

        $this->validator = Validator::make(
            data: $this->arguments(),
            rules: $this->getValidationRulesForCommand(),
            messages: $this->getValidationMessagesForCommand(),
            attributes: $this->getValidationAttributesForCommand(),
        );

        if ($this->validator->fails())
        {
            foreach ($this->validator->errors()->all() as $error)
            {
                $this->error($error);
            }

            return Command::INVALID;
        }

        return parent::execute($input, $output);
    }
}
