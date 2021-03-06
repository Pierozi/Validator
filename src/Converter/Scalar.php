<?php

declare(strict_types=1);
namespace Plab\Validator\Converter;

use Hoa\Ustring\Ustring;

trait Scalar
{
    /**
     * Cast to native php string
     * @param mixed $value
     * @return string
     */
    public static function toString($value): string
    {
        return '' . $value;
    }

    /**
     * Cast value to Unicode String object served by Hoa\Ustring
     * @param mixed $value
     * @return Ustring
     */
    public static function toUString($value): Ustring
    {
        return new Ustring($value);
    }

    /**
     * Cast to native boolean string as web standard
     * @param mixed $value
     * @return bool
     */
    public static function toBoolean($value): bool
    {
        if ('true' === $value || 1 === $value || 'on' === $value) {
            return true;
        }

        if ('false' === $value || 0 === $value || 'off' === $value) {
            return false;
        }

        return (bool)($value);
    }

    /**
     * Cast to native integer
     * @param mixed $value
     * @return int
     */
    public static function toInteger($value): int
    {
        return (int)$value;
    }
}
