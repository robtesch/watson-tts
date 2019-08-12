<?php

namespace Robtesch\Watsontts\Facades;

use Illuminate\Support\Facades\Facade;
use RuntimeException;

/**
 * Class Watsontts
 * @package Robtesch\Watsontts
 */
class Watsontts extends Facade
{

    /**
     * Get the registered name of the component.
     * @return string
     * @throws RuntimeException
     */
    protected static function getFacadeAccessor()
    : string
    {
        return 'Watsontts';
    }
}