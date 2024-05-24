<?php

declare(strict_types=1);

arch('it will not use debugging functions')
    ->expect(['dd', 'dump', 'ray', 'env', 'exit', 'die', 'print_r', 'var_dump', 'echo', 'print', 'phpinfo'])
    ->not->toBeUsed();
