<?php
/**
 * @author: Alexander Kiryukhin <alexander@kiryukhin.su>
 * @license: MIT
 */

namespace NeonXP\Dotenv\Parser;

use NeonXP\Dotenv\Types\KeyValue;

interface ParserInterface
{
    /**
     * @param string $line
     * @return KeyValue
     */
    public function parseLine(string $line): KeyValue;
}