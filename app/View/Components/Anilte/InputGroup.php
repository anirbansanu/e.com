<?php

namespace App\View\Components\Anilte;

use Illuminate\View\Component;

class InputGroup extends Component
{
    public $id;
    public $name;
    public $value;
    public $placeholder;
    public $required;
    public $label;
    public $icon;

    public function __construct($id, $name, $value = '', $placeholder = '', $required = false, $label = '', $icon = 'fas fa-user')
    {
        $this->id = $id;
        $this->name = $name;
        $this->value = $value;
        $this->placeholder = $placeholder;
        $this->required = $required;
        $this->label = $label;
        $this->icon = $icon;
    }

    public function render()
    {
        return view('vendor.anilte.components.form.input-group');
    }
}


