<?php

declare(strict_types=1);

namespace PerryvanderMeer\LaravelConsoleValidator\Features;

use Illuminate\Support\Arr;

trait ResolveValidationLogic
{
    /**
     * Get the validation rules that apply to the command.
     *
     * @return array<string, array<int, \Illuminate\Contracts\Validation\Rule|array|string>>
     */
    protected function getValidationRulesForCommand() : array
    {
        $rulesFromProperty = property_exists($this, 'rules') ? $this->rules : [];
        $rulesFromMethod = method_exists($this, 'rules') ? $this->rules() : [];

        foreach ($rulesFromProperty as &$ruleFromProperty)
        {
            $ruleFromProperty = Arr::wrap($ruleFromProperty);
        }

        foreach ($rulesFromMethod as &$ruleFromMethode)
        {
            $ruleFromMethode = Arr::wrap($ruleFromMethode);
        }

        return array_merge_recursive($rulesFromProperty, $rulesFromMethod);
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    protected function getValidationMessagesForCommand() : array
    {
        $messagesFromProperty = property_exists($this, 'messages') ? $this->messages : [];
        $messagesFromMethod = method_exists($this, 'messages') ? $this->messages() : [];

        return array_merge($messagesFromProperty, $messagesFromMethod);
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    protected function getValidationAttributesForCommand() : array
    {
        $attributesFromProperty = property_exists($this, 'attributes') ? $this->attributes : [];
        $attributesFromMethod = method_exists($this, 'attributes') ? $this->attributes() : [];

        return array_merge($attributesFromProperty, $attributesFromMethod);
    }
}
