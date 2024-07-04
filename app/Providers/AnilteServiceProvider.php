<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\View\Components\Anilte\AnilteDatatable;
use App\View\Components\Anilte\Card;
use App\View\Components\Anilte\TabNavItem;

class AnilteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::component('anilte::datatable', AnilteDatatable::class);
        Blade::component('anilte::card', Card::class);
        Blade::component('anilte::tab-nav-item', TabNavItem::class);
    }
}
