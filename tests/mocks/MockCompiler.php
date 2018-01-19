<?php
declare(strict_types=1);

/**
 * @author: Alexander Kiryukhin <alexander@kiryukhin.su>
 * @license: MIT
 */

use NeonXP\Dotenv\Compiler\CompilerInterface;
use NeonXP\Dotenv\Types\KeyValue;

/**
 * Class MockCompiler
 */
class MockCompiler implements CompilerInterface
{

    /**
     * @param KeyValue[] $collection
     */
    function setRawCollection(array $collection): void
    {
        // Do nothing
    }

    /**
     * @param KeyValue $keyValue
     * @return KeyValue
     */
    function compileKeyValue(KeyValue $keyValue): KeyValue
    {
        return $keyValue;
    }
}