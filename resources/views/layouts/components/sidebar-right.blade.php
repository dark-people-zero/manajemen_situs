<!-- Sidebar-right-->
<div class="sidebar sidebar-right sidebar-animate" wire:ignore.self data-sidebar-notclose=".clr-picker, #previewIMageModal, .removePreviewImage, .modal">
    <div class="panel panel-primary card mb-0 box-shadow p-0">
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
                        @if (auth()->user()->id_role == 1)
                            @foreach ($Aksessitus as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        @else
                            @foreach ($Aksessitus as $item)
                                <option value="{{$item->id}}">{{$item->situs->name}}</option>
                            @endforeach
                        @endif
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
                            @if (count($dataFiturDesktop) > 0)
                                <form id="formDesktop" enctype="multipart/form-data" wire:submit.prevent="saveContact">
                                    @foreach ($dataFiturDesktop as $itemFitur)
                                        {{-- untuk popup modal --}}
                                        @if ($itemFitur->id_fitur == 1)
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
                                                                    @if (gettype($file_popupmodal_desktop) == "string")
                                                                        <img src="{{ $file_popupmodal_desktop }}">
                                                                    @else
                                                                        <img src="{{ $file_popupmodal_desktop->temporaryUrl() }}">
                                                                    @endif
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
                                        @endif

                                        {{-- untuk header apk --}}
                                        @if ($itemFitur->id_fitur == 2)
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
                                                                    @if (gettype($file_headerapk_desktop) == "string")
                                                                        <img src="{{ $file_headerapk_desktop }}">
                                                                    @else
                                                                        <img src="{{ $file_headerapk_desktop->temporaryUrl() }}">
                                                                    @endif
                                                                    <div class="removePreviewImage" wire:click="removeImage('file_headerapk_desktop')">
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
                                                                <textarea class="form-control resize" placeholder="Masukan Slogan" wire:model="slogan_headerapk_desktop"></textarea>
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
                                        @endif

                                        {{-- untuk Header Corousel --}}
                                        @if ($itemFitur->id_fitur == 3)
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
                                                            @error('file_headercorousel_desktop')
                                                                <span class="invalid-feedback d-block text-start" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
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
                                                                                @if (gettype($file) == "string")
                                                                                    <img src="{{ $file }}">
                                                                                @else
                                                                                    <img src="{{ $file->temporaryUrl() }}">
                                                                                @endif
                                                                                <div class="removePreviewImage" wire:click="removeImage('file_headercorousel_desktop', '{{$i}}')">
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
                                        @endif

                                        {{-- untuk Button Action --}}
                                        @if ($itemFitur->id_fitur == 4)
                                            <div class="swichermainleft text-center">
                                                <h4 class="d-flex justify-content-between" wire:ignore>
                                                    Button Action
                                                    <label class="custom-switch form-switch mb-0  p-0 cursor-pointer" data-bs-toggle="collapse" href="#coll-buttonaction" role="button" aria-expanded="false" aria-controls="coll-buttonaction">
                                                        <input type="checkbox" class="custom-switch-input" data-type="desktop" data-target="buttonaction" onchange="changeCheckbox(this)" {{$toogle_buttonaction_desktop ? 'checked' : ''}}>
                                                        <span class="custom-switch-indicator custom-switch-indicator"></span>
                                                    </label>
                                                </h4>
                                                <div class="skin-body collapse px-2 {{$toogle_buttonaction_desktop ? 'show' : ''}}" id="coll-buttonaction">
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

                                                        @error('data_buttonaction_desktop')
                                                            <span class="invalid-feedback d-block text-start" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        {{-- untuk Icon Sosmed --}}
                                        @if ($itemFitur->id_fitur == 5)
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
                                                        @error('data_iconsosmed_desktop')
                                                            <span class="invalid-feedback d-block text-start" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        {{-- untuk Promosi --}}
                                        @if ($itemFitur->id_fitur == 6)
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
                                                        {{-- untuk name promosi --}}
                                                        <div>
                                                            <div class="main-form-group mt-2">
                                                                <label class="form-label mt-0 text-start">Name</label>
                                                                <input class="form-control" placeholder="Masukan Name" type="text" wire:model="name_promosi_desktop">
                                                            </div>
                                                            @error('name_promosi_desktop')
                                                                <span class="invalid-feedback d-block text-start" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>

                                                        {{-- untuk link promosi --}}
                                                        <div>
                                                            <div class="main-form-group mt-2">
                                                                <label class="form-label mt-0 text-start">Link</label>
                                                                <input class="form-control" placeholder="Masukan Link" type="text" wire:model="link_promosi_desktop">
                                                            </div>
                                                            @error('link_promosi_desktop')
                                                                <span class="invalid-feedback d-block text-start" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        {{-- untuk file promosi --}}
                                                        <div>
                                                            <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress">
                                                                <div class="main-form-group mt-2">
                                                                    <label class="form-label mt-0 text-start">Image</label>
                                                                    <input class="form-control" type="file" accept="image/*" wire:model="image_promosi_desktop">
                                                                </div>
                                                                <div class="progress mg-b-10" x-show="isUploading">
                                                                    <div class="progress-bar ht-2" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" x-bind:style="`width:${progress}%`"></div>
                                                                </div>
                                                            </div>
                                                            @error('image_promosi_desktop')
                                                                <span class="invalid-feedback d-block text-start" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                            @if ($image_promosi_desktop && !$errors->has('image_promosi_desktop'))
                                                                <div class="mt-2 previewImg">
                                                                    @if (gettype($image_promosi_desktop) == "string")
                                                                        <img src="{{ $image_promosi_desktop }}">
                                                                    @else
                                                                        <img src="{{ $image_promosi_desktop->temporaryUrl() }}">
                                                                    @endif
                                                                    <div class="removePreviewImage" wire:click="removeImage('image_promosi_desktop')">
                                                                        <i class="fe fe-x"></i>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        {{-- untuk Before Footer --}}
                                        @if ($itemFitur->id_fitur == 7)
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
                                                        {{-- untuk title before footer --}}
                                                        <div>
                                                            <div class="main-form-group mt-2">
                                                                <label class="form-label mt-0 text-start">Title</label>
                                                                <input class="form-control" placeholder="Masukan Title" type="text" wire:model="title_beforeFooter_desktop">
                                                            </div>
                                                            @error('title_beforeFooter_desktop')
                                                                <span class="invalid-feedback d-block text-start" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>

                                                        {{-- untuk deskripsi before footer --}}
                                                        <div>
                                                            <div class="main-form-group mt-2">
                                                                <label class="form-label mt-0 text-start">Deskripsi</label>
                                                                <textarea class="form-control resize" rows="5" placeholder="Masukan Link" wire:model="deskripsi_beforeFooter_desktop"></textarea>
                                                            </div>
                                                            @error('deskripsi_beforeFooter_desktop')
                                                                <span class="invalid-feedback d-block text-start" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        {{-- untuk Footer Protection --}}
                                        @if ($itemFitur->id_fitur == 8)
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
                                                        {{-- untuk name footer protection --}}
                                                        <div>
                                                            <div class="main-form-group mt-2">
                                                                <label class="form-label mt-0 text-start">Name</label>
                                                                <input class="form-control" placeholder="Masukan Name" type="text" wire:model="name_footerProtection_desktop">
                                                            </div>
                                                            @error('name_footerProtection_desktop')
                                                                <span class="invalid-feedback d-block text-start" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>

                                                        {{-- untuk link footer protection --}}
                                                        <div>
                                                            <div class="main-form-group mt-2">
                                                                <label class="form-label mt-0 text-start">Link</label>
                                                                <input class="form-control" placeholder="Masukan Link" type="text" wire:model="link_footerProtection_desktop">
                                                            </div>
                                                            @error('link_footerProtection_desktop')
                                                                <span class="invalid-feedback d-block text-start" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        {{-- untuk file footer protection --}}
                                                        <div>
                                                            <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress">
                                                                <div class="main-form-group mt-2">
                                                                    <label class="form-label mt-0 text-start">Image</label>
                                                                    <input class="form-control" type="file" accept="image/*" wire:model="image_footerProtection_desktop">
                                                                </div>
                                                                <div class="progress mg-b-10" x-show="isUploading">
                                                                    <div class="progress-bar ht-2" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" x-bind:style="`width:${progress}%`"></div>
                                                                </div>
                                                            </div>
                                                            @error('image_footerProtection_desktop')
                                                                <span class="invalid-feedback d-block text-start" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                            @if ($image_footerProtection_desktop && !$errors->has('image_footerProtection_desktop'))
                                                                <div class="mt-2 previewImg">
                                                                    @if (gettype($image_footerProtection_desktop) == "string")
                                                                        <img src="{{ $image_footerProtection_desktop }}">
                                                                    @else
                                                                        <img src="{{ $image_footerProtection_desktop->temporaryUrl() }}">
                                                                    @endif
                                                                    <div class="removePreviewImage" wire:click="removeImage('image_footerProtection_desktop')">
                                                                        <i class="fe fe-x"></i>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        {{-- untuk Link Alternatif --}}
                                        @if ($itemFitur->id_fitur == 9)
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
                                                        <div class="d-flex-justify-content-start text-start">
                                                            <small><b>Note:</b> Untuk memisahkan link silahkan berikan tanda "--" tanpa tanda kutip.</small>
                                                        </div>
                                                        {{-- untuk file link laternatif --}}
                                                        <div>
                                                            <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress">
                                                                <div class="main-form-group mt-2">
                                                                    <label class="form-label mt-0 text-start">Image</label>
                                                                    <input class="form-control" type="file" accept="image/*" wire:model="image_linkAlternatif_desktop">
                                                                </div>
                                                                <div class="progress mg-b-10" x-show="isUploading">
                                                                    <div class="progress-bar ht-2" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" x-bind:style="`width:${progress}%`"></div>
                                                                </div>
                                                            </div>
                                                            @error('image_linkAlternatif_desktop')
                                                                <span class="invalid-feedback d-block text-start" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                            @if ($image_linkAlternatif_desktop && !$errors->has('image_linkAlternatif_desktop'))
                                                                <div class="mt-2 previewImg">
                                                                    @if (gettype($image_linkAlternatif_desktop) == "string")
                                                                        <img src="{{ $image_linkAlternatif_desktop }}">
                                                                    @else
                                                                        <img src="{{ $image_linkAlternatif_desktop->temporaryUrl() }}">
                                                                    @endif
                                                                    <div class="removePreviewImage" wire:click="removeImage('image_linkAlternatif_desktop')">
                                                                        <i class="fe fe-x"></i>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>

                                                        {{-- untuk List link laternatif --}}
                                                        <div>
                                                            <div class="main-form-group mt-2">
                                                                <label class="form-label mt-0 text-start">List Link</label>
                                                                <textarea class="form-control resize" placeholder="Masukan List Link" type="text" wire:model="listLink_linkAlternatif_desktop"></textarea>
                                                            </div>
                                                            @error('listLink_linkAlternatif_desktop')
                                                                <span class="invalid-feedback d-block text-start" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        {{-- untuk Barcode QRIS --}}
                                        @if ($itemFitur->id_fitur == 10)
                                            <div class="swichermainleft text-center">
                                                <h4 class="d-flex justify-content-between" wire:ignore>
                                                    Barcode QRIS
                                                    <label class="custom-switch form-switch mb-0  p-0 cursor-pointer" data-bs-toggle="collapse" href="#coll-barcodeqris" role="button" aria-expanded="false" aria-controls="coll-barcodeqris">
                                                        <input type="checkbox" class="custom-switch-input" data-type="desktop" data-target="barcodeqris" onchange="changeCheckbox(this)" {{$toogle_barcodeqris_desktop ? 'checked' : ''}}>
                                                        <span class="custom-switch-indicator custom-switch-indicator"></span>
                                                    </label>
                                                </h4>
                                                <div class="skin-body collapse {{$toogle_barcodeqris_desktop ? 'show' : ''}}" id="coll-barcodeqris">
                                                    <div class="switch_section qris">
                                                        {{-- untuk sample button barcode qris --}}
                                                        <div>
                                                            <span>Button Sample</span>
                                                            <div class="btn-sample" style="background: {{$bg_barcodeqris_desktop ? $bg_barcodeqris_desktop : '#c0392b'}}; color: {{$color_barcodeqris_desktop ? $color_barcodeqris_desktop : '#FFFFFF'}}; box-shadow: inset 0 -4px 0 {{$shadow_barcodeqris_desktop ? $shadow_barcodeqris_desktop : '#196a7d'}};">
                                                                {{$name_barcodeqris_desktop ? $name_barcodeqris_desktop : 'Barcode qris'}}
                                                            </div>
                                                        </div>
                                                        {{-- untuk name barcode qris --}}
                                                        <div>
                                                            <div class="main-form-group mt-2">
                                                                <label class="form-label mt-0 text-start">Name</label>
                                                                <input class="form-control" placeholder="Masukan Name" type="text" wire:model="name_barcodeqris_desktop" value="{{$name_barcodeqris_desktop}}">
                                                            </div>
                                                            @error('name_barcodeqris_desktop')
                                                                <span class="invalid-feedback d-block text-start" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>

                                                        {{-- untuk background barcode qris --}}
                                                        <div>
                                                            <div class="main-form-group mt-2">
                                                                <label class="form-label mt-0 text-start">Background</label>
                                                                <input class="form-control coloris coloris-barcode" placeholder="Masukan Background" type="text" wire:model="bg_barcodeqris_desktop" value="{{$bg_barcodeqris_desktop}}" readonly>
                                                            </div>
                                                        </div>

                                                        {{-- untuk color barcode qris --}}
                                                        <div>
                                                            <div class="main-form-group mt-2">
                                                                <label class="form-label mt-0 text-start">Color</label>
                                                                <input class="form-control coloris coloris-barcode" placeholder="Masukan Color" type="text" wire:model="color_barcodeqris_desktop" value="{{$color_barcodeqris_desktop}}" readonly>
                                                            </div>
                                                        </div>

                                                        {{-- untuk shadow barcode qris --}}
                                                        <div>
                                                            <div class="main-form-group mt-2">
                                                                <label class="form-label mt-0 text-start">Shadow</label>
                                                                <input class="form-control coloris coloris-barcode" placeholder="Masukan Shadow" type="text" wire:model="shadow_barcodeqris_desktop" value="{{$shadow_barcodeqris_desktop}}" readonly>
                                                            </div>
                                                        </div>

                                                        {{-- untuk file barcode qris --}}
                                                        <div>
                                                            <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress">
                                                                <div class="main-form-group mt-2">
                                                                    <label class="form-label mt-0 text-start">Image</label>
                                                                    <input class="form-control" type="file" accept="image/*" wire:model="image_barcodeqris_desktop">
                                                                </div>
                                                                <div class="progress mg-b-10" x-show="isUploading">
                                                                    <div class="progress-bar ht-2" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" x-bind:style="`width:${progress}%`"></div>
                                                                </div>
                                                            </div>
                                                            @error('image_barcodeqris_desktop')
                                                                <span class="invalid-feedback d-block text-start" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                            @if ($image_barcodeqris_desktop && !$errors->has('image_barcodeqris_desktop'))
                                                                <div class="mt-2 previewImg">
                                                                    @if (gettype($image_barcodeqris_desktop) == "string")
                                                                        <img src="{{ $image_barcodeqris_desktop }}">
                                                                    @else
                                                                        <img src="{{ $image_barcodeqris_desktop->temporaryUrl() }}">
                                                                    @endif
                                                                    <div class="removePreviewImage" wire:click="removeImage('image_barcodeqris_desktop')">
                                                                        <i class="fe fe-x"></i>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        {{-- untuk Sort List Bank --}}
                                        @if ($itemFitur->id_fitur == 11)
                                            <div class="swichermainleft text-center">
                                                <h4 class="d-flex justify-content-between" wire:ignore>
                                                    Sort List Bank
                                                    <label class="custom-switch form-switch mb-0  p-0 cursor-pointer" data-bs-toggle="collapse" href="#coll-sortlistbank-desktop" role="button" aria-expanded="false" aria-controls="coll-sortlistbank-desktop">
                                                        <input type="checkbox" class="custom-switch-input" data-type="desktop" data-target="sortlistbank" onchange="changeCheckbox(this)" {{$toogle_sortlistbank_desktop ? 'checked' : ''}}>
                                                        <span class="custom-switch-indicator custom-switch-indicator"></span>
                                                    </label>
                                                </h4>
                                                <div class="skin-body collapse {{$toogle_sortlistbank_desktop ? 'show' : ''}}" id="coll-sortlistbank-desktop">
                                                    <div class="switch_section">
                                                        <div class="d-flex-justify-content-start text-start">
                                                            <small><b>Note:</b> Untuk memisahkan link silahkan berikan tanda "--" tanpa tanda kutip.</small>
                                                        </div>
                                                        {{-- untuk List Sort List Bank --}}
                                                        <div>
                                                            <textarea class="form-control resize border mt-2" placeholder="Masukan List Link" type="text" wire:model="list_sortlistbank_desktop" rows="5"></textarea>
                                                            @error('list_sortlistbank_desktop')
                                                                <span class="invalid-feedback d-block text-start" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </form>
                            @else
                                <div class="w-100 text-center mt-3">
                                    The feature is not available on the site in desktop mode, please try it on mobile mode.
                                </div>
                            @endif
                        </div>
                        <div class="tab-pane {{$prevActive == 'mobile' ? 'active' : ''}}" id="mobile">
                            @if (count($dataFiturMobile) > 0)
                                <form id="formDesktop" enctype="multipart/form-data" wire:submit.prevent="saveContact">
                                    @foreach ($dataFiturMobile as $itemFitur)
                                        {{-- untuk popup modal --}}
                                        @if ($itemFitur->id_fitur == 1)
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
                                                                    @if (gettype($file_popupmodal_mobile) == "string")
                                                                        <img src="{{ $file_popupmodal_mobile }}">
                                                                    @else
                                                                        <img src="{{ $file_popupmodal_mobile->temporaryUrl() }}">
                                                                    @endif
                                                                    <div class="removePreviewImage" wire:click="removeImage('file_popupmodal_mobile')">
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
                                        @endif

                                        {{-- untuk header apk --}}
                                        @if ($itemFitur->id_fitur == 2)
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
                                                                    @if (gettype($file_headerapk_mobile) == "string")
                                                                        <img src="{{ $file_headerapk_mobile }}">
                                                                    @else
                                                                        <img src="{{ $file_headerapk_mobile->temporaryUrl() }}">
                                                                    @endif
                                                                    <div class="removePreviewImage" wire:click="removeImage('file_headerapk_mobile')">
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
                                                                <textarea class="form-control resize" placeholder="Masukan Slogan" wire:model="slogan_headerapk_mobile"></textarea>
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
                                        @endif

                                        {{-- untuk Header Corousel --}}
                                        @if ($itemFitur->id_fitur == 3)
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
                                                            @error('file_headercorousel_mobile')
                                                                <span class="invalid-feedback d-block text-start" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
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
                                                                                @if (gettype($file) == "string")
                                                                                    <img src="{{ $file }}">
                                                                                @else
                                                                                    <img src="{{ $file->temporaryUrl() }}">
                                                                                @endif
                                                                                <div class="removePreviewImage" wire:click="removeImage('file_headercorousel_mobile', '{{$i}}')">
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
                                        @endif

                                        {{-- untuk Button Action --}}
                                        @if ($itemFitur->id_fitur == 4)
                                            <div class="swichermainleft text-center">
                                                <h4 class="d-flex justify-content-between" wire:ignore>
                                                    Button Action
                                                    <label class="custom-switch form-switch mb-0  p-0 cursor-pointer" data-bs-toggle="collapse" href="#coll-buttonaction-mobile" role="button" aria-expanded="false" aria-controls="coll-buttonaction-mobile">
                                                        <input type="checkbox" class="custom-switch-input" data-type="mobile" data-target="buttonaction" onchange="changeCheckbox(this)" {{$toogle_buttonaction_mobile ? 'checked' : ''}}>
                                                        <span class="custom-switch-indicator custom-switch-indicator"></span>
                                                    </label>
                                                </h4>
                                                <div class="skin-body px-2 collapse {{$toogle_buttonaction_mobile ? 'show' : ''}}" id="coll-buttonaction-mobile">
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
                                                    @error('data_buttonaction_mobile')
                                                        <span class="invalid-feedback d-block text-start" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        @endif

                                        {{-- untuk Icon Sosmed --}}
                                        @if ($itemFitur->id_fitur == 5)
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
                                                        @error('data_iconsosmed_mobile')
                                                            <span class="invalid-feedback d-block text-start" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        {{-- untuk Promosi --}}
                                        @if ($itemFitur->id_fitur == 6)
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
                                                        {{-- untuk name promosi --}}
                                                        <div>
                                                            <div class="main-form-group mt-2">
                                                                <label class="form-label mt-0 text-start">Name</label>
                                                                <input class="form-control" placeholder="Masukan Name" type="text" wire:model="name_promosi_mobile">
                                                            </div>
                                                            @error('name_promosi_mobile')
                                                                <span class="invalid-feedback d-block text-start" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>

                                                        {{-- untuk link promosi --}}
                                                        <div>
                                                            <div class="main-form-group mt-2">
                                                                <label class="form-label mt-0 text-start">Link</label>
                                                                <input class="form-control" placeholder="Masukan Link" type="text" wire:model="link_promosi_mobile">
                                                            </div>
                                                            @error('link_promosi_mobile')
                                                                <span class="invalid-feedback d-block text-start" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        {{-- untuk file promosi --}}
                                                        <div>
                                                            <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress">
                                                                <div class="main-form-group mt-2">
                                                                    <label class="form-label mt-0 text-start">Image</label>
                                                                    <input class="form-control" type="file" accept="image/*" wire:model="image_promosi_mobile">
                                                                </div>
                                                                <div class="progress mg-b-10" x-show="isUploading">
                                                                    <div class="progress-bar ht-2" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" x-bind:style="`width:${progress}%`"></div>
                                                                </div>
                                                            </div>
                                                            @error('image_promosi_mobile')
                                                                <span class="invalid-feedback d-block text-start" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                            @if ($image_promosi_mobile && !$errors->has('image_promosi_mobile'))
                                                                <div class="mt-2 previewImg">
                                                                    @if (gettype($image_promosi_mobile) == "string")
                                                                        <img src="{{ $image_promosi_mobile }}">
                                                                    @else
                                                                        <img src="{{ $image_promosi_mobile->temporaryUrl() }}">
                                                                    @endif
                                                                    <div class="removePreviewImage" wire:click="removeImage('image_promosi_mobile')">
                                                                        <i class="fe fe-x"></i>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        {{-- untuk Before Footer --}}
                                        @if ($itemFitur->id_fitur == 7)
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
                                                        {{-- untuk title before footer --}}
                                                        <div>
                                                            <div class="main-form-group mt-2">
                                                                <label class="form-label mt-0 text-start">Title</label>
                                                                <input class="form-control" placeholder="Masukan Title" type="text" wire:model="title_beforeFooter_mobile">
                                                            </div>
                                                            @error('title_beforeFooter_mobile')
                                                                <span class="invalid-feedback d-block text-start" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>

                                                        {{-- untuk deskripsi before footer --}}
                                                        <div>
                                                            <div class="main-form-group mt-2">
                                                                <label class="form-label mt-0 text-start">Deskripsi</label>
                                                                <textarea class="form-control resize" rows="5" placeholder="Masukan Link" wire:model="deskripsi_beforeFooter_mobile"></textarea>
                                                            </div>
                                                            @error('deskripsi_beforeFooter_mobile')
                                                                <span class="invalid-feedback d-block text-start" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        {{-- untuk Footer Protection --}}
                                        @if ($itemFitur->id_fitur == 8)
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
                                                        {{-- untuk name footer protection --}}
                                                        <div>
                                                            <div class="main-form-group mt-2">
                                                                <label class="form-label mt-0 text-start">Name</label>
                                                                <input class="form-control" placeholder="Masukan Name" type="text" wire:model="name_footerProtection_mobile">
                                                            </div>
                                                            @error('name_footerProtection_mobile')
                                                                <span class="invalid-feedback d-block text-start" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>

                                                        {{-- untuk link footer protection --}}
                                                        <div>
                                                            <div class="main-form-group mt-2">
                                                                <label class="form-label mt-0 text-start">Link</label>
                                                                <input class="form-control" placeholder="Masukan Link" type="text" wire:model="link_footerProtection_mobile">
                                                            </div>
                                                            @error('link_footerProtection_mobile')
                                                                <span class="invalid-feedback d-block text-start" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        {{-- untuk file footer protection --}}
                                                        <div>
                                                            <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress">
                                                                <div class="main-form-group mt-2">
                                                                    <label class="form-label mt-0 text-start">Image</label>
                                                                    <input class="form-control" type="file" accept="image/*" wire:model="image_footerProtection_mobile">
                                                                </div>
                                                                <div class="progress mg-b-10" x-show="isUploading">
                                                                    <div class="progress-bar ht-2" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" x-bind:style="`width:${progress}%`"></div>
                                                                </div>
                                                            </div>
                                                            @error('image_footerProtection_mobile')
                                                                <span class="invalid-feedback d-block text-start" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                            @if ($image_footerProtection_mobile && !$errors->has('image_footerProtection_mobile'))
                                                                <div class="mt-2 previewImg">
                                                                    @if (gettype($image_footerProtection_mobile) == "string")
                                                                        <img src="{{ $image_footerProtection_mobile }}">
                                                                    @else
                                                                        <img src="{{ $image_footerProtection_mobile->temporaryUrl() }}">
                                                                    @endif
                                                                    <div class="removePreviewImage" wire:click="removeImage('image_footerProtection_mobile')">
                                                                        <i class="fe fe-x"></i>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        {{-- untuk Link Alternatif --}}
                                        @if ($itemFitur->id_fitur == 9)
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
                                                        <div class="d-flex-justify-content-start text-start">
                                                            <small><b>Note:</b> Untuk memisahkan link silahkan berikan tanda "--" tanpa tanda kutip.</small>
                                                        </div>
                                                        {{-- untuk file link laternatif --}}
                                                        <div>
                                                            <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress">
                                                                <div class="main-form-group mt-2">
                                                                    <label class="form-label mt-0 text-start">Image</label>
                                                                    <input class="form-control" type="file" accept="image/*" wire:model="image_linkAlternatif_mobile">
                                                                </div>
                                                                <div class="progress mg-b-10" x-show="isUploading">
                                                                    <div class="progress-bar ht-2" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" x-bind:style="`width:${progress}%`"></div>
                                                                </div>
                                                            </div>
                                                            @error('image_linkAlternatif_mobile')
                                                                <span class="invalid-feedback d-block text-start" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                            @if ($image_linkAlternatif_mobile && !$errors->has('image_linkAlternatif_mobile'))
                                                                <div class="mt-2 previewImg">
                                                                    @if (gettype($image_linkAlternatif_mobile) == "string")
                                                                        <img src="{{ $image_linkAlternatif_mobile }}">
                                                                    @else
                                                                        <img src="{{ $image_linkAlternatif_mobile->temporaryUrl() }}">
                                                                    @endif
                                                                    <div class="removePreviewImage" wire:click="removeImage('image_linkAlternatif_mobile')" >
                                                                        <i class="fe fe-x"></i>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>

                                                        {{-- untuk List link laternatif --}}
                                                        <div>
                                                            <div class="main-form-group mt-2">
                                                                <label class="form-label mt-0 text-start">List Link</label>
                                                                <textarea rows="5" class="form-control resize" placeholder="Masukan List Link" type="text" wire:model="listLink_linkAlternatif_mobile"></textarea>
                                                            </div>
                                                            @error('listLink_linkAlternatif_mobile')
                                                                <span class="invalid-feedback d-block text-start" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        {{-- untuk Barcode QRIS --}}
                                        @if ($itemFitur->id_fitur == 10)
                                            <div class="swichermainleft text-center">
                                                <h4 class="d-flex justify-content-between" wire:ignore>
                                                    Barcode QRIS
                                                    <label class="custom-switch form-switch mb-0  p-0 cursor-pointer" data-bs-toggle="collapse" href="#coll-barcodeqris-mobile" role="button" aria-expanded="false" aria-controls="coll-barcodeqris-mobile">
                                                        <input type="checkbox" class="custom-switch-input" data-type="mobile" data-target="barcodeqris" onchange="changeCheckbox(this)" {{$toogle_barcodeqris_mobile ? 'checked' : ''}}>
                                                        <span class="custom-switch-indicator custom-switch-indicator"></span>
                                                    </label>
                                                </h4>
                                                <div class="skin-body collapse {{$toogle_barcodeqris_mobile ? 'show' : ''}}" id="coll-barcodeqris-mobile">
                                                    <div class="switch_section qris">
                                                        {{-- untuk sample button barcode qris --}}
                                                        <div>
                                                            <span>Button Sample</span>
                                                            <div class="btn-sample" style="background: {{$bg_barcodeqris_mobile ? $bg_barcodeqris_mobile : '#c0392b'}}; color: {{$color_barcodeqris_mobile ? $color_barcodeqris_mobile : '#FFFFFF'}}; box-shadow: inset 0 -4px 0 {{$shadow_barcodeqris_mobile ? $shadow_barcodeqris_mobile : '#196a7d'}};">
                                                                {{$name_barcodeqris_mobile ? $name_barcodeqris_mobile : 'Barcode qris'}}
                                                            </div>
                                                        </div>
                                                        {{-- untuk name barcode qris --}}
                                                        <div>
                                                            <div class="main-form-group mt-2">
                                                                <label class="form-label mt-0 text-start">Name</label>
                                                                <input class="form-control" placeholder="Masukan Name" type="text" wire:model="name_barcodeqris_mobile" value="{{$name_barcodeqris_mobile}}">
                                                            </div>
                                                            @error('name_barcodeqris_mobile')
                                                                <span class="invalid-feedback d-block text-start" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>

                                                        {{-- untuk background barcode qris --}}
                                                        <div>
                                                            <div class="main-form-group mt-2">
                                                                <label class="form-label mt-0 text-start">Background</label>
                                                                <input class="form-control coloris-barcode" placeholder="Masukan Background" type="text" wire:model="bg_barcodeqris_mobile" value="{{$bg_barcodeqris_mobile}}" readonly>
                                                            </div>
                                                        </div>

                                                        {{-- untuk color barcode qris --}}
                                                        <div>
                                                            <div class="main-form-group mt-2">
                                                                <label class="form-label mt-0 text-start">Color</label>
                                                                <input class="form-control coloris-barcode" placeholder="Masukan Color" type="text" wire:model="color_barcodeqris_mobile" value="{{$color_barcodeqris_mobile}}" readonly>
                                                            </div>
                                                        </div>

                                                        {{-- untuk shadow barcode qris --}}
                                                        <div>
                                                            <div class="main-form-group mt-2">
                                                                <label class="form-label mt-0 text-start">Shadow</label>
                                                                <input class="form-control coloris-barcode" placeholder="Masukan Shadow" type="text" wire:model="shadow_barcodeqris_mobile" value="{{$shadow_barcodeqris_mobile}}" readonly>
                                                            </div>
                                                        </div>

                                                        {{-- untuk file barcode qris --}}
                                                        <div>
                                                            <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress">
                                                                <div class="main-form-group mt-2">
                                                                    <label class="form-label mt-0 text-start">Image</label>
                                                                    <input class="form-control" type="file" accept="image/*" wire:model="image_barcodeqris_mobile">
                                                                </div>
                                                                <div class="progress mg-b-10" x-show="isUploading">
                                                                    <div class="progress-bar ht-2" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" x-bind:style="`width:${progress}%`"></div>
                                                                </div>
                                                            </div>
                                                            @error('image_barcodeqris_mobile')
                                                                <span class="invalid-feedback d-block text-start" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                            @if ($image_barcodeqris_mobile && !$errors->has('image_barcodeqris_mobile'))
                                                                <div class="mt-2 previewImg">
                                                                    @if (gettype($image_barcodeqris_mobile) == "string")
                                                                        <img src="{{ $image_barcodeqris_mobile }}">
                                                                    @else
                                                                        <img src="{{ $image_barcodeqris_mobile->temporaryUrl() }}">
                                                                    @endif
                                                                    <div class="removePreviewImage" wire:click="removeImage('image_barcodeqris_mobile')">
                                                                        <i class="fe fe-x"></i>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        {{-- untuk Sort List Bank --}}
                                        @if ($itemFitur->id_fitur == 11)
                                            <div class="swichermainleft text-center">
                                                <h4 class="d-flex justify-content-between" wire:ignore>
                                                    Sort List Bank
                                                    <label class="custom-switch form-switch mb-0  p-0 cursor-pointer" data-bs-toggle="collapse" href="#coll-sortlistbank-mobile" role="button" aria-expanded="false" aria-controls="coll-sortlistbank-mobile">
                                                        <input type="checkbox" class="custom-switch-input" data-type="mobile" data-target="sortlistbank" onchange="changeCheckbox(this)" {{$toogle_sortlistbank_mobile ? 'checked' : ''}}>
                                                        <span class="custom-switch-indicator custom-switch-indicator"></span>
                                                    </label>
                                                </h4>
                                                <div class="skin-body collapse {{$toogle_sortlistbank_mobile ? 'show' : ''}}" id="coll-sortlistbank-mobile">
                                                    <div class="switch_section">
                                                        <div class="d-flex-justify-content-start text-start">
                                                            <small><b>Note:</b> Untuk memisahkan link silahkan berikan tanda "--" tanpa tanda kutip.</small>
                                                        </div>
                                                        {{-- untuk List Sort List Bank --}}
                                                        <div>
                                                            <textarea class="form-control resize border mt-2" placeholder="Masukan List Link" type="text" wire:model="list_sortlistbank_mobile" rows="5"></textarea>
                                                            @error('list_sortlistbank_mobile')
                                                                <span class="invalid-feedback d-block text-start" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach

                                </form>
                            @else
                                <div class="w-100 text-center mt-3">
                                    The feature is not available on the site in mobile mode, please try it on desktop mode.
                                </div>
                            @endif
                        </div>
                    </div>

                    @if (count($dataFiturDesktop) > 0 && $prevActive == "desktop" || count($dataFiturMobile) > 0 && $prevActive == "mobile")
                        <div class="w-100 px-2 mb-2 border-top">
                            <button type="button" wire:click="saveData" class="btn btn-primary-light w-100 mt-3">Simpan</button>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <div class="lds-dual-ring position-absolute w-100 h-100 justify-content-center align-items-center" style="background: #97939314; display: none" wire:loading.flex wire:target="saveData"></div>
    </div>
</div>
<!--/Sidebar-right-->
