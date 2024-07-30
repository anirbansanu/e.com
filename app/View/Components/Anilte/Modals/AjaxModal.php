<?php
// app/View/Components/Anilte/Modals/AjaxModal.php
namespace App\View\Components\Anilte\Modals;

use Illuminate\View\Component;

class AjaxModal extends Component
{
    public $id;
    public $formId;
    public $method;
    public $action;
    public $title;
    public $size;
    public $buttonId;

    public function __construct($id, $formId, $method = 'post', $action, $title, $buttonId, $size = 'modal-lg')
    {
        $this->id = $id;
        $this->formId = $formId;
        $this->method = $method;
        $this->action = $action;
        $this->title = $title;
        $this->size = $size;
        $this->buttonId = $buttonId;
    }

    public function render()
    {
        return view('vendor.anilte.components.modals.ajax-modal');
    }
}
