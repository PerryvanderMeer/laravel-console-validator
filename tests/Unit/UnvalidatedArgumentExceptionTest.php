<?php

declare(strict_types=1);

use PerryvanderMeer\LaravelConsoleValidator\Exceptions\UnvalidatedArgumentException;

test('that the exception can be constructed', function ()
{
    $exception = new UnvalidatedArgumentException('foo');

    expect($exception->getMessage())
        ->toBe('The requested argument [foo] is not validated.');
});
