<?php
namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use App\Models\User as Muser;
use App\Models\Situs as Msitus;
use App\Models\role as Mrole;
use App\Models\aksesMenu as MaksesMenu;
use App\Models\aksesSitus as MaksesSitus;
use App\Models\aksesFitur as MaksesFitur;
use DB;

class User extends Component
{
    use WithPagination;

    public $search = '';
    protected $listeners = ['removeAccessSite'];
    public $name, $username, $role;

    public $userSelect = false, $siteSelect = false, $siteDataSelect = false;

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

        return view('livewire.user',[
            "data" => $data,
            "situs" => Msitus::get(),
            "roleAll" => Mrole::get()
        ])->extends('layouts.app2');
    }

    public function updated($propertyName)
    {
        $this->validate([
            'name' => 'required',
            'username' => 'required',
            'role' => 'required'
        ]);
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

    public function saveData()
    {
        $this->validate([
            'name' => 'required',
            'username' => 'required',
            'role' => 'required'
        ]);

        $error = false;

        if ($this->role != 1) {
            $error = $this->filedValidate();
        }

        if (!$error) {
            DB::beginTransaction();
            try {
                $msg = "Data added successfully. Password default <u>smbit001122</u>";

                $user = new Muser;
                $user->name = $this->name;
                $user->username = $this->username;
                $user->password = Hash::make('smbit001122');
                $user->id_role = $this->role;
                $user->save();

                MaksesMenu::insert([
                    [
                        'id_user' => $user->id,
                        'name' => 'User',
                        'status' => $this->userSelect,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],[
                        'id_user' => $user->id,
                        'name' => 'Site',
                        'status' => $this->siteSelect,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],[
                        'id_user' => $user->id,
                        'name' => 'Site Data',
                        'status' => $this->siteDataSelect,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                ]);

                foreach ($this->accessSite as $i => $v) {
                    $situs = new MaksesSitus;
                    $situs->id_user = $user->id;
                    $situs->id_situs = $v['site'];
                    $situs->save();

                    foreach ($v['fitur'] as $item) {
                        $fitur = new MaksesFitur;
                        $fitur->id_akses_situs = $situs->id;
                        $fitur->id_fitur = $item['id'];
                        $fitur->desktop = $item['desktop'];
                        $fitur->mobile = $item['mobile'];
                        $fitur->save();
                    }
                }

                DB::commit();
                $this->resetForm();

                $this->dispatchBrowserEvent("modalClose");

                $this->dispatchBrowserEvent("toast:success", [
                    "message" => $msg
                ]);
            } catch (\Throwable $th) {
                DB::rollback();
                $this->dispatchBrowserEvent("toast:error", [
                    "message" => $th->getMessage()
                ]);

            }
        }
    }

    public function filedValidate()
    {
        $error = false;
        if (!$this->userSelect && !$this->siteSelect && !$this->siteDataSelect) {
            $this->addError('aksesMenu', 'Please provide at least one menu access.');
            $error = true;
        }

        $site = $this->accessSite;
        foreach ($this->dataAccessSite as $i => $v) {
            if (isset($site[$v])) {
                if (isset($site[$v]['site'])) {
                    if (isset($site[$v]['fitur'])) {
                        if (count($site[$v]['fitur']) == 0) {
                            $this->addError($v, 'Please select a feature');
                            $error = true;
                        }
                    }else{
                        $this->addError($v, 'Please select a feature');
                        $error = true;
                    }
                }else{
                    $this->addError($v, 'The site access field cannot be empty.');
                    $error = true;
                }
            }else{
                $this->addError($v, 'The site access field cannot be empty.');
                $error = true;
            }
        }

        return $error;
    }

    public function resetForm()
    {
        $this->resetValidation();
        $this->reset([
            'search',
            'name',
            'username',
            'role',
            'userSelect',
            'siteSelect',
            'siteDataSelect',
            'accessSite',
            'dataAccessSite',
        ]);
    }


}
