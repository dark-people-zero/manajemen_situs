<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\situs;
use Storage;

class configController extends Controller
{
    public function index($id)
    {
        $data = situs::with(['fiturSitus'])->find($id);
        if ($data) {
            $data->fitur_situs = $data->fiturSitus->map(function($e){
                $e->data = json_decode($e->data, true);
                return $e;
            })->groupBy("type");
        }
        // unset($data['fitur_situs']['desktop']);
        // return $data;

        return response()->json($data, 200);
    }

    public function git()
    {
        $win = env("AUTO_PULL_WINDOWS");
        if ($win) {
            $output = shell_exec('git pull 2>&1');
        }else{
            $output = shell_exec('sudo git pull 2>&1');
        }
        if (str_contains(strtolower($output), 'already')) {
            return redirect()->back()->with('gitsuccess', 'Data di server sudah di update.');
        }else{
            dd($output);
            return redirect()->back()->with('giterror', $output);
        }
    }

    public function situs($name, $type)
    {
        if (in_array($type, ["desktop", "mobile", "m"])) {
            if ($type == "mobile") return redirect("situs/$name/m");
            if ($type == "m") $type = "mobile";
            $target = "situs.$name.$type.index";
            if (view()->exists($target)){
                return view($target);
            }else{
                return view("pages.error404");
            }
        }else{
            return view("pages.error404");
        }
    }

    public function testing()
    {
        $directories = Storage::disk('spaces')->directories("situs");
        // spaces
        return DO_purge("situs");
        return $directories;
    }
}
