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
     */
    protected array $routes = [

    ];
}