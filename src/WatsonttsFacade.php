<?php

namespace Robtesch\Watsontts;

use Illuminate\Support\Facades\Facade;

class WatsonttsFacade extends Facade {
    protected static function getFacadeAccessor()
    {
        return 'watson-tts';
    }
}