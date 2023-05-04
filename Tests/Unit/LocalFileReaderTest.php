<?php

namespace Tests\Unit;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Readers\FileReaderProducer;

class LocalFileReaderTest extends TestCase
{
    /** @var string NON_EXISTENT_FILENAME */
    private const NON_EXISTENT_FILENAME = 'iDoNotExist.txt';

    /** @var string EXISTING_FILENAME */
    private const EXISTING_FILENAME = 'Tests/Mock/Data/input.txt';

    /**
     * Throw exception if I pass not existing file
     * @return void
     */
    public function testThrowExceptionOnNonExistentFile(): void
    {
        $this->expectException(InvalidArgumentException::class);
        FileReaderProducer::create(self::NON_EXISTENT_FILENAME);
    }

    /**
     * I expect iterable on reading a valid file
     * @return void
     */
    public function testCanProcessExistingFile(): void
    {
        $fileReader = FileReaderProducer::create(self::EXISTING_FILENAME);
        $this->assertIsIterable($fileReader->read());
    }
}
