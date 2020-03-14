<?php

namespace NetLinker\WideStore\Facades;

use Illuminate\Support\Facades\Facade;

class WideStore extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'wide-store';
    }
}
