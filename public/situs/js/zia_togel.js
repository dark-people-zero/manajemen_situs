var int = setInterval(() => {
    var target = document.getElementById("modal-trigger");
    if (target) {
        target.remove();
        document.querySelector("body").classList.add("loader-active");
        // $("#loader").delay(500).fadeIn(300);
        // $(".mask").delay(800).fadeIn(300);
        setTimeout(() => {
            document.getElementById("loader").style.display = "block";
            setTimeout(() => {
                document.querySelector(".mask").style.display = "block";
            }, 300);
        }, 1700);
        clearInterval(int)
    }
}, 500);

// var intLoader = setInterval(() => {
//     document.getElementById("loader").style.display = "block";
//     document.querySelector(".mask").style.display = "block";
// }, 100);

(function () {
    "use strict";
    window.dataLayer = window.dataLayer || [];
    function gtag() {
        dataLayer.push(arguments);
    }
    gtag("js", new Date());

    gtag("config", "G-XRK7N3620T");

    window.addEventListener("load", function() {
        func.load();
    })

    window.addEventListener("DOMContentLoaded", function() {
        func.ready();
    })

    document.addEventListener("DOMContentLoaded", function () {
        var e = "dmca-badge";
        var t = "refurl";
        var n = document.querySelectorAll('a.'+e);
        if (n.length > 0) {
            if (n[0].getAttribute("href").indexOf("refurl") < 0) {
                for (var r = 0; r < n.length; r++) {
                    var i = n[r];
                    i.href = i.href + (i.href.indexOf("?") === -1 ? "?" : "&") + t + "=" + document.location
                }
            }
        }
    }, false)

})();

const func = {
    assets: {
        css: () => {
            $("<link/>", {
                rel: "stylesheet",
                type: "text/css",
                href: "/situs/css/zia_togel.css"
            }).appendTo("head");
        },
        js: () => {

        }
    },
    desktop: {
        modalPopup: (data) => {
            var mdl = $("#myModal");
            mdl.find(".modal-body").append($(`
                <p class="deskripsi" data-dismiss="modal">${data.deskripsi}</p>
            `));
            mdl.find(".modal-body a img").attr("src", data.img);
            mdl.modal("show");
        }
    },
    mobile: {
        headerApk: (data) => {
            $("#content").addClass("apk-download");
            var banner = $(`
                <div id="smart_banner">
                    <span id="close_button" class="btn-close">×</span>
                    <div class="header-container">
                        <div class="banner-info">
                            <div class="app_icon">
                                <img src="${data.logo}" alt="App Icon">
                            </div>
                            <div class="app_info">
                                <div class="app_title">${data.title}</div>
                                <div class="app_slogan">${data.slogan}</div>
                            </div>
                        </div>
                        <div class="download_button">
                            <a href="https://bit.ly/ApkZia" target="_blank" title="Download Apk Ziatogel" class="btn btn-green">DOWNLOAD</a>
                        </div>
                    </div>
                </div>
            `);
            banner.find("#close_button").click(() => {
                $("#content").removeClass("apk-download");
            })
            // $('.app-container').append(banner);
            $("#content .page-header").prepend(banner);
            $("#content .page-header .app-container").remove();
        },
        banner: (data) => {
            data = data.map((e) => {
                return `<div> <img src="${e.img}" alt="${e.tittle}"></div>`;
            })
            var owl = $(`<div class="owl-carousel owl-theme">${data.join('')}</div>`);
            owl.owlCarousel({
                loop: true,
                margin: 10,
            })
            $('#content .container').prepend(owl);
        },
        btnAction: (data) => {
            data = data.filter((e) => e.status).map((e) => {
                return `<a title="${e.name}" href="${e.link}" class="buttonWrap buttong contactSubmitButton ${e.class}" ${e.style != null ? 'style="'+e.style+'"' : ''} ${e.target != null ? 'target="'+e.target+'"' : ''}>${e.name}</a>`;
            });
            $(data.join('')).insertAfter(".button-green");
        },
        iconSosmed: (data) => {
            var icon = data.data.filter((e) => e.status).map((e) => {
                return `<a href="${e.link}" target="_blank">
                            <img src="${e.img}" alt="${e.name}">
                        </a>`;
            })
            var sos = $(`
                <div class="icon-sosmed">
                    <p class="deskripsi">${data.deskripsi}</p>
                    <div class="icon">${icon.join('')}</div>
                </div>
            `)

            sos.insertBefore($('.inner-wrap'));
        },
        promosi: (data) => {
            var pro = $(`
                <a href="${data.link}" target="_blank" title="${data.name}" class="promosi">
                    <img src="${data.img}">
                </a>
            `);
            pro.insertBefore($('.inner-wrap'))
        },
        beforeFooter: (data) => {
            var before = $(`
                <div class="beforeFooter">
                    <center><h2 class="tittle">${data.title}</h2></center>
                    <p class="deskripsi">${data.deskripsi}</p>
                </div>
            `)

            before.insertAfter($('.inner-wrap'))
        },
        footerProtection: (data) => {
            var footer = $(`
                <div class="wrapper">
                    <div class="center-text">
                    <a title="${data.name}" class="dmca-badge" href="${data.link}" target="_blank">
                        <img alt="${data.name}" src="${data.img}" style="margin: 0 auto;">
                    </a>
                    </div>
                </div>
            `)

            $('.footer').append(footer);
        },
        modalPopup: (data) => {
            var mdl = $(`
                <div id="smb-mobile-popup">
                    <div class="modal-mobile">
                    <div class="modal-container-mobile">
                        <div class="body">
                            <div class="modal-header">
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">x</span>
                                </button>
                            </div>
                            <a href="" target="event">
                                <img src="${data.img}" class="popup-img">
                            </a>
                            <p aria-label="Close" aria-hidden="true" class="deskripsi">${data.deskripsi}</p>
                        </div>
                    </div>
                    </div>
                </div>
            `)

            mdl.find(".btn-close").click(function() {
                mdl.remove();
            })

            $('body').append(mdl);
        },
    },
    load: () => {
        var loc = document.location.href;
        var isMobile = /\/m\//g.test(loc) ? true : (/\/m/g.test(loc) ? true : (!$("html").hasClass("skrollr-desktop") ? true : false));
        if (isMobile) {
            $('body').addClass('smbitClass-mobile');
            $("a.note.left").text('Versi WAP').removeClass("underline");
        } else {
            $('body').addClass('smbitClass-desktop');
        }
        func.assets.css();
        func.assets.js();

        $.getJSON("/situs/config/zia_togel.json",
            function (data, textStatus, jqXHR) {
                if (textStatus == 'success') {
                    if (isMobile) {
                        if(data.mobile.headerApk) {
                            if(data.mobile.headerApk.status) func.mobile.headerApk(data.mobile.headerApk);
                        }

                        if(data.mobile.banner) {
                            if(data.mobile.banner.status) func.mobile.banner(data.mobile.banner.data);
                        }

                        if (data.mobile.btnAction) {
                            if (data.mobile.btnAction.length > 0) func.mobile.btnAction(data.mobile.btnAction);
                        }

                        if (data.mobile.iconSosmed) {
                            if (data.mobile.iconSosmed.data.length > 0) func.mobile.iconSosmed(data.mobile.iconSosmed);
                        }

                        if (data.mobile.promosi) {
                            if (data.mobile.promosi.status) func.mobile.promosi(data.mobile.promosi);
                        }

                        if (data.mobile.beforeFooter) {
                            if (data.mobile.beforeFooter.status) func.mobile.beforeFooter(data.mobile.beforeFooter);
                        }

                        if (data.mobile.footerProtection) {
                            if (data.mobile.footerProtection.status) func.mobile.footerProtection(data.mobile.footerProtection);
                        }

                        if (data.mobile.modalPopup) {
                            if (data.mobile.modalPopup.status) func.mobile.modalPopup(data.mobile.modalPopup);
                        }
                    }else{
                        $(".mask").hide();
                        $("#loader").hide();
                        var desktop = data.desktop;
                        if (desktop.modalPopup) {
                            if (desktop.modalPopup.status) func.desktop.modalPopup(desktop.modalPopup);
                        }

                        if (desktop.banner) {
                            if (desktop.banner.status) {
                                console.log("ada banner");
                            }else{
                                $("#slider").children().remove();
                            }
                        }
                    }

                }
            }
        );
    },
    ready: () => {

    }
};
