<?php

namespace Plab\Validator\Checker;

trait Scalar
{
    public static function isString($value)
    {
        return is_string($value);
    }

    public static function isBoolean($value)
    {
        return is_bool($value);
    }

    public static function isInteger($value)
    {
        return ctype_digit(strval($value));
    }
}
