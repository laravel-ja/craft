<?php

namespace Laravel\Services\Container;

use Laravel\Services\Container\Container;

/**
 * Class dependencies bind classes initially.
 */
class Dependencies
{

    /**
     * Registor binds into IoC container.
     */
    public function inject()
    {
        $c = Container::get();

        // $c->bind( 'ProviderJsonFileRepository', 'Prepper\Repositories\ProviderJsonFileRepository' );
    }

}
