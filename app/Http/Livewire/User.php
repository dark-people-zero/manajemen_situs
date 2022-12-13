<?php
namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\User as Muser;
use App\Models\situs as Msitus;
use App\Models\role as Mrole;
use App\Models\aksesMenu as MaksesMenu;
use App\Models\aksesSitus as MaksesSitus;
use App\Models\aksesFitur as MaksesFitur;
use App\Models\fitur;
use App\Models\log;
use DB;

class User extends Component
{
    use WithPagination;

    public $search = '';
    protected $listeners = ['removeAccessSite', 'deleteData'];
    public $name, $username, $role, $idUser, $methodUpdate = false;
    public $ip, $location;

    public $userSelect = false, $siteSelect = false, $siteDataSelect = false;

    public $menuAccessDefault = [];

    public $accessSite = [];

    public $dataAccessSite = [];

    public $fitur;

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

    public function render()
    {
        $this->updateLocation();
        $this->fitur = fitur::get()->toArray();
        $search = $this->search;
        $role = auth()->user()->role->role_id;
        $data = Muser::when($search, function($e) use($search){
            $e->where('name', 'like', '%'.$search.'%')
              ->orWhere('username', 'like', '%'.$search.'%');
        })->when($role, function($e) use($role) {
            if ($role == 2) $e->where("id_role", 3)->orWhere("id", auth()->user()->id);
        })->paginate(10);
        $roleAll = Mrole::when($role, function($e) use($role) {
            if ($role == 2) $e->where("role_id", 3);
            if ($role == 4) $e->where("role_id", "!=", 1);
        })->get();

        return view('livewire.user',[
            "data" => $data,
            "situs" => Msitus::get(),
            "roleAll" => $roleAll
        ])->extends('layouts.app2');
    }

    public function updated($propertyName)
    {
        $this->updateLocation();
        if ($propertyName == "role") {
            if (in_array($this->role, [2,3])) {
                if (count($this->menuAccessDefault) == 0){
                    $this->menuAccessDefault = [
                        [
                            "id_user" => null,
                            "name" => "User",
                            "status" => false,
                        ],
                        [
                            "id_user" => null,
                            "name" => "Site",
                            "status" => false,
                        ],
                        [
                            "id_user" => null,
                            "name" => "Site Data",
                            "status" => false,
                        ],
                    ];
                }
            }else{
                $this->reset([
                    "dataAccessSite",
                    "menuAccessDefault"
                ]);
                $this->addAccessSite();
            }
            $this->dispatchBrowserEvent("access:site");
        }

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

    public function ChangeMenuAccess($index)
    {
        $this->menuAccessDefault[$index]["status"] = !$this->menuAccessDefault[$index]["status"];
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

            if ($data) $data->fitur_situs = $data->fiturSitus;

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

        if (in_array($this->role, [2,3])) $error = $this->filedValidate();

        if (!$error) {
            $dataLog = [
                'class' => "Livewire->users->saveData",
                'name_activity' => "create",
                'data_ip' => $this->ip,
                'data_location' => $this->location,
                'data_user' => auth()->user()->toJson(),
                'data_before' => null,
                'data_after' => null,
                'keterangan' => null,
            ];
            DB::beginTransaction();
            try {
                $msg = "Data added successfully. Password default <u>smbit001122</u>";
                $type = "success";

                if ($this->methodUpdate) {
                    $user = Muser::with(['role','aksesMenu', 'aksesSitus' => function($e) {
                        $e->with(['situs','aksesFitur.fitur']);
                    }])->find($this->idUser);

                    $dataLog['data_before'] = $user->toJson();

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

                    $dataLog['data_after'] = Muser::with(["role","aksesMenu","aksesSitus" => function($e) {
                        $e->with(["situs", "aksesFitur.fitur"]);
                    }])->find($user->id)->toJson();

                    $dataLog['keterangan'] = "Berhasil mengubah data user";

                }else{
                    $user = new Muser;
                    $user->name = $this->name;
                    $user->username = $this->username;
                    $user->password = Hash::make('smbit001122');
                    $user->id_role = $this->role;
                    $user->save();

                    if (in_array($this->role, [2,3])) {
                        $menu = collect($this->menuAccessDefault)->map(function($e) use($user) {
                            $e["id_user"] = $user->id;
                            $e['created_at'] = now();
                            $e['updated_at'] = now();
                            return $e;
                        })->toArray();
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

                    $dataLog['data_after'] = Muser::with(["role","aksesMenu","aksesSitus" => function($e) {
                        $e->with(["situs", "aksesFitur.fitur"]);
                    }])->find($user->id)->toJson();

                    $dataLog['keterangan'] = "Berhasil menambahkan data user";

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
                $this->dispatchBrowserEvent("toast:error", [
                    "message" => $th->getMessage()
                ]);
                $dataLog['keterangan'] = "Gagal menambah atau mengubah data user karena => ".$th->getMessage();
                log::create($dataLog);

            }
        }
    }

    public function filedValidate()
    {
        $error = false;
        $accessMenu = collect($this->menuAccessDefault)->filter(function($e) {
            return $e["status"];
        });
        if (count($accessMenu) == 0) {
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
            'accessSite',
            'dataAccessSite',
            "menuAccessDefault",
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
        $this->role = $user->role->role_id;
        $this->dispatchBrowserEvent("sumo:role", [
            "type" => "set",
            "val" => $user->role->role_id
        ]);

        if (in_array($user->role->role_id, [4])) {
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
