<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\aksesSitus;
use App\Models\situs;
use App\Models\fiturSitus;
use App\Models\fitur;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use File;
use DB;
use Auth;

class Site extends Component
{
    use WithFileUploads;

    public $ip, $location;
    public $dataSitus, $idSitus, $typeSite, $dataFitur;

    public function updateLocation()
    {
        $cookies = [];
        $cookiesReq = explode(";", request()->server("HTTP_COOKIE"));

        foreach ($cookiesReq as $val) {
            $x = explode("=", $val);
            $key = str_replace(" ", "", $x[0]);
            $cookies[$key] = $x[1];
        }

        $ip = request()->ip();
        $latitude = $cookies["latitude"] ?? null;
        $longitude = $cookies["longitude"] ?? null;
        $accuracy = $cookies["accuracy"] ?? null;

        $this->ip = request()->ip();
        $this->location = collect([
            "latitude" => $latitude,
            "longitude" => $longitude,
            "accuracy" => $accuracy,
        ])->toJson();

        if ($latitude == null && $longitude == null && $accuracy == null) $this->dispatchBrowserEvent("logout");

    }

    public function mount()
    {
        $user = auth()->user();
        $role = $user->role->role_id;
        $situs = situs::All();

        if (!in_array($role, [1,4])) {
            $aksesSitus = aksesSitus::where("id_user", $user->id)->get()->pluck("id_situs");
            $situs = situs::whereIn("id", $aksesSitus)->get();
        }

        $this->dataSitus = $situs;
    }

    public function render()
    {
        $this->updateLocation();
        return view('livewire.site')->extends('layouts.app2');
    }

    public function updated($propertyName)
    {
        $this->updateLocation();
        // $this->validateOnly($propertyName, $this->filedValidate());
    }

    public function getFitur($type)
    {
        $this->typeSite = $type;

        if ($type != null) {
            $fiturSitus = fiturSitus::with(["fitur"])->where("id_situs", $this->idSitus)->where("type", $type)->get()->pluck("fitur");
            dd($fiturSitus->toArray());
        }else{
            $this->reset("dataFitur");
        }
    }
}
