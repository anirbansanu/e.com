<?php

namespace App\View\Components\Anilte;

use Illuminate\View\Component;

class EditButton extends Component
{
    public $route;
    public $routeParams;
    public $icon;
    public $label;

    /**
     * Create a new component instance.
     *
     * @param string $route
     * @param array $routeParams
     * @param string|null $icon
     * @param string|null $label
     */
    public function __construct($route, $routeParams = [], $icon = 'fas fa-pencil-alt', $label = 'Edit')
    {
        $this->route = $route;
        $this->routeParams = $routeParams;
        $this->icon = $icon;
        $this->label = $label;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('vendor.anilte.components.actions.edit-btn');
    }
}
