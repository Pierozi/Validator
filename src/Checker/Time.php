<?php

declare(strict_types=1);
namespace Plab\Validator\Checker;

trait Time
{
    public function isDatetime($value): bool
    {
        try {
            new \DateTimeImmutable($value);
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }

    public function isTimestamp($value): bool
    {
        $value = (int)$value;
        $value = (string)$value;

        return 10 === strlen($value);
    }
}