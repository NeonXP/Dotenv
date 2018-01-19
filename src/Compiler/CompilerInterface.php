<?php
declare(strict_types=1);

/**
 * @author: Alexander Kiryukhin <alexander@kiryukhin.su>
 * @license: MIT
 */

namespace NeonXP\Dotenv\Compiler;

/**
 * Interface CompilerInterface
 * @package NeonXP\Dotenv\Compiler
 */
interface CompilerInterface
{
    /**
     * @param array[] $collection
     */
    public function setRawCollection(array $collection): void;

    /**
     * @param array $array
     * @return array
     */
    public function compile(array $array): array;
}