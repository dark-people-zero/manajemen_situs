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

    public function testing()
    {
        // $img = Storage::disk('spaces')->putFile('danatoto/images/banks/', "danatoto_offline_bca.gif", 'public');
        return $img;
    }
}
