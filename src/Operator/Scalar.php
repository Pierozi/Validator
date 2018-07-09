<?php

declare(strict_types=1);
namespace Plab\Validator\Operator;

trait Scalar
{
    /**
     * @param string $value
     * @return bool
     */
    public static function opNoSpace(string $value): bool
    {
        return 0 === preg_match('/\s+/', $value);
    }

    /**
     * @param string $value
     * @return int
     */
    public static function opLen(string $value): int
    {
        return strlen($value);
    }
}
