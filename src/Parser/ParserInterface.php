<?php
declare(strict_types=1);

/**
 * @author: Alexander Kiryukhin <alexander@kiryukhin.su>
 * @license: MIT
 */

namespace NeonXP\Dotenv\Parser;

use NeonXP\Dotenv\Types\KeyValue;

/**
 * Interface ParserInterface
 * @package NeonXP\Dotenv\Parser
 */
interface ParserInterface
{
    /**
     * @param string $line
     * @return KeyValue
     */
    public function parseLine(string $line): KeyValue;
}