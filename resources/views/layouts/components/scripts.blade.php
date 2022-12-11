<!-- BACK-TO-TOP -->
<a href="#top" id="back-to-top"><i class="las la-arrow-up"></i></a>

<!-- JQUERY JS -->
<script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>

<!-- BOOTSTRAP JS -->
<script src="{{asset('assets/plugins/bootstrap/js/popper.min.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>

<!-- IONICONS JS -->
<script src="{{asset('assets/plugins/ionicons/ionicons.js')}}"></script>

<!-- MOMENT JS -->
<script src="{{asset('assets/plugins/moment/moment.js')}}"></script>

<!-- P-SCROLL JS -->
<script src="{{asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('assets/plugins/perfect-scrollbar/p-scroll.js')}}"></script>

<!-- SIDEBAR JS -->
<script src="{{asset('assets/plugins/side-menu/sidemenu.js')}}"></script>

<!-- STICKY JS -->
<script src="{{asset('assets/js/sticky.js')}}"></script>

<!-- Chart-circle js -->
<script src="{{asset('assets/plugins/circle-progress/circle-progress.min.js')}}"></script>

<!-- RIGHT-SIDEBAR JS -->
<script src="{{asset('assets/plugins/sidebar/sidebar.js')}}"></script>
<script src="{{asset('assets/plugins/sidebar/sidebar-custom.js')}}"></script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@yield('scripts')
@livewireScripts

<!-- EVA-ICONS JS -->
<script src="{{asset('assets/plugins/eva-icons/eva-icons.min.js')}}"></script>

<!-- THEME-COLOR JS -->
<script src="{{asset('assets/js/themecolor.js')}}"></script>

<!-- CUSTOM JS -->
<script src="{{asset('assets/js/custom.js')}}"></script>

<!-- exported JS -->
<script src="{{asset('assets/js/exported.js')}}"></script>


<script>
    const cookies = {
        get: (name = null) => {
            var allCookieArray = document.cookie.split(';').reduce((a,b) => {
                var x = b.split("=");
                var key = x[0].replaceAll(" ","");
                a[key] = x[1];
                return a;
            },{})

            if (name) return allCookieArray[name];

            return allCookieArray;
        },
        remove: (dtName) => {
            dtName.forEach(e => {
                document.cookie = e+"= ; expires = Thu, 01 Jan 1970 00:00:00 GMT"
            });
        }
    }

    const loc = {
        init: (state) => {
            navigator.geolocation.getCurrentPosition(loc.success, loc.error, loc.options);
            if (state == "denied"){
                cookies.remove([
                    "latitude",
                    "longitude",
                    "accuracy",
                ])
            }
        },
        tmpErr: () => {
            return `
                <div class="alert alert-danger mg-b-0 alert-dismissible fade show mb-3" role="alert">
                    <span style="margin-right: 10px">Silahkan aktifkan layanan lokasi, untuk melanjutkan</span>
                    <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            `;
        },
        options: {
            enableHighAccuracy: true,
            timeout: 5000,
            maximumAge: 0
        },
        success: (pos) => {
            // loc.showError(false);
            var expTime = new Date();
            expTime.setHours(expTime.getHours()+5);
            const crd = pos.coords;
            document.cookie = "latitude="+crd.latitude+"; expires="+expTime.toGMTString()+"; path=/";
            document.cookie = "longitude="+crd.longitude+"; expires="+expTime.toGMTString()+"; path=/";
            document.cookie = "accuracy="+crd.accuracy+"; expires="+expTime.toGMTString()+"; path=/";
        },
        error: (err) => {
            // loc.showError(true);
            console.warn(`ERROR(${err.code}): ${err.message}`);
        },
        showError: (show) => {
            var target = $("#errorlocation");
            if (target.find(".alert").length == 0) target.append(loc.tmpErr());

            if (show) {
                target.removeClass("d-none");
            }else{
                target.addClass("d-none");
            }

        }

    }

    navigator.permissions.query({ name: 'geolocation' }).then((e) => {
        loc.init(e.state);
        e.onchange = () => loc.init(e.state);
    });
</script>
