<?php

namespace App\Http\Controllers;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
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

    public function git()
    {
        // dd("ada");
        // $process = new Process(['C:\Program Files\Git\cmd\git', 'pull']);

        // try {
        //     $process->mustRun();

        //     echo $process->getOutput();
        // } catch (ProcessFailedException $exception) {
        //     echo $exception->getMessage();
        // }

        $process = Process::fromShellCommandline('cd ' . env('AUTO_PULL_DIR') . ' && "C:\Program Files\Git\cmd\git" pull');
        try {
            $process->mustRun();

            echo $process->getOutput();
        } catch (ProcessFailedException $exception) {
            dd($exception);
            return [
                "message" => $exception->getMessage(),
                "add" => $exception
            ];
        }
    }
}
