<?php

declare(strict_types=1);

namespace system\core\helpers;

use JetBrains\PhpStorm\NoReturn;

class Debug
{
    public static function dump()
    {
    }

    /**
     * @param mixed ...$variables
     * @return void
     */
    #[NoReturn] public static function dumpAndExit(...$variables): void
    {
        echo '<pre>';
        var_dump(...$variables);
        echo '</pre>';
        die();
    }
}