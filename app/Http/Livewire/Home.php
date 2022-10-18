<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\aksesSitus;
use App\Models\situs;
use App\Models\fiturSitus;
use Illuminate\Support\Facades\Storage;
use File;

class Home extends Component
{
    use WithFileUploads;

    public $Aksessitus;
    public $idSitus, $prevActive, $urlActive, $dataSitus;
    public $statPengaturan = false;
    public $dataFiturDesktop = [], $dataFiturMobile = [];

    // untuk toogle desktop
    public $toogle_popupmodal_desktop = false;
    public $toogle_headerapk_desktop = false;
    public $toogle_headercorousel_desktop = false;
    public $toogle_buttonaction_desktop = false;
    public $toogle_iconsosmed_desktop = false;
    public $toogle_promosi_desktop = false;
    public $toogle_beforefooter_desktop = false;
    public $toogle_footerprotection_desktop = false;
    public $toogle_linkAlternatif_desktop = false;
    public $toogle_barcodeqris_desktop = false;
    public $toogle_sortlistbank_desktop = false;

    // untuk toogle mobile
    public $toogle_popupmodal_mobile = false;
    public $toogle_headerapk_mobile = false;
    public $toogle_headercorousel_mobile = false;
    public $toogle_buttonaction_mobile = false;
    public $toogle_iconsosmed_mobile = false;
    public $toogle_promosi_mobile = false;
    public $toogle_beforefooter_mobile = false;
    public $toogle_footerprotection_mobile = false;
    public $toogle_linkAlternatif_mobile = false;
    public $toogle_barcodeqris_mobile = false;
    public $toogle_sortlistbank_mobile = false;

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

    // untuk promosi desktop dan mobile
    public $name_promosi_desktop, $link_promosi_desktop, $image_promosi_desktop, $name_promosi_mobile, $link_promosi_mobile, $image_promosi_mobile;

    // untuk before footer desktop dan mobile
    public $title_beforePromosi_desktop, $deskripsi_beforeFooter_desktop, $title_beforePromosi_mobile, $deskripsi_beforeFooter_mobile;

    // untuk footer protection desktop dan mobile
    public $name_footerProtection_desktop, $link_footerProtection_desktop, $image_footerProtection_desktop, $name_footerProtection_mobile, $link_footerProtection_mobile, $image_footerProtection_mobile;

    // untuk link alternatif desktop dan mobile
    public $image_linkAlternatif_desktop, $listLink_linkAlternatif_desktop, $image_linkAlternatif_mobile, $listLink_linkAlternatif_mobile;

    // untuk barcode QRIS desktop dan mobile
    public $name_barcodeqris_desktop = "barocde qris", $bg_barcodeqris_desktop = "#c0392b", $color_barcodeqris_desktop = "#FFFFFF", $shadow_barcodeqris_desktop = "#196a7d", $image_barcodeqris_desktop, $name_barcodeqris_mobile = "barocde qris", $bg_barcodeqris_mobile = "#c0392b", $color_barcodeqris_mobile = "#FFFFFF", $shadow_barcodeqris_mobile = "#196a7d", $image_barcodeqris_mobile;

    // untuk sort list bank desktop dan mobile
    public $list_sortlistbank_desktop, $list_sortlistbank_mobile;

    public function mount()
    {
        $this->Aksessitus = aksesSitus::with(['situs'])->where('id_user', auth()->user()->id)->get();
    }

    public function render()
    {
        // dd(collect([
        //     "file" => "https://static.hokibagus.club/ziatogel/images/popup/ziatogel_popup_bri.png",
        //     "title" => "aplikasi ziatogel",
        //     "slogan" => "Klik di mana saja untuk menutup"
        // ])->toJson());
        return view('livewire.home')->extends('layouts.app');
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

    public function changeSelectSitus($id)
    {
        $stat = env("APP_STAT");
        $dataSitus = $this->Aksessitus->where("id", $id)->first();
        if ($dataSitus) {
            $situs = $dataSitus->situs;
            $this->dataSitus = $situs;
            if ($situs->status_desktop) {
                $this->prevActive = 'desktop';
                $this->urlActive = $situs["url_desktop_$stat"];
                $this->statPengaturan = true;
            }else if ($situs->status_mobile) {
                $this->prevActive = 'mobile';
                $this->urlActive = $situs["url_mobile_$stat"];
                $this->statPengaturan = true;
            }else{
                $this->prevActive = 'desktop';
                $this->urlActive = '/underconstruction';
                $this->statPengaturan = false;
            }

            // untuk set data fitur
            if ($situs->status_desktop) {
                $this->dataFiturDesktop = $situs->fiturSitus->where("type", "desktop");
            }else {
                $this->reset("dataFiturDesktop");
            }
            if ($situs->status_mobile) {
                $this->dataFiturMobile = $situs->fiturSitus->where("type", "mobile");
            }else {
                $this->reset("dataFiturMobile");
            }

            $this->setValue();
        }
    }

    public function validationFiled()
    {
        $validate = [];
        $message = [];
        $attribute = [];

        // untuk popup modal desktop dan mobile
        if ($this->toogle_popupmodal_desktop) {
            $validate["deskripsi_popupmodal_desktop"] = 'required';
            $validate["file_popupmodal_desktop"] = 'required';

            $message["deskripsi_popupmodal_desktop.required"] = str_replace(":attribute", "deskripsi", trans("validation.required"));
            $message["file_popupmodal_desktop.required"] = str_replace(":attribute", "image", trans("validation.required"));

            if ($this->file_popupmodal_desktop && gettype($this->file_popupmodal_desktop) != "string") {
                $validate["file_popupmodal_desktop"] = 'image|max:20480'; // 20MB max
                $file = $this->file_popupmodal_desktop;
                $orgName = $file->getClientOriginalName();
                $message["file_popupmodal_desktop.image"] = str_replace(":attribute","file $orgName", trans("validation.image"));
                $message["file_popupmodal_desktop.max"] = str_replace(":max", "20480", str_replace(":attribute","file $orgName", trans("validation.max.file")));
            }

        }
        if ($this->toogle_popupmodal_mobile) {
            $validate["file_popupmodal_mobile"] = 'required';
            $validate["deskripsi_popupmodal_mobile"] = 'required';

            $message["deskripsi_popupmodal_mobile.required"] = str_replace(":attribute", "deskripsi", trans("validation.required"));
            $message["file_popupmodal_mobile.required"] = str_replace(":attribute", "deskripsi", trans("validation.required"));

            if ($this->file_popupmodal_mobile && gettype($this->file_popupmodal_mobile) != "string") {
                $validate["file_popupmodal_mobile"] = 'image|max:20480'; // 20MB max
                $file = $this->file_popupmodal_mobile;
                $orgName = $file->getClientOriginalName();
                $message["file_popupmodal_mobile.image"] = str_replace(":attribute","file $orgName", trans("validation.image"));
                $message["file_popupmodal_mobile.max"] = str_replace(":max", "20480", str_replace(":attribute","file $orgName", trans("validation.max.file")));
            }
        }

        // untuk header apk desktop dan mobile
        if ($this->toogle_headerapk_desktop) {
            $validate["file_headerapk_desktop"] = 'required';
            $validate["title_headerapk_desktop"] = 'required';
            $validate["slogan_headerapk_desktop"] = 'required';

            $message["title_headerapk_desktop.required"] = str_replace(":attribute", "title", trans("validation.required"));
            $message["slogan_headerapk_desktop.required"] = str_replace(":attribute", "slogan", trans("validation.required"));
            $message["file_headerapk_desktop.required"] = str_replace(":attribute", "image", trans("validation.required"));

            if ($this->file_headerapk_desktop) {
                if (gettype($this->file_headerapk_desktop) != "string") {
                    $validate["file_headerapk_desktop"] = 'image|max:3072'; // 3MB max
                    $file = $this->file_headerapk_desktop;
                    $orgName = $file->getClientOriginalName();
                    $message["file_headerapk_desktop.image"] = str_replace(":attribute","file $orgName", trans("validation.image"));
                    $message["file_headerapk_desktop.max"] = str_replace(":max", "3072", str_replace(":attribute","file $orgName", trans("validation.max.file")));
                }
            }
        }
        if ($this->toogle_headerapk_mobile) {
            $validate["file_headerapk_mobile"] = 'required';
            $validate["title_headerapk_mobile"] = 'required';
            $validate["slogan_headerapk_mobile"] = 'required';

            $message["file_headerapk_mobile.required"] = str_replace(":attribute", "title", trans("validation.required"));
            $message["title_headerapk_mobile.required"] = str_replace(":attribute", "slogan", trans("validation.required"));
            $message["slogan_headerapk_mobile.required"] = str_replace(":attribute", "image", trans("validation.required"));

            if ($this->file_headerapk_mobile) {
                if (gettype($this->file_headerapk_mobile) != "string") {
                    $validate["file_headerapk_mobile"] = 'image|max:3072'; // 3MB max
                    $file = $this->file_headerapk_mobile;
                    $orgName = $file->getClientOriginalName();
                    $message["file_headerapk_mobile.image"] = str_replace(":attribute","file $orgName", trans("validation.image"));
                    $message["file_headerapk_mobile.max"] = str_replace(":max", "3072", str_replace(":attribute","file $orgName", trans("validation.max.file")));
                }
            }
        }

        // untuk header corousel desktop dan mobile
        if ($this->toogle_headercorousel_desktop) {
            foreach ($this->file_headercorousel_desktop as $i => $file) {
                if (gettype($file) != "string") {
                    $validate["file_headercorousel_desktop.$i"] = 'image|max:20480';
                    $orgName = $file->getClientOriginalName();
                    $message["file_headercorousel_desktop.$i.image"] = str_replace(":attribute","file $orgName", trans("validation.image"));
                    $message["file_headercorousel_desktop.$i.max"] = str_replace(":max", "20480", str_replace(":attribute","file $orgName", trans("validation.max.file")));
                }
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

        // untuk promosi desktop dan mobile
        if ($this->toogle_promosi_desktop) {
            $validate["name_promosi_desktop"] = "required";
            $validate["link_promosi_desktop"] = "required|url";
            $validate["image_promosi_desktop"] = "required|image|max:20480";

            $message["name_promosi_desktop.required"] = str_replace(":attribute","name", trans("validation.required"));
            $message["link_promosi_desktop.required"] = str_replace(":attribute","link", trans("validation.required"));
            $message["link_promosi_desktop.url"] = str_replace(":attribute","link", trans("validation.url"));
            $message["image_promosi_desktop.required"] = str_replace(":attribute","image", trans("validation.required"));

            if ($this->image_promosi_desktop) {
                $file = $this->image_promosi_desktop;
                $orgName = $file->getClientOriginalName();
                $message["image_promosi_desktop.image"] = str_replace(":attribute","file $orgName", trans("validation.image"));
                $message["image_promosi_desktop.max"] = str_replace(":max", "20480", str_replace(":attribute","file $orgName", trans("validation.max.file")));
            }
        }

        if ($this->toogle_promosi_mobile) {
            $validate["name_promosi_mobile"] = "required";
            $validate["link_promosi_mobile"] = "required|url";
            $validate["image_promosi_mobile"] = "required|image|max:20480";

            $message["name_promosi_mobile.required"] = str_replace(":attribute","name", trans("validation.required"));
            $message["link_promosi_mobile.required"] = str_replace(":attribute","link", trans("validation.required"));
            $message["link_promosi_mobile.url"] = str_replace(":attribute","link", trans("validation.url"));
            $message["image_promosi_mobile.required"] = str_replace(":attribute","image", trans("validation.required"));

            if ($this->image_promosi_mobile) {
                $file = $this->image_promosi_mobile;
                $orgName = $file->getClientOriginalName();
                $message["image_promosi_mobile.image"] = str_replace(":attribute","file $orgName", trans("validation.image"));
                $message["image_promosi_mobile.max"] = str_replace(":max", "20480", str_replace(":attribute","file $orgName", trans("validation.max.file")));
            }
        }

        // untuk before footer desktop dan mobile
        if ($this->toogle_beforefooter_desktop) {
            $validate["title_beforePromosi_desktop"] = "required";
            $validate["deskripsi_beforeFooter_desktop"] = "required";

            $message["title_beforePromosi_desktop.required"] = str_replace(":attribute","name", trans("validation.required"));
            $message["deskripsi_beforeFooter_desktop.required"] = str_replace(":attribute","link", trans("validation.required"));
        }
        if ($this->toogle_beforefooter_mobile) {
            $validate["title_beforePromosi_mobile"] = "required";
            $validate["deskripsi_beforeFooter_mobile"] = "required";

            $message["title_beforePromosi_mobile.required"] = str_replace(":attribute","name", trans("validation.required"));
            $message["deskripsi_beforeFooter_mobile.required"] = str_replace(":attribute","link", trans("validation.required"));
        }

        // untuk footer protection desktop dan mobile
        if ($this->toogle_footerprotection_desktop) {
            $validate["name_footerProtection_desktop"] = "required";
            $validate["link_footerProtection_desktop"] = "required|url";
            $validate["image_footerProtection_desktop"] = "required|image|max:20480";

            $message["name_footerProtection_desktop.required"] = str_replace(":attribute","name", trans("validation.required"));
            $message["link_footerProtection_desktop.required"] = str_replace(":attribute","link", trans("validation.required"));
            $message["link_footerProtection_desktop.url"] = str_replace(":attribute","link", trans("validation.url"));
            $message["image_footerProtection_desktop.required"] = str_replace(":attribute","link", trans("validation.required"));

            if ($this->image_footerProtection_desktop) {
                $file = $this->image_footerProtection_desktop;
                $orgName = $file->getClientOriginalName();
                $message["image_footerProtection_desktop.image"] = str_replace(":attribute","file $orgName", trans("validation.image"));
                $message["image_footerProtection_desktop.max"] = str_replace(":max", "20480", str_replace(":attribute","file $orgName", trans("validation.max.file")));
            }
        }
        if ($this->toogle_footerprotection_mobile) {
            $validate["name_footerProtection_mobile"] = "required";
            $validate["link_footerProtection_mobile"] = "required|url";
            $validate["image_footerProtection_mobile"] = "required|image|max:20480";

            $message["name_footerProtection_mobile.required"] = str_replace(":attribute","name", trans("validation.required"));
            $message["link_footerProtection_mobile.required"] = str_replace(":attribute","link", trans("validation.required"));
            $message["link_footerProtection_mobile.url"] = str_replace(":attribute","link", trans("validation.url"));
            $message["image_footerProtection_mobile.required"] = str_replace(":attribute","link", trans("validation.required"));

            if ($this->image_footerProtection_mobile) {
                $file = $this->image_footerProtection_mobile;
                $orgName = $file->getClientOriginalName();
                $message["image_footerProtection_mobile.image"] = str_replace(":attribute","file $orgName", trans("validation.image"));
                $message["image_footerProtection_mobile.max"] = str_replace(":max", "20480", str_replace(":attribute","file $orgName", trans("validation.max.file")));
            }
        }

        // untuk footer protection desktop dan mobile
        if ($this->toogle_linkAlternatif_desktop) {
            $validate["listLink_linkAlternatif_desktop"] = "required";
            $validate["image_linkAlternatif_desktop"] = "required|image|max:20480";

            $message["listLink_linkAlternatif_desktop.required"] = str_replace(":attribute","list link", trans("validation.required"));
            $message["image_linkAlternatif_desktop.required"] = str_replace(":attribute","image", trans("validation.required"));

            if ($this->image_linkAlternatif_desktop) {
                $file = $this->image_linkAlternatif_desktop;
                $orgName = $file->getClientOriginalName();
                $message["image_linkAlternatif_desktop.image"] = str_replace(":attribute","file $orgName", trans("validation.image"));
                $message["image_linkAlternatif_desktop.max"] = str_replace(":max", "20480", str_replace(":attribute","file $orgName", trans("validation.max.file")));
            }
        }
        if ($this->toogle_linkAlternatif_mobile) {
            $validate["listLink_linkAlternatif_mobile"] = "required";
            $validate["image_linkAlternatif_mobile"] = "required|image|max:20480";

            $message["listLink_linkAlternatif_mobile.required"] = str_replace(":attribute","list link", trans("validation.required"));
            $message["image_linkAlternatif_mobile.required"] = str_replace(":attribute","image", trans("validation.required"));

            if ($this->image_linkAlternatif_mobile) {
                $file = $this->image_linkAlternatif_mobile;
                $orgName = $file->getClientOriginalName();
                $message["image_linkAlternatif_mobile.image"] = str_replace(":attribute","file $orgName", trans("validation.image"));
                $message["image_linkAlternatif_mobile.max"] = str_replace(":max", "20480", str_replace(":attribute","file $orgName", trans("validation.max.file")));
            }
        }

        // untuk barcode qris desktop dan mobile
        if ($this->toogle_barcodeqris_desktop) {
            $validate["name_barcodeqris_desktop"] = "required";
            $validate["image_barcodeqris_desktop"] = "required|image|max:20480";

            $message["name_barcodeqris_desktop.required"] = str_replace(":attribute","list link", trans("validation.required"));
            $message["image_barcodeqris_desktop.required"] = str_replace(":attribute","image", trans("validation.required"));

            if ($this->image_barcodeqris_desktop) {
                $file = $this->image_barcodeqris_desktop;
                $orgName = $file->getClientOriginalName();
                $message["image_barcodeqris_desktop.image"] = str_replace(":attribute","file $orgName", trans("validation.image"));
                $message["image_barcodeqris_desktop.max"] = str_replace(":max", "20480", str_replace(":attribute","file $orgName", trans("validation.max.file")));
            }
        }

        if ($this->toogle_barcodeqris_mobile) {
            $validate["name_barcodeqris_mobile"] = "required";
            $validate["image_barcodeqris_mobile"] = "required|image|max:20480";

            $message["name_barcodeqris_mobile.required"] = str_replace(":attribute","list link", trans("validation.required"));
            $message["image_barcodeqris_mobile.required"] = str_replace(":attribute","image", trans("validation.required"));

            if ($this->image_barcodeqris_mobile) {
                $file = $this->image_barcodeqris_mobile;
                $orgName = $file->getClientOriginalName();
                $message["image_barcodeqris_mobile.image"] = str_replace(":attribute","file $orgName", trans("validation.image"));
                $message["image_barcodeqris_mobile.max"] = str_replace(":max", "20480", str_replace(":attribute","file $orgName", trans("validation.max.file")));
            }
        }

        // untuk sort list bank dektop dan mobile
        if ($this->toogle_sortlistbank_desktop) {
            $validate["list_sortlistbank_desktop"] = "required";
            $message["list_sortlistbank_desktop.required"] = str_replace(":attribute","list bank", trans("validation.required"));
        }

        if ($this->toogle_sortlistbank_mobile) {
            $validate["list_sortlistbank_mobile"] = "required";
            $message["list_sortlistbank_mobile.required"] = str_replace(":attribute","list bank", trans("validation.required"));
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
            }else if ($desktop && !$situs->status_desktop) {
                $this->prevActive = 'desktop';
                $this->urlActive = '/underconstruction';
            }

            if(!$desktop && $situs->status_mobile) {
                $this->prevActive = 'mobile';
                $this->urlActive = $situs["url_mobile_$stat"];
            }else if (!$desktop && !$situs->status_mobile) {
                $this->prevActive = 'mobile';
                $this->urlActive = '/underconstruction';
            }
        }
    }

    public function setValue()
    {
        $dataFiturDesktop = $this->dataFiturDesktop;
        $dataFiturMobile = $this->dataFiturMobile;
        if (count($dataFiturDesktop) > 0) {
            foreach ($dataFiturDesktop as $item) {
                if ($item->id_fitur == 1) {
                    $this->toogle_popupmodal_desktop = $item->status;
                    $data = json_decode($item->data, true);
                    if ($data) {
                        $this->file_popupmodal_desktop = $data["file"];
                        $this->deskripsi_popupmodal_desktop = $data["deskripsi"];
                    }
                }

                if ($item->id_fitur == 2) {
                    $this->toogle_headerapk_desktop = $item->status;
                    $data = json_decode($item->data, true);
                    if ($data) {
                        $this->file_headerapk_desktop = $data["file"];
                        $this->title_headerapk_desktop = $data["title"];
                        $this->slogan_headerapk_desktop = $data["slogan"];
                    }
                }
            }
        }

        if (count($dataFiturMobile) > 0) {
            foreach ($dataFiturMobile as $item) {
                if ($item->id_fitur == 1) {
                    $this->toogle_popupmodal_mobile = $item->status;
                    $data = json_decode($item->data, true);
                    if ($data) {
                        $this->file_popupmodal_mobile = $data["file"];
                        $this->deskripsi_popupmodal_mobile = $data["deskripsi"];
                    }
                }

                if ($item->id_fitur == 2) {
                    $this->toogle_headerapk_mobile = $item->status;
                    $data = json_decode($item->data, true);
                    if ($data) {
                        $this->file_headerapk_mobile = $data["file"];
                        $this->title_headerapk_mobile = $data["title"];
                        $this->slogan_headerapk_mobile = $data["slogan"];
                    }
                }
            }
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

    public function saveData()
    {
        $validate = $this->validationFiled();
        if(count($validate['validate']) > 0) $this->validate($validate['validate'], $validate['message'], $validate['attribute']);

        // ini untuk desktop
        foreach ($this->dataFiturDesktop as $val) {
            $dir = "public/images/".strtolower($this->dataSitus->name);
            if ($val->id_fitur == 1) {
                $dir = $dir."/popup modal";
                $img = $this->file_popupmodal_desktop;
                if (gettype($img) != "string") {
                    $ext = $img->getClientOriginalExtension();
                    $name = now()->format('Ymd-His');
                    $img = $this->file_popupmodal_desktop->storePubliclyAs($dir, "$name.$ext");
                    $img = url(Storage::url($img));
                }
                $data = collect([
                    "file" => $img,
                    "deskripsi" => $this->deskripsi_popupmodal_desktop,
                ])->toJson();
                fiturSitus::find($val->id)->update([
                    "status" => $this->toogle_popupmodal_desktop,
                    "data" => $data
                ]);
            }

            if ($val->id_fitur == 2) {
                $dir = $dir."/header apk";
                $img = $this->file_headerapk_desktop;
                if (gettype($img) != "string") {
                    $ext = $img->getClientOriginalExtension();
                    $name = now()->format('Ymd-His');
                    $img = $this->file_headerapk_desktop->storePubliclyAs($dir, "$name.$ext");
                    $img = url(Storage::url($img));
                }
                $data = collect([
                    "file" => $img,
                    "title" => $this->title_headerapk_desktop,
                    "slogan" => $this->slogan_headerapk_desktop,
                ])->toJson();
                fiturSitus::find($val->id)->update([
                    "status" => $this->toogle_headerapk_desktop,
                    "data" => $data
                ]);
            }
        }

        // ini untuk mobile
        foreach ($this->dataFiturMobile as $val) {
            $dir = "public/images/".strtolower($this->dataSitus->name);
            if ($val->id_fitur == 1) {
                $dir = $dir."/popup modal";
                $img = $this->file_popupmodal_mobile;
                if (gettype($img) != "string") {
                    $ext = $img->getClientOriginalExtension();
                    $name = now()->format('Ymd-His');
                    $img = $this->file_popupmodal_mobile->storePubliclyAs($dir, "$name.$ext");
                    $img = url(Storage::url($img));
                }
                $data = collect([
                    "file" => $img,
                    "deskripsi" => $this->deskripsi_popupmodal_mobile,
                ])->toJson();
                fiturSitus::find($val->id)->update([
                    "status" => $this->toogle_popupmodal_mobile,
                    "data" => $data
                ]);
            }

            if ($val->id_fitur == 2) {
                $dir = $dir."/header apk";
                $img = $this->file_headerapk_mobile;
                if (gettype($img) != "string") {
                    $ext = $img->getClientOriginalExtension();
                    $name = now()->format('Ymd-His');
                    $img = $this->file_headerapk_mobile->storePubliclyAs($dir, "$name.$ext");
                    $img = url(Storage::url($img));
                }
                $data = collect([
                    "file" => $img,
                    "title" => $this->title_headerapk_mobile,
                    "slogan" => $this->slogan_headerapk_mobile,
                ])->toJson();
                fiturSitus::find($val->id)->update([
                    "status" => $this->toogle_headerapk_mobile,
                    "data" => $data
                ]);
            }
        }
        // dataFiturDesktop
        // dataFiturMobile
        // toogle_popupmodal_desktop
        // toogle_headerapk_desktop
        // toogle_headercorousel_desktop
        // toogle_buttonaction_desktop
        // toogle_iconsosmed_desktop
        // toogle_promosi_desktop
        // toogle_beforefooter_desktop
        // toogle_footerprotection_desktop
        // toogle_linkAlternatif_desktop
        // toogle_barcodeqris_desktop
        // toogle_sortlistbank_desktop
        // toogle_popupmodal_mobile
        // toogle_headerapk_mobile
        // toogle_headercorousel_mobile
        // toogle_buttonaction_mobile
        // toogle_iconsosmed_mobile
        // toogle_promosi_mobile
        // toogle_beforefooter_mobile
        // toogle_footerprotection_mobile
        // toogle_linkAlternatif_mobile
        // toogle_barcodeqris_mobile
        // toogle_sortlistbank_mobile
    }
}
