<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Situs as Msitus;
use App\Models\fitur;

class AccessSite extends Component
{
    public $index;

    public function render()
    {
        return view('livewire.access-site',[
            "situs" => Msitus::get(),
            "fitur" => fitur::get()
        ]);
    }
}
