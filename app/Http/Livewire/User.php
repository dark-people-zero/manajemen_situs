<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User as Muser;
use App\Models\Situs as Msitus;

class User extends Component
{
    use WithPagination;

    public $search = '';
    protected $listeners = ['removeAccessSite'];

    public $dataAccessSite = [
        "no1",
        "no2"
    ];

    public function render()
    {
        $search = $this->search;
        $data = Muser::when($search, function($e) use($search){
            $e->where('name', 'like', '%'.$search.'%')
              ->orWhere('username', 'like', '%'.$search.'%');
        })->paginate(10);

        $situs = Msitus::get();

        return view('livewire.user',[
            "data" => $data,
            "situs" => $situs
        ])->extends('layouts.app2');
    }

    public function removeAccessSite($index)
    {
        if (($key = array_search($index, $this->dataAccessSite)) !== false) {
            unset($this->dataAccessSite[$key]);
        }
    }

    public function addAccessSite()
    {
        $count = count($this->dataAccessSite)+1;
        array_push($this->dataAccessSite,"no$count");
    }
}
