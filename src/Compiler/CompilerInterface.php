<?php
declare(strict_types=1);

/**
 * @author: Alexander Kiryukhin <alexander@kiryukhin.su>
 * @license: MIT
 */

namespace NeonXP\Dotenv\Compiler;

use NeonXP\Dotenv\Types\KeyValue;

/**
 * Interface CompilerInterface
 * @package NeonXP\Dotenv\Compiler
 */
interface CompilerInterface
{
    /**
     * @param KeyValue[] $collection
     */
    public function setRawCollection(array $collection): void;

    /**
     * @param KeyValue $keyValue
     * @return KeyValue
     */
    public function compileKeyValue(KeyValue $keyValue): KeyValue;
}