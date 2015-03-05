<?php

namespace Supercluster\Nebula\Routing;

use Respect\Rest\Routable;
use Respect\Rest\Routes\AbstractRoute;
use Supercluster\Gravity\Configuration\BootableContainer;

class VendorList implements Routable
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
        $vendors = [];

        foreach ($this->background->boot as $vendor) {
            $base = dirname($vendor);
            $composer = json_decode(
                file_get_contents($base . '/composer.json')
            );
            $vendors[$vendor] = [
                'name' => $composer ? $composer->name : null,
                'base' => $base,
                'spec' => parse_ini_file($vendor, true)
            ];
        }

        return [ 'vendorList' =>  $vendors ];
    }

    public function post()
    {

        return [ 'vendorList' => [] ];
    }
}
