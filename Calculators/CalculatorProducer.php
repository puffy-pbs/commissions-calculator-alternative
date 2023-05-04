<?php

namespace Calculators;

use Base\Fees;

class CalculatorProducer
{
    /**
     * Calculator producer
     * @param bool $isEU
     * @return DefaultCalculator
     */
    public static function create(bool $isEU): DefaultCalculator
    {
        $fee = Fees::NON_EU_FEE;
        if ($isEU) {
            $fee = Fees::EU_FEE;
        }

        return new DefaultCalculator($fee);
    }
}
