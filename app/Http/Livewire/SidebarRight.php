<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SidebarRight extends Component
{
    public $situs = '';
    public $message;


    public function render()
    {
        return view('livewire.sidebar-right');
    }
}
