<?php

namespace App\Http\Livewire\Pages;

use Livewire\Component;
use File;

class Home extends Component
{
    public $situs, $config;

    public function render()
    {
        return view('livewire.pages.home')->extends('layouts.app');
    }

    public function updated($propertyName)
    {
        if ($propertyName == "situs") {
            //cek apakah file config untuk situs yang di pilih ada atau tidak
            $path = public_path("/situs/config/".$this->situs.".json");
            $isExistsFile = File::exists($path);

            // jika ada maka
            if ($isExistsFile) {

            }else{ // jika gak ada maka

            }
        }
    }
}
