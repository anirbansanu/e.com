<?php

namespace App\View\Components\Anilte;

use Illuminate\View\Component;

class DeleteButton extends Component
{
    public $route;
    public $routeParams;
    public $icon;
    public $label;
    public $alertTitle;
    public $text;
    public $iconType;
    public $cancelBtn;
    public $confirmText;
    public $cancelText;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $route,
        $routeParams = [],
        $icon = null,
        $label = null,
        $alertTitle = "Are you sure?",
        $text = "You won't be able to revert this!",
        $iconType = "warning",
        $cancelBtn = true,
        $confirmText = "Yes, delete it!",
        $cancelText = "Cancel"
    ) {
        $this->route = $route;
        $this->routeParams = $routeParams;
        $this->icon = $icon;
        $this->label = $label;
        $this->alertTitle = $alertTitle;
        $this->text = $text;
        $this->iconType = $iconType;
        $this->cancelBtn = $cancelBtn;
        $this->confirmText = $confirmText;
        $this->cancelText = $cancelText;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('vendor.anilte.components.actions.delete-btn');
    }
}
