<?php
declare(strict_types=1);

/**
 * @author: Alexander Kiryukhin <alexander@kiryukhin.su>
 * @license: MIT
 */

use NeonXP\Dotenv\Types\KeyValue;
use PHPUnit\Framework\TestCase;

/**
 * Class CompilerTest
 */
class CompilerTest extends TestCase
{
    public function testParseLines()
    {
        $collection = [
            'KEY1' => 'VALUE1',
            'KEY2' => '${KEY1} ${KEY3}',
            'KEY3' => 'VALUE3',
            'KEY4' => 'Test ${KEY2} => ${KEY3}'
        ];
        $tests = [
            'KEY1' => 'VALUE1',
            'KEY2' => 'VALUE1 VALUE3',
            'KEY3' => 'VALUE3',
            'KEY4' => 'Test VALUE1 VALUE3 => VALUE3',
        ];
        $compiler = new \NeonXP\Dotenv\Compiler\Compiler();
        $collectionOfKeyValues = [];
        foreach ($collection as $key => $value) {
            $collectionOfKeyValues[] = new KeyValue($key, $value);
        }
        $compiler->setRawCollection($collectionOfKeyValues);

        foreach ($tests as $key => $expected) {
            $result = $compiler->compileKeyValue(new KeyValue($key, $collection[$key]));
            $this->assertEquals($key, $result->getKey());
            $this->assertEquals($expected, $result->getValue());
        }
    }
}