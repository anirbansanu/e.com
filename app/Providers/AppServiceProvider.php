<?php

namespace App\Providers;

use App\Services\Settings\SettingsService;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
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
        $this->app->singleton(SettingsService::class, function ($app) {
            return new SettingsService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(SettingsService $settingsService)
    {
        //
        if (Schema::hasTable('settings')) {
            $settings = $settingsService->getSettings();
            config()->set('settings', $settings);
        }

        // Register custom Blade directive
        Blade::directive('setting', function ($key) {
            return "<?php echo config('settings.' . {$key}); ?>";
        });
    }
}
