<?php

namespace Readers;

use InvalidArgumentException;
use Iterator;

class LocalFileReader implements FileReader
{
    /** @var false|resource $fileHandler */
    private $fileHandler;

    /**
     * @param string $fileName
     */
    public function __construct(string $fileName)
    {
        // File not found
        if (!file_exists($fileName)) {
            throw new InvalidArgumentException(' File not found');
        }

        $this->fileHandler = fopen($fileName, 'r');

        // File not valid
        if (!is_resource($this->fileHandler)) {
            throw new InvalidArgumentException('File not valid');
        }
    }

    public function __destruct()
    {
        fclose($this->fileHandler);
    }

    /**
     * Read each line and return it
     * @return Iterator
     */
    public function read(): Iterator
    {
        while (!feof($this->fileHandler)) {
            $line = fgets($this->fileHandler);
            $trimmedLine = trim($line);

            // If empty line - then skip
            if (empty($trimmedLine)) {
                continue;
            }

            yield $line;
        }
    }
}
