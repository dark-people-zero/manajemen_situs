<?php

namespace App\Http\Livewire;

use Livewire\Component;
use File;

class Home extends Component
{
    public $situs, $prevActive, $urlActive;
    public $statPengaturan = false;
    public $c_desktop, $c_mobile;

    // filed untuk desktop
    public $d_p_status, $d_p_nama, $d_p_url, $d_p_img;

    public function render()
    {
        return view('livewire.home')->extends('layouts.app');
    }

    public function updated($propertyName)
    {
        if ($propertyName == "situs") {
            // kita setting dulu halaman awal ketika situs terpilih
            // dan kita cek, apakah situsnya active atau tidak
            if ($this->situs['device']['desktop']['status']) {
                $this->prevActive = 'desktop';
                $this->urlActive = $this->situs['device']['desktop']['url'][env('APP_STAT')];
                $this->pengaturanSitus();
            }elseif ($this->situs['device']['mobile']['status']) {
                $this->prevActive = 'mobile';
                $this->urlActive = $this->situs['device']['mobile']['url'][env('APP_STAT')];
                $this->pengaturanSitus();
            }else{ // jika gak ada maka
                $this->prevActive = 'desktop';
                $this->urlActive = '/underconstruction';
                $this->reset([
                    'statPengaturan',
                    'd_p_status',
                    'd_p_nama',
                    'd_p_url',
                    'd_p_img',
                ]);
            }
        }
    }

    public function changePrev($desktop)
    {
        if ($this->prevActive && $this->urlActive) {
            if ($desktop && $this->situs['device']['desktop']['status']) {
                $this->prevActive = 'desktop';
                $this->urlActive = $this->situs['device']['desktop']['url'][env('APP_STAT')];
            }
            if(!$desktop && $this->situs['device']['mobile']['status']) {
                $this->prevActive = 'mobile';
                $this->urlActive = $this->situs['device']['mobile']['url'][env('APP_STAT')];
            }
        }
    }

    private function pengaturanSitus()
    {
        // Lalu kita cek apakah sudah ada file pengaturan untuk situs yang terpilih
        $path = public_path("/situs/config/".$this->situs['id'].".json");
        $isExistsFile = File::exists($path);

        // jika ada maka
        if ($isExistsFile) {
            $data = json_decode(file_get_contents($path), false);
            if (isset($data->desktop)) {
                $this->statPengaturan = true;
            }elseif (isset($data->mobile)) {
                $this->statPengaturan = true;
            }else{
                $this->statPengaturan = false;
            }
        }else{
            $this->statPengaturan = false;
        }
    }

    public function saveDesktop()
    {
        dd("ini untuk save");
    }
}
