<?php
declare(strict_types=1);

/**
 * @author: Alexander Kiryukhin <alexander@kiryukhin.su>
 * @license: MIT
 */

use NeonXP\Dotenv\Loader\LoaderInterface;

/**
 * Class MockLoader
 */
class MockLoader implements LoaderInterface
{

    /**
     * Load not empty lines from file or other source
     * @param string $filePath
     * @return string[]
     */
    public function load(string $filePath = '.env'): array
    {
        return [
            'KEY1=VALUE1',
            'KEY2=VALUE2',
            'KEY3=VALUE3',
            'KEY4=VALUE4',
            'KEY5=VALUE5',
        ];
    }
}