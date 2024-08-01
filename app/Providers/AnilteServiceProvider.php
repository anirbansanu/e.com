<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\View\Components\Anilte\AnilteDatatable;
use App\View\Components\Anilte\AjaxDataTable;
use App\View\Components\Anilte\Card;
use App\View\Components\Anilte\TabNavItem;
use App\View\Components\Anilte\DeleteButton;
use App\View\Components\Anilte\EditButton;
use App\View\Components\Anilte\Form\Select2;
use App\View\Components\Anilte\InputGroup;
use App\View\Components\Anilte\Loaders\RoundLoader;
use App\View\Components\Anilte\Medias\Dropzone;
use App\View\Components\Anilte\Modals\AjaxModal;
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
            'input-group' => InputGroup::class,
            'select2' => Select2::class,
            'ajax-datatable' => AjaxDataTable::class,
            'modals.ajax-modal' => AjaxModal::class,
            'loader.round-loader' => RoundLoader::class,
            'medias.dropzone' => Dropzone::class
        ];

        foreach ($components as $alias => $component) {
            Blade::component("anilte::$alias", $component);
        }
    }
}
