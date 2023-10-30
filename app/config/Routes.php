<?php

namespace app\config;

use system\core\Routes\RoutesConfig;

class Routes extends RoutesConfig
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     *  Cesty musí být definované ve formátu.
     * "nazev-cety" => ["cílový-controller","cílová-cesta-controlleru"]
     * @var string[][]
     */
    protected array $routes = [
        "karel" => ["Default", "process"],
    ];
}