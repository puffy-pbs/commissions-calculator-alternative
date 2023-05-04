<?php

namespace Tests\Unit;

use Builders\TransactionDataBuilder;
use Entities\TransactionData;
use Parsers\Parser;
use Parsers\ParserProducer;
use PHPUnit\Framework\TestCase;
use Readers\FileReader;
use Readers\FileReaderProducer;

ini_set('auto_detect_line_endings',true);

class TransactionDataBuilderTest extends TestCase
{
    /** @var string MOCK_DATA_FILENAME */
    private const MOCK_DATA_FILENAME = 'Tests/Mock/Data/input.txt';

    /** @var string RANDOM_BIN */
    private const RANDOM_BIN = '123456';

    /** @var float RANDOM_AMOUNT */
    private const RANDOM_AMOUNT = 0.5;

    /** @var string RANDOM_CURRENCY */
    private const RANDOM_CURRENCY = 'JPY';

    /** @var FileReader $fileReader */
    private FileReader $fileReader;

    /** @var Parser $parser */
    private Parser $parser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->fileReader = FileReaderProducer::create(self::MOCK_DATA_FILENAME);
        $this->parser = ParserProducer::create();
    }

    /**
     * Can create transaction data from local file
     * @return void
     */
    public function testCanCreateTransactionDataFromLocalFileData(): void
    {
        foreach ($this->fileReader->read() as $line) {
            $transactionData = $this->parser->parse($line);
            $this->assertInstanceOf(TransactionData::class, $transactionData);
        }
    }

    /**
     * Can set string value for amount but object will have a float value
     * @return void
     */
    public function testCanSetStringValueForAmountButObjectWillHaveFloatForValue(): void
    {
        // Create Transaction data
        $transactionData = (new TransactionDataBuilder())
            ->setBin(self::RANDOM_BIN)
            ->setAmount(strval(self::RANDOM_AMOUNT))
            ->setCurrency(self::RANDOM_CURRENCY)
            ->build();

        // Assert
        $this->assertIsFloat($transactionData->amount);
    }
}
