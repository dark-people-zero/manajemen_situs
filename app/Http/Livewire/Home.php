<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\aksesSitus;
use App\Models\situs;
use File;

class Home extends Component
{
    use WithFileUploads;

    public $idSitus, $prevActive, $urlActive, $dataSitus;
    public $statPengaturan = false;
    public $data_desktop = [], $data_mobile = [];

    // untuk toogle desktop
    public $toogle_popupmodal_desktop = false;
    public $toogle_headerapk_desktop = false;
    public $toogle_headercorousel_desktop = false;
    public $toogle_buttonaction_desktop = true;
    public $toogle_iconsosmed_desktop = false;
    public $toogle_promosi_desktop = false;
    public $toogle_beforefooter_desktop = false;
    public $toogle_footerprotection_desktop = false;
    public $toogle_linkAlternatif_desktop = false;
    public $toogle_barcodeqris_desktop = false;

    // untuk toogle mobile
    public $toogle_popupmodal_mobile = false;
    public $toogle_headerapk_mobile = false;
    public $toogle_headercorousel_mobile = false;
    public $toogle_buttonaction_mobile = false;
    public $toogle_iconsosmed_mobile = true;
    public $toogle_promosi_mobile = false;
    public $toogle_beforefooter_mobile = false;
    public $toogle_footerprotection_mobile = false;
    public $toogle_linkAlternatif_mobile = false;
    public $toogle_barcodeqris_mobile = false;

    // untuk popup modal desktop dan mobile
    public $file_popupmodal_desktop, $deskripsi_popupmodal_desktop, $file_popupmodal_mobile, $deskripsi_popupmodal_mobile;

    // untuk header APk desktop dan mobile
    public $file_headerapk_desktop, $title_headerapk_desktop, $slogan_headerapk_desktop, $file_headerapk_mobile, $title_headerapk_mobile, $slogan_headerapk_mobile;

    // untuk header corousel desktop dan mobile
    public $file_headercorousel_desktop = [], $file_headercorousel_mobile = [];
    public $file_temp_headercorousel_desktop = [], $file_temp_headercorousel_mobile = [];

    // untuk btn action desktop dan mobile
    public $data_buttonaction_desktop = [], $data_buttonaction_mobile = [];

    // untuk icon sosmed desktop dan mobile
    public $data_iconsosmed_desktop = [], $data_iconsosmed_mobile = [];

    // filed untuk desktop
    public $d_p_status, $d_p_nama, $d_p_url, $d_p_img;

    public function render()
    {
        $situs = aksesSitus::with(['situs'])->where('id_user', auth()->user()->id)->get();
        return view('livewire.home',[
            "Aksessitus" => $situs
        ])->extends('layouts.app');
    }

    public function removeImage($target, $index = null)
    {
        if ($index != null) {
            if ($target == "file_headercorousel_desktop") unset($this->file_headercorousel_desktop[(int)$index]);
        }else{
            $this->reset($target);
        }
    }

    public function showModalMore($target)
    {
        $data = [];
        if ($target == "file_headercorousel_desktop") {
            $data = collect($this->file_headercorousel_desktop)->map(function($e) {
                return $e->temporaryUrl();
            });
        }
        if ($target == "file_headercorousel_mobile") {
            $data = collect($this->file_headercorousel_mobile)->map(function($e) {
                return $e->temporaryUrl();
            });
        }

        $this->dispatchBrowserEvent("showModalMore", [
            "target" => $target,
            "img" => $data
        ]);
    }

    public function updated($propertyName)
    {
        if ($propertyName == "idSitus") {
            $situs = situs::with(['fiturSitus'])->find($this->idSitus);
            $stat = env("APP_STAT");
            $this->dataSitus = $situs;
            if ($situs->status_desktop) {
                $this->prevActive = 'desktop';
                $this->urlActive = $situs["url_desktop_$stat"];
                $this->statPengaturan = true;
                $this->setFiturSitur($situs->fiturSitus);
            }else if ($situs->status_mobile) {
                $this->prevActive = 'mobile';
                $this->urlActive = $situs["url_mobile_$stat"];
                $this->statPengaturan = true;
                $this->setFiturSitur($situs->fiturSitus);
            }else{
                $this->prevActive = 'desktop';
                $this->urlActive = '/underconstruction';
                $this->statPengaturan = false;
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

        $validate = $this->validationFiled();

        if ($propertyName == "file_temp_headercorousel_desktop") {
            $this->file_headercorousel_desktop = array_merge($this->file_headercorousel_desktop, $this->file_temp_headercorousel_desktop);
            $this->reset("file_temp_headercorousel_desktop");
        }

        if ($propertyName == "file_temp_headercorousel_mobile") {
            $this->file_headercorousel_mobile = array_merge($this->file_headercorousel_mobile, $this->file_temp_headercorousel_mobile);
            $this->reset("file_temp_headercorousel_mobile");
        }

        if(count($validate['validate']) > 0) $this->validate($validate['validate'], $validate['message'], $validate['attribute']);



    }

    public function validationFiled()
    {
        $validate = [];
        $message = [];
        $attribute = [];

        // untuk popup modal desktop dan mobile
        if ($this->toogle_popupmodal_desktop) {
            $validate["deskripsi_popupmodal_desktop"] = 'required';
            $message["deskripsi_popupmodal_desktop.required"] = str_replace(":attribute", "deskripsi", trans("validation.required"));

            $validate["file_popupmodal_desktop"] = 'required|image|max:20480'; // 20MB max
            $message["file_popupmodal_desktop.required"] = str_replace(":attribute", "image", trans("validation.required"));
            if ($this->file_popupmodal_desktop) {
                $file = $this->file_popupmodal_desktop;
                $orgName = $file->getClientOriginalName();
                $message["file_popupmodal_desktop.image"] = str_replace(":attribute","file $orgName", trans("validation.image"));
                $message["file_popupmodal_desktop.max"] = str_replace(":max", "20480", str_replace(":attribute","file $orgName", trans("validation.max.file")));
            }

        }
        if ($this->toogle_popupmodal_mobile) {
            $validate["file_popupmodal_mobile"] = 'required|image|max:20480'; // 20MB max
            $validate["deskripsi_popupmodal_mobile"] = 'required';

            $validate["deskripsi_popupmodal_mobile"] = 'required';
            $message["deskripsi_popupmodal_mobile.required"] = str_replace(":attribute", "deskripsi", trans("validation.required"));

            $validate["file_popupmodal_mobile"] = 'required|image|max:20480'; // 20MB max
            $message["file_popupmodal_mobile.required"] = str_replace(":attribute", "image", trans("validation.required"));
            if ($this->file_popupmodal_mobile) {
                $file = $this->file_popupmodal_mobile;
                $orgName = $file->getClientOriginalName();
                $message["file_popupmodal_mobile.image"] = str_replace(":attribute","file $orgName", trans("validation.image"));
                $message["file_popupmodal_mobile.max"] = str_replace(":max", "20480", str_replace(":attribute","file $orgName", trans("validation.max.file")));
            }
        }

        // untuk header apk desktop dan mobile
        if ($this->toogle_headerapk_desktop) {
            $validate["file_headerapk_desktop"] = 'required|image|max:3072'; // 3MB max
            $validate["title_headerapk_desktop"] = 'required';
            $validate["slogan_headerapk_desktop"] = 'required';

            $message["title_headerapk_desktop.required"] = str_replace(":attribute", "title", trans("validation.required"));
            $message["slogan_headerapk_desktop.required"] = str_replace(":attribute", "slogan", trans("validation.required"));
            $message["file_headerapk_desktop.required"] = str_replace(":attribute", "image", trans("validation.required"));

            if ($this->file_headerapk_desktop) {
                $file = $this->file_headerapk_desktop;
                $orgName = $file->getClientOriginalName();
                $message["file_headerapk_desktop.image"] = str_replace(":attribute","file $orgName", trans("validation.image"));
                $message["file_headerapk_desktop.max"] = str_replace(":max", "3072", str_replace(":attribute","file $orgName", trans("validation.max.file")));
            }
        }
        if ($this->toogle_headerapk_mobile) {
            $message["file_headerapk_mobile.required"] = str_replace(":attribute", "title", trans("validation.required"));
            $message["title_headerapk_mobile.required"] = str_replace(":attribute", "slogan", trans("validation.required"));
            $message["slogan_headerapk_mobile.required"] = str_replace(":attribute", "image", trans("validation.required"));

            if ($this->file_headerapk_mobile) {
                $file = $this->file_headerapk_mobile;
                $orgName = $file->getClientOriginalName();
                $message["file_headerapk_mobile.image"] = str_replace(":attribute","file $orgName", trans("validation.image"));
                $message["file_headerapk_mobile.max"] = str_replace(":max", "3072", str_replace(":attribute","file $orgName", trans("validation.max.file")));
            }
        }

        // untuk header corousel desktop dan mobile
        if ($this->toogle_headercorousel_desktop) {
            $validate["file_headercorousel_desktop.*"] = 'image|max:20480';
            foreach ($this->file_headercorousel_desktop as $i => $file) {
                $orgName = $file->getClientOriginalName();
                $message["file_headercorousel_desktop.$i.image"] = str_replace(":attribute","file $orgName", trans("validation.image"));
                $message["file_headercorousel_desktop.$i.max"] = str_replace(":max", "20480", str_replace(":attribute","file $orgName", trans("validation.max.file")));
            }
        }
        if ($this->toogle_headercorousel_mobile) {
            $validate["file_headercorousel_mobile.*"] = 'image|max:20480';
            foreach ($this->file_headercorousel_mobile as $i => $file) {
                $orgName = $file->getClientOriginalName();
                $message["file_headercorousel_mobile.$i.image"] = str_replace(":attribute","file $orgName", trans("validation.image"));
                $message["file_headercorousel_mobile.$i.max"] = str_replace(":max", "20480", str_replace(":attribute","file $orgName", trans("validation.max.file")));
            }
        }

        // untuk btn action mobile dan desktop
        if ($this->toogle_buttonaction_desktop) {
            foreach ($this->data_buttonaction_desktop as $i => $val) {
                $validate["data_buttonaction_desktop.$i.name"] = "required";
                $validate["data_buttonaction_desktop.$i.link"] = [
                    "required",
                    "url"
                ];

                $message["data_buttonaction_desktop.$i.name.required"] = str_replace(":attribute","name", trans("validation.required"));
                $message["data_buttonaction_desktop.$i.link.required"] = str_replace(":attribute","link", trans("validation.required"));
                $message["data_buttonaction_desktop.$i.link.url"] = str_replace(":attribute","link", trans("validation.url"));
            }
        }

        if ($this->toogle_buttonaction_mobile) {
            foreach ($this->data_buttonaction_mobile as $i => $val) {
                $validate["data_buttonaction_mobile.$i.name"] = "required";
                $validate["data_buttonaction_mobile.$i.link"] = "required|url";

                $message["data_buttonaction_mobile.$i.name.required"] = str_replace(":attribute","name", trans("validation.required"));
                $message["data_buttonaction_mobile.$i.link.required"] = str_replace(":attribute","link", trans("validation.required"));
                $message["data_buttonaction_mobile.$i.link.url"] = str_replace(":attribute","link", trans("validation.url"));
            }
        }

        // untuk icon sosmed mobile dan desktop
        if ($this->toogle_iconsosmed_desktop) {
            foreach ($this->data_iconsosmed_desktop as $i => $val) {
                $validate["data_iconsosmed_desktop.$i.name"] = "required";
                $validate["data_iconsosmed_desktop.$i.link"] = "required|url";
                $validate["data_iconsosmed_desktop.$i.image"] = "required|image|max:20480";

                $message["data_iconsosmed_desktop.$i.name.required"] = str_replace(":attribute","name", trans("validation.required"));
                $message["data_iconsosmed_desktop.$i.link.required"] = str_replace(":attribute","link", trans("validation.required"));
                $message["data_iconsosmed_desktop.$i.link.url"] = str_replace(":attribute","link", trans("validation.url"));
                $message["data_iconsosmed_desktop.$i.image.required"] = str_replace(":attribute","image", trans("validation.required"));

                if ($val["image"]) {
                    $file = $val["image"];
                    $orgName = $file->getClientOriginalName();
                    $message["data_iconsosmed_desktop.$i.image.image"] = str_replace(":attribute","file $orgName", trans("validation.image"));
                    $message["data_iconsosmed_desktop.$i.image.max"] = str_replace(":max", "20480", str_replace(":attribute","file $orgName", trans("validation.max.file")));
                }
            }
        }

        if ($this->toogle_iconsosmed_mobile) {
            foreach ($this->data_iconsosmed_mobile as $i => $val) {
                $validate["data_iconsosmed_mobile.$i.name"] = "required";
                $validate["data_iconsosmed_mobile.$i.link"] = "required|url";
                $validate["data_iconsosmed_mobile.$i.image"] = "required|image|max:20480";

                $message["data_iconsosmed_mobile.$i.name.required"] = str_replace(":attribute","name", trans("validation.required"));
                $message["data_iconsosmed_mobile.$i.link.required"] = str_replace(":attribute","link", trans("validation.required"));
                $message["data_iconsosmed_mobile.$i.link.url"] = str_replace(":attribute","link", trans("validation.url"));
                $message["data_iconsosmed_mobile.$i.image.required"] = str_replace(":attribute","image", trans("validation.required"));

                if ($val["image"]) {
                    $file = $val["image"];
                    $orgName = $file->getClientOriginalName();
                    $message["data_iconsosmed_mobile.$i.image.image"] = str_replace(":attribute","file $orgName", trans("validation.image"));
                    $message["data_iconsosmed_mobile.$i.image.max"] = str_replace(":max", "20480", str_replace(":attribute","file $orgName", trans("validation.max.file")));
                }
            }
        }

        return [
            "validate" => $validate,
            "message" => $message,
            "attribute" => $attribute,
        ];
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

    private function setFiturSitur($data)
    {
        if ($data->count() > 0) {
            $this->data_desktop = $data->where("type", "desktop");
            $this->data_mobile = $data->where("type", "mobile");

            $this->dispatchBrowserEvent("testing",[
                "desktop" => $data->where("type", "desktop"),
                "mobile" => $data->where("type", "mobile"),
            ]);
        }
    }

    public function showFormSosmed($desktop)
    {
        if ($desktop && count($this->data_iconsosmed_desktop) == 0) $this->addFormIconSosmed(true);
        if (!$desktop && count($this->data_iconsosmed_mobile) == 0) $this->addFormIconSosmed(false);

        $this->dispatchBrowserEvent("showModalSosmed",[
            "desktop" => $desktop
        ]);
    }

    public function addFormIconSosmed($desktop)
    {
        if ($desktop) {
            array_push($this->data_iconsosmed_desktop, [
                "status" => false,
                "name" => "",
                "link" => "",
                "image" => null
            ]);
        }
        if (!$desktop) {
            array_push($this->data_iconsosmed_mobile, [
                "status" => false,
                "name" => "",
                "link" => "",
                "image" => null
            ]);
        }
        $this->resetErrorBag();
    }

    public function closeFormIconSosmed($desktop)
    {
        $validate = [];
        $message = [];
        $attribute = [];

        if ($this->toogle_iconsosmed_desktop && $desktop) {
            foreach ($this->data_iconsosmed_desktop as $i => $val) {
                $validate["data_iconsosmed_desktop.$i.name"] = "required";
                $validate["data_iconsosmed_desktop.$i.link"] = "required|url";
                $validate["data_iconsosmed_desktop.$i.image"] = "required|image|max:20480";

                $message["data_iconsosmed_desktop.$i.name.required"] = str_replace(":attribute","name", trans("validation.required"));
                $message["data_iconsosmed_desktop.$i.link.required"] = str_replace(":attribute","link", trans("validation.required"));
                $message["data_iconsosmed_desktop.$i.link.url"] = str_replace(":attribute","link", trans("validation.url"));
                $message["data_iconsosmed_desktop.$i.image.required"] = str_replace(":attribute","image", trans("validation.required"));

                if ($val["image"]) {
                    $file = $val["image"];
                    $orgName = $file->getClientOriginalName();
                    $message["data_iconsosmed_desktop.$i.image.image"] = str_replace(":attribute","file $orgName", trans("validation.image"));
                    $message["data_iconsosmed_desktop.$i.image.max"] = str_replace(":max", "20480", str_replace(":attribute","file $orgName", trans("validation.max.file")));
                }
            }
        }

        if ($this->toogle_iconsosmed_mobile && !$desktop) {
            foreach ($this->data_iconsosmed_mobile as $i => $val) {
                $validate["data_iconsosmed_mobile.$i.name"] = "required";
                $validate["data_iconsosmed_mobile.$i.link"] = "required|url";
                $validate["data_iconsosmed_mobile.$i.image"] = "required|image|max:20480";

                $message["data_iconsosmed_mobile.$i.name.required"] = str_replace(":attribute","name", trans("validation.required"));
                $message["data_iconsosmed_mobile.$i.link.required"] = str_replace(":attribute","link", trans("validation.required"));
                $message["data_iconsosmed_mobile.$i.link.url"] = str_replace(":attribute","link", trans("validation.url"));
                $message["data_iconsosmed_mobile.$i.image.required"] = str_replace(":attribute","image", trans("validation.required"));

                if ($val["image"]) {
                    $file = $val["image"];
                    $orgName = $file->getClientOriginalName();
                    $message["data_iconsosmed_mobile.$i.image.image"] = str_replace(":attribute","file $orgName", trans("validation.image"));
                    $message["data_iconsosmed_mobile.$i.image.max"] = str_replace(":max", "20480", str_replace(":attribute","file $orgName", trans("validation.max.file")));
                }
            }
        }

        $this->validate($validate, $message, $attribute);
        $this->dispatchBrowserEvent("closeModalSosmed",[
            "desktop" => $desktop
        ]);
    }

    public function removeFormIconSosmed($desktop, $index)
    {
        if ($desktop) unset($this->data_iconsosmed_desktop[(int)$index]);
        if (!$desktop) unset($this->data_iconsosmed_mobile[(int)$index]);
        $this->resetErrorBag();
    }

    public function showFormBtnAction($desktop)
    {
        if ($desktop && count($this->data_buttonaction_desktop) == 0) $this->addFormBtnAction(true);
        if (!$desktop && count($this->data_buttonaction_mobile) == 0) $this->addFormBtnAction(false);

        $this->dispatchBrowserEvent("showModalBtnAction",[
            "desktop" => $desktop
        ]);
    }

    public function addFormBtnAction($desktop)
    {
        if ($desktop) {
            array_push($this->data_buttonaction_desktop, [
                "status" => false,
                "name" => "",
                "link" => "https://",
                "class" => "btn-light",
                "style" => null,
                "target" => null,
                "shadow" => "#1b693c"
            ]);
        }
        if (!$desktop) {
            array_push($this->data_buttonaction_mobile, [
                "status" => false,
                "name" => "",
                "link" => "https://",
                "class" => "btn-light",
                "style" => null,
                "target" => null,
                "shadow" => "#1b693c"
            ]);
        }
        $this->resetErrorBag();
    }

    public function closeFormBtnAction($desktop)
    {
        $validate = [];
        $message = [];
        $attribute = [];

        // untuk btn action mobile dan desktop
        if ($this->toogle_buttonaction_desktop) {
            foreach ($this->data_buttonaction_desktop as $i => $val) {
                $validate["data_buttonaction_desktop.$i.name"] = "required";
                $validate["data_buttonaction_desktop.$i.link"] = [
                    "required",
                    "url"
                ];

                $message["data_buttonaction_desktop.$i.name.required"] = str_replace(":attribute","name", trans("validation.required"));
                $message["data_buttonaction_desktop.$i.link.required"] = str_replace(":attribute","link", trans("validation.required"));
                $message["data_buttonaction_desktop.$i.link.url"] = str_replace(":attribute","link", trans("validation.url"));
            }
        }

        if ($this->toogle_buttonaction_mobile) {
            foreach ($this->data_buttonaction_mobile as $i => $val) {
                $validate["data_buttonaction_mobile.$i.name"] = "required";
                $validate["data_buttonaction_mobile.$i.link"] = "required";

                $message["data_buttonaction_mobile.$i.name.required"] = str_replace(":attribute","name", trans("validation.required"));
                $message["data_buttonaction_mobile.$i.link.required"] = str_replace(":attribute","link", trans("validation.required"));
            }
        }

        $this->validate($validate, $message, $attribute);
        $this->dispatchBrowserEvent("closeModalBtnAction",[
            "desktop" => $desktop
        ]);
    }

    public function removeFormBtnAction($desktop, $index)
    {
        if ($desktop) unset($this->data_buttonaction_desktop[(int)$index]);
        if (!$desktop) unset($this->data_buttonaction_mobile[(int)$index]);
        $this->resetErrorBag();
    }

    public function saveDesktop()
    {
        dd("ini untuk save");
    }
}
