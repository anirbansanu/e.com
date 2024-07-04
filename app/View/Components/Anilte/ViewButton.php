<?php

namespace App\View\Components\Anilte;

use Illuminate\View\Component;

class ViewButton extends Component
{
    public $route;
    public $routeParams;
    public $icon;
    public $label;

    public function __construct($route, $routeParams = [], $icon = 'fas fa-eye', $label = 'View')
    {
        $this->route = $route;
        $this->routeParams = $routeParams;
        $this->icon = $icon;
        $this->label = $label;
    }

    public function render()
    {
        return view('vendor.anilte.components.actions.view-btn');
    }
}
