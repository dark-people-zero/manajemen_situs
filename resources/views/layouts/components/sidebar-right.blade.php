<!-- Sidebar-right-->
<div class="sidebar sidebar-right sidebar-animate" wire:ignore.self data-sidebar-notclose=".clr-picker, #previewIMageModal, .removePreviewImage, .modal">
    <div class="panel panel-primary card mb-0 box-shadow">
        <div class="tab-menu-heading card-img-top-1 border-0 p-3">
            <div class="card-title mb-0">Pengaturan</div>
            <div class="card-options ms-auto">
                <a href="javascript:void(0);" class="sidebar-remove"><i class="fe fe-x"></i></a>
            </div>
        </div>
        <div class="panel-body tabs-menu-body latest-tasks p-0 border-0">
            <div class="swichermainleft text-center">
                <h4 class="con-tittle">Situs</h4>
                <div class="skin-body border-bottom" style="padding-bottom: 10px" wire:ignore>
                    <select class="form-control select2-situs" id="selectSitus">
                        <option></option>
                        @foreach ($Aksessitus as $item)
                            <option value="{{$item->id_situs}}">{{$item->situs->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @if ($statPengaturan)
                <div id="areaPengaturan">
                    <div class="tabs-menu">
                        <!-- Tabs -->
                        <ul class="nav panel-tabs justify-content-between">
                            <li style="width: 49%">
                                <a href="#desktop" class="{{$prevActive == 'desktop' ? 'active' : ''}} w-100 text-center" data-bs-toggle="tab" wire:click="changePrev(true)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pc-display-horizontal side-menu__icon" viewBox="0 0 16 16">
                                        <path d="M1.5 0A1.5 1.5 0 0 0 0 1.5v7A1.5 1.5 0 0 0 1.5 10H6v1H1a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1h-5v-1h4.5A1.5 1.5 0 0 0 16 8.5v-7A1.5 1.5 0 0 0 14.5 0h-13Zm0 1h13a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-7a.5.5 0 0 1 .5-.5ZM12 12.5a.5.5 0 1 1 1 0 .5.5 0 0 1-1 0Zm2 0a.5.5 0 1 1 1 0 .5.5 0 0 1-1 0ZM1.5 12h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1ZM1 14.25a.25.25 0 0 1 .25-.25h5.5a.25.25 0 1 1 0 .5h-5.5a.25.25 0 0 1-.25-.25Z"/>
                                    </svg>
                                    Desktop
                                </a>
                            </li>
                            <li style="width: 49%">
                                <a href="#mobile" data-bs-toggle="tab" class="{{$prevActive == 'mobile' ? 'active' : ''}} w-100 text-center" wire:click="changePrev(false)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-phone side-menu__icon" viewBox="0 0 16 16">
                                        <path d="M11 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h6zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H5z"/>
                                        <path d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                                    </svg>
                                    Mobile
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane {{$prevActive == 'desktop' ? 'active' : ''}} " id="desktop">
                            @if (count($data_desktop) > 0)
                                <form id="formDesktop" enctype="multipart/form-data" wire:submit.prevent="saveContact">
                                    {{-- untuk popup modal --}}
                                    <div class="swichermainleft text-center">
                                        <h4 class="d-flex justify-content-between" wire:ignore>
                                            Popup Modal
                                            <label class="custom-switch form-switch mb-0  p-0 cursor-pointer" data-bs-toggle="collapse" href="#coll-popupmodal" role="button" aria-expanded="false" aria-controls="coll-popupmodal">
                                                <input type="checkbox" class="custom-switch-input" data-type="desktop" data-target="popupmodal" onchange="changeCheckbox(this)" {{$toogle_popupmodal_desktop ? 'checked' : ''}}>
                                                <span class="custom-switch-indicator custom-switch-indicator"></span>
                                            </label>
                                        </h4>
                                        <div class="skin-body collapse {{$toogle_popupmodal_desktop ? 'show' : ''}}" id="coll-popupmodal">
                                            <div class="switch_section">
                                                {{-- untuk file popup modal --}}
                                                <div>
                                                    <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress">
                                                        <div class="main-form-group mt-2">
                                                            <label class="form-label mt-0 text-start">Image</label>
                                                            <input class="form-control" type="file" accept="image/*" wire:model="file_popupmodal_desktop">
                                                        </div>
                                                        <div class="progress mg-b-10" x-show="isUploading">
                                                            <div class="progress-bar ht-2" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" x-bind:style="`width:${progress}%`"></div>
                                                        </div>
                                                    </div>
                                                    @error('file_popupmodal_desktop')
                                                        <span class="invalid-feedback d-block text-start" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    @if ($file_popupmodal_desktop && !$errors->has('file_popupmodal_desktop'))
                                                        <div class="mt-2 previewImg">
                                                            <img src="{{ $file_popupmodal_desktop->temporaryUrl() }}">
                                                            <div class="removePreviewImage" wire:click="removeImage('file_popupmodal_desktop')" onclick="$(this).closest('.switch_section').find('input').val('')">
                                                                <i class="fe fe-x"></i>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>

                                                {{-- untuk deskripsi popup modal --}}
                                                <div>
                                                    <div class="main-form-group mt-2">
                                                        <label class="form-label mt-0 text-start">Deskripsi</label>
                                                        <input class="form-control" placeholder="Masukan Deskripsi" type="text" wire:model="deskripsi_popupmodal_desktop">
                                                    </div>
                                                    @error('deskripsi_popupmodal_desktop')
                                                        <span class="invalid-feedback d-block text-start" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- untuk header apk --}}
                                    <div class="swichermainleft text-center">
                                        <h4 class="d-flex justify-content-between" wire:ignore>
                                            header apk
                                            <label class="custom-switch form-switch mb-0  p-0 cursor-pointer" data-bs-toggle="collapse" href="#coll-headerapk" role="button" aria-expanded="false" aria-controls="coll-headerapk">
                                                <input type="checkbox" class="custom-switch-input" data-type="desktop" data-target="headerapk" onchange="changeCheckbox(this)" {{$toogle_headerapk_desktop ? 'checked' : ''}}>
                                                <span class="custom-switch-indicator custom-switch-indicator"></span>
                                            </label>
                                        </h4>
                                        <div class="skin-body collapse {{$toogle_headerapk_desktop ? 'show' : ''}}" id="coll-headerapk">
                                            <div class="switch_section">
                                                {{-- untuk file header APK --}}
                                                <div>
                                                    <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress">
                                                        <div class="main-form-group mt-2">
                                                            <label class="form-label mt-0 text-start">Logo</label>
                                                            <input class="form-control" type="file" accept="image/*" wire:model="file_headerapk_desktop">
                                                        </div>
                                                        <div class="progress mg-b-10" x-show="isUploading">
                                                            <div class="progress-bar ht-2" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" x-bind:style="`width:${progress}%`"></div>
                                                        </div>
                                                    </div>
                                                    @error('file_headerapk_desktop')
                                                        <span class="invalid-feedback d-block text-start" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    @if ($file_headerapk_desktop && !$errors->has('file_headerapk_desktop'))
                                                        <div class="mt-2 previewImg">
                                                            <img src="{{ $file_headerapk_desktop->temporaryUrl() }}">
                                                            <div class="removePreviewImage" wire:click="removeImage('file_headerapk_desktop')" onclick="$(this).closest('.switch_section').find('input').val('')">
                                                                <i class="fe fe-x"></i>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>

                                                {{-- untuk title header apk --}}
                                                <div>
                                                    <div class="main-form-group mt-2">
                                                        <label class="form-label mt-0 text-start">Title</label>
                                                        <input class="form-control" placeholder="Masukan Title" type="text" wire:model="title_headerapk_desktop">
                                                    </div>
                                                    @error('title_headerapk_desktop')
                                                        <span class="invalid-feedback d-block text-start" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                {{-- untuk slogan header apk --}}
                                                <div>
                                                    <div class="main-form-group mt-2">
                                                        <label class="form-label mt-0 text-start">Slogan</label>
                                                        <textarea class="form-control" onchange="this.style.height = this.scrollHeight + 'px';" placeholder="Masukan Slogan" wire:model="slogan_headerapk_desktop"></textarea>
                                                    </div>
                                                    @error('slogan_headerapk_desktop')
                                                        <span class="invalid-feedback d-block text-start" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- untuk Header Corousel --}}
                                    <div class="swichermainleft text-center">
                                        <h4 class="d-flex justify-content-between" wire:ignore>
                                            Header Corousel
                                            <label class="custom-switch form-switch mb-0  p-0 cursor-pointer" data-bs-toggle="collapse" href="#coll-headercorousel" role="button" aria-expanded="false" aria-controls="coll-headercorousel">
                                                <input type="checkbox" class="custom-switch-input" data-type="desktop" data-target="headercorousel" onchange="changeCheckbox(this)" {{$toogle_headercorousel_desktop ? 'checked' : ''}}>
                                                <span class="custom-switch-indicator custom-switch-indicator"></span>
                                            </label>
                                        </h4>
                                        <div class="skin-body collapse {{$toogle_headercorousel_desktop ? 'show' : ''}}" id="coll-headercorousel">
                                            <div class="switch_section">
                                                {{-- untuk file header corousel --}}
                                                <div>
                                                    <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress">
                                                        <div class="main-form-group mt-2">
                                                            <label class="form-label mt-0 text-start">Image</label>
                                                            <input class="form-control" type="file" accept="image/*" wire:model="file_temp_headercorousel_desktop" multiple>
                                                        </div>
                                                        <div class="progress mg-b-10" x-show="isUploading">
                                                            <div class="progress-bar ht-2" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" x-bind:style="`width:${progress}%`"></div>
                                                        </div>
                                                    </div>
                                                    @error('file_headercorousel_desktop.*')
                                                        @foreach ($errors->get("file_headercorousel_desktop.*") as $msg)
                                                            @foreach ($msg as $item)
                                                                <span class="invalid-feedback d-block text-start" role="alert">
                                                                    <strong>{{ $item }}</strong>
                                                                </span>
                                                            @endforeach
                                                        @endforeach
                                                    @enderror
                                                    @if (count($file_headercorousel_desktop) > 0)
                                                        <div class="multiple-preview" data-count="{{count($file_headercorousel_desktop) > 4 ? '*' : count($file_headercorousel_desktop)}}">
                                                            @php $n = 0; @endphp
                                                            @foreach ($file_headercorousel_desktop as $i => $file)
                                                                @if ($n <= 3)
                                                                    <div class="mt-2 previewImg">
                                                                        <img src="{{ $file->temporaryUrl() }}">
                                                                        <div class="removePreviewImage" wire:click="removeImage('file_headercorousel_desktop', '{{$i}}')" onclick="$(this).closest('.switch_section').find('input').val('')">
                                                                            <i class="fe fe-x"></i>
                                                                        </div>
                                                                    </div>
                                                                    @php $n = $n+1; @endphp
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                        @if (count($file_headercorousel_desktop) > 4)
                                                            <div class="btn btn-primary mt-2 btn-sm" wire:click="showModalMore('file_headercorousel_desktop')">Show {{count($file_headercorousel_desktop) - 4}} more...</div>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- untuk Button Action --}}
                                    <div class="swichermainleft text-center">
                                        <h4 class="d-flex justify-content-between" wire:ignore>
                                            Button Action
                                            <label class="custom-switch form-switch mb-0  p-0 cursor-pointer" data-bs-toggle="collapse" href="#coll-buttonaction" role="button" aria-expanded="false" aria-controls="coll-buttonaction">
                                                <input type="checkbox" class="custom-switch-input" data-type="desktop" data-target="buttonaction" onchange="changeCheckbox(this)" {{$toogle_buttonaction_desktop ? 'checked' : ''}}>
                                                <span class="custom-switch-indicator custom-switch-indicator"></span>
                                            </label>
                                        </h4>
                                        <div class="skin-body collapse p-0 {{$toogle_buttonaction_desktop ? 'show' : ''}}" id="coll-buttonaction">
                                            <div class="switch_section">
                                                @if (count($data_buttonaction_desktop) > 0)
                                                    <span class="text-center-w-100">
                                                        Ada {{count($data_buttonaction_desktop)}} data. Klik <i class="fa fa-eye cursor-pointer" wire:click="showFormBtnAction(true)"></i> untuk melihat data.
                                                    </span>
                                                    <div class="mt-2">
                                                        @foreach ($data_buttonaction_desktop as $item)
                                                            @if ($item['status'])
                                                                <div href="{{$item['link']}}" target="{{$item['target'] ? '_blank' : ''}}" class="btn w-100 btn-sm {{$item['class']}} btn-sample mt-2" style="{{$item['shadow'] ? 'box-shadow: inset 0 -4px 0 '.$item['shadow'].';' : ''}}{{$item['style']}}" onclick="sampleButton(this)">{{$item['name'] == '' ? 'Sample' : $item['name']}}</div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <span class="text-center-w-100">
                                                        Belum ada data. silahkan klik <i class="fa fa-plus cursor-pointer" wire:click="showFormBtnAction(true)"></i> untuk menambahkan.
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    {{-- untuk Icon Sosmed --}}
                                    <div class="swichermainleft text-center">
                                        <h4 class="d-flex justify-content-between" wire:ignore>
                                            Icon Sosmed
                                            <label class="custom-switch form-switch mb-0  p-0 cursor-pointer" data-bs-toggle="collapse" href="#coll-iconsosmed" role="button" aria-expanded="false" aria-controls="coll-iconsosmed">
                                                <input type="checkbox" class="custom-switch-input" data-type="desktop" data-target="iconsosmed" onchange="changeCheckbox(this)" {{$toogle_iconsosmed_desktop ? 'checked' : ''}}>
                                                <span class="custom-switch-indicator custom-switch-indicator"></span>
                                            </label>
                                        </h4>
                                        <div class="skin-body collapse {{$toogle_iconsosmed_desktop ? 'show' : ''}}" id="coll-iconsosmed">
                                            <div class="switch_section">
                                                <span class="text-center-w-100">
                                                    @if (count($data_iconsosmed_desktop) > 0)
                                                        Ada {{count($data_iconsosmed_desktop)}} data. Klik <i class="fa fa-eye cursor-pointer" wire:click="showFormSosmed(true)"></i> untuk melihat data.
                                                    @else
                                                        Belum ada data. silahkan klik <i class="fa fa-plus cursor-pointer" wire:click="showFormSosmed(true)"></i> untuk menambahkan.
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- untuk Promosi --}}
                                    <div class="swichermainleft text-center">
                                        <h4 class="d-flex justify-content-between" wire:ignore>
                                            Promosi
                                            <label class="custom-switch form-switch mb-0  p-0 cursor-pointer" data-bs-toggle="collapse" href="#coll-promosi" role="button" aria-expanded="false" aria-controls="coll-promosi">
                                                <input type="checkbox" class="custom-switch-input" data-type="desktop" data-target="promosi" onchange="changeCheckbox(this)" {{$toogle_promosi_desktop ? 'checked' : ''}}>
                                                <span class="custom-switch-indicator custom-switch-indicator"></span>
                                            </label>
                                        </h4>
                                        <div class="skin-body collapse {{$toogle_promosi_desktop ? 'show' : ''}}" id="coll-promosi">
                                            <div class="switch_section">
                                                untuk promosi
                                            </div>
                                        </div>
                                    </div>

                                    {{-- untuk Before Footer --}}
                                    <div class="swichermainleft text-center">
                                        <h4 class="d-flex justify-content-between" wire:ignore>
                                            before footer
                                            <label class="custom-switch form-switch mb-0  p-0 cursor-pointer" data-bs-toggle="collapse" href="#coll-beforefooter" role="button" aria-expanded="false" aria-controls="coll-beforefooter">
                                                <input type="checkbox" class="custom-switch-input" data-type="desktop" data-target="beforefooter" onchange="changeCheckbox(this)" {{$toogle_beforefooter_desktop ? 'checked' : ''}}>
                                                <span class="custom-switch-indicator custom-switch-indicator"></span>
                                            </label>
                                        </h4>
                                        <div class="skin-body collapse {{$toogle_beforefooter_desktop ? 'show' : ''}}" id="coll-beforefooter">
                                            <div class="switch_section">
                                                untuk beforefooter
                                            </div>
                                        </div>
                                    </div>

                                    {{-- untuk Footer Protection --}}
                                    <div class="swichermainleft text-center">
                                        <h4 class="d-flex justify-content-between" wire:ignore>
                                            footer protection
                                            <label class="custom-switch form-switch mb-0  p-0 cursor-pointer" data-bs-toggle="collapse" href="#coll-footerprotection" role="button" aria-expanded="false" aria-controls="coll-footerprotection">
                                                <input type="checkbox" class="custom-switch-input" data-type="desktop" data-target="footerprotection" onchange="changeCheckbox(this)" {{$toogle_footerprotection_desktop ? 'checked' : ''}}>
                                                <span class="custom-switch-indicator custom-switch-indicator"></span>
                                            </label>
                                        </h4>
                                        <div class="skin-body collapse {{$toogle_footerprotection_desktop ? 'show' : ''}}" id="coll-footerprotection">
                                            <div class="switch_section">
                                                untuk footerprotection
                                            </div>
                                        </div>
                                    </div>

                                    {{-- untuk Link Alternatif --}}
                                    <div class="swichermainleft text-center">
                                        <h4 class="d-flex justify-content-between" wire:ignore>
                                            Link Alternatif
                                            <label class="custom-switch form-switch mb-0  p-0 cursor-pointer" data-bs-toggle="collapse" href="#coll-linkAlternatif" role="button" aria-expanded="false" aria-controls="coll-linkAlternatif">
                                                <input type="checkbox" class="custom-switch-input" data-type="desktop" data-target="linkAlternatif" onchange="changeCheckbox(this)" {{$toogle_linkAlternatif_desktop ? 'checked' : ''}}>
                                                <span class="custom-switch-indicator custom-switch-indicator"></span>
                                            </label>
                                        </h4>
                                        <div class="skin-body collapse {{$toogle_linkAlternatif_desktop ? 'show' : ''}}" id="coll-linkAlternatif">
                                            <div class="switch_section">
                                                untuk linkAlternatif
                                            </div>
                                        </div>
                                    </div>

                                    {{-- untuk Barcode QRIS --}}
                                    <div class="swichermainleft text-center">
                                        <h4 class="d-flex justify-content-between" wire:ignore>
                                            Barcode QRIS
                                            <label class="custom-switch form-switch mb-0  p-0 cursor-pointer" data-bs-toggle="collapse" href="#coll-barcodeqris" role="button" aria-expanded="false" aria-controls="coll-barcodeqris">
                                                <input type="checkbox" class="custom-switch-input" data-type="desktop" data-target="barcodeqris" onchange="changeCheckbox(this)" {{$toogle_barcodeqris_desktop ? 'checked' : ''}}>
                                                <span class="custom-switch-indicator custom-switch-indicator"></span>
                                            </label>
                                        </h4>
                                        <div class="skin-body collapse {{$toogle_barcodeqris_desktop ? 'show' : ''}}" id="coll-barcodeqris">
                                            <div class="switch_section">
                                                untuk barcodeqris
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <div class="swichermainleft text-center" id="promosiArea">
                                        <h4 class="d-flex justify-content-between" >
                                            PROMOSI
                                            <label class="custom-switch form-switch mb-0  p-0 cursor-pointer" data-bs-toggle="collapse" href="#coll-promosi" role="button" aria-expanded="false" aria-controls="coll-promosi">
                                                <input type="checkbox" class="custom-switch-input" wire:model="d_p_status">
                                                <span class="custom-switch-indicator custom-switch-indicator"></span>
                                            </label>
                                        </h4>
                                        <div class="skin-body collapse" id="coll-promosi">
                                            <div class="switch_section">
                                                <div class="main-form-group">
                                                    <label class="form-label mt-0 text-start">Nama</label>
                                                    <input class="form-control" placeholder="Masukan Nama Promosi" type="text" wire:model="d_p_nama">
                                                </div>
                                                <div class="main-form-group mt-2">
                                                    <label class="form-label mt-0 text-start">URL</label>
                                                    <input class="form-control" placeholder="Masukan URL Promosi" type="text" wire:model="d_p_url">
                                                </div>
                                                <div class="main-form-group mt-2">
                                                    <label class="form-label mt-0 text-start">Image</label>
                                                    <input class="form-control" type="file" wire:model="d_p_img">
                                                </div>
                                                <div id="previewImagePromosi" class="mt-2 d-none">
                                                    <img src="#" style="max-height: 200px;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swichermainleft text-center" id="linkAlterArea">
                                        <h4 class="d-flex justify-content-between">
                                            LINK ALTERNATIF
                                            <label class="custom-switch form-switch mb-0  p-0 cursor-pointer" data-bs-toggle="collapse" href="#coll-link-alter" role="button" aria-expanded="false" aria-controls="desktop">
                                                <input type="checkbox" name="linkAlter" class="custom-switch-input">
                                                <span class="custom-switch-indicator custom-switch-indicator"></span>
                                            </label>
                                        </h4>
                                        <div class="skin-body collapse" id="coll-link-alter">
                                            <div class="switch_section">
                                                <div class="main-form-group mt-2">
                                                    <label class="form-label mt-0 text-start">Image</label>
                                                    <input class="form-control" type="file" name="imageAlter">
                                                </div>
                                                <div id="previewImageLinkAlter" class="mt-2 d-none">
                                                    <img src="#" style="max-height: 200px;">
                                                </div>

                                                <div class="main-form-group mt-2">
                                                    <label class="form-label mt-0 text-start">URL</label>
                                                    <textarea class="form-control" onchange="this.style.height = this.scrollHeight + 'px';" placeholder="Masukan URL Promosi" name="urlAlter"></textarea>
                                                </div>
                                                <div class="text-start">
                                                    <small class="text-warning fw-bold">Info: untuk memisahkan link silahkan beri tanda '|' tanpa tanda kutip.</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}

                                    <div class="w-100 px-2 mb-3">
                                        <button type="submit" class="btn btn-primary-light w-100 mt-2">Simpan</button>
                                    </div>
                                </form>
                            @else
                                <div class="w-100 text-center mt-3">
                                    The feature is not available on the site in desktop mode, please try it on mobile mode.
                                </div>
                            @endif
                        </div>
                        <div class="tab-pane {{$prevActive == 'mobile' ? 'active' : ''}}" id="mobile">
                            @if (count($data_mobile) > 0)
                                <form id="formDesktop" enctype="multipart/form-data" wire:submit.prevent="saveContact">

                                    {{-- untuk popup modal --}}
                                    <div class="swichermainleft text-center">
                                        <h4 class="d-flex justify-content-between" wire:ignore>
                                            Popup Modal
                                            <label class="custom-switch form-switch mb-0  p-0 cursor-pointer" data-bs-toggle="collapse" href="#coll-popupmodal-mobile" role="button" aria-expanded="false" aria-controls="coll-popupmodal-mobile">
                                                <input type="checkbox" class="custom-switch-input" data-type="mobile" data-target="popupmodal" onchange="changeCheckbox(this)" {{$toogle_popupmodal_mobile ? 'checked' : ''}}>
                                                <span class="custom-switch-indicator custom-switch-indicator"></span>
                                            </label>
                                        </h4>
                                        <div class="skin-body collapse {{$toogle_popupmodal_mobile ? 'show' : ''}}" id="coll-popupmodal-mobile">
                                            <div class="switch_section">
                                                {{-- untuk file popup modal --}}
                                                <div>
                                                    <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress">
                                                        <div class="main-form-group mt-2">
                                                            <label class="form-label mt-0 text-start">Image</label>
                                                            <input class="form-control" type="file" accept="image/*" wire:model="file_popupmodal_mobile">
                                                        </div>
                                                        <div class="progress mg-b-10" x-show="isUploading">
                                                            <div class="progress-bar ht-2" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" x-bind:style="`width:${progress}%`"></div>
                                                        </div>
                                                    </div>
                                                    @error('file_popupmodal_mobile')
                                                        <span class="invalid-feedback d-block text-start" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    @if ($file_popupmodal_mobile && !$errors->has('file_popupmodal_mobile'))
                                                        <div class="mt-2 previewImg">
                                                            <img src="{{ $file_popupmodal_mobile->temporaryUrl() }}">
                                                            <div class="removePreviewImage" wire:click="removeImage('file_popupmodal_mobile')" onclick="$(this).closest('.switch_section').find('input').val('')">
                                                                <i class="fe fe-x"></i>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>

                                                {{-- untuk deskripsi popup modal --}}
                                                <div>
                                                    <div class="main-form-group mt-2">
                                                        <label class="form-label mt-0 text-start">Deskripsi</label>
                                                        <input class="form-control" placeholder="Masukan Deskripsi" type="text" wire:model="deskripsi_popupmodal_mobile">
                                                    </div>
                                                    @error('deskripsi_popupmodal_mobile')
                                                        <span class="invalid-feedback d-block text-start" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- untuk header apk --}}
                                    <div class="swichermainleft text-center">
                                        <h4 class="d-flex justify-content-between" wire:ignore>
                                            header apk
                                            <label class="custom-switch form-switch mb-0  p-0 cursor-pointer" data-bs-toggle="collapse" href="#coll-headerapk-mobile" role="button" aria-expanded="false" aria-controls="coll-headerapk-mobile">
                                                <input type="checkbox" class="custom-switch-input" data-type="mobile" data-target="headerapk" onchange="changeCheckbox(this)" {{$toogle_headerapk_mobile ? 'checked' : ''}}>
                                                <span class="custom-switch-indicator custom-switch-indicator"></span>
                                            </label>
                                        </h4>
                                        <div class="skin-body collapse {{$toogle_headerapk_mobile ? 'show' : ''}}" id="coll-headerapk-mobile">
                                            <div class="switch_section">
                                                {{-- untuk file header APK --}}
                                                <div>
                                                    <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress">
                                                        <div class="main-form-group mt-2">
                                                            <label class="form-label mt-0 text-start">Logo</label>
                                                            <input class="form-control" type="file" accept="image/*" wire:model="file_headerapk_mobile">
                                                        </div>
                                                        <div class="progress mg-b-10" x-show="isUploading">
                                                            <div class="progress-bar ht-2" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" x-bind:style="`width:${progress}%`"></div>
                                                        </div>
                                                    </div>
                                                    @error('file_headerapk_mobile')
                                                        <span class="invalid-feedback d-block text-start" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    @if ($file_headerapk_mobile && !$errors->has('file_headerapk_mobile'))
                                                        <div class="mt-2 previewImg">
                                                            <img src="{{ $file_headerapk_mobile->temporaryUrl() }}">
                                                            <div class="removePreviewImage" wire:click="removeImage('file_headerapk_mobile')" onclick="$(this).closest('.switch_section').find('input').val('')">
                                                                <i class="fe fe-x"></i>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>

                                                {{-- untuk title header apk --}}
                                                <div>
                                                    <div class="main-form-group mt-2">
                                                        <label class="form-label mt-0 text-start">Title</label>
                                                        <input class="form-control" placeholder="Masukan Title" type="text" wire:model="title_headerapk_mobile">
                                                    </div>
                                                    @error('title_headerapk_mobile')
                                                        <span class="invalid-feedback d-block text-start" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                {{-- untuk slogan header apk --}}
                                                <div>
                                                    <div class="main-form-group mt-2">
                                                        <label class="form-label mt-0 text-start">Slogan</label>
                                                        <textarea class="form-control" onchange="this.style.height = this.scrollHeight + 'px';" placeholder="Masukan Slogan" wire:model="slogan_headerapk_mobile"></textarea>
                                                    </div>
                                                    @error('slogan_headerapk_mobile')
                                                        <span class="invalid-feedback d-block text-start" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- untuk Header Corousel --}}
                                    <div class="swichermainleft text-center">
                                        <h4 class="d-flex justify-content-between" wire:ignore>
                                            Header Corousel
                                            <label class="custom-switch form-switch mb-0  p-0 cursor-pointer" data-bs-toggle="collapse" href="#coll-headercorousel-mobile" role="button" aria-expanded="false" aria-controls="coll-headercorousel-mobile">
                                                <input type="checkbox" class="custom-switch-input" data-type="mobile" data-target="headercorousel" onchange="changeCheckbox(this)" {{$toogle_headercorousel_mobile ? 'checked' : ''}}>
                                                <span class="custom-switch-indicator custom-switch-indicator"></span>
                                            </label>
                                        </h4>
                                        <div class="skin-body collapse {{$toogle_headercorousel_mobile ? 'show' : ''}}" id="coll-headercorousel-mobile">
                                            <div class="switch_section">
                                                {{-- untuk file header corousel --}}
                                                <div>
                                                    <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress">
                                                        <div class="main-form-group mt-2">
                                                            <label class="form-label mt-0 text-start">Image</label>
                                                            <input class="form-control" type="file" accept="image/*" wire:model="file_temp_headercorousel_mobile" multiple>
                                                        </div>
                                                        <div class="progress mg-b-10" x-show="isUploading">
                                                            <div class="progress-bar ht-2" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" x-bind:style="`width:${progress}%`"></div>
                                                        </div>
                                                    </div>
                                                    @error('file_temp_headercorousel_mobile.*')
                                                        @foreach ($errors->get("file_temp_headercorousel_mobile.*") as $msg)
                                                            @foreach ($msg as $item)
                                                                <span class="invalid-feedback d-block text-start" role="alert">
                                                                    <strong>{{ $item }}</strong>
                                                                </span>
                                                            @endforeach
                                                        @endforeach
                                                    @enderror
                                                    @if (count($file_headercorousel_mobile) > 0)
                                                        <div class="multiple-preview" data-count="{{count($file_headercorousel_mobile) > 4 ? '*' : count($file_headercorousel_mobile)}}">
                                                            @php $n = 0; @endphp
                                                            @foreach ($file_headercorousel_mobile as $i => $file)
                                                                @if ($n <= 3)
                                                                    <div class="mt-2 previewImg">
                                                                        <img src="{{ $file->temporaryUrl() }}">
                                                                        <div class="removePreviewImage" wire:click="removeImage('file_headercorousel_mobile', '{{$i}}')" onclick="$(this).closest('.switch_section').find('input').val('')">
                                                                            <i class="fe fe-x"></i>
                                                                        </div>
                                                                    </div>
                                                                    @php $n = $n+1; @endphp
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                        @if (count($file_headercorousel_mobile) > 4)
                                                            <div class="btn btn-primary mt-2 btn-sm" wire:click="showModalMore('file_headercorousel_mobile')">Show {{count($file_headercorousel_mobile) - 4}} more...</div>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- untuk Button Action --}}
                                    <div class="swichermainleft text-center">
                                        <h4 class="d-flex justify-content-between" wire:ignore>
                                            Button Action
                                            <label class="custom-switch form-switch mb-0  p-0 cursor-pointer" data-bs-toggle="collapse" href="#coll-buttonaction-mobile" role="button" aria-expanded="false" aria-controls="coll-buttonaction-mobile">
                                                <input type="checkbox" class="custom-switch-input" data-type="mobile" data-target="buttonaction" onchange="changeCheckbox(this)" {{$toogle_buttonaction_mobile ? 'checked' : ''}}>
                                                <span class="custom-switch-indicator custom-switch-indicator"></span>
                                            </label>
                                        </h4>
                                        <div class="skin-body collapse {{$toogle_buttonaction_mobile ? 'show' : ''}}" id="coll-buttonaction-mobile">
                                            @if (count($data_buttonaction_mobile) > 0)
                                                <span class="text-center-w-100">
                                                    Ada {{count($data_buttonaction_mobile)}} data. Klik <i class="fa fa-eye cursor-pointer" wire:click="showFormBtnAction(false)"></i> untuk melihat data.
                                                </span>
                                                <div class="mt-2">
                                                    @foreach ($data_buttonaction_mobile as $item)
                                                        @if ($item['status'])
                                                            <div href="{{$item['link']}}" target="{{$item['target'] ? '_blank' : ''}}" class="btn w-100 btn-sm {{$item['class']}} btn-sample mt-2" style="{{$item['shadow'] ? 'box-shadow: inset 0 -4px 0 '.$item['shadow'].';' : ''}}{{$item['style']}}" onclick="sampleButton(this)">{{$item['name'] == '' ? 'Sample' : $item['name']}}</div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @else
                                                <span class="text-center-w-100">
                                                    Belum ada data. silahkan klik <i class="fa fa-plus cursor-pointer" wire:click="showFormBtnAction(false)"></i> untuk menambahkan.
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- untuk Icon Sosmed --}}
                                    <div class="swichermainleft text-center">
                                        <h4 class="d-flex justify-content-between" wire:ignore>
                                            Icon Sosmed
                                            <label class="custom-switch form-switch mb-0  p-0 cursor-pointer" data-bs-toggle="collapse" href="#coll-iconsosmed-mobile" role="button" aria-expanded="false" aria-controls="coll-iconsosmed-mobile">
                                                <input type="checkbox" class="custom-switch-input" data-type="mobile" data-target="iconsosmed" onchange="changeCheckbox(this)" {{$toogle_iconsosmed_mobile ? 'checked' : ''}}>
                                                <span class="custom-switch-indicator custom-switch-indicator"></span>
                                            </label>
                                        </h4>
                                        <div class="skin-body collapse {{$toogle_iconsosmed_mobile ? 'show' : ''}}" id="coll-iconsosmed-mobile">
                                            <div class="switch_section">
                                                <span class="text-center-w-100">
                                                    @if (count($data_iconsosmed_mobile) > 0)
                                                        Ada {{count($data_iconsosmed_mobile)}} data. Klik <i class="fa fa-eye cursor-pointer" wire:click="showFormSosmed(false)"></i> untuk melihat data.
                                                    @else
                                                        Belum ada data. silahkan klik <i class="fa fa-plus cursor-pointer" wire:click="showFormSosmed(false)"></i> untuk menambahkan.
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- untuk Promosi --}}
                                    <div class="swichermainleft text-center">
                                        <h4 class="d-flex justify-content-between" wire:ignore>
                                            Promosi
                                            <label class="custom-switch form-switch mb-0  p-0 cursor-pointer" data-bs-toggle="collapse" href="#coll-promosi-mobile" role="button" aria-expanded="false" aria-controls="coll-promosi-mobile">
                                                <input type="checkbox" class="custom-switch-input" data-type="mobile" data-target="promosi" onchange="changeCheckbox(this)" {{$toogle_promosi_mobile ? 'checked' : ''}}>
                                                <span class="custom-switch-indicator custom-switch-indicator"></span>
                                            </label>
                                        </h4>
                                        <div class="skin-body collapse {{$toogle_promosi_mobile ? 'show' : ''}}" id="coll-promosi-mobile">
                                            <div class="switch_section">
                                                untuk promosi
                                            </div>
                                        </div>
                                    </div>

                                    {{-- untuk Before Footer --}}
                                    <div class="swichermainleft text-center">
                                        <h4 class="d-flex justify-content-between" wire:ignore>
                                            before footer
                                            <label class="custom-switch form-switch mb-0  p-0 cursor-pointer" data-bs-toggle="collapse" href="#coll-beforefooter-mobile" role="button" aria-expanded="false" aria-controls="coll-beforefooter-mobile">
                                                <input type="checkbox" class="custom-switch-input" data-type="mobile" data-target="beforefooter" onchange="changeCheckbox(this)" {{$toogle_beforefooter_mobile ? 'checked' : ''}}>
                                                <span class="custom-switch-indicator custom-switch-indicator"></span>
                                            </label>
                                        </h4>
                                        <div class="skin-body collapse {{$toogle_beforefooter_mobile ? 'show' : ''}}" id="coll-beforefooter-mobile">
                                            <div class="switch_section">
                                                untuk beforefooter
                                            </div>
                                        </div>
                                    </div>

                                    {{-- untuk Footer Protection --}}
                                    <div class="swichermainleft text-center">
                                        <h4 class="d-flex justify-content-between" wire:ignore>
                                            footer protection
                                            <label class="custom-switch form-switch mb-0  p-0 cursor-pointer" data-bs-toggle="collapse" href="#coll-footerprotection-mobile" role="button" aria-expanded="false" aria-controls="coll-footerprotection-mobile">
                                                <input type="checkbox" class="custom-switch-input" data-type="mobile" data-target="footerprotection" onchange="changeCheckbox(this)" {{$toogle_footerprotection_mobile ? 'checked' : ''}}>
                                                <span class="custom-switch-indicator custom-switch-indicator"></span>
                                            </label>
                                        </h4>
                                        <div class="skin-body collapse {{$toogle_footerprotection_mobile ? 'show' : ''}}" id="coll-footerprotection-mobile">
                                            <div class="switch_section">
                                                untuk footerprotection
                                            </div>
                                        </div>
                                    </div>

                                    {{-- untuk Link Alternatif --}}
                                    <div class="swichermainleft text-center">
                                        <h4 class="d-flex justify-content-between" wire:ignore>
                                            Link Alternatif
                                            <label class="custom-switch form-switch mb-0  p-0 cursor-pointer" data-bs-toggle="collapse" href="#coll-linkAlternatif-mobile" role="button" aria-expanded="false" aria-controls="coll-linkAlternatif-mobile">
                                                <input type="checkbox" class="custom-switch-input" data-type="mobile" data-target="linkAlternatif" onchange="changeCheckbox(this)" {{$toogle_linkAlternatif_mobile ? 'checked' : ''}}>
                                                <span class="custom-switch-indicator custom-switch-indicator"></span>
                                            </label>
                                        </h4>
                                        <div class="skin-body collapse {{$toogle_linkAlternatif_mobile ? 'show' : ''}}" id="coll-linkAlternatif-mobile">
                                            <div class="switch_section">
                                                untuk linkAlternatif
                                            </div>
                                        </div>
                                    </div>

                                    {{-- untuk Barcode QRIS --}}
                                    <div class="swichermainleft text-center">
                                        <h4 class="d-flex justify-content-between" wire:ignore>
                                            Barcode QRIS
                                            <label class="custom-switch form-switch mb-0  p-0 cursor-pointer" data-bs-toggle="collapse" href="#coll-barcodeqris-mobile" role="button" aria-expanded="false" aria-controls="coll-barcodeqris-mobile">
                                                <input type="checkbox" class="custom-switch-input" data-type="mobile" data-target="barcodeqris" onchange="changeCheckbox(this)" {{$toogle_barcodeqris_mobile ? 'checked' : ''}}>
                                                <span class="custom-switch-indicator custom-switch-indicator"></span>
                                            </label>
                                        </h4>
                                        <div class="skin-body collapse {{$toogle_barcodeqris_mobile ? 'show' : ''}}" id="coll-barcodeqris-mobile">
                                            <div class="switch_section">
                                                untuk barcodeqris
                                            </div>
                                        </div>
                                    </div>

                                    <div class="w-100 px-2 mb-3">
                                        <button type="submit" class="btn btn-primary-light w-100 mt-2">Simpan</button>
                                    </div>
                                </form>
                            @else
                                <div class="w-100 text-center mt-3">
                                    The feature is not available on the site in mobile mode, please try it on desktop mode.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
<!--/Sidebar-right-->
