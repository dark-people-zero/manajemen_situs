<?php
namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\User as Muser;
use App\Models\Situs as Msitus;
use App\Models\role as Mrole;
use App\Models\aksesMenu as MaksesMenu;
use App\Models\aksesSitus as MaksesSitus;
use App\Models\aksesFitur as MaksesFitur;
use App\Models\fitur;
use DB;

class User extends Component
{
    use WithPagination;

    public $search = '';
    protected $listeners = ['removeAccessSite', 'deleteData'];
    public $name, $username, $role, $idUser, $methodUpdate = false;

    public $userSelect = false, $siteSelect = false, $siteDataSelect = false;

    public $accessSite = [];

    public $dataAccessSite = [];

    public $fitur;

    public function render()
    {
        $this->fitur = fitur::get()->toArray();
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
        if (in_array($propertyName,['name','username','role'])) {
            $this->validate([
                'name' => 'required',
                'username' => 'required',
                'role' => 'required'
            ]);
        }
    }

    public function removeAccessSite($index)
    {
        if (($key = array_search($index, $this->dataAccessSite)) !== false) {
            unset($this->dataAccessSite[$key]);
            unset($this->accessSite[$index]);
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
            if (!$val[$i]['desktop'] && !$val[$i]['mobile']) {
                unset($this->accessSite[$index][$type][$i]);
            }else{
                $this->accessSite[$index][$type][$i] = $val[$i];
            }
        }else{
            $this->accessSite[$index][$type] = $val;
            $data = Msitus::with(['fiturSitus.fitur'])->find($val);
            $existing = null;
            if ($this->idUser) {
                $existing = MaksesSitus::with(['aksesFitur'])->where("id_user", $this->idUser)->where("id_situs", $val)->first();
            }

            $this->dispatchBrowserEvent("collapse:fitur", [
                "index" => $index,
                "data" => $data,
                "fitur" => $this->fitur,
                "existing" => $existing
            ]);
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
                $type = "success";

                if ($this->methodUpdate) {
                    $user = Muser::with(['aksesMenu', 'aksesSitus' => function($e) {
                        $e->with([
                            'situs',
                            'aksesFitur' => function($e) {
                                $e->with('fitur');
                            }
                        ]);
                    }])->where("id", $this->idUser)->first();

                    $user->name = $this->name;
                    $user->username = $this->username;
                    $user->id_role = $this->role;
                    $user->save();

                    if ($this->role != 1) {
                        foreach ($user->aksesMenu as $val) {
                            if (strtolower($val->name) == "user") MaksesMenu::where("id", $val->id)->update([
                                'status' => $this->userSelect,
                            ]);

                            if (strtolower($val->name) == "site") MaksesMenu::where("id", $val->id)->update([
                                'status' => $this->siteSelect,
                            ]);

                            if (strtolower($val->name) == "site data") MaksesMenu::where("id", $val->id)->update([
                                'status' => $this->siteDataSelect,
                            ]);
                        }

                        // remove data lama
                        $idSitus = $user->aksesSitus->pluck("id");
                        MaksesSitus::destroy($idSitus);

                        $idFitur = $user->aksesSitus->map(function($e) {
                            return $e->aksesFitur->pluck("id");
                        })->collapse();
                        MaksesFitur::destroy($idFitur);

                        //input data baru
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
                    }

                    $msg = "Data update successfully.";
                    $type = "info";

                }else{
                    $user = new Muser;
                    $user->name = $this->name;
                    $user->username = $this->username;
                    $user->password = Hash::make('smbit001122');
                    $user->id_role = $this->role;
                    $user->save();

                    if ($this->role != 1) {

                        $menu = [
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
                        ];
                        if ($this->role == 3) $menu = [
                            [
                                'id_user' => $user->id,
                                'name' => 'Site',
                                'status' => $this->siteSelect,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]
                        ];
                        MaksesMenu::insert($menu);

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
                    }

                }


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
                        }else {
                            foreach ($site[$v]['fitur'] as $val) {
                                if (!$val['desktop'] && !$val['mobile']) {
                                    $this->addError($v, 'Please select a feature');
                                    $error = true;
                                }
                            }
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
            'methodUpdate',
            "idUser",
            'userSelect',
            'siteSelect',
            'siteDataSelect',
            'accessSite',
            'dataAccessSite',
        ]);

        $this->dispatchBrowserEvent("sumo:role", [
            "type" => "reset"
        ]);
    }

    public function setUpdate($id)
    {
        $this->resetForm();

        $this->methodUpdate = true;
        $this->idUser = $id;
        $user = Muser::with(['aksesMenu', 'aksesSitus' => function($e) {
            $e->with([
                'situs',
                'aksesFitur' => function($e) {
                    $e->with('fitur');
                }
            ]);
        }])->where("id", $id)->first();

        $this->name = $user->name;
        $this->username = $user->username;
        $this->role = $user->id_role;
        $this->dispatchBrowserEvent("sumo:role", [
            "type" => "set",
            "val" => $user->id_role
        ]);

        if ($user->id_role != 1) {
            foreach ($user->aksesMenu as $item) {
                if (strtolower($item->name) == "user" && $item->status) $this->userSelect = $item->status;
                if (strtolower($item->name) == "site" && $item->status) $this->siteSelect = $item->status;
                if (strtolower($item->name) == "site data" && $item->status) $this->siteDataSelect = $item->status;
            }

            // untuk akses situs
            if ($user->aksesSitus->count() > 0) $this->dataAccessSite = [];
            foreach ($user->aksesSitus as $i => $item) {
                $i = "no".($i+1);
                $this->addAccessSiteVal($i,"site", $item->id_situs);
                foreach ($item->aksesFitur as $val) {
                    $this->addAccessSiteVal($i,"fitur", [
                        $val->id_fitur => [
                            "id" => $val->id_fitur,
                            "desktop" => $val->desktop,
                            "mobile" => $val->mobile,
                            "idExisting" => $val->id
                        ]
                    ]);
                }

                $this->addAccessSite();

            }

            $this->dispatchBrowserEvent("sumo:site", [
                "data" => $this->accessSite,
                "index" => $this->dataAccessSite
            ]);
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
        $user = Muser::with(['aksesMenu', 'aksesSitus' => function($e) {
            $e->with([
                'situs',
                'aksesFitur' => function($e) {
                    $e->with('fitur');
                }
            ]);
        }])->where("id", $id)->first();

        $menuAkses = $user->aksesMenu->pluck("id");
        $aksesSitus = $user->aksesSitus->pluck("id");
        $aksesFitur = $user->aksesSitus->map(function($e) {
            return $e->aksesFitur->pluck("id");
        })->collapse();
        MaksesMenu::destroy($menuAkses);
        MaksesSitus::destroy($aksesSitus);
        MaksesFitur::destroy($aksesFitur);

        $user->delete();
        $this->dispatchBrowserEvent("toast:info", [
            "message" => "Data deleted successfully"
        ]);

    }

    public function getDataFitur($id)
    {
        $data = Msitus::find($id);
        return $data;
    }


}
