<?php

namespace Tests\Unit;

use Calculators\CalculatorProducer;
use Parsers\Parser;
use Parsers\ParserProducer;
use PHPUnit\Framework\TestCase;
use Processors\TransactionProcessor;
use Readers\FileReader;
use Readers\FileReaderProducer;

class TransactionProcessorTest extends TestCase
{
    /** @var string MOCK_DATA_FILENAME */
    private const MOCK_DATA_FILENAME = 'Tests/Mock/Data/input.txt';

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
     * Test process function
     * @return void
     */
    public function testProcessFunction(): void
    {
        $transactionProcessor = $this->mockTransactionProcess();
        $transactionProcessor->process();
    }

    public function tearDown(): void
    {
        \Mockery::close();
    }

    /**
     * Mock transaction processor
     * @return TransactionProcessor
     */
    private function mockTransactionProcess(): TransactionProcessor
    {
        // Create transaction processor
        $transactionProcessMock = $this->getMockBuilder(TransactionProcessor::class)
            ->setConstructorArgs([
                $this->fileReader,
                $this->parser,
            ])
            ->setMethods([
                'process',
            ])
            ->getMock();

        // Mock process function
        $transactionProcessMock
            ->expects($this->any())
            ->method('process')
            ->willReturnCallback(
                function () {
                    foreach ($this->fileReader->read() as $line) {
                        // Parse
                        $transactionData = $this->parser->parse($line);

                        // Set amount
                        $amount = $transactionData->amount;

                        // Get calculator
                        $calculator = CalculatorProducer::create(false);

                        // Calculate commission
                        $commission = $calculator->calculateCommission($amount);

                        // Assert
                        $this->assertIsFloat($commission);
                    }
                }
            );

        // Return
        return $transactionProcessMock;
    }

}
