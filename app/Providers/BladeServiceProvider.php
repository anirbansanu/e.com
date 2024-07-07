<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('convertAsLabel', function ($key) {
            return "<?php echo convertAsLabel($key); ?>";
        });

        Blade::directive('setting', function ($expression) {
            return "<?php echo setting($expression); ?>";
        });

        Blade::directive('formatedSize', function ($expression) {
            return "<?php echo formatedSize($expression); ?>";
        });

        Blade::directive('activeLink', function ($expression) {
            list($routeNames, $msg) = explode(',', $expression . ',');

            $routeNames = trim($routeNames);
            $msg = trim($msg);

            return "<?php echo active_link($routeNames, $msg); ?>";
        });
        
    }
}
