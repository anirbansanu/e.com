<?php

namespace App\View\Components\Anilte;

use Illuminate\Support\Facades\Log;
use Illuminate\View\Component;

class AjaxDataTable extends Component
{
    public $columns;
    public $fetchUrl;
    public $actionButtons;
    public $pageSize;

    public function __construct($columns, $fetchUrl, $actionButtons = null, $pageSize = 10)
    {
        $this->columns = $columns;
        $this->fetchUrl = $fetchUrl;
        $this->actionButtons = $actionButtons;
        $this->pageSize = $pageSize;
    }

    public function render()
    {
        return view('vendor.anilte.components.datatables.ajax-datatable');
    }
}
