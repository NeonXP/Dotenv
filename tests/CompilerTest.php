<?php
declare(strict_types=1);

/**
 * @author: Alexander Kiryukhin <alexander@kiryukhin.su>
 * @license: MIT
 */

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
        $collectionOfarrays = [];
        foreach ($collection as $key => $value) {
            $collectionOfarrays[] = ['key' => $key, 'value' => $value];
        }
        $compiler->setRawCollection($collectionOfarrays);

        foreach ($tests as $key => $expected) {
            $result = $compiler->compile(['key' => $key, 'value' => $collection[$key]]);
            $this->assertEquals($key, $result['key']);
            $this->assertEquals($expected, $result['value']);
        }
    }
}