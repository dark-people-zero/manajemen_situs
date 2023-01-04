<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\formFitur as MformFitur;
use App\Models\optionElement;
use App\Models\typeElement;
use App\Models\log;
use DB;

class FormFitur extends Component
{
    use WithPagination;

    protected $listeners = ['deleteData'];

    public $search = '';
    public $ip, $location;
    public $name, $type, $placeholder, $switch_on, $switch_off, $option, $isMultiple = false, $methodUpdate = false;

    public $typeElement, $idFormElement;

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
        $this->typeElement = typeElement::All();
    }

    public function render()
    {
        $search = $this->search;
        $data = MformFitur::when($search, function($e) use($search) {
            $e->where("name", 'like', '%'.$search.'%')
            ->orWhere('placeholder', 'like', '%'.$search.'%')
            ->orWhereHas('typeElemen', function($e) {
                $e->where("name", 'like', '%'.$search.'%');
            })
            ->orWhereHas('typeFitur', function($e) {
                $e->where("name", 'like', '%'.$search.'%');
            });
        })->with(['typeElemen', 'typeFitur'])->paginate(10);

        return view('livewire.form-fitur', [
            "data" => $data
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
            'placeholder',
            'switch_on',
            'switch_off',
            'option',
            'isMultiple',
            'methodUpdate',
            'idFormElement',
        ]);

        $this->dispatchBrowserEvent("sumo:type", [
            "type" => "reset"
        ]);
    }

    public function showForm($add, $id = null)
    {
        if ($add) {
            $this->methodUpdate = false;
        }else{
            $this->methodUpdate = true;
            $this->idFormElement = $id;
            $formElement = MformElement::find($id);
            $this->name = $formElement->name;
            $this->type = $formElement->id_type_element;
            $this->placeholder = $formElement->placeholder;
            $this->isMultiple = $formElement->is_multiple;
            $this->switch_on = $formElement->switch_on;
            $this->switch_off = $formElement->switch_off;
            foreach ($formElement->optionElemen as $val) {
                $this->option = $this->option.$val->code." => ".$val->name.",\n";
            }

            $this->dispatchBrowserEvent("sumo:type", [
                "type" => "set",
                "val" => $formElement->id_type_element
            ]);
        }
    }

    public function validateData()
    {
        $validate = [
            'name' => 'required',
            'type' => 'required',
            'placeholder' => 'required'
        ];

        if ($this->type == 3) $validate["option"] = 'required';
        if ($this->type == 6) {
            $validate["switch_on"] = 'required';
            $validate["switch_off"] = 'required';
        }

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
            $formElement = new MformElement;

            if ($this->methodUpdate) {
                $formElement = MformElement::with(['typeElemen', 'optionElemen'])->find($this->idFormElement);
                $dataLog["data_before"] = $formElement->toJson();
                $dataLog['keterangan'] = "Berhasil mengubah data form element";
                $msg = "Data update successfully.";
                $type = "info";
            }

            $formElement->name = $this->name;
            $formElement->id_type_element = $this->type;
            $formElement->placeholder = $this->placeholder;
            $formElement->is_multiple = $this->isMultiple;

            if ($this->type == 6) {
                $formElement->switch_on = $this->switch_on;
                $formElement->switch_off = $this->switch_off;
            }else{
                $formElement->switch_on = null;
                $formElement->switch_off = null;
            }

            $formElement->save();
            optionElement::where("id_form_element", $formElement->id)->delete();
            if ($this->type == 3) {
                $option = str_replace("\n", "", $this->option);
                if ($option != "") {
                    $option = explode(",",$option);
                    foreach ($option as $val) {
                        if($val != ""){
                            $val = explode("=>",$val);
                            optionElement::create([
                                'id_form_element' => $formElement->id,
                                'code' => str_replace(" ", "", $val[0]),
                                'name' => str_replace(" ", "", $val[1]),
                            ]);
                        }
                    }
                }
            }

            $dataLog['data_after'] = MformElement::with(['typeElemen', 'optionElemen'])->find($formElement->id)->toJson();

            log::create($dataLog);

            DB::commit();
            $this->resetForm();

            $this->dispatchBrowserEvent("modalClose");

            $this->dispatchBrowserEvent("toast:$type", [
                "message" => $msg
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
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
            $formElement = MformElement::with(['typeElemen', 'optionElemen'])->where("id", $id)->first();

            $dataLog["data_before"] = $formElement;

            optionElement::where("id_form_element", $id)->delete();

            $formElement->delete();
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
