<?php
declare(strict_types=1);

/**
 * @author: Alexander Kiryukhin <alexander@kiryukhin.su>
 * @license: MIT
 */

use NeonXP\Dotenv\Parser\ParserInterface;

/**
 * Class MockParser
 */
class MockParser implements ParserInterface
{

    /**
     * @param string $line
     * @return array
     */
    public function parseLine(string $line): array
    {
        list($key, $value) = explode("=", $line);

        return ['key' => $key, 'value' => $value];
    }
}