<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Situs as Msitus;
use App\Models\fitur as Mfitur;
use App\Models\fiturSitus;
use DB;

class Situs extends Component
{
    use WithPagination;

    protected $listeners = ['deleteData'];

    public $search = '';
    public $closeModal = false;
    public $idUpdate = null;

    public $name, $d_status = false, $m_status = false, $url_d_desktop, $url_d_mobile, $url_p_desktop, $url_p_mobile;

    public $fiturDesktop = [], $fiturMobile = [];

    public function render()
    {
        $search = $this->search;
        $data = Msitus::when($search, function($e) use($search){
            $e->where('name', 'like', '%'.$search.'%')
              ->orWhere('url_desktop_dev', 'like', '%'.$search.'%')
              ->orWhere('url_desktop_prod', 'like', '%'.$search.'%')
              ->orWhere('url_mobile_dev', 'like', '%'.$search.'%')
              ->orWhere('url_mobile_prod', 'like', '%'.$search.'%');
        })->orderBy('id', 'desc')->paginate(10);

        return view('livewire.situs', [
            "data" => $data,
            "dataFitur" => Mfitur::get()
        ])->extends('layouts.app2');
    }

    public function filedValidate()
    {
        $rules = [
            'name' => 'required',
        ];

        if ($this->d_status) {
            $rules['url_d_desktop'] = 'required';
            $rules['url_p_desktop'] = 'required';
        }

        if ($this->m_status) {
            $rules['url_d_mobile'] = 'required';
            $rules['url_p_mobile'] = 'required';
        }

        if (count($this->fiturDesktop) == 0) $rules['fiturDesktop'] = 'required';
        if (count($this->fiturMobile) == 0) $rules['fiturMobile'] = 'required';

        return $rules;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->filedValidate());
    }

    public function shodModal($add, $id = null)
    {
        if ($add) {
            $this->idUpdate = null;
            $this->resetForm();
        }else{
            $this->idUpdate = $id;
            $data = Msitus::with(['fiturSitus'])->find($id);

            $this->name = $data->name;
            $this->d_status = $data->status_desktop;
            $this->m_status = $data->status_mobile;
            $this->url_d_desktop = $data->url_desktop_dev;
            $this->url_d_mobile = $data->url_desktop_prod;
            $this->url_p_desktop = $data->url_mobile_dev;
            $this->url_p_mobile = $data->url_mobile_prod;

            $this->fiturDesktop = $data->fiturSitus->where('type','desktop')->pluck('id_fitur');
            $this->fiturMobile = $data->fiturSitus->where('type','mobile')->pluck('id_fitur');

            $this->dispatchBrowserEvent("sumo:select",[
                "desktop" => $this->fiturDesktop,
                "mobile" => $this->fiturMobile
            ]);
        }
    }

    public function saveData()
    {
        $this->validate($this->filedValidate());

        DB::beginTransaction();
        try {
            $filed = [
                'name' => $this->name,
                'status_desktop' => $this->d_status,
                'status_mobile' => $this->m_status,
                'url_desktop_dev' => $this->url_d_desktop,
                'url_desktop_prod' => $this->url_p_desktop,
                'url_mobile_dev' => $this->url_d_mobile,
                'url_mobile_prod' => $this->url_p_mobile
            ];
            $type = 'success';
            $msg = "Data added successfully.";

            if ($this->idUpdate != null) {
                Msitus::with(['fiturSitus'])->where('id', $this->idUpdate)->update($filed);

                fiturSitus::where('id_situs', $this->idUpdate)->delete();

                $fiturDesktop = collect($this->fiturDesktop)->map(function($e) {
                    return [
                        "id_situs" => $this->idUpdate,
                        "id_fitur" => $e,
                        "type" => "desktop",
                        "created_at" => now(),
                        "updated_at" => now()
                    ];
                })->toArray();
                $fiturMobile = collect($this->fiturMobile)->map(function($e) {
                    return [
                        "id_situs" => $this->idUpdate,
                        "id_fitur" => $e,
                        "type" => "mobile",
                        "created_at" => now(),
                        "updated_at" => now()
                    ];
                })->toArray();
                fiturSitus::insert($fiturDesktop);
                fiturSitus::insert($fiturMobile);

                $msg = "Data changed successfully.";
                $type = 'info';
            }else{
                $situs = Msitus::create($filed);
                $fiturDesktop = collect($this->fiturDesktop)->map(function($e) use($situs) {
                    return [
                        "id_situs" => $situs->id,
                        "id_fitur" => $e,
                        "type" => "desktop",
                        "created_at" => now(),
                        "updated_at" => now()
                    ];
                })->toArray();
                $fiturMobile = collect($this->fiturMobile)->map(function($e) use($situs) {
                    return [
                        "id_situs" => $situs->id,
                        "id_fitur" => $e,
                        "type" => "mobile",
                        "created_at" => now(),
                        "updated_at" => now()
                    ];
                })->toArray();

                fiturSitus::insert($fiturDesktop);
                fiturSitus::insert($fiturMobile);
            }
            DB::commit();

            $this->closeModal = true;
            $this->resetForm();

            $this->dispatchBrowserEvent("toast:$type", [
                "message" => $msg
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            $this->dispatchBrowserEvent("toast:error", [
                "message" => $th->getMessage()
            ]);
        }
    }

    public function resetForm()
    {
        $this->reset([
            'name',
            'd_status',
            'm_status',
            'url_d_desktop',
            'url_d_mobile',
            'url_p_desktop',
            'url_p_mobile',
            'fiturDesktop',
            'fiturMobile',
        ]);
        $this->dispatchBrowserEvent("sumo:reset");
    }

    public function deleteConfirm($id)
    {
        $this->dispatchBrowserEvent("swal:confirm", [
            "id" => $id
        ]);
    }

    public function deleteData($id)
    {
        Msitus::find($id)->delete();

        $this->dispatchBrowserEvent("toast:info", [
            "message" => "Data deleted successfully"
        ]);
    }
}
