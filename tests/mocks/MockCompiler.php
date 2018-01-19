<?php
declare(strict_types=1);

/**
 * @author: Alexander Kiryukhin <alexander@kiryukhin.su>
 * @license: MIT
 */

use NeonXP\Dotenv\Compiler\CompilerInterface;

/**
 * Class MockCompiler
 */
class MockCompiler implements CompilerInterface
{

    /**
     * @param array[] $collection
     */
    function setRawCollection(array $collection): void
    {
        // Do nothing
    }

    /**
     * @param array $array
     * @return array
     */
    function compile(array $array): array
    {
        return $array;
    }
}