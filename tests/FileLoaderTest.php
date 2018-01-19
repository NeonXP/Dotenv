<?php
declare(strict_types=1);

/**
 * @author: Alexander Kiryukhin <alexander@kiryukhin.su>
 * @license: MIT
 */
use PHPUnit\Framework\TestCase;

/**
 * Class FileLoaderTest
 */
class FileLoaderTest extends TestCase
{
    public function testLoadfile()
    {
        $loader = new NeonXP\Dotenv\Loader\FileLoader();

        $result = $loader->load(__DIR__ . '/misc/.env.test');

        $this->assertEquals(['KEY1=VALUE1', 'KEY2=VALUE2'], $result);
    }
}