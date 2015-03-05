<?php

namespace Supercluster\Nebula\Routing;

use Respect\Rest\Routable;
use Respect\Rest\Routes\AbstractRoute;
use Supercluster\Gravity\Configuration\BootableContainer;
use Supercluster\Nebula\RouteInformation;

class Home implements Routable
{
    protected $background;
    protected $routeList;

    public function __construct(
        BootableContainer $background = null,
        AbstractRoute $routeList,
        AbstractRoute $vendorList,
        AbstractRoute $instanceList
    ) {
        if ( ! $background) {
            $this->background = new BootableContainer(
                'supercluster.package.ini'
            );
        }

        $this->routeList  = $routeList;
        $this->vendorList = $vendorList;
        $this->instanceList = $instanceList;
    }

    public function get()
    {
        return [
            'nebulaHome' => [
                'vendors'     =>  [
                    'title' => 'Vendors',
                    'url' => $this->vendorList->createUri()
                ],
                'routes'     =>  [
                    'title' => 'Routes',
                    'url' => $this->routeList->createUri()
                ],
                'instances'     =>  [
                    'title' => 'Instances',
                    'url' => $this->instanceList->createUri()
                ],
                'schemas'     =>  [
                    'title' => 'Schemas',
                    'url' => $this->instanceList->createUri()
                ],
                'collections'     =>  [
                    'title' => 'Collections',
                    'url' => $this->instanceList->createUri()
                ]
            ],
            'composer' => json_decode(file_get_contents('composer.json'), true)
        ];
    }

    public function post()
    {

        return [ 'routeList' => [] ];
    }
}
