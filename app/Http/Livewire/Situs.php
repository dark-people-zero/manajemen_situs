<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Situs as Msitus;
use DB;

class Situs extends Component
{
    use WithPagination;

    protected $listeners = ['deleteData'];

    public $search = '';
    public $closeModal = false;
    public $idUpdate = null;

    public $name, $d_status = false, $m_status = false, $url_d_desktop, $url_d_mobile, $url_p_desktop, $url_p_mobile;

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
            "data" => $data
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
            $data = Msitus::find($id);

            $this->name = $data->name;
            $this->d_status = $data->status_desktop;
            $this->m_status = $data->status_mobile;
            $this->url_d_desktop = $data->url_desktop_dev;
            $this->url_d_mobile = $data->url_desktop_prod;
            $this->url_p_desktop = $data->url_mobile_dev;
            $this->url_p_mobile = $data->url_mobile_prod;
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
                Msitus::where('id', $this->idUpdate)->update($filed);
                $msg = "Data changed successfully.";
                $type = 'info';
            }else{
                Msitus::create($filed);
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
            'url_p_mobile'
        ]);
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
