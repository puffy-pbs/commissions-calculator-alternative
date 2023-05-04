<?php

use Parsers\TransactionParser;
use Processors\TransactionProcessor;
use Readers\LocalFileReader;

// Require
require_once('vendor/autoload.php');

// Ancient Mac fix
ini_set('auto_detect_line_endings',true);

try {
    // Create calculator
    $commissionsCalculator = new TransactionProcessor(
        new LocalFileReader($argv[1] ?? ''),
        new TransactionParser()
    );

    // Start the process
    $commissionsCalculator->process();
} catch (Exception $e) {

}



