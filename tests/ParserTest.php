<?php
declare(strict_types=1);

/**
 * @author: Alexander Kiryukhin <alexander@kiryukhin.su>
 * @license: MIT
 */

use NeonXP\Dotenv\Parser\Parser;
use PHPUnit\Framework\TestCase;

/**
 * Class ParserTest
 */
class ParserTest extends TestCase
{
    public function testParseLines()
    {
        $tests = [
            "key1='value1' # comment" => ['key1', 'value1'],
            "key2 = 'value2'" => ['key2', 'value2'],
            "key3 = \"value3\" # comment" => ['key3', 'value3'],
            "key4 =\"value4\"" => ['key4', 'value4'],
            "key5 ='value5 # not comment'" => ['key5', 'value5 # not comment'],
            "key6 = \"value6 # not comment\"" => ['key6', 'value6 # not comment'],
            "boolean=true" => ['boolean', true],
            "numeric = 123" => ['numeric', 123]
        ];

        $parser = new Parser();

        foreach ($tests as $test => $expected) {
            $result = $parser->parseLine($test);
            $this->assertEquals($expected[0], $result['key']);
            $this->assertEquals($expected[1], $result['value']);
        }
    }
}