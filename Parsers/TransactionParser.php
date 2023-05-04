<?php

namespace Parsers;

use Builders\TransactionDataBuilder;
use Entities\TransactionData;
use ReflectionClass;
use ReflectionProperty;

class TransactionParser implements Parser
{
    /**
     * Parse string and return transaction data object on success
     * @param string $line
     * @return TransactionData|null
     */
    public function parse(string $line): ?TransactionData
    {
        // Convert to array
        $toArray = json_decode($line, true);
        if (null === $toArray || !$this->hasValidKeys($toArray)) {
            return null;
        }

        // Return
        return (new TransactionDataBuilder())
            ->setBin($toArray['bin'])
            ->setAmount(floatval($toArray['amount']))
            ->setCurrency($toArray['currency'])
            ->build();
    }

    /**
     * Let`s validate our possibly correct JSON
     * @param array $decodedJson
     * @return bool
     */
    private function hasValidKeys(array $decodedJson): bool
    {
        // Get keys
        $decodedJsonKeys = array_keys($decodedJson);

        // Reflection here used for getting the properties of the Transaction Data class
        $reflectionClass = new ReflectionClass(TransactionData::class);

        // Get properties
        $classProperties = $reflectionClass->getProperties();

        // Check JSON keys
        $propertiesMatched = array_filter(
            $classProperties,
            function (ReflectionProperty $property) use ($decodedJsonKeys) {
                return in_array($property->getName(), $decodedJsonKeys, true);
            }
        );

        // Return
        return count($propertiesMatched) === count($classProperties);
    }

}
