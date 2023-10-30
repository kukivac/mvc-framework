<?php

declare(strict_types=1);

namespace system\core\helpers;

enum SystemEnvironments: string
{
    case DEVELOPMENT = "dev";
    case PRODUCTION = "prod";
}