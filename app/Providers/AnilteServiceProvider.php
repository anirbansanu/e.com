<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\View\Components\Anilte\AnilteDatatable;
use App\View\Components\Anilte\Card;
use App\View\Components\Anilte\TabNavItem;
use App\View\Components\Anilte\DeleteButton;
use App\View\Components\Anilte\EditButton;
use App\View\Components\Anilte\RestoreButton;
use App\View\Components\Anilte\ViewButton;

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
        $components = [
            'datatable' => AnilteDatatable::class,
            'card' => Card::class,
            'tab-nav-item' => TabNavItem::class,
            'delete-btn' => DeleteButton::class,
            'edit-btn' => EditButton::class,
            'restore-btn' => RestoreButton::class,
            'view-btn' => ViewButton::class,
        ];

        foreach ($components as $alias => $component) {
            Blade::component("anilte::$alias", $component);
        }
    }
}
