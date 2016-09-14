<?php

namespace Plab\Parameter\Converter;

trait Scalar
{
    public function toString($value) : string
    {
        return '' . $value;
    }

    public function toBoolean($value) : bool
    {
        if ('true' === $value || 1 === $value || 'on' === $value) {
            return true;
        }

        if ('false' === $value || 0 === $value || 'off' === $value) {
            return false;
        }

        return (bool)($value);
    }
}
