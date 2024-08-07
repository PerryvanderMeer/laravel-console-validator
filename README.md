# Validate arguments in Laravel commands
[![Latest Version on Packagist](https://img.shields.io/packagist/v/perryvandermeer/laravel-console-validator.svg?style=flat-square)](https://packagist.org/packages/perryvandermeer/laravel-console-validator)
[![GitHub Pest Action Status](https://img.shields.io/github/actions/workflow/status/perryvandermeer/laravel-console-validator/pest.yml?branch=main&label=tests&style=flat-square)](https://github.com/perryvandermeer/laravel-console-validator/actions?query=workflow%3Apest+branch%3Amain)
[![GitHub Pint Status](https://img.shields.io/github/actions/workflow/status/perryvandermeer/laravel-console-validator/pint.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/perryvandermeer/laravel-console-validator/actions?query=workflow%3Apint+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/perryvandermeer/laravel-console-validator.svg?style=flat-square)](https://packagist.org/packages/perryvandermeer/laravel-console-validator)

This package allows you to easily validate all entered arguments in [Laravel commands](https://laravel.com/docs/11.x/artisan).

![laravel-console-validator](https://github.com/PerryvanderMeer/laravel-console-validator/assets/11609290/07494741-d7f1-4ae4-8f05-3fa79145de2a)

Here's a brief example where we will **automatically** validate the `foo` argument against the `required` and `min:3` rules:  

```php
<?php
 
namespace App\Console\Commands;
 
use Illuminate\Console\Command;
use PerryvanderMeer\LaravelConsoleValidator\ValidatesArguments;
 
class ExampleCommand extends Command
{
    use ValidatesArguments;
    
    /**
     * Set the validation rules that apply to the command.
     *
     * @var array<string, array|string>
     */
    protected array $rules = [
        'foo' => ['required', 'min:3'],
    ];
}
```

## Requirements
This package requires PHP 8.1+ and Laravel 10+.

## Installation
You can install the package via composer:

```bash
composer require perryvandermeer/laravel-console-validator
```

## Usage
To get started, you will need to include the `ValidatesArguments` trait in your [command](https://laravel.com/docs/11.x/artisan).  
When the command is executed, it will **automatically** perform validation before reaching the `handle()` method.
When the validation fails, the `handle()` method will <ins>never</ins> be executed.

```php
<?php
 
namespace App\Console\Commands;
 
use Illuminate\Console\Command;
use PerryvanderMeer\LaravelConsoleValidator\ValidatesArguments;
 
class ExampleCommand extends Command
{
    use ValidatesArguments;
}
```

## Configuring The Validator
Just like when you use [Laravel's validator](https://laravel.com/docs/validation), it is possible to configure the rules, messages and attributes.

### Rules
You may configure the validation rules used by the command by defining the `$rules` property and/or the `rules()` method.

The `rules()` method can be helpful if you are trying to use run-time syntaxes that aren't supported in array properties, like Laravel rule objects such as `Rule::password()`.
When you use both the `$rules` property and the `rules()` method, we merge them together.

The property and/or method should return an array of argument / rule pairs and their corresponding validation rules.

```php
/**
 * Set the validation rules that apply to the command.
 *
 * @var array<string, array|string>
 */
protected array $rules = [
    'title' => ['required', 'min:3'],
    'content' => 'required',
];
```

```php
/**
 * Get the validation rules that apply to the command.
 *
 * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
 */
protected function rules() : array
{
    return [
        'title' => ['required', 'min:3', Rule::unique('posts')],
        'content' => 'required',
    ];
}
```

### Messages
You may customize the error messages used by the command by defining the `$messages` property and/or the `messages()` method.

The `messages()` method can be helpful if you are trying to use run-time syntaxes that aren't supported in array properties.
When you use both the `$messages` property and the `messages()` method, we merge them together.

The property and/or method should return an array of argument / rule pairs and their corresponding error messages.

```php
/**
 * Set the error messages for the defined validation rules.
 *
 * @var array<string, string>
 */
protected array $messages = [
    'title' => 'Whoo general message for title argument..!',
    'content.min' => 'Hmm the content is very short..!',
];
```

```php
/**
 * Get the error messages for the defined validation rules.
 *
 * @return array<string, string>
 */
protected function messages() : array
{
    return [
        'title' => 'Whoo general message for title argument..!',
        'content.min' => 'Hmm the content is very short..!',
    ];   
}
```

### Attributes
Many of Laravel's built-in validation rule error messages contain an `:attribute` placeholder. 
As default, the name of the argument is used as `:attribute`.
If you would like the `:attribute` placeholder of your validation message to be replaced with a custom attribute name, you may specify the custom names by defining the `$attributes` property and/or the `attributes()` method..

The `attributes()` method can be helpful if you are trying to use run-time syntaxes that aren't supported in array properties.
When you use both the `$attributes` property and the `attributes()` method, we merge them together.

The property and/or method should return an array of argument / name pairs.

```php
/**
 * Set custom attributes for validator errors.
 *
 * @return array<string, string>
 */
protected array $attributes = [
    'title' => 'custom title',
    'content' => 'custom content',
];
```

```php
/**
 * Get custom attributes for validator errors.
 *
 * @return array<string, string>
 */
protected function attributes() : array
{
    return [
        'title' => 'custom title',
        'content' => 'custom content',
    ];
}
```

## Preparing Arguments For Validation
If you need to prepare or sanitize any data before you apply your validation rules, you may use the `prepareForValidation()` method.

```php
/**
 * Prepare the data for validation.
 */
protected function prepareForValidation() : void
{
     $this->input->setArgument(
        name: 'foo',
        value: "{$this->argument('foo')}-bar",
    );
}
```

## Working With Validated Arguments
Just like when you use [Laravel's validator](https://laravel.com/docs/validation#working-with-validated-input), it is possible to use the validated arguments in the rest of your implementation.

### Retrieving All Validated Arguments
After validating the arguments, you may wish to retrieve the arguments that actually underwent validation. 
This can be accomplished in several ways. First, you may call the `validated()` method within your command. 
This method returns an array of the data that was validated. 

```php
$this->validated(); // (array) ['foo' => 'bar', 'bar' => 'baz']
```

When you want a [Collection](https://laravel.com/docs/collections) of all arguments that underwent validation, you may call the `collect()` method within your command.
This method returns a [Collection](https://laravel.com/docs/collections) of the data that was validated.

```php
$this->collect(); // collect(['foo' => 'bar', 'bar' => 'baz'])
```

### Retrieving A Single Validated Argument
When you pass an argument to the `validated()` method, it will only return the validated value of that argument.
When the requested argument has not been validated, it will throw the `UnvalidatedArgumentException` exception.

```php
$this->validated('foo'); // (string) 'bar'
```

When you want to make sure the validated value of the argument is cast to a string, you may use the `string()` method.

```php
$this->string('foo'); // (string) 'bar'
```

Your command may receive "truthy" values that are actually strings, like `(string) 'true'` or `(string) 'on'`. 
You may use the `bool()` or `boolean()` method to retrieve these values as booleans.
Those methods use PHP's [FILTER_VALIDATE_BOOLEAN](https://www.php.net/manual/en/filter.filters.validate.php) flag to determine if the passed argument is `(bool) true` or `(bool) false`. 

```php
$this->boolean('foo'); // (bool) false
```

## Testing
When using `laravel/framework` above version `11.9.0`, you may use the custom `assertFailedWithValidationError()` method to assert that the command returned any validation error:

```php
use Symfony\Component\Console\Command\Command;

$this->artisan('foo')
    ->assertFailedWithValidationError();
```

When using a lower version of `laravel/framework`, you may use the `assertExitCode()` method to assert that the command returned any validation error:

```php
use Symfony\Component\Console\Command\Command;

$this->artisan('foo')
    ->assertExitCode(Command::INVALID);
```

In addition, it may be useful to test for a specific validation error.
You may use the `expectsOutput()` method to assert that the command returned a specific validation error:

```php
$this->artisan('foo')
    ->expectsOutput('The foo field must be at least 6 characters.') 
```

## Contributing
Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities
Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits
- [Perry van der Meer](https://github.com/PerryvanderMeer)
- [All Contributors](../../contributors)

## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
