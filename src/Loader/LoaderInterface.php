<?php
/**
 * @author: Alexander Kiryukhin <alexander@kiryukhin.su>
 * @license: MIT
 */

namespace NeonXP\Dotenv\Loader;

interface LoaderInterface
{
    /**
     * @param string $filePath
     * @return string[]
     */
    public function load(string $filePath = '.env'): array;
}