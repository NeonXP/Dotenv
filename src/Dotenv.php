<?php
declare(strict_types=1);

/**
 * @author: Alexander Kiryukhin <alexander@kiryukhin.su>
 * @license: MIT
 */

namespace NeonXP\Dotenv;

use NeonXP\Dotenv\Compiler\Compiler;
use NeonXP\Dotenv\Compiler\CompilerInterface;
use NeonXP\Dotenv\Exception\RuntimeException;
use NeonXP\Dotenv\Loader\FileLoader;
use NeonXP\Dotenv\Loader\LoaderInterface;
use NeonXP\Dotenv\Parser\Parser;
use NeonXP\Dotenv\Parser\ParserInterface;
use NeonXP\Dotenv\Types\KeyValue;

/**
 * Class Dotenv
 * @package NeonXP\Dotenv
 */
class Dotenv implements \ArrayAccess, \IteratorAggregate
{
    /**
     * @var LoaderInterface
     */
    private $loader;
    /**
     * @var ParserInterface
     */
    private $parser;
    /**
     * @var CompilerInterface
     */
    private $compiler;

    /**
     * @var array
     */
    private $loadedValues;

    /**
     * Dotenv constructor.
     * @param LoaderInterface $loader
     * @param ParserInterface $parser
     * @param CompilerInterface $compiler
     */
    public function __construct(LoaderInterface $loader = null, ParserInterface $parser = null, CompilerInterface $compiler = null)
    {
        if (!$loader) {
            $loader = new FileLoader(); // Default loader
        }
        if (!$parser) {
            $parser = new Parser(); // Default parser
        }
        if (!$compiler) {
            $compiler = new Compiler(); // Default compiler
        }

        $this->loader = $loader;
        $this->parser = $parser;
        $this->compiler = $compiler;
    }

    /**
     * Load .env file using loader and parse it
     * @param string $filePath
     * @return Dotenv
     */
    public function load(string $filePath = '.env'): Dotenv
    {
        $lines = $this->loader->load($filePath);
        $rawData = array_map([$this->parser, 'parseLine'], $lines);
        $this->compiler->setRawCollection($rawData);
        $this->loadedValues = array_reduce(
            array_map([$this->compiler, 'compileKeyValue'], $rawData),
            function (array $acc, KeyValue $current) {
                $acc[$current->getKey()] = $current->getValue();
                return $acc;
            },
            []
        );
        foreach ($this->loadedValues as $key => $value) {
            $_ENV[$key] = $value;
            $_SERVER[$key] = $value;
            putenv($key . "=" . $value);
        }

        return $this;
    }

    /**
     * Is key exists
     * @param string $key
     * @return bool
     * @throws RuntimeException
     */
    public function has(string $key): bool
    {
        $this->checkIsLoaded();
        return isset($this->loadedValues[$key]);
    }

    /**
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     * @throws RuntimeException
     */
    public function get(string $key, $default = null)
    {
        if (!$this->has($key)) {
            return $default;
        }
        return $this->loadedValues[$key];
    }

    /**
     * @internal
     * @throws RuntimeException
     * @return void
     */
    protected function checkIsLoaded(): void
    {
        if (!$this->loadedValues) {
            throw new RuntimeException('Dotenv file not loaded');
        }
    }

    /**
     * @inheritdoc
     * @return \ArrayIterator|\Traversable
     * @throws RuntimeException
     */
    public function getIterator()
    {
        $this->checkIsLoaded();
        return new \ArrayIterator($this->loadedValues);
    }

    /**
     * @inheritdoc
     * @param string $offset
     * @return bool
     * @throws RuntimeException
     */
    public function offsetExists($offset): bool
    {
        return $this->has($offset);
    }

    /**
     * @inheritdoc
     * @param string $offset
     * @return mixed
     * @throws RuntimeException
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * @inheritdoc
     * @param string $offset
     * @param mixed $value
     * @throws RuntimeException
     */
    public function offsetSet($offset, $value)
    {
        throw new RuntimeException('Collection is immutable');
    }

    /**
     * @inheritdoc
     * @param string $offset
     * @throws RuntimeException
     */
    public function offsetUnset($offset)
    {
        throw new RuntimeException('Collection is immutable');
    }


}