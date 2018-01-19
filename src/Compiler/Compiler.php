<?php
declare(strict_types=1);

/**
 * @author: Alexander Kiryukhin <alexander@kiryukhin.su>
 * @license: MIT
 */

namespace NeonXP\Dotenv\Compiler;

use NeonXP\Dotenv\Exception\RuntimeException;
use NeonXP\Dotenv\Types\KeyValue;

/**
 * Class Compiler
 * @package NeonXP\Dotenv\Compiler
 */
class Compiler implements CompilerInterface
{
    const REGEX_VARIABLE = '/\$\{(.+?)\}/';

    /**
     * @var KeyValue[]
     */
    protected $collection = [];

    /**
     * @var KeyValue[]
     */
    protected $cache = [];

    /**
     * @inheritdoc
     * @param KeyValue[] $collection
     */
    public function setRawCollection(array $collection): void
    {
        $this->collection = [];
        $this->cache = [];
        foreach ($collection as $keyValue) {
            $this->collection[$keyValue->getKey()] = $keyValue;
        }
    }

    /**
     * @inheritdoc
     * @param KeyValue $keyValue
     * @return KeyValue
     */
    public function compileKeyValue(KeyValue $keyValue): KeyValue
    {
        $newValue = preg_replace_callback(self::REGEX_VARIABLE, function ($variable) use ($keyValue) {
            $variable = $variable[1];
            if ($variable === $keyValue->getKey()) {
                throw new RuntimeException('Self referencing');
            }
            if (isset($this->cache[$variable])) {
                return $this->cache[$variable]->getValue();
            } elseif (isset($this->collection[$variable]) && !$this->needToCompile($this->collection[$variable])) {
                return $this->collection[$variable]->getValue();
            } elseif (isset($this->collection[$variable]) && $this->needToCompile($this->collection[$variable])) {
                return $this->compileKeyValue($this->collection[$variable])->getValue();
            }
            return "UNKNOWN VARIABLE {$variable}";
        }, $keyValue->getValue());
        $result = new KeyValue($keyValue->getKey(), $newValue);
        $this->cache[$result->getKey()] = $result;

        return $result;
    }

    /**
     * @param KeyValue $keyValue
     * @return bool
     */
    protected function needToCompile(KeyValue $keyValue): bool
    {
        return !!preg_match(self::REGEX_VARIABLE, $keyValue->getValue());
    }
}