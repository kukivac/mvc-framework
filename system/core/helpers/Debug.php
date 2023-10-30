<?php

declare(strict_types=1);

namespace system\core\helpers;

use JetBrains\PhpStorm\NoReturn;
use Tracy\Debugger;

class Debug
{
    /**
     * @param mixed ...$variables
     * @return void
     */
    public static function dump(...$variables): void
    {
        Debugger::dump($variables);
    }

    /**
     * @param mixed ...$variables
     * @return void
     */
    #[NoReturn] public static function dumpAndExit(...$variables): void
    {
        Debugger::dump($variables);
        die();
    }
}