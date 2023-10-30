<?php

declare(strict_types=1);

namespace system\core\helpers;

class Format
{
    /**
     * @param mixed $array
     * @return bool
     */
    public static function isArrayOfStrings(mixed $array): bool
    {
        if (!is_array($array)) {
            return false;
        }

        return count($array) === count(array_filter($array, 'is_string'));
    }
}