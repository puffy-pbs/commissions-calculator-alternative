<?php

namespace Processors;

use Base\Currency;
use Base\IsEUChecker;
use Calculators\CalculatorProducer;
use Parsers\Parser;
use Readers\FileReader;
use Services\ServiceProducer;

class TransactionProcessor
{
    /** @var FileReader $fileReader */
    private FileReader $fileReader;

    /** @var Parser $parser */
    private Parser $parser;

    /**
     * @param FileReader $fileReader
     * @param Parser $parser
     */
    public function __construct(FileReader $fileReader, Parser $parser)
    {
        $this->fileReader = $fileReader;
        $this->parser = $parser;
    }

    /**
     * Process
     * @return void
     */
    public function process(): void
    {
        foreach ($this->fileReader->read() as $line) {
            // Parse
            $transactionData = $this->parser->parse($line);
            if (null === $transactionData) {
                continue;
            }

            // Get latest exchange rates
            $latestExchangeRates = ServiceProducer::create()->getData();

            // Extract currency
            $currency = $transactionData->currency;

            // Set rate
            $rate = 0;

            // If rates are being retrieved then get the one for the current currency
            if (isset($latestExchangeRates->rates->{$currency})) {
                $rate = $latestExchangeRates->rates->{$currency};
            }

            // Set amount
            $amount = $transactionData->amount;

            // If currency is not EUR and rate is > 0 then calculate
            if ($currency !== Currency::EUR && $rate > 0) {
                $amount /= $rate;
            }

            // Get data for current BIN
            $binResults = ServiceProducer::create($transactionData->bin)->getData();
            if (empty($binResults)) {
                continue;
            }

            // Extract country code
            $countryCode = $binResults->country->alpha2;

            // Is country from EU ?
            $isEU = IsEUChecker::isEU($countryCode);

            // Get calculator
            $calculator = CalculatorProducer::create($isEU);

            // Print
            echo($calculator->calculateCommission($amount) . PHP_EOL);
        }
    }
}
