<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\aksesSitus;
use App\Models\situs;
use File;

class Home extends Component
{
    public $idSitus, $prevActive, $urlActive, $dataSitus;
    public $statPengaturan = false;
    public $c_desktop, $c_mobile;

    // filed untuk desktop
    public $d_p_status, $d_p_nama, $d_p_url, $d_p_img;

    public function render()
    {
        $situs = aksesSitus::with(['situs'])->where('id_user', auth()->user()->id)->get();
        return view('livewire.home',[
            "Aksessitus" => $situs
        ])->extends('layouts.app');
    }

    public function updated($propertyName)
    {
        if ($propertyName == "idSitus") {
            $situs = situs::find($this->idSitus);
            $stat = env("APP_STAT");
            $this->dataSitus = $situs;
            if ($situs->status_desktop) {
                $this->prevActive = 'desktop';
                $this->urlActive = $situs["url_desktop_$stat"];
            }else if ($situs->status_mobile) {
                $this->prevActive = 'mobile';
                $this->urlActive = $situs["url_mobile_$stat"];
            }else{
                $this->prevActive = 'desktop';
                $this->urlActive = '/underconstruction';
            }
            // kita setting dulu halaman awal ketika situs terpilih
            // dan kita cek, apakah situsnya active atau tidak
            // if ($this->situs['device']['desktop']['status']) {
            //     $this->prevActive = 'desktop';
            //     $this->urlActive = $this->situs['device']['desktop']['url'][env('APP_STAT')];
            //     $this->pengaturanSitus();
            // }elseif ($this->situs['device']['mobile']['status']) {
            //     $this->prevActive = 'mobile';
            //     $this->urlActive = $this->situs['device']['mobile']['url'][env('APP_STAT')];
            //     $this->pengaturanSitus();
            // }else{ // jika gak ada maka
            //     $this->prevActive = 'desktop';
            //     $this->urlActive = '/underconstruction';
            //     $this->reset([
            //         'statPengaturan',
            //         'd_p_status',
            //         'd_p_nama',
            //         'd_p_url',
            //         'd_p_img',
            //     ]);
            // }
        }
    }

    public function changePrev($desktop)
    {
        $situs = $this->dataSitus;
        $stat = env("APP_STAT");
        if ($this->prevActive && $this->urlActive) {
            if ($desktop && $situs->status_desktop) {
                $this->prevActive = 'desktop';
                $this->urlActive = $situs["url_desktop_$stat"];
            }
            if(!$desktop && $situs->status_mobile) {
                $this->prevActive = 'mobile';
                $this->urlActive = $situs["url_mobile_$stat"];
            }

            if ($desktop && !$situs->status_desktop) {
                $this->prevActive = 'desktop';
                $this->urlActive = '/underconstruction';
            }

            if (!$desktop && !$situs->status_mobile) {
                $this->prevActive = 'mobile';
                $this->urlActive = '/underconstruction';
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
