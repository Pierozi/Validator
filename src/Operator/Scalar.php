<?php

declare(strict_types=1);
namespace Plab\Validator\Operator;

trait Scalar
{
    public static function opNoSpace($value): bool
    {
        return 0 === preg_match('/\s+/', $value);
    }

    public static function opLen($value): int
    {
        return strlen($value);
    }
}
