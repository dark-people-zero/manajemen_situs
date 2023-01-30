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
                            <nav class="nav main-nav-column">
                                @foreach ($dataFitur as $i => $item)

                                    <a class="nav-link thumb {{$i == 0 ? 'active' : ''}}" href="javascript:void(0);" wire:click="getFileds({{ $item['id'] }})">
                                        <i class="fe fe-disc"></i>
                                        {{$item['name']}}
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
                    <form>
                        @foreach ($filed as $i => $fill)
                        {{-- {{ dd($fill->toJson()) }} --}}
                        {{-- {{ $fill->formElemen }} --}}
                        


                                @switch($fill->formElemen->typeElemen->name)
                                    @case("input")
                                    <div class="mb-3">
                                        <div>
                                            <label for="{{$fill->formElemen->name}}" class="form-label">{{$fill->formElemen->name}}</label>
                                            <input type="text" class="form-control" id="{{$fill->formElemen->name}}" wire:model="name" placeholder="{{ $fill->formElemen->placeholder }}">
                                        </div>
                                    </div>
                                    @break

                                    @case("images")
                                    <div class="mb-3">
                                        <div >
                                            <label class="form-label mt-0 text-start">{{$fill->formElemen->name}}</label>
                                            @if($fill->formElemen->is_multiple) 
                                                <input class="form-control" type="file" accept="image/*" multiple wire:model="image" >

                                            @else 
                                                <input class="form-control" type="file" accept="image/*" wire:model="image">

                                            @endif
                                            @if($image)
                                                @if(gettype($image) == "array")
                                                    <div class="multiple-preview  d-flex">
                                                        @foreach($image as $i => $img)
                                                            <div class="previewImg">
                                                                <img class="me-2 mt-1" style="height: 200px;" src="{{ $img->temporaryUrl() }}" />

                                                                <div class="removePreviewImage" wire:click="removeImage({{$i}})">
                                                                    <i class="fe fe-x"></i>
                                                                </div>

                                                            </div>
                                                            
                                                        @endforeach
                                                    </div>
                                                @else 
                                                    <img class="mt-1"  src="{{ $image->temporaryUrl() }}" />
                                                @endif
                                            @endif
                                        
                                        </div>
                                    </div>
                                    @break

                                    @case("textarea")
                                    <div class="mb-3">
                                        <div >
                                            <label class="form-label mt-0 text-start">{{$fill->formElemen->name}}</label>
                                            <textarea class="form-control resize" rows="5" placeholder="{{ $fill->formElemen->placeholder }}" wire:model="textarea"  style="height: 44px;"></textarea>
                                        </div>
                                    </div>
                                    @break

                                    @case("select")
                                    @if($fill->formElemen->optionElemen)
                                        <div class="mb-3" >
                                            <select class="form-control form-select " wire:model="selectOption">
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
                                            <input type="checkbox" class="form-check-input" wire:model="checkbox">
                                            <label>{{ $fill->formElemen->placeholder }}</label>
                                        </div>
                                    </div>
                                    @break

                                    @case("switch")
                                    <div class="mb-3">
                                    <h4 class="d-flex justify-content-between">
                                        {{$fill->formElemen->name}}
                                        <label class="custom-switch form-switch mb-0  p-0 cursor-pointer" data-bs-toggle="collapse" role="button" >
                                            <input type="checkbox" class="custom-switch-input"  checked="" wire:model="switch">
                                            <span class="custom-switch-indicator custom-switch-indicator"></span>
                                        </label>
                                    </h4>
                                    </div>
                                    @break

                                    @case("color")
                                    <div class="mb-3">
                                    <div class="">
                                        <label class="form-label mt-0 text-start">{{$fill->formElemen->name}}</label>
                                        <div class="clr-field" style="color:#fff;" >
                                            <button type="button" aria-labelledby="clr-open-label"></button>
                                            <input class="form-control coloris coloris-barcode" placeholder="Masukan Color" type="text" wire:model="color" value="{{ $color }}" readonly="" data-coloris></div>
                                    </div>
                                    </div>
                                    @break
                                    
                                    @default
                                        
                                @endswitch

                              {{-- <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Password</label>
                                <input type="password" class="form-control" id="exampleInputPassword1">
                              </div> --}}
                        @endforeach
                        <div class="py-4 border-top">
                            <a href="#" class="btn btn-primary" wire:click="saveData">Simpan</a>
                        </div>
    
                            
                    </form>
                
                @endif
                

            </div>
        </div>
    </div>
</div>

@section('scripts')
    <!--Internal  Select2 js -->
    <script>
        document.addEventListener('coloris:pick', e => {
            setTimeout(() => {
                document.querySelector('.clr-field').style.color = e.detail.color;
                
            }, 1000);

        });


    </script>
    <script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="{{ asset('assets/plugins/coloris/coloris.js') }}"></script>

    <script src="{{ asset('assets/js-pages/page-site.js') }}"></script>

@endsection
