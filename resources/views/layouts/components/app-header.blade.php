<!-- main-header -->
<div class="main-header side-header sticky nav nav-item">
    <div class=" main-container container-fluid">
        <div class="main-header-left ">
            <div class="main-header-center ms-4 d-block form-group">
                <div class="title">
                    Manajemen Situs SMB
                </div>
            </div>
        </div>
        <div class="main-header-center justify-content-center">
            <div class="d-flex" style="margin-right: 135px;">
                <a href="javascript:void(0);" class="header-icon-svgs-prev desktop {{$prevActive == 'desktop' ? 'active' : ''}}" wire:click="changePrev(true)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-pc-display" viewBox="0 0 24 24">
                        <path d="M8 1a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H9a1 1 0 0 1-1-1V1Zm1 13.5a.5.5 0 1 0 1 0 .5.5 0 0 0-1 0Zm2 0a.5.5 0 1 0 1 0 .5.5 0 0 0-1 0ZM9.5 1a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5ZM9 3.5a.5.5 0 0 0 .5.5h5a.5.5 0 0 0 0-1h-5a.5.5 0 0 0-.5.5ZM1.5 2A1.5 1.5 0 0 0 0 3.5v7A1.5 1.5 0 0 0 1.5 12H6v2h-.5a.5.5 0 0 0 0 1H7v-4H1.5a.5.5 0 0 1-.5-.5v-7a.5.5 0 0 1 .5-.5H7V2H1.5Z"/>
                    </svg>
                </a>
                <a href="javascript:void(0);" class="header-icon-svgs-prev ms-3 mobile {{$prevActive == 'mobile' ? 'active' : ''}}" wire:click="changePrev(false)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-phone" viewBox="0 0 24 24">
                        <path d="M11 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h6zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H5z"/>
                        <path d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                        </svg>
                </a>
            </div>
        </div>
        <div class="main-header-right">
            <button class="navbar-toggler navresponsive-toggler d-md-none ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent-4" aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon fe fe-more-vertical "></span>
            </button>
            <div class="d-flex align-items-center">
                <a class="new nav-link theme-layout nav-link-bg layout-setting me-3" >
                    <span class="dark-layout">
                        <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" width="24" height="24" viewBox="0 0 24 24">
                            <path d="M20.742 13.045a8.088 8.088 0 0 1-2.077.271c-2.135 0-4.14-.83-5.646-2.336a8.025 8.025 0 0 1-2.064-7.723A1 1 0 0 0 9.73 2.034a10.014 10.014 0 0 0-4.489 2.582c-3.898 3.898-3.898 10.243 0 14.143a9.937 9.937 0 0 0 7.072 2.93 9.93 9.93 0 0 0 7.07-2.929 10.007 10.007 0 0 0 2.583-4.491 1.001 1.001 0 0 0-1.224-1.224zm-2.772 4.301a7.947 7.947 0 0 1-5.656 2.343 7.953 7.953 0 0 1-5.658-2.344c-3.118-3.119-3.118-8.195 0-11.314a7.923 7.923 0 0 1 2.06-1.483 10.027 10.027 0 0 0 2.89 7.848 9.972 9.972 0 0 0 7.848 2.891 8.036 8.036 0 0 1-1.484 2.059z"/>
                        </svg>
                    </span>
                    <span class="light-layout">
                        <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" width="24" height="24" viewBox="0 0 24 24">
                            <path d="M6.993 12c0 2.761 2.246 5.007 5.007 5.007s5.007-2.246 5.007-5.007S14.761 6.993 12 6.993 6.993 9.239 6.993 12zM12 8.993c1.658 0 3.007 1.349 3.007 3.007S13.658 15.007 12 15.007 8.993 13.658 8.993 12 10.342 8.993 12 8.993zM10.998 19h2v3h-2zm0-17h2v3h-2zm-9 9h3v2h-3zm17 0h3v2h-3zM4.219 18.363l2.12-2.122 1.415 1.414-2.12 2.122zM16.24 6.344l2.122-2.122 1.414 1.414-2.122 2.122zM6.342 7.759 4.22 5.637l1.415-1.414 2.12 2.122zm13.434 10.605-1.414 1.414-2.122-2.122 1.414-1.414z"/>
                        </svg>
                    </span>
                </a>
                <a class="new nav-link full-screen-link fullscreen-button me-3" href="javascript:void(0);">
                    <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" width="24" height="24" viewBox="0 0 24 24">
                        <path d="M5 5h5V3H3v7h2zm5 14H5v-5H3v7h7zm11-5h-2v5h-5v2h7zm-2-4h2V3h-7v2h5z"/>
                    </svg>
                </a>
                <a class="demo-icon new nav-link" href="javascript:void(0);" data-bs-toggle="sidebar-right" data-bs-target=".sidebar-right" style="padding-left: 0 !important; margin-left:0 !important">
                    <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs fa-spin" width="24" height="24" viewBox="0 0 24 24"><path d="M12 16c2.206 0 4-1.794 4-4s-1.794-4-4-4-4 1.794-4 4 1.794 4 4 4zm0-6c1.084 0 2 .916 2 2s-.916 2-2 2-2-.916-2-2 .916-2 2-2z"></path><path d="m2.845 16.136 1 1.73c.531.917 1.809 1.261 2.73.73l.529-.306A8.1 8.1 0 0 0 9 19.402V20c0 1.103.897 2 2 2h2c1.103 0 2-.897 2-2v-.598a8.132 8.132 0 0 0 1.896-1.111l.529.306c.923.53 2.198.188 2.731-.731l.999-1.729a2.001 2.001 0 0 0-.731-2.732l-.505-.292a7.718 7.718 0 0 0 0-2.224l.505-.292a2.002 2.002 0 0 0 .731-2.732l-.999-1.729c-.531-.92-1.808-1.265-2.731-.732l-.529.306A8.1 8.1 0 0 0 15 4.598V4c0-1.103-.897-2-2-2h-2c-1.103 0-2 .897-2 2v.598a8.132 8.132 0 0 0-1.896 1.111l-.529-.306c-.924-.531-2.2-.187-2.731.732l-.999 1.729a2.001 2.001 0 0 0 .731 2.732l.505.292a7.683 7.683 0 0 0 0 2.223l-.505.292a2.003 2.003 0 0 0-.731 2.733zm3.326-2.758A5.703 5.703 0 0 1 6 12c0-.462.058-.926.17-1.378a.999.999 0 0 0-.47-1.108l-1.123-.65.998-1.729 1.145.662a.997.997 0 0 0 1.188-.142 6.071 6.071 0 0 1 2.384-1.399A1 1 0 0 0 11 5.3V4h2v1.3a1 1 0 0 0 .708.956 6.083 6.083 0 0 1 2.384 1.399.999.999 0 0 0 1.188.142l1.144-.661 1 1.729-1.124.649a1 1 0 0 0-.47 1.108c.112.452.17.916.17 1.378 0 .461-.058.925-.171 1.378a1 1 0 0 0 .471 1.108l1.123.649-.998 1.729-1.145-.661a.996.996 0 0 0-1.188.142 6.071 6.071 0 0 1-2.384 1.399A1 1 0 0 0 13 18.7l.002 1.3H11v-1.3a1 1 0 0 0-.708-.956 6.083 6.083 0 0 1-2.384-1.399.992.992 0 0 0-1.188-.141l-1.144.662-1-1.729 1.124-.651a1 1 0 0 0 .471-1.108z"></path></svg>
                </a>

                @php
                    $user = auth()->user();
                    $mnUser = $user->aksesMenu->where('name', 'User')->first();
                    $mnSiteData = $user->aksesMenu->where('name', 'Site Data')->first();
                @endphp
                <div class="header-icons main-profile-menu">
                    <a class="new nav-link profile-user d-flex" href="" data-bs-toggle="dropdown" data-name="{{Auth::user()->name}}">
                        <img alt="" src="https://ui-avatars.com/api/?name={{Auth::user()->name}}&bold=true" class="img-profile">
                    </a>
                    <div class="dropdown-menu mt-2">
                        <div class="menu-header-content p-3 border-bottom">
                            <div class="d-flex wd-100p">
                                <div class="main-img-user">
                                    <img alt="" src="https://ui-avatars.com/api/?name={{Auth::user()->name}}&bold=true" class="img-profile">
                                </div>
                                <div class="ms-3 my-auto">
                                    <h6 class="tx-15 font-weight-semibold mb-0">{{Auth::user()->name}}</h6>
                                    <span class="dropdown-title-text subtext op-6  tx-12">{{Auth::user()->role->name}}</span>
                                </div>
                            </div>
                        </div>
                        @if ($user->id_role == 1 || $mnUser->status)
                            <a class="dropdown-item" href="/user">
                                <i class="fa fa-users"></i>Users
                            </a>
                        @endif

                        @if ($user->id_role == 1 || $mnSiteData->status)
                            <a class="dropdown-item" href="/data-situs">
                                <i class="fab fa-chrome"></i>Site Data
                            </a>
                        @endif

                        <a class="dropdown-item" href="password/reset/{{Str::random(20)}}">
                            <i class="far fa-sun"></i>  Change Password
                        </a>
                        <a class="dropdown-item" href="javascript:void(0);" onclick="$('#formLogout').submit()">
                            <i class="far fa-arrow-alt-circle-left"></i> Sign Out
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form action="/logout" method="post" id="formLogout">@csrf</form>
</div>
<!-- /main-header -->
