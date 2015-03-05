<?php

namespace Supercluster\Nebula\Routing;

use Respect\Rest\Routable;
use Respect\Rest\Routes\AbstractRoute;
use Supercluster\Gravity\Configuration\BootableContainer;
use Respect\Config\Instantiator;
use Supercluster\Nebula\RouteInformation;

class InstanceList implements Routable
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
        $instances = [];


        $allBackground = $this->background;

        foreach ($allBackground as $key => $instance) {
            if ($instance instanceof Instantiator) {
                $value = ' (lazy) ' . $instance->getClassName();
            } elseif (is_object($instance)) {
                $value = ' (object) ' . get_class($instance);
            } elseif (is_array($instance) && array_filter($instance, 'is_scalar')) {
                $value = $instance;
            } elseif (!is_array($instance)) {
                $value = ' (scalar) ' . $instance;
            } else {
                $value = ' (collection) ' . implode(
                    ', ',
                    array_map('get_class', array_filter($instance, 'is_object'))
                );
            }
            $instances[$key] = [
                'value' => $value
            ];
        }
        return [ 'instanceList' =>  $instances ];
    }

    public function post()
    {

        return [ 'instanceList' => [] ];
    }
}
