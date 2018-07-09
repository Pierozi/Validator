<?php

declare(strict_types=1);
namespace Plab\Validator\Checker;

trait Identifier
{
    /**
     * @param string $value
     * @return bool
     */
    public function isUuid(string $value): bool
    {
        return 1 === preg_match('/^[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}$/', $value);
    }
}