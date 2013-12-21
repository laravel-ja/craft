<?php

namespace Laravel\Services\Container;

use Illuminate\Container\Container as C;

final class Container
{
    private static $container;

    /**
     * Constructer, must not be used
     */
    private function __construct()
    {

    }

    /**
     * Magic method for cloning.
     * Avoid to clone this instance.
     */
    private function __clone()
    {

    }

    /**
     * Get Container Instance
     *
     * @return type
     */
    final public static function get()
    {
        if( is_null( self::$container ) )
        {
            self::$container = new C;

            $dependencies = new Dependencies;
            $dependencies->inject();
        }
        return self::$container;
    }

}
