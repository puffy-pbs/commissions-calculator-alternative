<?php

namespace Calculators;

class DefaultCalculator
{
    /** @var float $fee */
    private float $fee;

    /**
     * @param float $fee
     */
    public function __construct(float $fee)
    {
        $this->fee = $fee;
    }

    /**
     * Calculate commission
     * @param float $amount
     * @return float
     */
    public function calculateCommission(float $amount): float
    {
        return $amount * $this->fee;
    }
}
