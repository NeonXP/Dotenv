<?php
declare(strict_types=1);

/**
 * @author: Alexander Kiryukhin <alexander@kiryukhin.su>
 * @license: MIT
 */

namespace NeonXP\Dotenv\Parser;

use NeonXP\Dotenv\Types\KeyValue;

/**
 * Class Parser
 * @package NeonXP\Dotenv\Parser
 */
class Parser implements ParserInterface
{
    const REGEX_EXPORT_PREFIX = '/^\s*export\s/i';

    // Quotes and comments
    const SINGLE_QUOTED_LINE_WITH_COMMENT = '/^\'(.*?)\'\s+#.*?$/i';
    const DOUBLE_QUOTED_LINE_WITH_COMMENT = '/^\"(.+?)\"\s+#.*?$/i';
    const SINGLE_QUOTED_LINE = '/^\'(.+?)\'$/i';
    const DOUBLE_QUOTED_LINE = '/^\"(.*?)\"$/i';

    // Types
    const BOOLEAN = '/^(true|false)$/i';
    const NUMBER = '/^(\d+)$/';

    public function parseLine(string $line): KeyValue
    {
        $line = preg_replace(self::REGEX_EXPORT_PREFIX, '', $line);
        list($key, $value) = explode('=', $line, 2) + ['', ''];
        $key = trim($key);
        $value = trim($value);
        $matches = [];
        if (
            preg_match(self::SINGLE_QUOTED_LINE_WITH_COMMENT, $value, $matches) ||
            preg_match(self::DOUBLE_QUOTED_LINE_WITH_COMMENT, $value, $matches) ||
            preg_match(self::SINGLE_QUOTED_LINE, $value, $matches) ||
            preg_match(self::DOUBLE_QUOTED_LINE, $value, $matches)
        ) {
            $value = $matches[1];
        }

        if (preg_match(self::BOOLEAN, $value)) {
            $value = (strtolower($value) === 'true');
        } elseif (preg_match(self::NUMBER, $value)) {
            $value = intval($value);
        }

        return new KeyValue($key, $value);
    }
}