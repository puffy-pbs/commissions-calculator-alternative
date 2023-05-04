<?php

namespace Tests\Unit;

use Base\Fees;
use Calculators\CalculatorProducer;
use PHPUnit\Framework\TestCase;

class DefaultCalculatorTest extends TestCase
{
    /** @var int AMOUNT */
    private const AMOUNT = 1;

    /** @var float|int NON_EU_COMMISSION */
    private const NON_EU_COMMISSION = Fees::NON_EU_FEE * self::AMOUNT;

    /** @var float|int EU_COMMISSION */
    private const EU_COMMISSION = Fees::EU_FEE * self::AMOUNT;

    /**
     * Can calculate non eu commission
     * @return void
     */
    public function testCanSuccessfullyCalculateNonEUCommission(): void
    {
        // Get calculator
        $calculator = CalculatorProducer::create(false);

        // Calculate fee
        $calculatedFee = $calculator->calculateCommission(self::AMOUNT);

        // Assert
        $this->assertIsFloat($calculatedFee);
        $this->assertSame(self::NON_EU_COMMISSION, $calculatedFee);
    }

    /**
     * Can calculate eu commission
     * @return void
     */
    public function testCanSuccessfullyCalculateEUCommission(): void
    {
        // Get calculator
        $calculator = CalculatorProducer::create(true);

        // Calculated fee
        $calculatedFee = $calculator->calculateCommission(self::AMOUNT);

        // Assert
        $this->assertIsFloat($calculatedFee);
        $this->assertSame(self::EU_COMMISSION, $calculatedFee);
    }
}
