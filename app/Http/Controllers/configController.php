<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\situs;

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
}
