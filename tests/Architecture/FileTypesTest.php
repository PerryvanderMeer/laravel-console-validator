<?php

declare(strict_types=1);

use PerryvanderMeer\LaravelConsoleValidator\ValidatesArguments;

arch('all files should use strict types')
    ->expect('PerryvanderMeer\\LaravelConsoleValidator')
    ->toUseStrictTypes();

arch('all exceptions should extend the base exception')
    ->expect('PerryvanderMeer\\LaravelConsoleValidator\\Exceptions')
    ->toExtend(Exception::class);

arch('all exceptions should end with Exception')
    ->expect('PerryvanderMeer\\LaravelConsoleValidator\\Exceptions')
    ->toHaveSuffix('Exception');

arch('all features should be traits')
    ->expect('PerryvanderMeer\\LaravelConsoleValidator\\Features')
    ->toBeTraits();

arch('all features should be stand-alone')
    ->expect('PerryvanderMeer\\LaravelConsoleValidator\\Features')
    ->toExtendNothing()
    ->toImplementNothing();

arch('all features should be used')
    ->expect('PerryvanderMeer\\LaravelConsoleValidator\\Features')
    ->toBeUsedIn(ValidatesArguments::class);
