<?php

namespace Supercluster\Nebula\Routing;

use Respect\Rest\Routable;
use Respect\Rest\Routes\AbstractRoute;
use Supercluster\Gravity\Configuration\BootableContainer;
use Supercluster\Nebula\RouteInformation;

class SingleRoute implements Routable
{
    protected $background;
    protected $singleRoute;

    public function __construct(
        BootableContainer $background = null
    ) {

        if ( ! $background) {
            $this->background = new BootableContainer(
                'supercluster.package.ini'
            );
        }
    }

    public function get($routeId)
    {
        $route = $this->background->routes[$routeId];
        $route = [
            'method'  => $route->method,
            'pattern' => $route->pattern
        ];

        return [ 'singleRoute' =>  $route ];
    }

    public function post()
    {

        return [ 'singleRoute' => [] ];
    }
}
