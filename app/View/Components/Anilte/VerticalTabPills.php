<?php

namespace App\View\Components\Anilte;

use Illuminate\View\Component;

class VerticalTabPills extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $tabs;
    public $userName;
    public $userRole;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($tabs,$userName,$userRole)
    {
        $this->tabs = $tabs;
        $this->userName = $userName;
        $this->userRole = $userRole;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('vendor.anilte.components.tabs.vertical-tab-pills');
    }
}
