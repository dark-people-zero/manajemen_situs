<!-- main-sidebar -->

@php
    $mnUser = Auth::user()->aksesMenu->where('name', 'User')->first();
    $mnSite = Auth::user()->aksesMenu->where('name', 'Site')->first();
    $mnSiteData = Auth::user()->aksesMenu->where('name', 'Site Data')->first();
@endphp

<div class="sticky">
    <aside class="app-sidebar">
        <div class="main-sidebar-header active">
            <a class="header-logo active" href="{{url('index')}}">
                <img src="{{asset('assets/img/brand/logo2.png')}}" class="main-logo  desktop-logo" alt="logo">
                <img src="{{asset('assets/img/brand/logo-white2.png')}}" class="main-logo  desktop-dark" alt="logo">
                <img src="{{asset('assets/img/brand/favicon2.png')}}" class="main-logo  mobile-logo" alt="logo">
                <img src="{{asset('assets/img/brand/favicon-white2.png')}}" class="main-logo  mobile-dark" alt="logo">
            </a>
        </div>
        <div class="main-sidemenu">
            <div class="slide-left disabled" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"/>
                </svg>
            </div>
            <ul class="side-menu">
                <li class="side-item side-item-category">App</li>
                <li class="slide">
                    <a class="side-menu__item" href="/">
                        <i class="fe fe-layout side-menu-icon"></i>
                        <span class="side-menu__label">Site Manager</span>
                    </a>
                </li>
                @if (Auth::user()->role->role_id != 3)
                    <li class="side-item side-item-category">Settings</li>
                    @if (in_array(Auth::user()->role->role_id, [1,4]) || $mnUser->status)
                        <li class="slide">
                            <a class="side-menu__item" href="/user">
                                <i class="fe fe-users side-menu-icon"></i>
                                <span class="side-menu__label">Users</span>
                            </a>
                        </li>
                    @endif
                    @if (in_array(Auth::user()->role->role_id, [1,4]) || $mnSiteData->status)
                        <li class="slide">
                            <a class="side-menu__item" href="/data-situs">
                                <i class="fe fe-layers side-menu-icon"></i>
                                <span class="side-menu__label">Site Data</span>
                            </a>
                        </li>
                    @endif

                    @if (env('AUTO_PULL_ACTIVE') && Auth::user()->role->role_id == 1)
                        <li class="slide">
                            <a href="#" class="side-menu__item">
                                <i class="fe fe-clipboard side-menu-icon"></i>
                                <span class="side-menu__label">Form Fitur</span>
                            </a>
                        </li>

                        <li class="slide">
                            <a href="/gitpull" class="side-menu__item">
                                <i class="fe fe-hard-drive side-menu-icon"></i>
                                <span class="side-menu__label">Update Server</span>
                            </a>
                        </li>

                        <li class="slide">
                            <a href="#" class="side-menu__item">
                                <i class="fe fe-sidebar side-menu-icon"></i>
                                <span class="side-menu__label">Form Element</span>
                            </a>
                        </li>
                    @endif
                @endif

            </ul>
            <div class="slide-right" id="slide-right">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"/>
                </svg>
            </div>
        </div>
    </aside>
</div>
<!-- main-sidebar -->
