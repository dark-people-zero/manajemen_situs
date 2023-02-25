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

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use File;
use DB;
use Auth;

class Site extends Component
{
    use WithFileUploads;

    public $ip, $location;
    public $dataSitus, $idSitus, $idFitur, $typeInput, $typeSite, $namaFitur, $filed = [], $dataFitur = [], $formFitur;

    public $name, $image, $images, $textarea, $selectOption, $checkbox, $switch, $color, $active, $dataLama, $imagesLama, $data_iconsosmed = []  ;

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

    $this->data_iconsosmed = [[
        "status" => false,
        "name" => "",
        "link" => "",
        "image" => null
    ]];
    
        if($propertyName == 'images' ) {
            if(!empty($this->imagesLama)) {
                $this->images = array_merge($this->imagesLama, $this->images);

            }
            // dd($this->images);
        }
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

        // dd($this->color);
        
        $this->filed =  formFitur::with(["formElemen.typeElemen" ,"formElemen.optionElemen", "typeFitur"])->where("id_fitur", $id)->get();
        $this->idFitur = $id;
        $this->active = $id;
        $this->name = null; $this->image= null; $this->images = null; $this->textarea = null; $this->selectOption = null; $this->checkbox = null; $this->switch = null; $this->color = null;

        $this->formFitur = fiturSitus::where("id_situs", $this->idSitus)->where("id_fitur", $this->idFitur)->where("type", $this->typeSite)->get()->toJson();
        $dataLamaFormFitur = json_decode($this->formFitur);
        $dataLamaFormFiturJson = json_decode($dataLamaFormFitur[0]->data);



        // data lama input
        if(!empty($dataLamaFormFiturJson->name)) {
            if(count(get_object_vars($dataLamaFormFiturJson->name)) > 0) {
                foreach($dataLamaFormFiturJson->name as $key => $data) {
                    $this->name[$key] = $data;
                }
            }
        }

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
            // dd(gettype($dataLamaFormFiturJson->images));
            $datala = $dataLamaFormFiturJson->images;
            // dd($dataLamaFormFiturJson->images);
            // if($this->images) {
            //     $this->images = array_push($datala, $this->images);

            // }

        
            $this->imagesLama = array_map(function ($datala) { return $datala; }, $datala);
            $this->images = $this->imagesLama;
            // if(empty($this->images)) {
            //     $this->images = implode(', ', $this->imagesLama);
                
            // }
            
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

    
    public function saveData() {
        // $this->validate([
        //     "name" => 'required',
        //     "image" =>'required',
        //     "images" => 'required',
        //     "textarea" => 'required',
        //     "selectOption" => 'required',
        //     "checkbox" => 'required',
        //     "switch" => 'required',
        //     "color" => 'required',
        // ]);
        // $this->validate($dataValidate);.



        $dataLog = [
            'class' => "Livewire->formElement->saveData",
            'name_activity' => true ? "update" : "create",
            'data_ip' => $this->ip,
            'data_location' => $this->location,
            'data_user' => auth()->user()->toJson(),
            'data_before' => null,
            'data_after' => null,
            'keterangan' => "Berhasil menambahkan data form element",
        ];

        $formFiturs = fiturSitus::where("id_situs", $this->idSitus)->where("id_fitur", $this->idFitur)->where("type", $this->typeSite);
        $situsName = $this->dataSitus->where("id", $this->idSitus)->first();
        // $this->test = $this->formFitur->get("data");
        // dd();
        DB::beginTransaction();
        try {
            $msg = "Data added successfully";
            $type = "success";

            $dir = "situs/". strtolower(trim($situsName->name)) . "/" . $this->typeSite . "/" . $this->filed[0]->typeFitur->name;
            $imgs = [];
            if($this->images) {
                foreach ($this->images as $img) {
                    // $imgs[] = $this->uploadFiles($dir, $img);
                    if (gettype($img) != "string") {
                        $store = $this->uploadFiles($dir, $img);
                        // dd($store);
                        if ($store['status']) array_push($imgs, $store['url']);
                        // if ($store['status']) array_push($img, $store['url']);
                    } else {
                        array_push($imgs, $img);
                        // $this->uploadFiles($dir, $img);
                    }
                }
            }
    
            // dd($imgs);
    
            $data = collect([
                    "name" => $this->name,
                    "image" =>$this->uploadFiles($dir, $this->image),
                    "images" => $imgs,
                    "textarea" => $this->textarea,
                    "selectOption" => $this->selectOption, 
                    "checkbox" => $this->checkbox,
                    "switch" => $this->switch,
                    "color" => $this->color,
            ]);
    
            $formFiturs->update(["data" =>  $data]);

            log::create($dataLog);
    
            DB::commit();
            // $this->resetForm();

            $this->dispatchBrowserEvent("modalClose");

            $this->dispatchBrowserEvent("toast:$type", [
                "message" => $msg
            ]);
            
        }catch (\Throwable $th) {
            DB::rollback();
            dd($th);
            $this->dispatchBrowserEvent("toast:error", [
                "message" => $th->getMessage()
            ]);
            $dataLog['keterangan'] = "Gagal menambah atau mengubah data form element karena => ".$th->getMessage();
            log::create($dataLog);
        }

      
       
        


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

        // dd($this->data_iconsosmed_desktop);
    }
    public function removeFormIconSosmed($id) {
        unset($this->data_iconsosmed[$id]);

    }
    

    public function uploadFiles($path, $file)
    {
        try {
            if ($file && gettype($file) != "string") {
                // $ext = $file->getClientOriginalExtension();
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
            // return response()->json(['message' => $exception->getMessage()], 409);

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

