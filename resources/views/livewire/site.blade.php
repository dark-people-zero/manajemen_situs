@section('title', 'Site')
@section('styles')
    <link href="{{asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/switcher/css/switcher.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/coloris/coloris.min.css') }}">
    <style>
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
        .btn-type.active svg,
        .btn-type:hover svg {
            fill: #fff !important;
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
                                <a href="javascript:void(0);" class="btn btn-sm btn-primary-light w-49 {{$typeSite == "desktop" ? 'active' : ''}} btn-type" wire:click="getFitur('desktop')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pc-display-horizontal side-menu__icon" viewBox="0 0 16 16">
                                        <path d="M1.5 0A1.5 1.5 0 0 0 0 1.5v7A1.5 1.5 0 0 0 1.5 10H6v1H1a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1h-5v-1h4.5A1.5 1.5 0 0 0 16 8.5v-7A1.5 1.5 0 0 0 14.5 0h-13Zm0 1h13a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-7a.5.5 0 0 1 .5-.5ZM12 12.5a.5.5 0 1 1 1 0 .5.5 0 0 1-1 0Zm2 0a.5.5 0 1 1 1 0 .5.5 0 0 1-1 0ZM1.5 12h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1ZM1 14.25a.25.25 0 0 1 .25-.25h5.5a.25.25 0 1 1 0 .5h-5.5a.25.25 0 0 1-.25-.25Z"></path>
                                    </svg>
                                    Desktop
                                </a>
                            @endif
                            @if ($m)
                                <a href="javascript:void(0);" class="btn btn-sm btn-primary-light w-49 {{$typeSite == "mobile" ? 'active' : ''}} btn-type" wire:click="getFitur('mobile')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-phone side-menu__icon" viewBox="0 0 16 16">
                                        <path d="M11 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h6zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H5z"></path>
                                        <path d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"></path>
                                    </svg>
                                    Mobile
                                </a>
                            @endif
                        </div>
                    @endif

                    <div class="main-mail-menu h-100" style="max-height: calc(100% - 70px - 2rem);">
                        @if (count($dataFitur) > 0)
                            <nav class="nav main-nav-column">
                                {{-- @foreach ($dataFitur as $i => $item)
                                    <a class="nav-link thumb {{$i == 0 ? 'active' : ''}}" href="javascript:void(0);">
                                        <i class="fe fe-disc"></i>
                                        {{$item->name}}
                                    </a>
                                @endforeach --}}
                                <a class="nav-link thumb" href="javascript:void(0);"><i class="fe fe-music"></i> Music</a>
                                <a class="nav-link thumb" href="javascript:void(0);"><i class="fe fe-video"></i> Videos</a>
                                <a class="nav-link thumb" href="javascript:void(0);"><i class="fe fe-smartphone"></i> APKS</a>
                                <a class="nav-link thumb" href="javascript:void(0);"><i class="fe fe-download"></i>
                                    Downloads</a>
                                <a class="nav-link thumb" href="javascript:void(0);"><i class="fe fe-heart"></i> Favourites</a>
                                <a class="nav-link thumb" href="javascript:void(0);"><i class="fe fe-eye"></i> Hidden FIles</a>
                                <a class="nav-link thumb" href="javascript:void(0);"><i class="fe fe-share"></i> Transfer files
                                </a>
                                <a class="nav-link thumb" href="javascript:void(0);"><i class="fe fe-database"></i> Google
                                    Drive</a>
                                <a class="nav-link thumb" href="javascript:void(0);"><i class="fe fe-airplay"></i> FTP</a>
                                <a class="nav-link thumb" href="javascript:void(0);"><i class="fe fe-lock"></i> Private
                                    FIles</a>
                                <a class="nav-link thumb" href="javascript:void(0);"><i class="fe fe-wind"></i> Deep Clean</a>
                                <a class="nav-link thumb" href="javascript:void(0);"><i class="fe fe-grid "></i> More</a>
                            </nav>
                        @else
                            <div class="nullFitur d-flex align-items-center justify-content-center h-100">
                                @if ($idSitus)
                                    <span class="text-muted text-center">Tidak tersedia fitur apapun pada situs <b>{{$dt->name}}</b> dengan mode <b>{{$typeSite}}</b>. Silahkan coba pada mode <b>{{$typeSite == "desktop" ? "mobile" : "desktop"}}</b>, jika masih tidak tersedia, silahkan menghubungi bagian IT, untuk di tambahkan fitur pada situs <b>{{$dt->name}}</b>.</span>
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
            <div id="notSelected" class="d-flex justify-content-center align-items-center h-100">
                <span class="text-muted">Silahkan pilih fitur untuk memunculkan form.</span>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    <!--Internal  Select2 js -->
    <script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="{{ asset('assets/plugins/coloris/coloris.js') }}"></script>

    <script src="{{ asset('assets/js-pages/page-site.js') }}"></script>

@endsection
