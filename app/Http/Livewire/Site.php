<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\aksesSitus;
use App\Models\situs;
use App\Models\fiturSitus;
use App\Models\formFitur;
use App\Models\fitur;
use App\Models\typeElement;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use File;
use DB;
use Auth;

class Site extends Component
{
    use WithFileUploads;

    public $ip, $location;
    public $dataSitus, $idSitus, $idFitur, $typeInput, $typeSite, $filed = [], $dataFitur = [];

    public $name, $image, $textarea, $selectOption, $checkbox, $switch, $color ;

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
            $this->dataFitur = fiturSitus::with(["fitur"])->where("id_situs", $this->idSitus)->where("type", $type)->get()->pluck("fitur")->toArray();
        }else{
            $this->dataFitur = [];
        }
        // dd($this->dataFitur);
    }

    public function getFileds($id)
    {
        
        $this->filed =  formFitur::with(["formElemen.typeElemen" ,"formElemen.optionElemen", "typeFitur"])->where("id_fitur", $id)->get();
        $this->idFitur = $id;

        // $test = typeElement::where("id", $this->filed)->get()->toArray()
        // dd($this->test);
        // dd($this->filed[0]["type_elemen"]["id_type_element"]);
// function($e) {
        // $this->filed = [
        //     [
        //         "id" => $idFitur,
        //         "isMultiple" => false,
        //         "isImage" => false,
        //         "isMultipleImage" => false,
        //         "filed" => ["name", "deskripsi", "image", "status", "link", "btnImage", "btnText", "background", "color", "style"]
        //     ]
        // ];
        // dd($idFitur);

        // $this->app->bind(User::class, function () {
        //     $user_id = request('user') ?: request()->route('user');
        //     return User::findOrFail($user_id);
        // });

    }
    
    public function saveData() {
        // $dataLog = [
        //     'class' => "Livewire->formElement->saveData",
        //     'name_activity' => $this->methodUpdate ? "update" : "create",
        //     'data_ip' => $this->ip,
        //     'data_location' => $this->location,
        //     'data_user' => auth()->user()->toJson(),
        //     'data_before' => null,
        //     'data_after' => null,
        //     'keterangan' => "Berhasil menambahkan data form element",
        // ];

        // dd([$this->name, $this->image, $this->textarea, $this->selectOption, $this->checkbox, $this->switch, $this->color]);
        $formFitur = fiturSitus::where("id_situs", $this->idSitus)->where("id_fitur", $this->idFitur)->where("type", $this->typeSite);
        $images = [];
        if(gettype($this->image) == "array"){
            foreach($this->image as $img) {
                $images = [];
            } 
        }
        
        // if($this->name) {
        //     $name = $this->name
        // }
        $data = collect([
                "name" => $this->name,
                "image" => $this->image,
                "textarea" => $this->textarea,
                "selectOption" => $this->selectOption,
                "checkbox" => $this->checkbox,
                "switch" => $this->switch,
                "color" => $this->color,
        ]);
        // json_decode($data);
        // dd($this->image);
        // dd(gettype($formFitur));
        $formFitur->update(["data" =>  $data]);
        


        // $dataInsert = collect($this->type)->map(function($e) use($name) {
        //     return [
        //         "id_fitur" => $name,
        //         "id_form_element" => $e,
        //     ];
        // })->toArray();

        // $msg = "Data update successfully.";
        // $type = "info";

        // fiturSitus::insert($dataInsert);
    }
    
    public function removeImage($id) {
        // dd($this->image);
        unset($this->image[$id]);
    }
}

