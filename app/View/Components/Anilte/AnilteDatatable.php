<?php

namespace App\View\Components\Anilte;

use Illuminate\View\Component;

class AnilteDatatable extends Component
{
    public $url;
    public $thead;
    public $tbody;
    public $actions;

    public function __construct($url, $thead, $tbody, $actions)
    {
        $this->url = $url;
        $this->thead = $thead;
        $this->tbody = $tbody;
        $this->actions = $actions;
    }

    public function render()
    {
        return view('vendor.anilte.components.datatables.datatable');
    }
}
