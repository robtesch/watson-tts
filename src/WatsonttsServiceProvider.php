<?php /** @noinspection PhpUndefinedFunctionInspection */

namespace Robtesch\Watsontts;

use Illuminate\Support\ServiceProvider;

/**
 * Class WatsonttsServiceProvider
 * @package Robtesch\Watsontts
 */
class WatsonttsServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap services.
     * @return void
     */
    public function boot()
    {
        $configPath = __DIR__ . '/../config/watson-tts.php';
        if (function_exists('config_path')) {
            $publishPath = config_path('watson-tts.php');
        } else {
            $publishPath = base_path('config/watson-tts.php');
        }
        $this->publishes([$configPath => $publishPath], 'config');
    }

    /**
     * Register services.
     * @return void
     */
    public function register()
    {
        $configPath = __DIR__ . '/../config/watson-tts.php';
        $this->mergeConfigFrom($configPath, 'watson-tts');
        $this->app->bind('Watsontts', static function () {
            return new Watsontts;
        });
        $this->app->alias(Watsontts::class, 'Watsontts');
    }
}
