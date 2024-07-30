<?php

namespace App\View\Components\Anilte;

use Illuminate\View\Component;

class AjaxDataTable extends Component
{
    public $id;
    public $columns;
    public $fetchUrl;
    public $deleteUrl;
    public $actionButtons;
    public $pageSize;

    public function __construct($id, $columns, $fetchUrl, $deleteUrl, $actionButtons = null, $pageSize = 10)
    {
        $this->id = $id;
        $this->columns = $columns;
        $this->fetchUrl = $fetchUrl;
        $this->deleteUrl = $deleteUrl;
        $this->actionButtons = $actionButtons;
        $this->pageSize = $pageSize;
    }

    public function render()
    {
        return view('vendor.anilte.components.datatables.ajax-datatable');
    }
}
