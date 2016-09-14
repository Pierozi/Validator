<?php

namespace Plab\Parameter\Checker;

trait Scalar
{
    public function isString($value)
    {
        return is_string($value);
    }

    public function isBoolean($value)
    {
        return is_bool($value);
    }
}
