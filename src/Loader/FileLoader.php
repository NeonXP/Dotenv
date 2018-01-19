<?php
declare(strict_types=1);

/**
 * @author: Alexander Kiryukhin <alexander@kiryukhin.su>
 * @license: MIT
 */

namespace NeonXP\Dotenv\Loader;

use NeonXP\Dotenv\Exception\RuntimeException;

/**
 * Class FileLoader
 * @package NeonXP\Dotenv\Loader
 */
class FileLoader implements LoaderInterface
{
    const COMMENT_LINE_REGEX = '/^\s*#/';

    /**
     * @inheritdoc
     * @param string $filePath
     * @return array
     * @throws RuntimeException
     */
    public function load(string $filePath = '.env'): array
    {
        if (!file_exists($filePath)) {
            throw new RuntimeException("There is no {$filePath} file!");
        }
        $lines = file($filePath);
        $lines = array_map('trim', $lines);
        $lines = array_filter($lines, function (string $line) {
            return trim($line) && !preg_match(self::COMMENT_LINE_REGEX, $line);
        });
        $lines = array_values($lines);

        return $lines;
    }
}