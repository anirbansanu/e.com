<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
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
        //
        $settings = cache()->remember('settings', 3600, function () {
            return \App\Models\Setting::all(['key', 'value'])->pluck('value', 'key')->toArray();
        });

        config()->set('settings', $settings);

        // Register custom Blade directive
        Blade::directive('setting', function ($key) {
            return "<?php echo config('settings.' . {$key}); ?>";
        });
    }
}
