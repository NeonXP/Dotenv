<?php
declare(strict_types=1);

/**
 * @author: Alexander Kiryukhin <alexander@kiryukhin.su>
 * @license: MIT
 */

use NeonXP\Dotenv\Compiler\CompilerInterface;
use NeonXP\Dotenv\Dotenv;
use NeonXP\Dotenv\Exception\RuntimeException;
use NeonXP\Dotenv\Loader\LoaderInterface;
use NeonXP\Dotenv\Parser\ParserInterface;

use PHPUnit\Framework\TestCase;

/**
 * Class TestDotenv
 */
class DotenvTest extends TestCase
{
    /**
     * @var LoaderInterface
     */
    private $mockLoader;

    /**
     * @var ParserInterface
     */
    private $mockParser;

    /**
     * @var CompilerInterface
     */
    private $mockCompiler;

    public function setUp()
    {
        $this->mockLoader = new MockLoader();
        $this->mockParser = new MockParser();
        $this->mockCompiler = new MockCompiler();
    }

    public function testLoad()
    {
        $dotenv = new Dotenv($this->mockLoader, $this->mockParser, $this->mockCompiler);

        try {
            $dotenv->get('TEST1');
            $this->assertTrue(false, 'Dotenv must throws exception if it not loaded');
        } catch (RuntimeException $exception) {
            $this->assertTrue(true, 'Dotenv must throws exception if it not loaded');
        }

        $dotenv->load();

        $this->assertNull( $dotenv->get('NOT_EXISTS'));
        $this->assertEquals('default value', $dotenv->get('NOT_EXISTS', 'default value'));
        $this->assertEquals('VALUE3', $dotenv->get('KEY3', 'default value'));
        $this->assertEquals('VALUE3', $dotenv['KEY3']);
        $idx = 1;
        foreach ($dotenv as $key => $value) {
            $this->assertEquals("KEY{$idx}", $key);
            $this->assertEquals("VALUE{$idx}", $value);
            $idx++;
        }
    }
}