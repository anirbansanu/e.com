<?php

namespace App\View\Components\Anilte\Medias;

use Illuminate\View\Component;

class Dropzone extends Component
{
    public $id;
    public $url;
    public $maxFiles;
    public $existingFiles;

    public function __construct($id, $url, $maxFiles = 5, $existingFiles = [])
    {
        $this->id = $id;
        $this->url = $url;
        $this->maxFiles = $maxFiles;
        $this->existingFiles = $existingFiles;
    }

    public function render()
    {
        return view('vendor.anilte.components.form.dropzone');
    }
}
