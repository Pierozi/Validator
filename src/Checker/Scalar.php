<?php

declare(strict_types=1);
namespace Plab\Validator\Checker;

trait Scalar
{
    public static function isString($value): bool
    {
        return is_string($value);
    }

    public static function isBoolean($value): bool
    {
        return is_bool($value);
    }

    public static function isInteger($value): bool
    {
        return ctype_digit(strval($value));
    }

    public static function isNumeric($value): bool
    {
        return is_numeric(strval($value));
    }
}
