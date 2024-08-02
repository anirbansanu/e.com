<?php

namespace App\View\Components\Anilte\Form;

use Illuminate\View\Component;

class Dropzone extends Component
{
    public $id;
    public $url;
    public $maxFiles;
    public $field;
    public $existing;
    public $isMultiple;
    public $removeUrl;
    public $collection;

    public function __construct($id, $url, $maxFiles, $field, $existing = [], $isMultiple = false,$removeUrl, $collection)
    {
        $this->id = $id;
        $this->url = $url;
        $this->maxFiles = $maxFiles;
        $this->field = $field;
        $this->existing = $existing;
        $this->isMultiple = $isMultiple;
        $this->removeUrl = $removeUrl;
        $this->collection = $collection;
    }

    public function render()
    {
        return view('vendor.anilte.components.form.dropzone');
    }
}
