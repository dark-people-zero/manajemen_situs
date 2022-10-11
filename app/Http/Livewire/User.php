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
    public $name, $username;

    public $all_c = false, $all_r = false, $all_u = false, $all_d = false;
    public $user_c = false, $user_r = false, $user_u = false, $user_d = false;
    public $situs_c = false, $situs_r = false, $situs_u = false, $situs_d = false;

    public $accessSite = [];

    public $dataAccessSite = [
        "no1"
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

    public function updated($propertyName)
    {
        if ($propertyName == "accessSite") {
            dd($this->accessSite);
        }
        if ($propertyName == 'all_c') {
            $this->user_c = $this->all_c;
            $this->situs_c = $this->all_c;

            if ($this->all_c) {
                $this->all_r = $this->all_c;
                $this->user_r = $this->all_c;
                $this->situs_r = $this->all_c;
            }

        }

        if ($propertyName == 'all_r') {
            $this->user_r = $this->all_r;
            $this->situs_r = $this->all_r;
        }

        if ($propertyName == 'all_u') {
            $this->user_u = $this->all_u;
            $this->situs_u = $this->all_u;

            if ($this->all_u) {
                $this->all_r = $this->all_u;
                $this->user_r = $this->all_u;
                $this->situs_r = $this->all_u;
            }
        }

        if ($propertyName == 'all_d') {
            $this->user_d = $this->all_d;
            $this->situs_d = $this->all_d;

            if ($this->all_d) {
                $this->all_r = $this->all_d;
                $this->user_r = $this->all_d;
                $this->situs_r = $this->all_d;
            }
        }

        if ($propertyName == 'user_c') {
            if ($this->user_c && !$this->user_r) $this->user_r = $this->user_c;
        }

        if ($propertyName == 'user_u') {
            if ($this->user_u && !$this->user_r) $this->user_r = $this->user_u;
        }

        if ($propertyName == 'user_d') {
            if ($this->user_d && !$this->user_r) $this->user_r = $this->user_d;
        }

        if ($propertyName == 'situs_c') {
            if ($this->situs_c && !$this->situs_r) $this->situs_r = $this->situs_c;
        }

        if ($propertyName == 'situs_u') {
            if ($this->situs_u && !$this->situs_r) $this->situs_r = $this->situs_u;
        }

        if ($propertyName == 'situs_d') {
            if ($this->situs_d && !$this->situs_r) $this->situs_r = $this->situs_d;
        }

        if ($propertyName == 'user_c' || $propertyName == 'situs_c') {
            if ($this->user_c && $this->situs_c) {
                $this->all_c = true;
            } else {
                $this->all_c = false;
            }

            if ($this->user_r && $this->situs_r) {
                $this->all_r = true;
            }
        }

        if ($propertyName == 'user_r' || $propertyName == 'situs_r') {
            if ($this->user_r && $this->situs_r) {
                $this->all_r = true;
            } else {
                $this->all_r = false;
            }
        }

        if ($propertyName == 'user_u' || $propertyName == 'situs_u') {
            if ($this->user_u && $this->situs_u) {
                $this->all_u = true;
            } else {
                $this->all_u = false;
            }

            if ($this->user_r && $this->situs_r) {
                $this->all_r = true;
            }
        }

        if ($propertyName == 'user_d' || $propertyName == 'situs_d') {
            if ($this->user_d && $this->situs_d) {
                $this->all_d = true;
            } else {
                $this->all_d = false;
            }

            if ($this->user_r && $this->situs_r) {
                $this->all_r = true;
            }
        }
    }

    public function removeAccessSite($index)
    {
        if (($key = array_search($index, $this->dataAccessSite)) !== false) {
            unset($this->dataAccessSite[$key]);
            unset($this->accessSite[$key]);
        }
    }

    public function addAccessSite()
    {
        $count = count($this->dataAccessSite)+1;
        array_push($this->dataAccessSite,"no$count");
        $this->dispatchBrowserEvent("access:site");
    }

    public function addAccessSiteVal($index, $type, $val)
    {
        if ($type == "fitur") {
            $i = array_keys($val)[0];
            $this->accessSite[$index][$type][$i] = $val[$i];
        }else{
            $this->accessSite[$index][$type] = $val;
        }
    }


}
