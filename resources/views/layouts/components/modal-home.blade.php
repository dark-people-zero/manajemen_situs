<div id="previewIMageModal" class="modal fade" wire:ignore>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body mx-auto">
                <div class="modalPrevContainer">
                    <div class="modalPrevImage">
                        <img src="https://static.hokibagus.club/ziatogel/images/slider/ziatogel_slidermobile_allbonus.jpg">
                        <div class="removePreviewImage">
                            <i class="fe fe-x"></i>
                        </div>
                    </div>
                    <div class="modalPrevImage">
                        <img src="https://static.hokibagus.club/ziatogel/images/slider/ziatogel_slidermobile_tipebet.jpg">
                        <div class="removePreviewImage">
                            <i class="fe fe-x"></i>
                        </div>
                    </div>
                    <div class="modalPrevImage">
                        <img src="https://static.hokibagus.club/ziatogel/images/slider/ziatogel_slidermobile_allbonus.jpg">
                        <div class="removePreviewImage">
                            <i class="fe fe-x"></i>
                        </div>
                    </div>
                    <div class="modalPrevImage">
                        <img src="https://static.hokibagus.club/ziatogel/images/slider/ziatogel_slidermobile_prosesdeposit.jpg">
                        <div class="removePreviewImage">
                            <i class="fe fe-x"></i>
                        </div>
                    </div>
                    <div class="modalPrevImage">
                        <img src="https://static.hokibagus.club/ziatogel/images/slider/ziatogel_slidermobile_allbonus.jpg">
                        <div class="removePreviewImage">
                            <i class="fe fe-x"></i>
                        </div>
                    </div>
                </div>
            </div><!-- modal-body -->
        </div>
    </div><!-- modal-dialog -->
</div>

<div id="formAddbtnActionDesktop" class="modal fade modalActionBtn" wire:ignore.self data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <a href="javascript:void(0);" class="btn btn-sm btn-primary me-3" wire:click="addFormBtnAction(true)">
                    Tambah data button action
                </a>
                <button type="button" class="btn-close" aria-label="Close" wire:click="closeFormBtnAction(true)">
                    <i class="fa fa-times fs-5 cursor-pointer"></i>
                </button>
            </div>
            <div class="modal-body mx-auto overflow-hidden">
                <div class="form-sosmed-container">

                    @if (count($data_buttonaction_desktop) > 0)
                        @foreach ($data_buttonaction_desktop as $i => $item)
                            <div class="form-sosmed-container-item">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="checkbox">
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-desktop-btnAction-{{$i}}" wire:model="data_buttonaction_desktop.{{$i}}.status" {{$item['status'] ? 'checked' : ''}}>
                                            <label for="checkbox-desktop-btnAction-{{$i}}" class="custom-control-label">Status Button</label>
                                        </div>
                                    </div>
                                    <i class="far fa-times-circle fs-5 text-danger cursor-pointer" wire:click="removeFormBtnAction(true,'{{$i}}')"></i>
                                </div>

                                <div class="checkbox mb-3">
                                    <div class="custom-checkbox custom-control">
                                        <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-blank-desktop-btnAction-{{$i}}" wire:model="data_buttonaction_desktop.{{$i}}.target" {{$item['target'] ? 'checked' : ''}}>
                                        <label for="checkbox-blank-desktop-btnAction-{{$i}}" class="custom-control-label">Target Is Blank</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Name Button" wire:model="data_buttonaction_desktop.{{$i}}.name" value="{{$item['name']}}">
                                    @if($errors->has("data_buttonaction_desktop.$i.name"))
                                        <span class="invalid-feedback d-block text-start" role="alert">
                                            <strong>{{ $errors->first("data_buttonaction_desktop.$i.name") }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Link Button" wire:model="data_buttonaction_desktop.{{$i}}.link" value="{{$item['link']}}" style="font-size: 10px">
                                    @if($errors->has("data_buttonaction_desktop.$i.link"))
                                        <span class="invalid-feedback d-block text-start" role="alert">
                                            <strong>{{ $errors->first("data_buttonaction_desktop.$i.link") }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control coloris shadowColor" placeholder="Shadow Color Button" wire:model.lazy="data_buttonaction_desktop.{{$i}}.shadow" value="{{$item['shadow']}}">
                                </div>
                                <div class="form-group">
                                    <select class="form-control" wire:model="data_buttonaction_desktop.{{$i}}.class">
                                        <option value="btn-primary" {{$item['class'] == 'btn-primary' ? 'selected' : ''}}>btn-primary</option>
                                        <option value="btn-secondary" {{$item['class'] == 'btn-secondary' ? 'selected' : ''}}>btn-secondary</option>
                                        <option value="btn-success" {{$item['class'] == 'btn-success' ? 'selected' : ''}}>btn-success</option>
                                        <option value="btn-info" {{$item['class'] == 'btn-info' ? 'selected' : ''}}>btn-info</option>
                                        <option value="btn-warning" {{$item['class'] == 'btn-warning' ? 'selected' : ''}}>btn-warning</option>
                                        <option value="btn-light" {{$item['class'] == 'btn-light' ? 'selected' : ''}}>btn-light</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control resize" placeholder="Style Button" wire:model="data_buttonaction_desktop.{{$i}}.style" style="font-size: 10px" rows="5"></textarea>
                                </div>
                                <div href="{{$item['link']}}" target="{{$item['target'] ? '_blank' : ''}}" class="btn w-100 btn-sm {{$item['class']}} btn-sample" style="{{$item['shadow'] ? 'box-shadow: inset 0 -4px 0 '.$item['shadow'].';' : ''}}{{$item['style']}}" onclick="sampleButton(this)">{{$item['name'] == '' ? 'Sample' : $item['name']}}</div>
                            </div>

                        @endforeach
                    @else
                        <div class="d-flex w-100 h-100 justify-content-center align-items-center flex-column">
                            <span>Belum ada data. silahkan klik <a href="javascript:void(0);" class="btn btn-sm btn-primary mx-3" wire:click="addFormBtnAction(true)">
                                Tambah data button action
                            </a> untuk menambahkan.</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div id="formAddbtnActionMobile" class="modal fade" wire:ignore.self data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <a href="javascript:void(0);" class="btn btn-sm btn-primary" wire:click="addFormBtnAction(false)">
                    Tambah data button action
                </a>
                <button type="button" class="btn-close" aria-label="Close" wire:click="closeFormBtnAction(false)">
                    <i class="fa fa-times fs-5 cursor-pointer"></i>
                </button>
            </div>
            <div class="modal-body mx-auto overflow-hidden">
                <div class="form-sosmed-container">

                    @if (count($data_buttonaction_mobile) > 0)
                        @foreach ($data_buttonaction_mobile as $i => $item)
                            <div class="form-sosmed-container-item">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="checkbox">
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-mobile-btnAction-{{$i}}" wire:model="data_buttonaction_mobile.{{$i}}.status" {{$item['status'] ? 'checked' : ''}}>
                                            <label for="checkbox-mobile-btnAction-{{$i}}" class="custom-control-label">Status Button</label>
                                        </div>
                                    </div>
                                    <i class="far fa-times-circle fs-5 text-danger cursor-pointer" wire:click="removeFormBtnAction(false,'{{$i}}')"></i>
                                </div>

                                <div class="checkbox mb-3">
                                    <div class="custom-checkbox custom-control">
                                        <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-blank-mobile-btnAction-{{$i}}" wire:model="data_buttonaction_mobile.{{$i}}.target" {{$item['target'] ? 'checked' : ''}}>
                                        <label for="checkbox-blank-mobile-btnAction-{{$i}}" class="custom-control-label">Target Is Blank</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Name Button" wire:model="data_buttonaction_mobile.{{$i}}.name" value="{{$item['name']}}">
                                    @if($errors->has("data_buttonaction_mobile.$i.name"))
                                        <span class="invalid-feedback d-block text-start" role="alert">
                                            <strong>{{ $errors->first("data_buttonaction_mobile.$i.name") }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Link Button" wire:model="data_buttonaction_mobile.{{$i}}.link" value="{{$item['link']}}" style="font-size: 10px">
                                    @if($errors->has("data_buttonaction_mobile.$i.link"))
                                        <span class="invalid-feedback d-block text-start" role="alert">
                                            <strong>{{ $errors->first("data_buttonaction_mobile.$i.link") }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control coloris shadowColor" placeholder="Shadow Color Button" wire:model.lazy="data_buttonaction_mobile.{{$i}}.shadow" value="{{$item['shadow']}}">
                                </div>
                                <div class="form-group">
                                    <select class="form-control" wire:model="data_buttonaction_mobile.{{$i}}.class">
                                        <option value="btn-primary" {{$item['class'] == 'btn-primary' ? 'selected' : ''}}>btn-primary</option>
                                        <option value="btn-secondary" {{$item['class'] == 'btn-secondary' ? 'selected' : ''}}>btn-secondary</option>
                                        <option value="btn-success" {{$item['class'] == 'btn-success' ? 'selected' : ''}}>btn-success</option>
                                        <option value="btn-info" {{$item['class'] == 'btn-info' ? 'selected' : ''}}>btn-info</option>
                                        <option value="btn-warning" {{$item['class'] == 'btn-warning' ? 'selected' : ''}}>btn-warning</option>
                                        <option value="btn-light" {{$item['class'] == 'btn-light' ? 'selected' : ''}}>btn-light</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control resize" placeholder="Style Button" wire:model="data_buttonaction_mobile.{{$i}}.style" style="font-size: 10px" rows="5"></textarea>
                                </div>
                                <div href="{{$item['link']}}" target="{{$item['target'] ? '_blank' : ''}}" class="btn w-100 btn-sm {{$item['class']}} btn-sample" style="{{$item['shadow'] ? 'box-shadow: inset 0 -4px 0 '.$item['shadow'].';' : ''}}{{$item['style']}}" onclick="sampleButton(this)">{{$item['name'] == '' ? 'Sample' : $item['name']}}</div>
                            </div>

                        @endforeach
                    @else
                        <div class="d-flex w-100 h-100 justify-content-center align-items-center flex-column">
                            <span>Belum ada data. silahkan klik <a href="javascript:void(0);" class="btn btn-sm btn-primary mx-3" wire:click="addFormBtnAction(false)">
                                Tambah data button action
                            </a> untuk menambahkan.</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div id="formAddSosmedDesktop" class="modal fade" wire:ignore.self data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <a href="javascript:void(0);" class="btn btn-sm btn-primary" wire:click="addFormIconSosmed(true)">
                    Tambah data icon sosmed
                </a>
                <button type="button" class="btn-close" aria-label="Close" wire:click="closeFormIconSosmed(true)">
                    <i class="fa fa-times fs-5 cursor-pointer"></i>
                </button>
            </div>
            <div class="modal-body mx-auto overflow-hidden">
                <div class="form-sosmed-container">
                    @if (count($data_iconsosmed_desktop) > 0)
                        @foreach ($data_iconsosmed_desktop as $i => $item)
                            <div class="form-sosmed-container-item">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="checkbox">
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-{{$i}}" wire:model="data_iconsosmed_desktop.{{$i}}.status" {{$item['status'] ? 'checked' : ''}}>
                                            <label for="checkbox-{{$i}}" class="custom-control-label">Status icon</label>
                                        </div>
                                    </div>
                                    <i class="far fa-times-circle fs-5 text-danger cursor-pointer" wire:click="removeFormIconSosmed(true,'{{$i}}')"></i>
                                </div>
                                <div class="form-group">
                                    <label>Name Icon</label>
                                    <input type="text" class="form-control" placeholder="Name icon" wire:model="data_iconsosmed_desktop.{{$i}}.name" value="{{$item['name']}}">
                                    @if($errors->has("data_iconsosmed_desktop.$i.name"))
                                        <span class="invalid-feedback d-block text-start" role="alert">
                                            <strong>{{ $errors->first("data_iconsosmed_desktop.$i.name") }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Link icon</label>
                                    <input type="text" class="form-control" placeholder="Link icon" wire:model="data_iconsosmed_desktop.{{$i}}.link" value="{{$item['link']}}">
                                    @if($errors->has("data_iconsosmed_desktop.$i.link"))
                                        <span class="invalid-feedback d-block text-start" role="alert">
                                            <strong>{{ $errors->first("data_iconsosmed_desktop.$i.link") }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div>
                                    <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress">
                                        <div class="form-group m-0">
                                            <label class="form-label mt-0 text-start">Image icon</label>
                                            <input class="form-control" type="file" accept="image/*" wire:model="data_iconsosmed_desktop.{{$i}}.image">
                                        </div>
                                        <div class="progress mg-b-10" x-show="isUploading">
                                            <div class="progress-bar ht-2" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" x-bind:style="`width:${progress}%`"></div>
                                        </div>
                                    </div>
                                    @if($errors->has("data_iconsosmed_desktop.$i.image"))
                                        <span class="invalid-feedback d-block text-start" role="alert">
                                            <strong>{{ $errors->first("data_iconsosmed_desktop.$i.image") }}</strong>
                                        </span>
                                    @endif
                                    @isset($item['image'])
                                        @if ($item['image'] && !$errors->has('data_iconsosmed_desktop.{{$i}}.image'))
                                            <div class="mt-3 previewImg">
                                                @if (gettype($item['image']) == "string")
                                                    <img src="{{ $item['image'] }}">
                                                @else
                                                    <img src="{{ $data_iconsosmed_desktop[$i]['image']->temporaryUrl() }}">
                                                @endif
                                            </div>
                                        @endif
                                    @endisset
                                </div>
                            </div>

                        @endforeach
                    @else
                        <div class="d-flex w-100 h-100 justify-content-center align-items-center flex-column">
                            <span>Belum ada data. silahkan klik <a href="javascript:void(0);" class="btn btn-sm btn-primary" wire:click="addFormIconSosmed(true)"> Tambah data icon sosmed </a> untuk menambahkan.</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div id="formAddSosmedMobile" class="modal fade" wire:ignore.self data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <a href="javascript:void(0);" class="btn btn-sm btn-primary" wire:click="addFormIconSosmed(false)">
                    Tambah data icon sosmed
                </a>
                <button type="button" class="btn-close" aria-label="Close" wire:click="closeFormIconSosmed(false)">
                    <i class="fa fa-times fs-5 cursor-pointer"></i>
                </button>
            </div>
            <div class="modal-body mx-auto overflow-hidden">
                <div class="form-sosmed-container">
                    @if (count($data_iconsosmed_mobile) > 0)
                        @foreach ($data_iconsosmed_mobile as $i => $item)
                            <div class="form-sosmed-container-item">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="checkbox">
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-mobile-{{$i}}" wire:model="data_iconsosmed_mobile.{{$i}}.status" {{$item['status'] ? 'checked' : ''}}>
                                            <label for="checkbox-mobile-{{$i}}" class="custom-control-label">Status icon</label>
                                        </div>
                                    </div>
                                    <i class="far fa-times-circle fs-5 text-danger cursor-pointer" wire:click="removeFormIconSosmed(false,'{{$i}}')"></i>
                                </div>
                                <div class="form-group">
                                    <label>Name Icon</label>
                                    <input type="text" class="form-control" placeholder="Name icon" wire:model="data_iconsosmed_mobile.{{$i}}.name" value="{{$item['name']}}">
                                    @if($errors->has("data_iconsosmed_mobile.$i.name"))
                                        <span class="invalid-feedback d-block text-start" role="alert">
                                            <strong>{{ $errors->first("data_iconsosmed_mobile.$i.name") }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Link icon</label>
                                    <input type="text" class="form-control" placeholder="Link icon" wire:model="data_iconsosmed_mobile.{{$i}}.link" value="{{$item['link']}}">
                                    @if($errors->has("data_iconsosmed_mobile.$i.link"))
                                        <span class="invalid-feedback d-block text-start" role="alert">
                                            <strong>{{ $errors->first("data_iconsosmed_mobile.$i.link") }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div>
                                    <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress">
                                        <div class="form-group m-0">
                                            <label class="form-label mt-0 text-start">Image icon</label>
                                            <input class="form-control" type="file" accept="image/*" wire:model="data_iconsosmed_mobile.{{$i}}.image">
                                        </div>
                                        <div class="progress mg-b-10" x-show="isUploading">
                                            <div class="progress-bar ht-2" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" x-bind:style="`width:${progress}%`"></div>
                                        </div>
                                    </div>
                                    @if($errors->has("data_iconsosmed_mobile.$i.image"))
                                        <span class="invalid-feedback d-block text-start" role="alert">
                                            <strong>{{ $errors->first("data_iconsosmed_mobile.$i.image") }}</strong>
                                        </span>
                                    @endif
                                    @isset($item['image'])
                                        @if ($item['image'] && !$errors->has('data_iconsosmed_mobile.{{$i}}.image'))
                                            <div class="mt-3 previewImg">
                                                @if (gettype($item['image']) == "string")
                                                    <img src="{{ $item['image'] }}">
                                                @else
                                                    <img src="{{ $data_iconsosmed_mobile[$i]['image']->temporaryUrl() }}">
                                                @endif
                                            </div>
                                        @endif
                                    @endisset
                                </div>
                            </div>

                        @endforeach
                    @else
                        <div class="d-flex w-100 h-100 justify-content-center align-items-center flex-column">
                            <span>Belum ada data. silahkan klik <a href="javascript:void(0);" class="btn btn-sm btn-primary" wire:click="addFormIconSosmed(false)"> Tambah data icon sosmed </a> untuk menambahkan.</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
