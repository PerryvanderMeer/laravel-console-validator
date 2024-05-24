<?php

declare(strict_types=1);

namespace PerryvanderMeer\LaravelConsoleValidator\Features;

trait PrepareArgumentsForValidation
{
    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation() : void
    {
        // You can prepare the given arguments for validation
        // by, for example, replacing the arguments with
        // $this->input->setArgument($name, $value);
    }
}
