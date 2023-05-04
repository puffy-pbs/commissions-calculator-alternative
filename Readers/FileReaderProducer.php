<?php

namespace Readers;

final class FileReaderProducer
{
    /**
     * Reader producer
     * @param string $fileName
     * @return FileReader
     */
    public static function create(string $fileName): FileReader
    {
        return new LocalFileReader($fileName);
    }
}
