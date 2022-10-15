<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Situs as Msitus;
use App\Models\fitur;

class AccessSite extends Component
{
    public $index, $data;

    public function render()
    {
        // if($this->data != null)dd($this->data);
        return view('livewire.access-site',[
            "situs" => Msitus::get()
        ]);
    }
}
