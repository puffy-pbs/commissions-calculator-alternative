<?php

namespace Parsers;

interface Parser
{
    public function parse(string $line);
}
