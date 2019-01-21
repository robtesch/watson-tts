<?php

namespace Robtesch\Watsontts;

use Illuminate\Support\Facades\Facade;

/**
 * Class WatsonttsFacade
 * @package Robtesch\Watsontts
 */
class WatsonttsFacade extends Facade
{

    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'watson-tts';
    }
}