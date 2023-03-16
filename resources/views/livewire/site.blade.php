@section('title', 'Site')
@section('styles')
    <link href="{{asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/switcher/css/switcher.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/coloris/coloris.min.css') }}">
    <style>
        .previewImg {
            position: relative;
        }
        .removePreviewImage {
            position: absolute;
            top: 5px;
            right: 10px;
        }
        .select2-container--default .select2-selection--single .select2-selection__clear {
            position: absolute;
            right: 30px;
            color: #f34343;
        }

        .btn-type.active {
            color: #fff;
            background: var(--primary-bg-color);
            border-color: var(--primary-bg-color);
        }
        .btn-type.active .side-menu__icon,
        .btn-type:hover .side-menu__icon {
            color: #fff !important;
        }
        .w-49 {
            width: 49%;
        }


    </style>
@endsection

<div id="page-site">
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
          <span class="main-content-title mg-b-0 mg-b-lg-1">SITE MANAGER</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Apps</a></li>
                <li class="breadcrumb-item active" aria-current="page">Site</li>
            </ol>
        </div>
    </div>

    <div class="row" style="min-height: calc(100vh - 220px);">
        <div class="col-lg-4 col-xl-3">
            <div class="card h-100">
                <div class="main-content-left main-content-left-mail card-body">
                    <div class="mb-3" wire:ignore>
                        <select class="form-control select2-situs">
                            <option></option>
                            @foreach ($dataSitus as $item)
                                <option value="{{$item->id}}" status-d="{{$item->status_desktop}}" status-m="{{$item->status_mobile}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    @if ($idSitus)
                        <div class="d-flex justify-content-between mb-3">
                            @php
                                $dt = $dataSitus->where("id", $idSitus)->first();
                                $d = $dt->status_desktop;
                                $m = $dt->status_mobile;
                            @endphp
                            @if ($d)
                                <a href="javascript:void(0);" class="btn btn-sm btn-primary-light w-49 {{$typeSite == "desktop" ? 'active' : ''}} btn-type d-flex align-items-center" wire:click="getFitur('desktop')">
                                    <span class="fe fe-monitor side-menu__icon"></span>
                                    Desktop
                                </a>
                            @endif
                            @if ($m)
                                <a href="javascript:void(0);" class="btn btn-sm btn-primary-light w-49 {{$typeSite == "mobile" ? 'active' : ''}} btn-type d-flex align-items-center" wire:click="getFitur('mobile')">
                                    <span class="fe fe-smartphone side-menu__icon"></span>
                                    Mobile
                                </a>
                            @endif
                        </div>
                    @endif

                    <div class="main-mail-menu h-100" style="max-height: calc(100% - 70px - 2rem);">
                        @if (count($dataFitur) > 0)
                            <nav class="nav main-nav-column ">
                                @foreach ($dataFitur as $i => $item)
                                    <a class="btnActives nav-link thumb {{ $i + 1 == $active  ? "active" : "" }}" href="javascript:void(0);" wire:click="getFileds({{ $item['id'] }})">
                                        <i class="fe fe-disc"></i>
                                        {{ $item['name'] }}
                                    </a>

                                @endforeach
                            </nav>
                        @else
                            <div class="nullFitur d-flex align-items-center justify-content-center h-100">
                                @if ($idSitus)
                                    <span class="text-muted text-center">Tidak tersedia fitur apapun pada situs <b>{{$dt->name}}</b> dengan mode <b>{{$typeSite}}</b>. Silahkan coba pada mode <span><b>{{$typeSite == "desktop" ? "mobile" : "desktop"}}</b></span>, jika masih tidak tersedia, silahkan menghubungi bagian IT, untuk di tambahkan fitur pada situs <b>{{$dt->name}}</b>.</span>
                                @else
                                    <span class="text-muted text-center">Silahkan pilih situs untuk memunculkan daftar fitur. Jika daftar situs tidak muncul silahkan menghubungi bagian IT, untuk di tambahkan daftar situs untuk user anda.</span>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-xl-9">
            <div id="notSelected" class="d-flex justify-content-center  h-100">
                @if($filed ) 
                    @php
                    $dataLamaFormFitur = json_decode($formFitur);
                    $dataLamaFormFiturJson = json_decode($dataLamaFormFitur[0]->data);
                    @endphp
                    <form>
                        @foreach ($filed as $i => $fill)

                                @switch($fill->formElemen->typeElemen->name)
                                    @case("switch")
                                    <div class="mb-3">
                                    <h4 class="d-flex justify-content-between">
                                        {{$fill->formElemen->name}}
                                        <label class="custom-switch form-switch mb-0  p-0 cursor-pointer" data-bs-toggle="collapse" role="button" >
                                            <input type="checkbox" class="custom-switch-input" value="{{ $switch }}"  {{ $switch ? 'checked': ''}} wire:model="switch">
                                            <span class="custom-switch-indicator custom-switch-indicator"></span>
                                        </label>
                                    </h4>
                                    </div>
                                    @break

                                    @case("input")
                                        <div class="mb-3">
                                            <div>
                                                <label for="{{$fill->formElemen->name . strval($i)}}" class="form-label">{{$fill->formElemen->name}}</label>
                                                <input type="text" class="form-control @error('name') is-invalid @enderror" value="name.{{ $fill->formElemen->name }}"  id="input{{ $fill->formElemen->name }}"  wire:model="name.{{ $fill->formElemen->name }}" placeholder="{{ $fill->formElemen->placeholder }}" required >
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    
                                    @break

                                    @case("images")
                                    <div class="mb-3">
                                        <div >
                                            <label class="form-label mt-0 text-start">{{$fill->formElemen->name}}</label>
                                            @if($fill->formElemen->is_multiple) 
                                                <input class="form-control" type="file" accept="image/*" multiple wire:model="images" >
                                                @if($images)
                                                    <div class="multiple-preview  d-flex">
                                                            @foreach( $images as $i => $img)
                                                            <div class="previewImg">
                                                                @if (gettype($img) == "string")
                                                                    <img class="me-2 mt-1" style="height: 200px;" src="{{ $img }}">
                                                                @else
                                                                    <img class="me-2 mt-1" style="height: 200px;" src="{{ $img->temporaryUrl() }}">
                                                                @endif
                                                                <div class="removePreviewImage" wire:click="removeImage({{$i}})">
                                                                    <i class="fe fe-x"></i>
                                                                </div>
                                                                {{-- <img class="me-2 mt-1" style="height: 200px;" src="{{ $img }}" /> --}}
                                                            </div>
                                                            @endforeach
                                                    </div>
                                                @endif
                                            @else 
                                                <input class="form-control" type="file" accept="image/*" wire:model="image">
                                                @if($image)
                                                    @if(gettype($image) == "string") 
                                                        <img class="mt-1"  src="{{ $image }}" />

                                                    @else 
                                                        <img class="mt-1"  src="{{ $image->temporaryUrl() }}" />
                                                    @endif
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                    @break

                                    @case("textarea")
                                    <div class="mb-3">
                                        <div >
                                            <label class="form-label mt-0 text-start">{{$fill->formElemen->name}}</label>
                                            <textarea class="form-control resize" rows="5" placeholder="{{ $fill->formElemen->placeholder }}"  wire:model="textarea"  style="height: 120px;">{{ $textarea }}</textarea>
                                        </div>
                                    </div>
                                    @break

                                    @case("select")
                                    @if($fill->formElemen->optionElemen)
                                        <div class="mb-3" >
                                            <select class="form-control form-select " value={{ $selectOption }} wire:model="selectOption">
                                                <option value=""  selected hidden>Select your option</option>
                                                @foreach ($fill->formElemen->optionElemen as $item)
                                                    <option value="{{ $item->code }}">{{ $item->name }}</option>
                                                @endforeach
                                                
                                            </select>
                                        </div>
                                    @endif
                                    @break

                                    @case("checkbox")
                                    <div class="checkbox">
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" class="form-check-input" value="{{ $checkbox }}" wire:model="checkbox">
                                            <label>{{ $fill->formElemen->placeholder }}</label>
                                        </div>
                                    </div>
                                    @break

                                    @case("color")
                                    <div class="mb-3">
                                        <div class="">

                                            <label class="form-label mt-0 text-start">{{$fill->formElemen->name}}</label>
                                            <div class="clr-field" style="color: {{ $color[$fill->formElemen->name ] ? $color[$fill->formElemen->name ] : '' }};" >
                                                <button type="button" aria-labelledby="clr-open-label"></button>
                                                <input class="form-control coloris coloris-barcode" placeholder="Masukan Color" id="color" type="text" value="color.{{$fill->formElemen->name}}" wire:model="color.{{$fill->formElemen->name}}"    readonly="" data-coloris>
                                            </div>
                                        </div>
                                    </div>
                                    @break
                                     {{-- " --}}
                                    {{-- " --}}
                                    @default
                                        
                                @endswitch
                                
                                
                        @endforeach

                        @if(!empty($fill->typeFitur->name == "Icon Sosmed"))
                        
                        <div class="container d-flex flex-col flex-wrap">
                            {{-- {{ dd($data_iconsosmed) }} --}}
                            @if(count($data_iconsosmed) > 0)
                                @foreach($data_iconsosmed as $key => $data)
                                {{-- {{ dd($data) }} --}}
                                    <div class="card mx-2 p-3" style="width: 18rem;">
                                        <div class="form-sosmed-container-item">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <div class="checkbox">
                                                    <div class="custom-checkbox custom-control">
                                                        <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-{{ $key }}" {{ $data["status"] ? 'checked': ''}} data-key="{{ $key }}" onChange="checkboxOnChange(this)" />
                                                        
                                                        <label for="checkbox-{{ $key }}" class="custom-control-label">Status icon</label>
                                                    </div>
                                                </div>
                                                <i class="far fa-times-circle fs-5 text-danger cursor-pointer" wire:click="removeFormIconSosmed({{ $key }})"></i>
                                            </div>
                                            <div class="form-group">
                                                <label>Name Icon</label>
                                                <input type="text" class="form-control" placeholder="Name icon" wire:model="data_iconsosmed.{{ $key }}.icon" value="data_iconsosmed.{{ $key }}.icon" />      
                                            </div>
                                            <div class="form-group">
                                                <label>Link icon</label>
                                                <input type="text" class="form-control" placeholder="Link icon" wire:model="data_iconsosmed.{{ $key }}.link" value="data_iconsosmed.{{ $key }}.link" />
                                            </div>
                                            <div>
                                                <div
                                                    x-data="{ isUploading: false, progress: 0 }"
                                                    x-on:livewire-upload-start="isUploading = true"
                                                    x-on:livewire-upload-finish="isUploading = false"
                                                    x-on:livewire-upload-error="isUploading = false"
                                                    x-on:livewire-upload-progress="progress = $event.detail.progress"
                                                >
                                                    <div class="form-group m-0">
                                                        <label class="form-label mt-0 text-start">Image icon</label>
                                                        <input class="form-control" type="file" accept="image/*" wire:model="data_iconsosmed.{{ $key }}.image" />
                                                    </div>
                                                    <div class="progress mg-b-10" x-show="isUploading" style="display: none;">
                                                        <div class="progress-bar ht-2" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" x-bind:style="`width:${progress}%`" style="width: 0%;"></div>
                                                    </div>
                                                </div>
                                                <div class="mt-3 previewImg">
                                                    @if($data["image"])
                                                        @if (gettype($data["image"] ) == "string")
                                                            <img class="me-2 mt-1" style="height: 200px;" src="{{ $data["image"] }}">
                                                        @else
                                                            <img class="me-2 mt-1" style="height: 200px;" src="{{ $data["image"]->temporaryUrl() }}">
                                                        @endif

                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            <div class="d-flex align-items-center">
                                <a href="#" class="btn btn-primary" wire:click="addFormIconSosmed" >
                                    <i class="fa fa-plus-circle fs-5 text-white "></i>
                                </a>
                            </div>
                        </div>
                            
                        @endif

                        @if(!empty($fill->typeFitur->name == "Button Action"))
                            <div class="container d-flex flex-col flex-wrap">
                                @if(count($data_buttonaction) > 0)
                                    @foreach($data_buttonaction as $key => $data)
                                        <div class="card mx-2 p-3" style="width: 18rem;">
                                            <div class="form-sosmed-container-item">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <div class="checkbox">
                                                        <div class="custom-checkbox custom-control">
                                                            <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-btnActionStatus-{{ $key }}" wire:model="data_buttonaction.{{ $key }}.status">
                                                            <label for="checkbox-btnActionStatus-{{ $key }}" class="custom-control-label">Status Button</label>
                                                        </div>
                                                    </div>
                                                    <i class="far fa-times-circle fs-5 text-danger cursor-pointer" wire:click="removeButtonAction({{ $key }})"></i>
                                                </div>
                
                                                <div class="checkbox mb-3">
                                                    <div class="custom-checkbox custom-control">
                                                        <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-btnActionBlank-{{ $key }}" wire:model="data_buttonaction.{{ $key }}.target">
                                                        <label for="checkbox-btnActionBlank-{{ $key }}" class="custom-control-label">Target Is Blank</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" placeholder="Name Button" wire:model="data_buttonaction.{{ $key }}.name" value="">
                                                                                    </div>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" placeholder="Link Button" wire:model="data_buttonaction.{{ $key }}.link" value="" style="font-size: 10px">
                                                                                    </div>
                                                <div class="form-group">
                                                    <div class="clr-field" style="color: {{ $data["color"] }};">
                                                        <button type="button" aria-labelledby="clr-open-label"></button>
                                                        <input type="text" class="form-control coloris shadowColor" placeholder="Shadow Color Button" wire:model.lazy="data_buttonaction.{{ $key }}.color" value="#1b693c" readonly="" data-coloris>
                                                    </div>
                                                </div>
    
                                                <div class="form-group">
                                                    <select class="form-control" wire:model="data_buttonaction.{{ $key }}.class">
                                                        <option value="btn-default" selected="">btn-default</option>
                                                        <option value="btn-primary">btn-primary</option>
                                                        <option value="btn-secondary">btn-secondary</option>
                                                        <option value="btn-success">btn-success</option>
                                                        <option value="btn-info">btn-info</option>
                                                        <option value="btn-warning">btn-warning</option>
                                                        <option value="btn-light">btn-light</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    {{-- <textarea class="form-control resize" placeholder="Style Button" wire:model="data_buttonaction_desktop.0.style" style="font-size: 10px; height: 0px;" rows="5"></textarea> --}}
                                                    <textarea class="form-control resize" placeholder="Style Button" wire:model="data_buttonaction.{{ $key }}.style" style="font-size: 10px; height: 0px;" rows="5"></textarea>

                                                </div>
                                                <div href="https://" target="" class="btn w-100 btn-sm {{ $data["class"] ? $data["class"] : ""}} btn-sample" style="box-shadow: inset 0 -4px 0 {{ $data["color"] ? $data["color"]. ';' : ""  }} {{$data['style']}}" onclick="sampleButton(this)">Sample</div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                <div class="d-flex align-items-center">
                                    <a href="#" class="btn btn-primary" wire:click="addFormButtonAction" >
                                        <i class="fa fa-plus-circle fs-5 text-white "></i>
                                    </a>
                                </div>
                                
                                
                            </div>
                        @endif

                        
                        <div class="py-4 border-top">
                            <a href="#" class="btn btn-primary" wire:click="saveData">Simpan</a>
                            {{-- @foreach($test as $t)
                                <span>{{ $t }}</span>
                            @endforeach --}}
                            {{-- @php
                                var_dump();
                            @endphp --}}
                        </div>
                        
    
                            
                    </form>
                
                @endif
                
                

            </div>
        </div>
    </div>
</div>
@section('scripts')
     <!--Internal  scriptku js -->

    <script>
        
        function waitForElm(selector) {
            return new Promise(resolve => {
                if (document.querySelector(selector)) {
                    return resolve(document.querySelector(selector));
                }

                const observer = new MutationObserver(mutations => {
                    if (document.querySelector(selector)) {
                        resolve(document.querySelector(selector));
                        observer.disconnect();
                    }
                });

                observer.observe(document.body, {
                    childList: true,
                    subtree: true
                });
            });
        }

        waitForElm('.nav.main-nav-column').then((elm) => {
            $(".btnActives").click(function(e) {
                $(this).addClass('active').siblings().removeClass('active');
            });
            
            
        });

        

    

     

       
    </script>
    
    
    
    <script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="{{ asset('assets/plugins/coloris/coloris.js') }}"></script>

    <script src="{{ asset('assets/js-pages/page-site.js') }}"></script>

@endsection
