<?php

namespace Builders;

use Entities\TransactionData;

final class TransactionDataBuilder implements Builder
{
    /** @var TransactionData $transactionData */
    private TransactionData $transactionData;

    public function __construct()
    {
        $this->transactionData = new TransactionData();
    }

    /**
     * Set bin
     * @param string $bin
     * @return $this
     */
    public function setBin(string $bin): TransactionDataBuilder
    {
        $this->transactionData->bin = $bin;
        return $this;
    }

    /**
     * Set amount
     * @param float $amount
     * @return $this
     */
    public function setAmount(float $amount): TransactionDataBuilder
    {
        $this->transactionData->amount = $amount;
        return $this;
    }

    /**
     * Set currency
     * @param string $currency
     * @return $this
     */
    public function setCurrency(string $currency): TransactionDataBuilder
    {
        $this->transactionData->currency = $currency;
        return $this;
    }

    /**
     * Build
     * @return TransactionData
     */
    public function build(): TransactionData
    {
        return $this->transactionData;
    }
}
