<?php

declare(strict_types=1);
namespace Plab\Validator\Fixtures;

use Plab\Validator\Checker\Identifier;
use Plab\Validator\Checker\Scalar;

class Parameter extends \Plab\Validator\Parameter
{
    use Scalar;
    use Identifier;

    const checkersRules = [
        'uuid' => 'isUuid(value)',
        'city' => 'isString(value) and len(value) < 32',
    ];

    const mandatory = [
        'city',
    ];
}