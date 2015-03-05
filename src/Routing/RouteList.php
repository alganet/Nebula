<?php

namespace Supercluster\Nebula\Routing;

use Respect\Rest\Routable;
use Respect\Rest\Routes\AbstractRoute;
use Supercluster\Gravity\Configuration\BootableContainer;

class RouteList implements Routable
{
    protected $background;
    protected $singleRoute;

    public function __construct(
        BootableContainer $background = null,
        AbstractRoute     $singleRoute
    ) {

        if ( ! $background) {
            $this->background = new BootableContainer(
                'supercluster.package.ini'
            );
        }

        $this->singleRoute = $singleRoute;
    }

    public function get()
    {
        $routes = $this->background->routes;

        foreach ($routes as $id => &$route) {
            $route = [
                'method'  => $route->method,
                'pattern' => $route->pattern,
                'url'     => $this->singleRoute->createUri($id)
            ];
        }

        return [ 'routeList' =>  $routes ];
    }

    public function post()
    {

        return [ 'routeList' => [] ];
    }
}
