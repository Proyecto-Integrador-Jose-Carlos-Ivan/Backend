<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Operator extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public $operator)
    {

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.operator');
    }
}
