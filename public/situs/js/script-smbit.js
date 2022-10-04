const func = {
    assets: {
        css: () => {
            $("<link/>", {
                rel: "stylesheet",
                type: "text/css",
                href: "/situs/css/zia_togel.css"
            }).appendTo("head");

            // $("<link/>", {
            //     rel: "stylesheet",
            //     type: "text/css",
            //     href: "https://static.hokibagus.club/testingAssets/style-smbit.css"
            // }).appendTo("head");
        },
        js: () => {

        }
    },
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
    load: () => {
        func.assets.css();
        func.assets.js();
        $("a.note.left").text('Versi WAP').removeClass("underline");

        $.getJSON("/situs/config/zia_togel.json",
            function (data, textStatus, jqXHR) {
                if (textStatus == 'success') {
                    if(data.headerApk) {
                        if(data.headerApk.status) func.headerApk(data.headerApk);
                    }

                    if(data.banner) {
                        if(data.banner.status) func.banner(data.banner.data);
                    }

                    if (data.btnAction) {
                        if (data.btnAction.length > 0) func.btnAction(data.btnAction);
                    }

                    if (data.iconSosmed) {
                        if (data.iconSosmed.data.length > 0) func.iconSosmed(data.iconSosmed);
                    }

                    if (data.promosi) {
                        if (data.promosi.status) func.promosi(data.promosi);
                    }

                    if (data.beforeFooter) {
                        if (data.beforeFooter.status) func.beforeFooter(data.beforeFooter);
                    }

                    if (data.footerProtection) {
                        if (data.footerProtection.status) func.footerProtection(data.footerProtection);
                    }

                    if (data.modalPopup) {
                        if (data.modalPopup.status) func.modalPopup(data.modalPopup);
                    }

                }
            }
        );
    },
    ready: () => {

    }
};

(function () {
    "use strict";
    window.dataLayer = window.dataLayer || [];
    function gtag() {
        dataLayer.push(arguments);
    }
    gtag("js", new Date());

    gtag("config", "G-XRK7N3620T");

    window.addEventListener("load", function() {
        $('body').addClass('smbitClass');
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
