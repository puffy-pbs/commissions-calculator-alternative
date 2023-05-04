<?php

namespace Tests\Unit;

use Entities\TransactionData;
use Parsers\ParserProducer;
use Parsers\TransactionParser;
use PHPUnit\Framework\TestCase;

class TransactionParserTest extends TestCase
{
    /** @var string NON_VALID_JSON */
    private const NON_VALID_JSON = '{"hello"}';

    /** @var string VALID_JSON_WITH_WRONG_PROPERTIES */
    private const VALID_JSON_WITH_WRONG_PROPERTIES = '{"ops": "sorry"}';

    /** @var string VALID_JSON_WITH_VALID_PROPERTIES */
    private const VALID_JSON_WITH_VALID_PROPERTIES = '{"bin":"4745030","amount":"2000222.00","currency":"GBP"}';

    /** @var TransactionParser $transactionParser */
    private TransactionParser $transactionParser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->transactionParser = ParserProducer::create(); // It should be changed if more Parsers are added
    }

    /**
     * I except to get null on messed-up json value
     * @return void
     */
    public function testReturnsNullOnInvalidJson(): void
    {
        $parsedData = $this->transactionParser->parse(self::NON_VALID_JSON);
        $this->assertNull($parsedData);
    }

    /**
     * I expect to get null on valid json with wrong keys
     * @return void
     */
    public function testReturnsNullOnValidJsonButWIthWrongProperties(): void
    {
        $parsedData = $this->transactionParser->parse(self::VALID_JSON_WITH_WRONG_PROPERTIES);
        $this->assertNull($parsedData);
    }

    /**
     * I expect to successfully parse valid json
     * @return void
     */
    public function testReturnsParsedDataOnValidJsonWithValidProperties(): void
    {
        $parsedData = $this->transactionParser->parse(self::VALID_JSON_WITH_VALID_PROPERTIES);
        $this->assertInstanceOf(TransactionData::class, $parsedData);
    }
}
