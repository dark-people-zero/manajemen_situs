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
use App\Models\log;
use Illuminate\Http\File;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
// use File;
use DB;
use Auth;

class Site extends Component
{
    use WithFileUploads;

    public $ip, $location;
    public $dataSitus, $idSitus, $idFitur, $typeInput, $typeSite, $namaFitur, $filed = [], $dataFitur = [], $formFitur, $fileLama;

    public $name, $image, $images, $textarea, $selectOption, $checkbox, $switch, $color, $active, $dataLama, $imagesLama, $data_iconsosmed = [], $data_buttonaction = [], $data_listbanner = [],  $data_iconsosmed_data;

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
          
        if($propertyName == 'images' ) {
            if(!empty($this->imagesLama)) {
                $this->images = array_merge($this->imagesLama, $this->images);

            }
        }
        $this->updateLocation();
    }

    public function getFitur($type)
    {
        $this->typeSite = $type;

        if ($type != null) {
            $this->dataFitur = fiturSitus::with(["fitur"])->where("id_situs", $this->idSitus)->where("type", $type)->get()->pluck("fitur")->toArray();
        }else{
            $this->dataFitur = [];
        }
    }
    public function resetForm()
    {
        $this->resetValidation();
        $this->reset([
            'name',
            'image',
            'images',
            'textarea',
            'selectOption',
            "checkbox",
            "switch",
            "color",
        ]);

        $this->dispatchBrowserEvent("sumo:type", [
            "type" => "reset",
            "name" => "reset"
        ]);
    }

    public function getFileds($id)
    {

        $this->filed =  formFitur::with(["formElemen.typeElemen" ,"formElemen.optionElemen", "typeFitur"])->where("id_fitur", $id)->get();
        $this->idFitur = $id;
        $this->active = $id;
        $this->name = null; $this->image= null; $this->images = null; $this->textarea = null; $this->selectOption = null; $this->checkbox = null; $this->switch = null; $this->color = null;

        $this->formFitur = fiturSitus::where("id_situs", $this->idSitus)->where("id_fitur", $this->idFitur)->where("type", $this->typeSite)->get()->toJson();

        $dataLamaFormFitur = json_decode($this->formFitur);
        $dataLamaFormFiturJson = json_decode($dataLamaFormFitur[0]->data);
        $this->fileLama = [$dataLamaFormFiturJson];
        
        if($dataLamaFormFitur[0]->id_fitur == 5){
            if(!empty($dataLamaFormFiturJson->data_iconsosmed)) {
                foreach($dataLamaFormFiturJson->data_iconsosmed as $key => $data) {
                    $this->data_iconsosmed[$key] = collect($data)->toArray();
                }
            }
        }

        if($dataLamaFormFitur[0]->id_fitur == 4){
            if(!empty($dataLamaFormFiturJson->data_buttonaction)) {
                foreach($dataLamaFormFiturJson->data_buttonaction as $key => $data) {
                    $this->data_buttonaction[$key] = collect($data)->toArray();
                }
            }
        }

        if($dataLamaFormFitur[0]->id_fitur == 12){
            if(!empty($dataLamaFormFiturJson->data_listbanner)) {
                foreach($dataLamaFormFiturJson->data_listbanner as $key => $data) {
                    $this->data_listbanner[$key] = collect($data)->toArray();
                }
            }
        }

        // data lama name
        if(!empty($dataLamaFormFiturJson->name)) {
            if(count(get_object_vars($dataLamaFormFiturJson->name)) > 0) {
                foreach($dataLamaFormFiturJson->name as $key => $data) {
                    $this->name[$key] = $data;
                }
            }
        }

        // data lama input
        if(!empty($dataLamaFormFiturJson->color)) {
            if(count(get_object_vars($dataLamaFormFiturJson->color)) > 0) {
                foreach($dataLamaFormFiturJson->color as $key => $data) {
                    $this->color[$key] = $data;
                }
            }
        }

        // data lama image
        if(!empty($dataLamaFormFiturJson->image)) {
            $this->image = $dataLamaFormFiturJson->image->url;
        }

        // data lama images
        if(!empty($dataLamaFormFiturJson->images)) {
            $dataImages = $dataLamaFormFiturJson->images;
            $this->imagesLama = array_map(function ($datala) { return $datala; }, $dataImages);
            $this->images = $this->imagesLama;
        }

        // data lama textarea
        if(!empty($dataLamaFormFiturJson->textarea)) {
            $this->textarea = $dataLamaFormFiturJson->textarea;
        }

        // data lama selectOption
        if(!empty($dataLamaFormFiturJson->selectOption)) {
            $this->selectOption = $dataLamaFormFiturJson->selectOption;
        }

        // data lama checkbox
        if(!empty($dataLamaFormFiturJson->checkbox)) {
            $this->checkbox = $dataLamaFormFiturJson->checkbox;
        }

        // data lama switch
        if(!empty($dataLamaFormFiturJson->switch)) {
            $this->switch = $dataLamaFormFiturJson->switch;
        }
    }
    public function checkboxOnChange($key, $status) {
        $this->data_iconsosmed[$key]["status"] = $status;
    }

    public function imageUpload($dir, $image) {

        if(gettype($image) == "object") {
            return $this->uploadFiles($dir, $image);
            
        }else {
            return [
                "status" => true,
                "url" => $this->fileLama[0]["image"]["url"]
            ];
        }
    } 

    public function saveData() {
        $dataLog = [
            'class' => "Livewire->formElement->saveData",
            'name_activity' => true ? "update" : "create",
            'data_ip' => $this->ip,
            'data_location' => $this->location,
            'data_user' => auth()->user()->toJson(),
            'data_before' => null,
            'data_after' => null,
            'keterangan' => "Berhasil menambahkan update Site Management",
        ];

        $formFiturs = fiturSitus::where("id_situs", $this->idSitus)->where("id_fitur", $this->idFitur)->where("type", $this->typeSite);
        $situsName = $this->dataSitus->where("id", $this->idSitus)->first();
        DB::beginTransaction();
        try {

            $msg = "Data added successfully";
            $type = "success";
            $dir = "situs/". strtolower(trim($situsName->name)) . "/" . $this->typeSite . "/" . $this->filed[0]->typeFitur->name;
            
            $imgs = [];
            if($this->images) {
                foreach ($this->images as $img) {
                    if (gettype($img) != "string") {
                        $store = $this->uploadFiles($dir, $img);
                        if ($store['status']) array_push($imgs, $store['url']);
                    } else {
                        array_push($imgs, $img);
                    }
                }
            }

            if($this->data_iconsosmed > 0) {
                $data_iconsosmed_data = collect($this->data_iconsosmed)->map(function ($e)  use ($dir) {
                    $img = $e['image'];
                    if (gettype($img) != "string") {
                        $store = $this->uploadFiles($dir, $img);
                        if ($store['status']) $e['image'] = $store['url'];
                    }
                    return $e;
                })->values();
            }else {
                $data_iconsosmed_data = $this->data_iconsosmed;
            }

            if($this->data_listbanner > 0) {
                $data_listbanner_data = collect($this->data_listbanner)->map(function ($e)  use ($dir) {
                    $img = $e['image'];
                    if (gettype($img) != "string") {
                        $store = $this->uploadFiles($dir, $img);
                        if ($store['status']) $e['image'] = $store['url'];
                    }
                    return $e;
                })->values();
            }else {
                $data_listbanner_data = $this->data_listbanner;
            }

            $data = collect([
                    "name" => $this->name,
                    "image" =>$this->imageUpload($dir, $this->image),
                    "images" => $imgs,
                    "textarea" => $this->textarea,
                    "selectOption" => $this->selectOption, 
                    "checkbox" => $this->checkbox,
                    "switch" => $this->switch,
                    "color" => $this->color,
                    "data_iconsosmed" => $data_iconsosmed_data,
                    "data_listbanner" => $data_listbanner_data,
                    "data_buttonaction" => $this->data_buttonaction
            ]);

            $dataLog["data_before"] = $formFiturs->first()->toJson();

            $formFiturs->update(["data" =>  $data]);

            $dataLog["data_after"] = $formFiturs->first()->toJson();
            
            $dataJson = fiturSitus::where("id_situs", $this->idSitus)->get();

            $this->uploadJson($dataJson, strtolower(trim($situsName->name)));

            log::create($dataLog);
    
            DB::commit();
            $this->dispatchBrowserEvent("modalClose");

            $this->dispatchBrowserEvent("toast:$type", [
                "message" => $msg
            ]);
            
        }catch (\Throwable $th) {
            DB::rollback();
            $this->dispatchBrowserEvent("toast:error", [
                "message" => $th->getMessage()
            ]);
            $dataLog['keterangan'] = "Gagal menambah atau mengubah data form element karena => ".$th->getMessage();
            log::create($dataLog);
        }
    }

    public function uploadJson($dataJson, $namaSitus) {
        $dirDO ="situs/". $namaSitus . "/json";
        $namaSitus = $namaSitus . ".json";
        $dirJson = storage_path("app/public/" . $namaSitus);
        $fileJson =  new File($dirJson);
        Storage::disk('public')->put($namaSitus, json_encode($dataJson, JSON_PRETTY_PRINT));
        $uploadJson = Storage::disk('spaces')->putFileAs($dirDO, $fileJson, $namaSitus, 'public');
        $pathPurge = env('DO_SPACES_PUBLIC'). $uploadJson;
        DO_purge($pathPurge);       
    }

    
    public function removeImage($id) {
        unset($this->images[$id]);
    }
    public function addFormIconSosmed() {
        array_push($this->data_iconsosmed, [
            "status" => false,
            "name" => "",
            "link" => "",
            "image" => null
        ]);
        $this->resetErrorBag();
    }
    public function removeFormIconSosmed($id) {
        unset($this->data_iconsosmed[$id]);
    }

    public function addFormButtonAction() {
        array_push($this->data_buttonaction, [
            "status" => false,
            "target" => false,
            "name" => "",
            "link" => "",
            "class" => "",
            "color" => null,
            "style" => ""
        ]);
        $this->resetErrorBag();
    }
    public function removeButtonAction($id) {
        unset($this->data_buttonaction[$id]);
    }

    public function addBannerMenu() {

        array_push($this->data_listbanner, [
            "status" => false,
            "name" => "",
            "link" => "",
            "image" => null
        ]);
        $this->resetErrorBag();
    }

    public function removeBannerMenu($id) {
        unset($this->data_listbanner[$id]);
    }
    
    public function uploadFiles($path, $file)
    {
        try {
            if ($file && gettype($file) != "string") {
                $name = $this->uuid();
                $ext = $file->getClientOriginalExtension();
                $name = "$name.$ext";
                $filePath = Storage::disk('spaces')->putFileAs($path, $file, $name, 'public');
                return [
                    "status" => true,
                    "url" => env('DO_SPACES_PUBLIC') . $filePath
                ];
            } else {
                return [
                    "status" => true,
                    "url" => ""
                ];
            }
        } catch (Exception $exception) {
            return [
                "status" => false,
                "message" => $exception->getMessage()
            ];
        }
    }

    public function uuid()
    {
        return (string) Str::uuid();
    }
}

