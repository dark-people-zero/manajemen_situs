(() => {
    function e(t) {
        return (
            (e =
                "function" == typeof Symbol &&
                "symbol" == typeof Symbol.iterator
                    ? function (e) {
                          return typeof e;
                      }
                    : function (e) {
                          return e &&
                              "function" == typeof Symbol &&
                              e.constructor === Symbol &&
                              e !== Symbol.prototype
                              ? "symbol"
                              : typeof e;
                      }),
            e(t)
        );
    }
    $(function () {
        "use strict";
        function t() {
            var e = $(' form[role="search"].active');
            e.find("input").val(""),
                e.removeClass("active"),
                $("body").removeClass("search-open");
        }
        $("#global-loader").fadeOut("slow"),
            $(document).on("click", "a[data-theme]", function () {
                $("head link#theme").attr("href", $(this).data("theme")),
                    $(this)
                        .toggleClass("active")
                        .siblings()
                        .removeClass("active");
            }),
            $(document).on("click", ".fullscreen-button", function () {
                $("html").addClass("fullscreen-button"),
                    (void 0 !== document.fullScreenElement &&
                        null === document.fullScreenElement) ||
                    (void 0 !== document.msFullscreenElement &&
                        null === document.msFullscreenElement) ||
                    (void 0 !== document.mozFullScreen &&
                        !document.mozFullScreen) ||
                    (void 0 !== document.webkitIsFullScreen &&
                        !document.webkitIsFullScreen)
                        ? document.documentElement.requestFullScreen
                            ? document.documentElement.requestFullScreen()
                            : document.documentElement.mozRequestFullScreen
                            ? document.documentElement.mozRequestFullScreen()
                            : document.documentElement.webkitRequestFullScreen
                            ? document.documentElement.webkitRequestFullScreen(
                                  Element.ALLOW_KEYBOARD_INPUT
                              )
                            : document.documentElement.msRequestFullscreen &&
                              document.documentElement.msRequestFullscreen()
                        : ($("html").removeClass("fullscreen-button"),
                          document.cancelFullScreen
                              ? document.cancelFullScreen()
                              : document.mozCancelFullScreen
                              ? document.mozCancelFullScreen()
                              : document.webkitCancelFullScreen
                              ? document.webkitCancelFullScreen()
                              : document.msExitFullscreen &&
                                document.msExitFullscreen());
            }),
            $(".cover-image").each(function () {
                var t = $(this).attr("data-image-src");
                "undefined" !== e(t) &&
                    !1 !== t &&
                    $(this).css("background", "url(" + t + ") center center");
            }),
            $(window).on("scroll", function (e) {
                $(this).scrollTop() > 0
                    ? $("#back-to-top").fadeIn("slow")
                    : $("#back-to-top").fadeOut("slow");
            }),
            $(document).on("click", "#back-to-top", function (e) {
                return $("html").animate({ scrollTop: 0 }, 0), !1;
            }),
            $(".toast").toast(),
            $(window).on("scroll", function (e) {
                $(window).scrollTop() >= 66
                    ? $("main-header").addClass("fixed-header")
                    : $(".main-header").removeClass("fixed-header");
            }),
            $('body, .main-header form[role="search"] button[type="reset"]').on(
                "click keyup",
                function (e) {
                    ((27 == e.which &&
                        $('.main-header form[role="search"]').hasClass(
                            "active"
                        )) ||
                        "reset" == $(e.currentTarget).attr("type")) &&
                        t();
                }
            ),
            $(document).on(
                "click",
                ' form[role="search"]:not(.active) button[type="submit"]',
                function (e) {
                    e.preventDefault();
                    var t = $(this).closest("form"),
                        n = t.find("input");
                    t.addClass("active"),
                        n.focus(),
                        $("body").addClass("search-open");
                }
            ),
            $(document).on(
                "click",
                ' form[role="search"].active button[type="submit"]',
                function (e) {
                    e.preventDefault();
                    var n = $(this).closest("form").find("input");
                    $("#showSearchTerm").text(n.val()),
                        t(),
                        $("body").addClass("search-open");
                }
            ),
            $(document).on(
                "click",
                ' form[role="search"].active button[type="reset"]',
                function (e) {
                    e.preventDefault(), $("body").removeClass("search-open");
                    var n = $(this).closest("form").find("input");
                    $("#showSearchTerm").text(n.val()), t();
                }
            ),
            $(".thumb").click(function () {
                $(this).hasClass("active") ||
                    ($(".thumb.active").removeClass("active"),
                    $(this).addClass("active"));
            });
        var n = "div.card";
        $(document).on("click", '[data-bs-toggle="card-remove"]', function (e) {
            return $(this).closest(n).remove(), e.preventDefault(), !1;
        }),
            $(document).on(
                "click",
                '[data-bs-toggle="card-collapse"]',
                function (e) {
                    return (
                        $(this).closest(n).toggleClass("card-collapsed"),
                        e.preventDefault(),
                        !1
                    );
                }
            ),
            $(document).on(
                "click",
                '[data-bs-toggle="card-fullscreen"]',
                function (e) {
                    return (
                        $(this)
                            .closest(n)
                            .toggleClass("card-fullscreen")
                            .removeClass("card-collapsed"),
                        e.preventDefault(),
                        !1
                    );
                }
            ),
            $(".main-navbar .with-sub").on("click", function (e) {
                e.preventDefault(),
                    $(this).parent().toggleClass("show"),
                    $(this).parent().siblings().removeClass("show");
            }),
            $(".dropdown-menu .main-header-arrow").on("click", function (e) {
                e.preventDefault(),
                    $(this).closest(".dropdown").removeClass("show");
            }),
            $("#mainNavShow, #azNavbarShow").on("click", function (e) {
                e.preventDefault(), $("body").addClass("main-navbar-show");
            }),
            $("#mainContentLeftShow").on("click touch", function (e) {
                e.preventDefault(),
                    $("body").addClass("main-content-left-show");
            }),
            $("#mainContentLeftHide").on("click touch", function (e) {
                e.preventDefault(),
                    $("body").removeClass("main-content-left-show");
            }),
            $("#mainContentBodyHide").on("click touch", function (e) {
                e.preventDefault(),
                    $("body").removeClass("main-content-body-show");
            }),
            $("body").append('<div class="main-navbar-backdrop"></div>'),
            $(".main-navbar-backdrop").on("click touchstart", function () {
                $("body").removeClass("main-navbar-show");
            }),
            $(document).on("click touchstart", function (e) {
                (e.stopPropagation(),
                $(e.target).closest(".main-header .dropdown").length ||
                    $(".main-header .dropdown").removeClass("show"),
                window.matchMedia("(min-width: 992px)").matches)
                    ? ($(e.target).closest(".main-navbar .nav-item").length ||
                          $(".main-navbar .show").removeClass("show"),
                      $(e.target).closest(".main-header-menu .nav-item")
                          .length ||
                          $(".main-header-menu .show").removeClass("show"),
                      $(e.target).hasClass("main-menu-sub-mega") &&
                          $(".main-header-menu .show").removeClass("show"))
                    : $(e.target).closest("#mainMenuShow").length ||
                      $(e.target).closest(".main-header-menu").length ||
                      $("body").removeClass("main-header-menu-show");
            }),
            $("#mainMenuShow").on("click", function (e) {
                e.preventDefault(),
                    $("body").toggleClass("main-header-menu-show");
            }),
            $(".main-header-menu .with-sub").on("click", function (e) {
                e.preventDefault(),
                    $(this).parent().toggleClass("show"),
                    $(this).parent().siblings().removeClass("show");
            }),
            $(".main-header-menu-header .close").on("click", function (e) {
                e.preventDefault(),
                    $("body").removeClass("main-header-menu-show");
            }),
            $(".card-header-right .card-option .fe fe-chevron-left").on(
                "click",
                function () {
                    var e = $(this);
                    e.hasClass("icofont-simple-right")
                        ? e.parents(".card-option").animate({ width: "35px" })
                        : e.parents(".card-option").animate({ width: "180px" }),
                        $(this)
                            .toggleClass("fe fe-chevron-right")
                            .fadeIn("slow");
                }
            );
        [].slice
            .call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            .map(function (e) {
                return new bootstrap.Tooltip(e);
            }),
            [].slice
                .call(document.querySelectorAll('[data-bs-toggle="popover"]'))
                .map(function (e) {
                    return new bootstrap.Popover(e);
                });
        $(document).ready(function () {
            $(".horizontalMenu-list li a").each(function () {
                var e = window.location.href.split(/[?#]/)[0];
                this.href == e &&
                    ($(this).addClass("active"),
                    $(this).parent().addClass("active"),
                    $(this).parent().parent().prev().addClass("active"),
                    $(this).parent().parent().prev().click());
            });
        }),
            $(document).ready(function () {
                $(".horizontalMenu-list li a").each(function () {
                    var e = window.location.href.split(/[?#]/)[0];
                    this.href == e &&
                        ($(this).addClass("active"),
                        $(this).parent().addClass("active"),
                        $(this).parent().parent().prev().addClass("active"),
                        $(this).parent().parent().prev().click());
                }),
                    $(".horizontal-megamenu li a").each(function () {
                        var e = window.location.href.split(/[?#]/)[0];
                        this.href == e &&
                            ($(this).addClass("active"),
                            $(this).parent().addClass("active"),
                            $(this)
                                .parent()
                                .parent()
                                .parent()
                                .parent()
                                .parent()
                                .parent()
                                .parent()
                                .prev()
                                .addClass("active"),
                            $(this).parent().parent().prev().click());
                    }),
                    $(".horizontalMenu-list .sub-menu .sub-menu li a").each(
                        function () {
                            var e = window.location.href.split(/[?#]/)[0];
                            this.href == e &&
                                ($(this).addClass("active"),
                                $(this).parent().addClass("active"),
                                $(this)
                                    .parent()
                                    .parent()
                                    .parent()
                                    .parent()
                                    .prev()
                                    .addClass("active"),
                                $(this).parent().parent().prev().click());
                        }
                    );
            }),
            $(".cover-image").each(function () {
                var t = $(this).attr("data-image-src");
                "undefined" !== e(t) &&
                    !1 !== t &&
                    $(this).css("background", "url(" + t + ") center center");
            }),
            $(".layout-setting").on("click", function (e) {
                document
                    ? $("body").toggleClass("dark-theme")
                    : ($("body").removeClass("dark-theme"),
                      $("body").addClass("light-theme"));
            }),
            $(".default-menu").on("click", function () {
                document.body.clientWidth >= 992 &&
                    $("body").removeClass("sidenav-toggled");
            }),
            (function () {
                if ($("body").hasClass("rtl")) {
                    var e;
                    $("body").addClass("rtl"),
                        $("html[lang=en]").attr("dir", "rtl"),
                        localStorage.setItem("rtl", "True"),
                        $("head link#style").attr("href", $(this)),
                        null === (e = document.getElementById("style")) ||
                            void 0 === e ||
                            e.setAttribute(
                                "href",
                                "http://127.0.0.1:8000/assets/plugins/bootstrap/css/bootstrap.rtl.min.css"
                            );
                    var t = $(".owl-carousel");
                    $.each(t, function (e, t) {
                        var n = $(t).data("owl.carousel");
                        (n.settings.rtl = !0),
                            (n.options.rtl = !0),
                            $(t).trigger("refresh.owl.carousel");
                    });
                } else {
                    var n;
                    $("body").removeClass("rtl"),
                        localStorage.setItem("rtl", "false"),
                        $("head link#style").attr("href", $(this)),
                        null === (n = document.getElementById("style")) ||
                            void 0 === n ||
                            n.setAttribute(
                                "href",
                                "http://127.0.0.1:8000/assets/plugins/bootstrap/css/bootstrap.min.css"
                            );
                }
                $("body").hasClass("horizontal") &&
                    ($("body").addClass("horizontal"),
                    $(".main-content").addClass("horizontal-content"),
                    $(".main-content").removeClass("app-content"),
                    $(".main-container").addClass("container"),
                    $(".main-container").removeClass("container-fluid"),
                    $(".main-header").addClass("hor-header"),
                    $(".main-header").removeClass("side-header"),
                    $(".app-sidebar").addClass("horizontal-main"),
                    $(".main-sidemenu").addClass("container"),
                    $("body").removeClass("sidebar-mini"),
                    $("#slide-left").removeClass("d-none"),
                    $("#slide-right").removeClass("d-none")),
                    $("body").hasClass("horizontal-hover") &&
                        ($("body").addClass("horizontal-hover"),
                        $("body").addClass("horizontal"),
                        $("#slide-left").addClass("d-none"),
                        $("#slide-right").addClass("d-none"),
                        $(".main-content").addClass("horizontal-content"),
                        $(".main-content").removeClass("app-content"),
                        $(".main-container").addClass("container"),
                        $(".main-container").removeClass("container-fluid"),
                        $(".main-header").addClass("hor-header"),
                        $(".main-header").removeClass("side-header"),
                        $(".app-sidebar").addClass("horizontal-main"),
                        $(".main-sidemenu").addClass("container"),
                        $("body").removeClass("sidebar-mini"),
                        $("body").removeClass("sidenav-toggled"));
            })();
    });
})();
