<?php

declare(strict_types=1);
namespace Plab\Validator\Checker;

use Hoa\Ustring\Ustring;

trait Business
{
    /**
     * Check if value respect the French Siret algorithm
     *
     * @note SIRET are number of 14 digit long
     * 9 first digit are SIREN (or RCS) related,
     * 4 next digit are related to company number
     * 2 last digit are the LUHN key.
     *
     * @param string $value
     * @return bool
     */
    public function isSiret(string $value): bool
    {
        if (1 > ((int)$value) || 14 !== strlen((string)$value)) {
            return false;
        }

        $siret = new Ustring($value);
        $calc  = 0;

        foreach ($siret as $index => $number) {
            $number = (int)$number;

            if (0 !== ($index % 2)) {
                $calc += $number;
                continue;
            }

            if (9 < $number * 2) {
                $calc += ( $number * 2 ) - 9;
                continue;
            }

            $calc += ( $number * 2 );
        }

        return 0 === ($calc % 10);
    }

    /**
     * @param $value
     * @return bool
     */
    public function isPricePositive($value): bool
    {
        $value = (float)str_replace([',', '.'], '.', $value);
        return $value > 0;
    }
}