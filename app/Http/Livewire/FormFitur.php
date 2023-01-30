<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\formFitur as MformFitur;
use App\Models\fitur;
use App\Models\formElement;
use App\Models\log;
use AWS\CRT\HTTP\Request;
use DB;

class FormFitur extends Component
{
    use WithPagination;

    protected $listeners = ['deleteData'];

    public $search = '';
    public $ip, $location;
    public $name, $type, $methodUpdate = false;

    public $nameUpdate, $typeUpdate;

    public $formElement, $idFormElement, $fitur;

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
        $this->updateLocation();
        $this->formElement = formElement::All();
        $this->fitur = fitur::All();

    }

    public function render()
    {
        $search = $this->search;
        $data = MformFitur::with(['formElemen', "typeFitur" ])
        ->when($search, function($e) use($search) {
            $e->orWhereHas('formElemen', function($e) use($search) {
                $e->where("name", 'like', '%'.$search.'%');
            })->orWhereHas('typeFitur', function($e) use($search) {
                $e->where("name", 'like', '%'.$search.'%');
            });
        })->paginate(10);
        return view('livewire.form-fitur', [
            "data" => $data,
        ])->extends('layouts.app2');
    }

    public function updated($propertyName)
    {

        $dataValidate = $this->validateData();
        $this->validate($dataValidate);

    }

    public function resetForm()
    {
        $this->resetValidation();
        $this->reset([
            'search',
            'name',
            'type',
            'methodUpdate',
            'idFormElement',
            "nameUpdate",
            "typeUpdate",
        ]);

        $this->dispatchBrowserEvent("sumo:type", [
            "type" => "reset",
            "name" => "reset"
        ]);
    }

    public function showForm($add, $id = null)
    {   
        if ($add) {
            $this->methodUpdate = false;
        }else{
            $this->methodUpdate = true;
            $data = MformFitur::where("id_fitur", $id)->get();
            $this->name = $data[0]->id_fitur;
            $this->type = $data->pluck("id_form_element");

            $this->nameUpdate = $data[0]->id_fitur;
            $this->typeUpdate = $data->pluck("id_form_element");

            $this->dispatchBrowserEvent("sumo:type", [
                "type" => "set",
                "val" => $this->type
            ]);
        }
    }

    public function validateData()
    {
        $validate = [
            'name' => 'required',
            'type' => 'required',
        ];

        return $validate;
    }

    public function saveData()
    {
        $dataValidate = $this->validateData();
        $this->validate($dataValidate);

        $dataLog = [
            'class' => "Livewire->formElement->saveData",
            'name_activity' => $this->methodUpdate ? "update" : "create",
            'data_ip' => $this->ip,
            'data_location' => $this->location,
            'data_user' => auth()->user()->toJson(),
            'data_before' => null,
            'data_after' => null,
            'keterangan' => "Berhasil menambahkan data form element",
        ];

        DB::beginTransaction();
        try {
            $msg = "Data added successfully";
            $type = "success";
            if ($this->methodUpdate) {
                $formFitur = MformFitur::where("id_fitur", $this->nameUpdate)->get();
                $dataLog["data_before"] = $formFitur->toJson();

                MformFitur::where("id_fitur", $this->nameUpdate)->delete();
                $name = $this->name;
                $dataInsert = collect($this->type)->map(function($e) use($name) {
                    return [
                        "id_fitur" => $name,
                        "id_form_element" => $e,
                    ];
                })->toArray();

                $msg = "Data update successfully.";
                $type = "info";
    
                MformFitur::insert($dataInsert);

                $formFitur = MformFitur::where("id_fitur", $this->name)->get();
                $dataLog["data_after"] = $formFitur->toJson();
            }else{
                $name = $this->name;
                if(!MformFitur::where("id_fitur", $name)->first()) {
                    $dataInsert = collect($this->type)->map(function($e) use($name) {
                        
                        return [
                            "id_fitur" => $name,
                            "id_form_element" => $e,
                        ];
                    })->toArray();
        
                    MformFitur::insert($dataInsert);

                    $formFitur = MformFitur::where("id_fitur", $this->name)->get();
                    $dataLog["data_after"] = $formFitur->toJson();
                }else {
                    $msg = "Data Fitur Already Exist";
                    $type = "info";
                }
            }

            log::create($dataLog);
    
            DB::commit();
            $this->resetForm();

            $this->dispatchBrowserEvent("modalClose");

            $this->dispatchBrowserEvent("toast:$type", [
                "message" => $msg
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th);
            $this->dispatchBrowserEvent("toast:error", [
                "message" => $th->getMessage()
            ]);
            $dataLog['keterangan'] = "Gagal menambah atau mengubah data form element karena => ".$th->getMessage();
            log::create($dataLog);
        }
    }

    public function deleteConfirm($id)
    {
        $this->dispatchBrowserEvent("swal:confirm", [
            "id" => $id
        ]);
    }

    public function deleteData($id)
    {
        $dataLog = [
            'class' => "Livewire->formElemen->deleteData",
            'name_activity' => "delete",
            'data_ip' => $this->ip,
            'data_location' => $this->location,
            'data_user' => auth()->user()->toJson(),
            'data_before' => null,
            'data_after' => null,
            'keterangan' => "Berhasil menghapus data form element",
        ];

        DB::beginTransaction();
        try {
            $formFitur = MformFitur::with(['formElemen', 'typeFitur'])->where("id_fitur", $id)->first();
            $dataLog["data_before"] = $formFitur;


            MformFitur::where("id_fitur", $id)->delete();
            log::create($dataLog);
            $this->dispatchBrowserEvent("toast:info", [
                "message" => "Data deleted successfully"
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            $this->dispatchBrowserEvent("toast:error", [
                "message" => $th->getMessage()
            ]);
            $dataLog['keterangan'] = "Gagal menghapus data form element karena => ".$th->getMessage();
            log::create($dataLog);
        }

    }
}
