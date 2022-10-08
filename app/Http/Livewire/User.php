<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User as Muser;

class User extends Component
{
    public $data;

    public function render()
    {
        $data = Muser::paginate(10);
        dd($data);
        $this->data = $data;

        return view('livewire.user')->extends('layouts.app2');
    }
}
