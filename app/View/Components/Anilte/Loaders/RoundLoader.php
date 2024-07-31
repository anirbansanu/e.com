<?php
// app/View/Components/Anilte/Modals/AjaxModal.php
namespace App\View\Components\Anilte\Loaders;

use Illuminate\View\Component;

class RoundLoader extends Component
{
    public function __construct()
    {

    }

    public function render()
    {
        return view('vendor.anilte.components.loaders.round-loader');
    }
}
