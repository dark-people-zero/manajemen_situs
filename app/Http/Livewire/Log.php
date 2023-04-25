<?php

namespace App\Http\Livewire;
use Livewire\WithPagination;

use App\Models\log as DataLog;

use Livewire\Component;

class Log extends Component
{
    use WithPagination;

    public $ip, $location;
    public $dataLog, $search;

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
        // $user = auth()->user();
        // $role = $user->role->role_id;
        // $situs = situs::All();

        // if (!in_array($role, [1,4])) {
        //     $aksesSitus = aksesSitus::where("id_user", $user->id)->get()->pluck("id_situs");
        //     $situs = situs::whereIn("id", $aksesSitus)->get();
        // }
        // $this->dataLog = dataLog::All()->paginate(10);
    }

    public function render()
    {
        $this->updateLocation();
        $search = $this->search;

        $data = DataLog::when($search, function($e) use($search){
            $e->where('data_user', 'LIKE', '%'.$search.'%')
              ->orWhere('keterangan', 'LIKE', '%'.$search.'%')
              ->orWhere('data_before', 'LIKE', '%'.$search.'%')
              ->orWhere('data_after', 'LIKE', '%'.$search.'%');
            //   ->orWhere('url_mobile_prod', 'like', '%'.$search.'%');
        })->orderBy('id', 'desc')->paginate(10);

        return view('livewire.log', [
            "data" => $data,
            
            // "situs" => Msitus::get(),
        ])->extends('layouts.app2');;
    }
}
