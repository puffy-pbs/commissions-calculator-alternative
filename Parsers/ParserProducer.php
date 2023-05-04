<?php

namespace Parsers;

final class ParserProducer
{
    /**
     * Parser producer
     * @return Parser
     */
    public static function create(): Parser
    {
        return new TransactionParser();
    }
}
