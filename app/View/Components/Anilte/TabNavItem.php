<?php

namespace App\View\Components\Anilte;

use Illuminate\View\Component;

class TabNavItem extends Component
{
    public $route;
    public $icon;
    public $routeParams;

    public function __construct($route, $icon, $routeParams = null)
    {
        $this->route = $route;
        $this->icon = $icon;
        $this->routeParams = $routeParams;
    }

    public function render()
    {
        return view('vendor.anilte.components.tabs.tab-nav-item');
    }
}
