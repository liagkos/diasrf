<?php

namespace Liagkos\Banks\Dias;

/**
 * Create RF codes for dias payments based on RI18 algorithm
 */
class RF
{
    /**
     * @param $customer     string Merchant's customer id (4 digits)
     * @param $identifier   string Payment identifier (15 digits)
     * @param $value        float  Optional value to generate check code
     * @param $type         string Default is normal, otherwise set recurring payment (fixed order)
     * @return string              Payment code
     */
    static function create($customer, $identifier, $value = 0, $type = 'normal')
    {
        if ($value) {
            $factors = [1, 7, 3, 1, 7, 3, 1, 7, 3, 1, 7];
            $strNum = strrev((string) $value * 100);
            $sum = 0;
            for ($i=0, $iMax = strlen($strNum); $i < $iMax; $i++) {
                $sum += $strNum[$i] * $factors[0];
                array_shift($factors);
            }
            $checkDigit = $sum % 8;
        } else {
            $checkDigit = $type === 'normal' ? 8 : 9;
        }

        // Only use 4 list digits of customer id
        // ie 91234 --> 1234, 981234 --> 1234
        if (strlen($customer) > 4) {
            $customer = substr($customer, -4);
        }

        $X = '9' .
            substr(str_pad($customer, 4, '0', STR_PAD_LEFT), 0,4) .
            $checkDigit .
            substr(str_pad($identifier, 15, '0', STR_PAD_LEFT), 0,15);
        $Y = bcmod($X . '271500', 97);
        $CD = str_pad(98 - $Y, 2, '0', STR_PAD_LEFT);

        return 'RF' . $CD . $X;
    }

    /**
     * @param $RF   string Payment code including RF
     * @return bool        Payment code is valid for this customer and payment identifier
     */
    static function check($RF)
    {
        $A = substr($RF, 4) . 2715 . substr($RF, 2, 2);
        $Y = bcmod($A, 97);

        return $Y === '1';
    }
}
