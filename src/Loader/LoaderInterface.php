<?php
declare(strict_types=1);

/**
 * @author: Alexander Kiryukhin <alexander@kiryukhin.su>
 * @license: MIT
 */

namespace NeonXP\Dotenv\Loader;

/**
 * Interface LoaderInterface
 * @package NeonXP\Dotenv\Loader
 */
interface LoaderInterface
{
    /**
     * Load not empty lines from file or other source
     * @param string $filePath
     * @return string[]
     */
    public function load(string $filePath = '.env'): array;
}