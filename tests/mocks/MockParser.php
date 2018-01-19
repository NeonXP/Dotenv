<?php
declare(strict_types=1);

/**
 * @author: Alexander Kiryukhin <alexander@kiryukhin.su>
 * @license: MIT
 */

use NeonXP\Dotenv\Parser\ParserInterface;
use NeonXP\Dotenv\Types\KeyValue;

/**
 * Class MockParser
 */
class MockParser implements ParserInterface
{

    /**
     * @param string $line
     * @return KeyValue
     */
    public function parseLine(string $line): KeyValue
    {
        list($key, $value) = explode("=", $line);

        return new KeyValue($key, $value);
    }
}