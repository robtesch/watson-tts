<?php

namespace Robtesch\Watsontts;

use Illuminate\Support\ServiceProvider;

class WatsonttsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '../config/watson-tts.php' => config_path('watson-tts.php'),
        ]);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '../config/watson-tts.php', 'watson-tts'
        );
    }
}
