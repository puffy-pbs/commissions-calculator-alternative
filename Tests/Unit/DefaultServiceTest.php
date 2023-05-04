<?php

namespace Tests\Unit;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Services\DefaultService;
use Services\ServiceProducer;

class DefaultServiceTest extends TestCase
{
    /** @var string BIN */
    private const BIN = '21345';

    /** @var string BINLIST_FILENAME */
    private const BINLIST_FILENAME = 'Tests/Mock/Data/validBinlistResponse.json';

    /** @var string RATES_FILENAME */
    private const RATES_FILENAME = 'Tests/Mock/Data/errorRatesResponse.json';

    /**
     * Return valid response when calling binlist endpoint
     * @return void
     */
    public function testCallBinlistReturnsValidResponse(): void
    {
        // Create service producer
        $serviceProducer = $this->mockServiceProducer(self::BIN);

        // Create service
        $service = $serviceProducer->create(self::BIN);

        // Assert
        $this->assertIsObject($service->getData());
    }

    /**
     * Returns error response when calling api exchange
     * @return void
     */
    public function testCallApiExchangeReturnsErrorResponse(): void
    {
        // Create service producer
        $serviceProducer = $this->mockServiceProducer();

        // Create service
        $service = $serviceProducer->create();

        // Assert
        $this->assertIsObject($service->getData());
    }

    public function tearDown(): void
    {
        \Mockery::close();
    }


    /**
     * Mock service producer
     * @param $bin
     * @return ServiceProducer
     */
    private function mockServiceProducer($bin = null): ServiceProducer
    {
        // Get service
        $defaultServiceMock = $this->mockService($bin);

        // Create service producer
        $serviceProducerMock = \Mockery::mock(ServiceProducer::class);
        $serviceProducerMock->shouldReceive('create')->andReturns($defaultServiceMock);

        // Return
        return $serviceProducerMock;
    }

    /**
     * Mock service
     * @param $bin
     * @return MockObject
     */
    private function mockService($bin = null): MockObject
    {
        // Get service mock
        $defaultServiceMock = $this->getMockBuilder(DefaultService::class)
            ->disableOriginalConstructor()
            ->setMethods(['getData'])
            ->getMock();

        // Mock getData method
        $defaultServiceMock->expects($this->any())
            ->method('getData')
            ->willReturnCallback(static function () use ($bin) {
                $fileName = $bin ? self::BINLIST_FILENAME : self::RATES_FILENAME;
                return json_decode(
                    file_get_contents($fileName)
                );
            });

        // Return
        return $defaultServiceMock;
    }
}
