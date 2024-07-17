<?php

namespace App\View\Components\Anilte\Form;

use Illuminate\View\Component;

class Select2 extends Component
{
    public $name;
    public $id;
    public $label;
    public $labelClass;
    public $selectClass;
    public $igroupSize;
    public $placeholder;
    public $ajaxRoute;
    public $options;
    public $useAjax;


    public function __construct(
        $name = '',
        $id = '',
        $label = '',
        $labelClass = '',
        $selectClass = '',
        $igroupSize = 'md',
        $placeholder = 'Select an option...',
        $ajaxRoute = '',
        $options = [],
        $useAjax = false
    ) {
        $this->name = $name;
        $this->id = $id;
        $this->label = $label;
        $this->labelClass = $labelClass;
        $this->selectClass = $selectClass;
        $this->igroupSize = $igroupSize;
        $this->placeholder = $placeholder;
        $this->ajaxRoute = $ajaxRoute;
        $this->options = $options;
        $this->useAjax = $useAjax;
    }

    public function render()
    {
        return view('vendor.anilte.components.form.select2');
    }
}
