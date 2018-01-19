<?php
declare(strict_types=1);

/**
 * @author: Alexander Kiryukhin <alexander@kiryukhin.su>
 * @license: MIT
 */

require_once (__DIR__ . "/mocks/MockLoader.php");
require_once (__DIR__ . "/mocks/MockParser.php");
require_once (__DIR__ . "/mocks/MockCompiler.php");

$vendorDir = __DIR__ . '/../../..';
if (file_exists($file = $vendorDir . '/autoload.php')) {
    require_once $file;
} else if (file_exists($file = './vendor/autoload.php')) {
    require_once $file;
} else {
    throw new \RuntimeException("Not found composer autoload");
}