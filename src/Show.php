<?php

namespace Laralum\Advertisements;

use Laralum\Advertisements\Advertisement;
use Illuminate\Support\Facades\Facade;

class Show extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Advertisement::class;
    }
}
