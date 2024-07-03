<?php

namespace App\View\Components\Anilte;

use Illuminate\View\Component;

class Card extends Component
{
    public $cardClass;
    public $headerClass;
    public $bodyClass;
    public $footerClass;
    public $minimize;
    public $maximize;
    public $close;

    public function __construct(
        $cardClass = '',
        $headerClass = '',
        $bodyClass = '',
        $footerClass = '',
        $minimize = null,
        $maximize = null,
        $close = null
    ) {
        $this->$cardClass = $cardClass;
        $this->headerClass = $headerClass;
        $this->bodyClass = $bodyClass;
        $this->footerClass = $footerClass;
        $this->minimize = $minimize;
        $this->maximize = $maximize;
        $this->close = $close;
    }

    public function render()
    {
        return view('vendor.anilte.components.cards.card');
    }
}
