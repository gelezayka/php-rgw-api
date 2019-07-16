<?php declare(strict_types=1);

namespace MyENA\RGW\Validator;

use MyENA\RGW\Validator;

/**
 * Class DateTimeValidator
 * @package MyENA\RGW\Validator
 */
class DateTimeValidator implements Validator
{
    const NAME       = 'datetime';
    const TEST_REGEX = '{(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$}';

    /**
     * @return string
     */
    public function name(): string
    {
        return self::NAME;
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public function test($value): bool
    {
        return is_string($value) && (bool)preg_match(self::TEST_REGEX, $value);
    }

    /**
     * @return string
     */
    public function expectedStatement(): string
    {
        return 'string conforming to ' . self::TEST_REGEX;
    }
}