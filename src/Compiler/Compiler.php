<?php
declare(strict_types=1);

/**
 * @author: Alexander Kiryukhin <alexander@kiryukhin.su>
 * @license: MIT
 */

namespace NeonXP\Dotenv\Compiler;

use NeonXP\Dotenv\Exception\RuntimeException;

/**
 * Class Compiler
 * @package NeonXP\Dotenv\Compiler
 */
class Compiler implements CompilerInterface
{
    const REGEX_VARIABLE = '/\$\{(.+?)\}/';

    /**
     * @var array[]
     */
    protected $collection = [];

    /**
     * @var array[]
     */
    protected $cache = [];

    /**
     * @inheritdoc
     * @param array[] $collection
     */
    public function setRawCollection(array $collection): void
    {
        $this->collection = [];
        $this->cache = [];
        foreach ($collection as $array) {
            $this->collection[$array['key']] = $array;
        }
    }

    /**
     * @inheritdoc
     * @param array $array
     * @return array
     */
    public function compile(array $array): array
    {
        $newValue = preg_replace_callback(self::REGEX_VARIABLE, function ($variable) use ($array) {
            $variable = $variable[1];
            if ($variable === $array['key']) {
                throw new RuntimeException('Self referencing');
            }
            if (isset($this->cache[$variable])) {
                return $this->cache[$variable]['value'];
            } elseif (isset($this->collection[$variable]) && !$this->needToCompile($this->collection[$variable])) {
                return $this->collection[$variable]['value'];
            } elseif (isset($this->collection[$variable]) && $this->needToCompile($this->collection[$variable])) {
                return $this->compile($this->collection[$variable])['value'];
            }
            return "UNKNOWN VARIABLE {$variable}";
        }, $array['value']);
        $result = [
            'key' => $array['key'],
            'value' => $newValue
        ];
        $this->cache[$result['key']] = $result;

        return $result;
    }

    /**
     * @param array $array
     * @return bool
     */
    protected function needToCompile(array $array): bool
    {
        return !!preg_match(self::REGEX_VARIABLE, $array['value']);
    }
}