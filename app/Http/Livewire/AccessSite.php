<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Situs as Msitus;

class AccessSite extends Component
{
    public $index;
    public $name, $username;

    public function render()
    {
        $situs = Msitus::get();
        return view('livewire.access-site',[
            "situs" => $situs
        ]);
    }
}
