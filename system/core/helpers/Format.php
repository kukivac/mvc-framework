<?php

declare(strict_types=1);

namespace system\core\helpers;

class Format
{
    /**
     * @param mixed[] $array
     * @return bool
     */
    public static function isArrayOfStrings(array $array):bool
    {
        return count($array) === count(array_filter($array, 'is_string'));
    }
}