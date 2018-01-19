<?php
declare(strict_types=1);

/**
 * @author: Alexander Kiryukhin <alexander@kiryukhin.su>
 * @license: MIT
 */

namespace NeonXP\Dotenv\Parser;

/**
 * Interface ParserInterface
 * @package NeonXP\Dotenv\Parser
 */
interface ParserInterface
{
    /**
     * @param string $line
     * @return array
     */
    public function parseLine(string $line): array;
}