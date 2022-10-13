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
                <img src="{{asset('assets/img/brand/logo.png')}}" class="main-logo  desktop-logo" alt="logo">
                <img src="{{asset('assets/img/brand/logo-white.png')}}" class="main-logo  desktop-dark" alt="logo">
                <img src="{{asset('assets/img/brand/favicon.png')}}" class="main-logo  mobile-logo" alt="logo">
                <img src="{{asset('assets/img/brand/favicon-white.png')}}" class="main-logo  mobile-dark" alt="logo">
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
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="side-menu__icon" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M16 8a8.001 8.001 0 0 1-7.022 7.94l1.902-7.098a2.995 2.995 0 0 0 .05-1.492A2.977 2.977 0 0 0 10.237 6h5.511A8 8 0 0 1 16 8ZM0 8a8 8 0 0 0 7.927 8l1.426-5.321a2.978 2.978 0 0 1-.723.255 2.979 2.979 0 0 1-1.743-.147 2.986 2.986 0 0 1-1.043-.7L.633 4.876A7.975 7.975 0 0 0 0 8Zm5.004-.167L1.108 3.936A8.003 8.003 0 0 1 15.418 5H8.066a2.979 2.979 0 0 0-1.252.243 2.987 2.987 0 0 0-1.81 2.59ZM8 10a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"/>
                        </svg>
                        <span class="side-menu__label">Site</span>
                    </a>
                </li>
                @if (in_array(Auth::user()->id_role, [1,2]))
                    <li class="side-item side-item-category">Settings</li>
                    @if (Auth::user()->id_role == 1 || $mnUser->status)
                        <li class="slide">
                            <a class="side-menu__item" href="/user">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="side-menu__icon" viewBox="0 0 16 16">
                                    <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                    <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/>
                                    <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
                                </svg>
                                <span class="side-menu__label">Users</span>
                            </a>
                        </li>
                    @endif
                    @if (Auth::user()->id_role == 1 || $mnSiteData->status)
                        <li class="slide">
                            <a class="side-menu__item" href="/data-situs">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="side-menu__icon" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M16 8a8.001 8.001 0 0 1-7.022 7.94l1.902-7.098a2.995 2.995 0 0 0 .05-1.492A2.977 2.977 0 0 0 10.237 6h5.511A8 8 0 0 1 16 8ZM0 8a8 8 0 0 0 7.927 8l1.426-5.321a2.978 2.978 0 0 1-.723.255 2.979 2.979 0 0 1-1.743-.147 2.986 2.986 0 0 1-1.043-.7L.633 4.876A7.975 7.975 0 0 0 0 8Zm5.004-.167L1.108 3.936A8.003 8.003 0 0 1 15.418 5H8.066a2.979 2.979 0 0 0-1.252.243 2.987 2.987 0 0 0-1.81 2.59ZM8 10a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"/>
                                </svg>
                                <span class="side-menu__label">Site Data</span>
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
