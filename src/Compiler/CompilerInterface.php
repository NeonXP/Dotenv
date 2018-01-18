<?php
/**
 * @author: Alexander Kiryukhin <alexander@kiryukhin.su>
 * @license: MIT
 */

namespace NeonXP\Dotenv\Compiler;

use NeonXP\Dotenv\Types\KeyValue;

interface CompilerInterface
{
    /**
     * @param KeyValue[] $collection
     */
    function setRawCollection(array $collection): void;

    /**
     * @param KeyValue $keyValue
     * @return KeyValue
     */
    function compileKeyValue(KeyValue $keyValue): KeyValue;
}