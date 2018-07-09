<?php

declare(strict_types=1);
namespace Plab\Validator\Checker;

trait Scalar
{
    /**
     * @param mixed $value
     * @return bool
     */
    public static function isString($value): bool
    {
        return is_string($value);
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public static function isBoolean($value): bool
    {
        return is_bool($value);
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public static function isInteger($value): bool
    {
        return ctype_digit(strval($value));
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public static function isNumeric($value): bool
    {
        return is_numeric(strval($value));
    }
}
