(function () {
    "use strict";
    window.dataLayer = window.dataLayer || [];
    function gtag() {
        dataLayer.push(arguments);
    }
    gtag("js", new Date());

    gtag("config", "G-PNDV8CWY5Q");

    // untuk hapus modal default
    var clrModal = setInterval(() => {
        var x = document.getElementById("modal-trigger");
        if (x) {
            clearInterval(clrModal);
            x.remove();
        }
    }, 1);

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
    desktop: {
        modal: (data) => {
            var template = $(`
                <div class="modal fade" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <img src="${data.file}" width="600" height="350" class="imgads">
                                <p aria-label="Close" aria-hidden="true" class="deskripsi">${data.deskripsi}</p>
                            </div>
                        </div>
                    </div>
                </div>
            `);

            $("body").append(template);
            template.modal("show");
        },
        headerApk: (data) => {
            var template = $(`
                <div class="headerApk container">
                    <span class="btn-close">
                        <i class="fa fa-times"></i>
                    </span>
                    <div class="header-container">
                        <div class="banner-info">
                            <div class="app_icon">
                                <img src="${data.file}" alt="App Icon">
                            </div>
                            <div class="app_info">
                                <div class="app_title">${data.title}</div>
                                <div class="app_slogan">${data.slogan}</div>
                            </div>
                        </div>
                        <div class="download_button">
                            <a href="${data.url}" target="_blank" title="Download Apk Ziatogel" class="btn btn-green">DOWNLOAD</a>
                        </div>
                    </div>
                </div>
            `);

            template.find(".btn-close").click(() => template.remove());

            template.insertAfter("#breadcrumbs");
        },
        headerCorousel: (data) => {
            var isPause, tick, percentTime, time = 7;
            var target = $("#slider");
            target.children().remove();

            data = data.map(e => {
                return `
                    <div class="item">
                        <img src="${e}" width="840px" height="482" />
                    </div>
                `;
            }).join("");
            var template = $(`<div class="owl-carousel owl-theme">${data}</div>`);

            template.owlCarousel({
                singleItem: true,
                stopOnHover: true,
                transitionStyle: "fade",
                addClassActive: true,
                afterMove: function(e) {
                    clearTimeout(tick);
                    startAnimation();
                    sliderAnimations();
                },
                afterInit: function(e) {
                    var bar = $(`
                        <div id="progressBar">
                            <div id="bar"></div>
                        </div>
                    `);
                    e.append(bar);
                    startAnimation();
                    sliderAnimations();
                },
                startDragging: () => isPause = true,
            });

            function startAnimation() {
                percentTime = 0;
                isPause = false;
                tick = setInterval(() => {
                    if (isPause === false) {
                        percentTime += 1 / time;
                        $("#bar").css({ width: percentTime + "%" });
                        if (percentTime >= 100) {
                            template.trigger("owl.next");
                        }
                    }
                }, 10);
            }

            function sliderAnimations() {
                target.find(".owl-item").not("active").find(".caption").each(function () {
                    $(this).removeClass("animated" + " " + $(this).data("animation"));
                });
                target.find(".owl-item.active .caption").each(function () {
                    var caption = $(this);
                    window.setTimeout(() => {
                        caption.addClass("animated" + " " + caption.data("animation"));
                    }, caption.data("delay"));
                });
            }

            template.on("mouseover", () => isPause = true);
            template.on("mouseout", () => isPause = false);
            target.append(template);
            target.find('.navigation .next').click(() => template.trigger("owl.next"));
            target.find('.navigation .prev').click(() => template.trigger("owl.prev"));

        },
        btnAction: (data) => {
            data = data.filter(e => e.status).map(e => {
                return `<a class="btn btn-custom ${e.class}" href="${e.link}" style="${e.style}" target="${e.target ? '_blank' : ''}">${e.name}</a>`;
            }).join("");

            $(".sidebar-button").append($(data));
        },
        iconSosmed: (data) => {
            var icon = data.data.filter(e => e.status).map(e => {
                return `
                    <div class="icon-item">
                        <a href="${e.link}" target="_blank">
                            <img src="${e.image}" alt="${e.name}">
                        </a>
                    </div>
                `;
            }).join("");

            var template = $(`
                <div class="icon-sosmed">
                    <div class="icon-info">${data.ket}</div>
                    <div class="icon-container">${icon}</div>
                </div>
            `);

            $(".blog-posts").append(template);
        },
        promosi: (data) => {
            $(`
                <div class="promosi">
                    <a href="${data.link}" target="_blank" title="${data.name}">
                        <img src="${data.image}" alt="${data.name}">
                    </a>
                </div>
            `).insertBefore($("#latest-results"));
        },
        beforeFooter: (data) => {
            var template = $(`
                <div class="footer-info">
                    <h2 class="footer-info-title">${data.title}</h2>
                    <p class="footer-info-deskripsi">${data.deskripsi}</p>
                </div>
            `);
            $("#footer .footer-main").prepend(template);
        },
        footerProtection: (data) => {
            var template = $(`
                <div class="container footer-protection">
                    <a title="${data.name}" class="dmca-badge" href="${data.link}" target="_blank">
                        <img alt="${data.name}" src="${data.image}">
                    </a>
                </div>
            `);

            $("#footer .footer-bottom").append(template);
        },
        linkAlter: (data) => {
            var listLink = data.listLink.map(e => {
                return `
                    <div class="linkalte-item">
                        <a href="${e}" target="_blank" title="Bandar Casino Online">${e.replace('https://','')}</a>
                    </div>
                `;
            }).join("")

            var template = $(`
                <div class="linkalte-container">
                    <img src="${data.image}" class="linkalte-btn">
                    <div class="linkalte-body">${listLink}</div>
                </div>
            `);

            $('body').append(template);

        },
        barcodeQris: (data) => {

            var btn = $(`<a class="btn btn-custom btn-success text-uppercase" href="javascript:void(0);">${data.name}</a>`);
            if (data.background) btn.css("background", data.bbackground);
            if (data.color) btn.css("color", data.bcolor);

            var mdl = $(`
                <div class="modal fade" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body">
                                <img src="${data.image}" width="600" height="350" class="imgads">
                            </div>
                        </div>
                    </div>
                </div>
            `);

            btn.click(() => mdl.modal("show"));

            mdl.click(function(e) {
                if ($(e.target).closest('.modal-content').length == 0) mdl.modal("hide");
            });

            btn.insertAfter(".sidebar-button .btn-theme");
            $('body').append(mdl);
        },
        sortBank: (data) => {
            var targetReplace = $('.bankscroll');
            var listImg = $('.bankscroll .owl-item .item');
            if (listImg.length > 0) {
                for (let i = 0; i < listImg.length; i++) {
                    var element = $(listImg[i]);
                    var img = element.find("img").attr("src").split("/").at(-1).split(".")[0];
                    if(img == "nofound") img = "mandiri";
                    if(img == "cimb-2") img = "cimb";

                    img = img.toUpperCase();
                    index = data.findIndex(e => e == img);
                    if (index > -1) {
                        element.find("div").addClass(img.toLocaleLowerCase());
                        data[index] = element[0].outerHTML;
                    }

                }
                data = data.filter(e => e.search('item') > 0);
                var newItem = $(`<div class="bankscroll">${data.join("")}</div>`);
                newItem.owlCarousel({ autoPlay: 5000, items: 5, itemsDesktop: false });
                newItem.insertBefore(targetReplace);
                targetReplace.remove();
            }
        },
        defaultFooter: () => {
            var target = $("#footer");
            var main = target.find(".footer-main");
            if (main.length == 0) {
                main = $("<div class='footer-main'></div>");
                target.prepend(main);
            }

            main.addClass("container");
        }
    },
    mobile: {
        modal: (data) => {
            if (data) {
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
                                    <img src="${data.file}" class="popup-img">
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
                                <img src="${data.file}" alt="App Icon">
                            </div>
                            <div class="app_info">
                                <div class="app_title">${data.title}</div>
                                <div class="app_slogan">${data.slogan}</div>
                            </div>
                        </div>
                        <div class="download_button">
                            <a href="${data.url}" target="_blank" title="Download Apk fiatogel" class="btn btn-green">DOWNLOAD</a>
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
        headerCorousel: (data) => {
            data = data.map((e) => {
                return `<div> <img src="${e}"></div>`;
            })
            var owl = $(`<div class="owl-carousel owl-theme">${data.join('')}</div>`);
            owl.owlCarousel({
                transitionStyle: "fade",
                addClassActive: true,
                loop: true,
                autoPlay: 3000,
            })
            $('#content .container').prepend(owl);
        },
        btnAction: (data) => {
            data = data.filter((e) => e.status).map((e) => {
                var shadow = e.shadow ? 'inset 0 -4px 0 '+e.shadow+';' : '';
                return `<a title="${e.name}" href="${e.link}" class="buttonWrap buttong contactSubmitButton ${e.class}" style="${shadow}${e.style}" target="${e.target ? '_blank' : ''}">${e.name}</a>`;
            }).join('');
            $(data).insertAfter(".button-green");
        },
        iconSosmed: (data) => {
            var icon = data.data.filter((e) => e.status).map((e) => {
                return `<a href="${e.link}" target="_blank">
                            <img src="${e.image}" alt="${e.name}">
                        </a>`;
            })

            var sos = $(`
                <div class="icon-sosmed">
                    <p class="deskripsi">${data.ket}</p>
                    <div class="icon">${icon.join('')}</div>
                </div>
            `)

            sos.insertBefore($('.inner-wrap'));
        },
        promosi: (data) => {
            var pro = $(`
                <a href="${data.link}" target="_blank" title="${data.name}" class="promosi">
                    <img src="${data.image}">
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
                        <img alt="${data.name}" src="${data.image}" style="margin: 0 auto;">
                    </a>
                    </div>
                </div>
            `)

            $('.footer').append(footer);
        },
        linkAlter: (data) => {
            var listLink = data.listLink.map(e => {
                return `
                    <li>
                        <a href="${e}" class="linkalte-item" target="_blank" title="Bandar Casino Online">${e.replace('https://','')}</a>
                    </li>
                `;
            }).join("")

            var template = $(`
                <div class="linkalte-container">
                    <img src="${data.image}" class="linkalte-btn">
                    <ul class="linkalte-body">${listLink}</ul>
                </div>
            `);

            $('body').append(template);

        },
        barcodeQris: (data) => {
            var btn = $(`
                <div class="btnqris">
                    <a class="buttons button-blue text-uppercase" href="javascript:void(0);">${data.name}</a>
                </div>
            `);
            if (data.background) btn.css("background", data.bbackground);
            if (data.color) btn.css("color", data.bcolor);

            var mdl = $(`
                <div class="modal fade" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body">
                                <img src="${data.image}" class="imgads">
                            </div>
                        </div>
                    </div>
                </div>
            `);

            mdl.click(function(e) {
                var x = $(e.target).closest('.modal-content');
                if (x.length == 0) mdl.removeClass('show');
            });

            btn.click(() => mdl.addClass("show"));

            $(".wrapper2").prepend(btn);
            $('body').append(mdl);
        },
        sortBank: (data) => {
            var targetReplace = $('#slider-hasil');
            var listImg = $('.bank');
            if (listImg.length > 0) {
                for (let i = 0; i < listImg.length; i++) {
                    var element = $(listImg[i]);
                    var img = element.children()[1].getAttribute("src").split("/").at(-1).split(".")[0];
                    if(img == "nofound") img = "mandiri";
                    if(img == "cimb-2") img = "cimb";

                    img = img.toUpperCase();
                    index = data.findIndex(e => e == img);
                    if (index > -1) {
                        data[index] = element[0].outerHTML;
                    }

                }
                data = data.filter(e => e.search('bank') > 0);
                var newItem = $(`<div class="listNewBank">${data.join("")}</div>`);
                newItem.insertAfter(targetReplace);
                listImg.parent().remove();
            }
        }


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

        $.ajax({
            type: "get",
            url: "/config/2",
            dataType: "json",
            success: function (response) {
                response = {
                    "id": 2,
                    "name": "Fia Togel",
                    "status_desktop": 1,
                    "status_mobile": 1,
                    "url_desktop_dev": "/situs/fia_togel/desktop",
                    "url_desktop_prod": "https://fiatogel176.com/",
                    "url_mobile_dev": "/situs/fia_togel/m",
                    "url_mobile_prod": "https://fiatogel176.com/m",
                    "created_at": "2022-10-11T15:24:48.000000Z",
                    "updated_at": "2022-11-10T04:16:56.000000Z",
                    "fitur_situs": {
                        "desktop": [
                            {
                                "id": 74,
                                "id_situs": 2,
                                "id_fitur": 1,
                                "type": "desktop",
                                "status": 1,
                                "data": {
                                    "file": "https://static.hokibagus.club/situs/fia togel/desktop/popup modal/fiatogel_popup_promokhusus.png",
                                    "deskripsi": "klik dimana saja untuk menutup"
                                },
                                "created_at": "2022-10-25T00:24:03.000000Z",
                                "updated_at": "2022-11-17T07:11:45.000000Z"
                            },
                            {
                                "id": 75,
                                "id_situs": 2,
                                "id_fitur": 2,
                                "type": "desktop",
                                "status": 0,
                                "data": {
                                    "url": "https://bit.ly/FiaTogel",
                                    "file": "https://static.hokibagus.club/situs/fia togel/desktop/header apk/fiatogel_icon.png",
                                    "title": "APLIKASI FIATOGEL",
                                    "slogan": " Silahkan diklik tombol Download"
                                },
                                "created_at": "2022-10-25T00:24:03.000000Z",
                                "updated_at": "2022-11-17T07:11:45.000000Z"
                            },
                            {
                                "id": 76,
                                "id_situs": 2,
                                "id_fitur": 3,
                                "type": "desktop",
                                "status": 1,
                                "data": [
                                    "https://static.hokibagus.club/situs/fia togel/desktop/header corousel/fiatogel_sliderweb_info2.jpg",
                                    "https://static.hokibagus.club/situs/fia togel/desktop/header corousel/fiatogel_sliderweb_allbonusevent.jpg",
                                    "https://static.hokibagus.club/situs/fia togel/desktop/header corousel/fiatogel_sliderweb_specialupdate.jpg"
                                ],
                                "created_at": "2022-10-25T00:24:03.000000Z",
                                "updated_at": "2022-11-17T07:11:45.000000Z"
                            },
                            {
                                "id": 77,
                                "id_situs": 2,
                                "id_fitur": 4,
                                "type": "desktop",
                                "status": 0,
                                "data": [],
                                "created_at": "2022-10-25T00:24:03.000000Z",
                                "updated_at": "2022-11-07T11:33:30.000000Z"
                            },
                            {
                                "id": 78,
                                "id_situs": 2,
                                "id_fitur": 5,
                                "type": "desktop",
                                "status": 0,
                                "data": {
                                    "ket": null,
                                    "data": []
                                },
                                "created_at": "2022-10-25T00:24:03.000000Z",
                                "updated_at": "2022-11-17T07:11:45.000000Z"
                            },
                            {
                                "id": 79,
                                "id_situs": 2,
                                "id_fitur": 6,
                                "type": "desktop",
                                "status": 1,
                                "data": {
                                    "link": "https://static.hokibagus.club/fiatogel/images/promo/fiatogel_promo_bonusslotgame.gif",
                                    "name": "promo",
                                    "image": "https://static.hokibagus.club/situs/fia togel/desktop/promosi/fiatogel_promo_bonusslotgame.gif"
                                },
                                "created_at": "2022-10-25T00:24:03.000000Z",
                                "updated_at": "2022-11-17T07:11:45.000000Z"
                            },
                            {
                                "id": 80,
                                "id_situs": 2,
                                "id_fitur": 7,
                                "type": "desktop",
                                "status": 1,
                                "data": {
                                    "title": "FIA TOGEL | Bandar Togel Online Indonesia Terbaik",
                                    "deskripsi": "<a href=\"/\" title=\"Bandar Togel Online Indonesia Terbaik\">FIA TOGEL</a> adalah bandar togel online indonesia terbaik yang menyediakan permainan togel online paling bersaing seperti singapura, hongkong, sydney, dan permainan livegames seperti roulette, sicbo, baccarat dan masih banyak lagi. Bagi anda para pecinta permainan togel online terbaik maka kami adalah pilihan terbaik untuk anda. Customer service online 24 jam nonstop dengan pelayanan terbaik."
                                },
                                "created_at": "2022-10-25T00:24:03.000000Z",
                                "updated_at": "2022-11-17T07:11:45.000000Z"
                            },
                            {
                                "id": 81,
                                "id_situs": 2,
                                "id_fitur": 8,
                                "type": "desktop",
                                "status": 0,
                                "data": {
                                    "link": null,
                                    "name": null,
                                    "image": ""
                                },
                                "created_at": "2022-10-25T00:24:03.000000Z",
                                "updated_at": "2022-11-17T07:11:45.000000Z"
                            },
                            {
                                "id": 82,
                                "id_situs": 2,
                                "id_fitur": 9,
                                "type": "desktop",
                                "status": 1,
                                "data": {
                                    "image": "https://static.hokibagus.club/situs/fia togel/desktop/link alternatif/linkfia.png",
                                    "listLink": [
                                        "https://linkr.bio/fiatogel",
                                        "https://rebrand.ly/fiatogel88/",
                                        "https://fiatogel176.com/"
                                    ]
                                },
                                "created_at": "2022-10-25T00:24:03.000000Z",
                                "updated_at": "2022-11-17T07:11:45.000000Z"
                            },
                            {
                                "id": 83,
                                "id_situs": 2,
                                "id_fitur": 10,
                                "type": "desktop",
                                "status": 0,
                                "data": {
                                    "name": "barocde qris",
                                    "color": "#FFFFFF",
                                    "image": "",
                                    "shadow": "#196a7d",
                                    "background": "#c0392b"
                                },
                                "created_at": "2022-10-25T00:24:03.000000Z",
                                "updated_at": "2022-11-17T07:11:45.000000Z"
                            },
                            {
                                "id": 84,
                                "id_situs": 2,
                                "id_fitur": 11,
                                "type": "desktop",
                                "status": 0,
                                "data": [
                                    ""
                                ],
                                "created_at": "2022-10-25T00:24:03.000000Z",
                                "updated_at": "2022-11-07T11:33:30.000000Z"
                            }
                        ],
                        "mobile": [
                            {
                                "id": 85,
                                "id_situs": 2,
                                "id_fitur": 1,
                                "type": "mobile",
                                "status": 1,
                                "data": {
                                    "file": "https://static.hokibagus.club/situs/fia togel/mobile/popup modal/fiatogel_popup_bri.png",
                                    "deskripsi": "Silahkan klik dimana saja untuk menutup."
                                },
                                "created_at": "2022-10-25T00:24:03.000000Z",
                                "updated_at": "2022-11-17T07:11:45.000000Z"
                            },
                            {
                                "id": 86,
                                "id_situs": 2,
                                "id_fitur": 2,
                                "type": "mobile",
                                "status": 1,
                                "data": {
                                    "url": "https://bit.ly/FiaTogel",
                                    "file": "https://static.hokibagus.club/situs/fia togel/mobile/header apk/fiatogel_icon.png",
                                    "title": "aplikasi fiatogel",
                                    "slogan": "Silahkan diklik tombol Download"
                                },
                                "created_at": "2022-10-25T00:24:03.000000Z",
                                "updated_at": "2022-11-17T07:11:45.000000Z"
                            },
                            {
                                "id": 87,
                                "id_situs": 2,
                                "id_fitur": 3,
                                "type": "mobile",
                                "status": 1,
                                "data": [
                                    "https://static.hokibagus.club/situs/fia togel/mobile/header corousel/fiatogel_slidermobile_info2.jpg",
                                    "https://static.hokibagus.club/situs/fia togel/mobile/header corousel/fiatogel_slidermobile_allbonusevent.jpg",
                                    "https://static.hokibagus.club/situs/fia togel/mobile/header corousel/fiatogel_slidermobile_specialupdate.jpg"
                                ],
                                "created_at": "2022-10-25T00:24:03.000000Z",
                                "updated_at": "2022-11-17T07:11:45.000000Z"
                            },
                            {
                                "id": 88,
                                "id_situs": 2,
                                "id_fitur": 4,
                                "type": "mobile",
                                "status": 1,
                                "data": [
                                    {
                                        "link": "https://rtpslotfia.com/",
                                        "name": "RTP Slot",
                                        "class": "btn-light",
                                        "style": "background-color: #e67e22;",
                                        "shadow": "#1b693c",
                                        "status": true,
                                        "target": true
                                    },
                                    {
                                        "link": "https://togelfia176.com/m/promotion.php",
                                        "name": "Promo",
                                        "class": "btn-light",
                                        "style": "background-color: #f1c40f;",
                                        "shadow": "#1b693c",
                                        "status": true,
                                        "target": true
                                    },
                                    {
                                        "link": "https://fiatogel.laporkeluhan.net/",
                                        "name": "Keluhan Member",
                                        "class": "btn-light",
                                        "style": "background-color: #2980b9;",
                                        "shadow": "#1b693c",
                                        "status": true,
                                        "target": true
                                    },
                                    {
                                        "link": "https://linklist.bio/fiatogel88",
                                        "name": "Lain - Lain",
                                        "class": "btn-light",
                                        "style": "background-color: #c0392b;",
                                        "shadow": "#1b693c",
                                        "status": true,
                                        "target": true
                                    }
                                ],
                                "created_at": "2022-10-25T00:24:03.000000Z",
                                "updated_at": "2022-11-17T07:11:45.000000Z"
                            },
                            {
                                "id": 89,
                                "id_situs": 2,
                                "id_fitur": 5,
                                "type": "mobile",
                                "status": 1,
                                "data": {
                                    "ket": "Klik icon sosmed di bawah ini untuk hubungi operator :",
                                    "data": [
                                        {
                                            "link": "https://api.whatsapp.com/send?phone=6281380376284",
                                            "name": "wa",
                                            "image": "https://static.hokibagus.club/situs/fia togel/mobile/icon sosmed/fiatogel_wa.png",
                                            "status": true
                                        },
                                        {
                                            "link": "https://www.instagram.com/fiatogel888/",
                                            "name": "ig",
                                            "image": "https://static.hokibagus.club/situs/fia togel/mobile/icon sosmed/fiatogel_contacts_ig.png",
                                            "status": true
                                        },
                                        {
                                            "link": "https://www.facebook.com/Fiatogell",
                                            "name": "fb",
                                            "image": "https://static.hokibagus.club/situs/fia togel/mobile/icon sosmed/FB.png",
                                            "status": true
                                        },
                                        {
                                            "link": "https://www.youtube.com/channel/UCwC82UdbVYViEFfCNiRblqg?sub_confirmation=1",
                                            "name": "yt",
                                            "image": "https://static.hokibagus.club/situs/fia togel/mobile/icon sosmed/YOUTUBE.png",
                                            "status": true
                                        }
                                    ]
                                },
                                "created_at": "2022-10-25T00:24:03.000000Z",
                                "updated_at": "2022-11-17T07:11:45.000000Z"
                            },
                            {
                                "id": 90,
                                "id_situs": 2,
                                "id_fitur": 6,
                                "type": "mobile",
                                "status": 1,
                                "data": {
                                    "link": "https://fiatogel176.com/register.php",
                                    "name": "promosi",
                                    "image": "https://static.hokibagus.club/situs/fia togel/mobile/promosi/fiatogel_promo_bonusslotgame.gif"
                                },
                                "created_at": "2022-10-25T00:24:03.000000Z",
                                "updated_at": "2022-11-17T07:11:45.000000Z"
                            },
                            {
                                "id": 91,
                                "id_situs": 2,
                                "id_fitur": 7,
                                "type": "mobile",
                                "status": 1,
                                "data": {
                                    "title": "Bandar Togel Online Indonesia Terbaik",
                                    "deskripsi": "FIATOGEL.COM adalah bandar togel online indonesia terbaik yang menyediakan permainan togel online paling bersaing seperti singapura, hongkong, sydney, dan permainan livegames seperti roulette, sicbo, baccarat dan masih banyak lagi. Bagi anda para pecinta permainan togel online terbaik maka kami adalah pilihan terbaik untuk anda. Customer service online 24 jam nonstop dengan pelayanan terbaik."
                                },
                                "created_at": "2022-10-25T00:24:03.000000Z",
                                "updated_at": "2022-11-17T07:11:45.000000Z"
                            },
                            {
                                "id": 92,
                                "id_situs": 2,
                                "id_fitur": 8,
                                "type": "mobile",
                                "status": 0,
                                "data": {
                                    "link": null,
                                    "name": null,
                                    "image": ""
                                },
                                "created_at": "2022-10-25T00:24:03.000000Z",
                                "updated_at": "2022-11-17T07:11:45.000000Z"
                            },
                            {
                                "id": 93,
                                "id_situs": 2,
                                "id_fitur": 9,
                                "type": "mobile",
                                "status": 0,
                                "data": {
                                    "image": "",
                                    "listLink": [
                                        ""
                                    ]
                                },
                                "created_at": "2022-10-25T00:24:03.000000Z",
                                "updated_at": "2022-11-17T07:11:45.000000Z"
                            },
                            {
                                "id": 94,
                                "id_situs": 2,
                                "id_fitur": 10,
                                "type": "mobile",
                                "status": 0,
                                "data": {
                                    "name": "barocde qris",
                                    "color": "#FFFFFF",
                                    "image": "",
                                    "shadow": "#196a7d",
                                    "background": "#c0392b"
                                },
                                "created_at": "2022-10-25T00:24:03.000000Z",
                                "updated_at": "2022-11-17T07:11:45.000000Z"
                            },
                            {
                                "id": 95,
                                "id_situs": 2,
                                "id_fitur": 11,
                                "type": "mobile",
                                "status": 0,
                                "data": [
                                    ""
                                ],
                                "created_at": "2022-10-25T00:24:03.000000Z",
                                "updated_at": "2022-11-07T11:33:30.000000Z"
                            }
                        ]
                    }
                }
                if (response) {
                    if (response.status_desktop && !isMobile) {
                        func.desktop.defaultFooter();
                        if (response.fitur_situs.desktop) {
                            var length = response.fitur_situs.desktop.length;
                            response.fitur_situs.desktop.forEach((el, i) => {
                                if (el.id_fitur == 1) {
                                    if (el.status) {
                                        func.desktop.modal(el.data);
                                    }else{
                                        $("#myModal").modal("show");
                                    }
                                }

                                if (el.id_fitur == 2 && el.status) func.desktop.headerApk(el.data);

                                if (el.id_fitur == 3 && el.status) func.desktop.headerCorousel(el.data);

                                if (el.id_fitur == 4 && el.status) func.desktop.btnAction(el.data);

                                if (el.id_fitur == 5 && el.status) func.desktop.iconSosmed(el.data);

                                if (el.id_fitur == 6 && el.status) func.desktop.promosi(el.data);

                                if (el.id_fitur == 7 && el.status) func.desktop.beforeFooter(el.data);

                                if (el.id_fitur == 8 && el.status) func.desktop.footerProtection(el.data);

                                if (el.id_fitur == 9 && el.status) func.desktop.linkAlter(el.data);

                                if (el.id_fitur == 10 && el.status) func.desktop.barcodeQris(el.data);

                                if (el.id_fitur == 11 && el.status) func.desktop.sortBank(el.data);

                                // untuk hide loading
                                if ((i+1) == length) $("#loadingCustom").hide();
                            });
                        }else{
                            $("#loadingCustom").hide();
                        }
                    }else if(response.status_mobile && isMobile){
                        if (response.fitur_situs.mobile) {
                            console.log(response.fitur_situs.mobile)
                            var length = response.fitur_situs.mobile.length;
                            response.fitur_situs.mobile.forEach((el, i) => {
                                if (el.id_fitur == 1 && el.status) func.mobile.modal(el.data);

                                if (el.id_fitur == 2 && el.status) func.mobile.headerApk(el.data);

                                if (el.id_fitur == 3 && el.status) func.mobile.headerCorousel(el.data);

                                if (el.id_fitur == 4 && el.status) func.mobile.btnAction(el.data);

                                if (el.id_fitur == 5 && el.status) func.mobile.iconSosmed(el.data);

                                if (el.id_fitur == 6 && el.status) func.mobile.promosi(el.data);

                                if (el.id_fitur == 7 && el.status) func.mobile.beforeFooter(el.data);

                                if (el.id_fitur == 8 && el.status) func.mobile.footerProtection(el.data);

                                if (el.id_fitur == 9 && el.status) func.mobile.linkAlter(el.data);

                                if (el.id_fitur == 10 && el.status) func.mobile.barcodeQris(el.data);

                                if (el.id_fitur == 11 && el.status) func.mobile.sortBank(el.data);




                                // untuk hide loading
                                if ((i+1) == length) $("#loadingCustom").hide();
                            });
                        }else{
                            $("#loadingCustom").hide();
                        }
                    }else{
                        $("#loadingCustom").hide();
                    }
                }else{
                    $("#loadingCustom").hide();
                }

            }
        });
    },
    ready: () => {

    }
};

// menambahkan info pada modal

setTimeout(() => {
    var mdlBody = document.querySelector(".modal-body");
    if (mdlBody) {
        var p = document.createElement("p");
        p.setAttribute("aria-label", "Close");
        p.setAttribute("aria-hidden", "true");
        p.classList.add("deskripsi")
        p.textContent = "Klik di mana saja untuk menutup";
        mdlBody.appendChild(p);
    }
}, 5);

// menambahkan class pada image bank
var insertClass = setInterval(() => {
    var listBank = document.querySelectorAll('.bankscroll .owl-item .item img');
    if (listBank.length > 0) {
        clearInterval(insertClass);
        var loc = document.location.href;
        var isMobile = /\/m\//g.test(loc) ? true : (/\/m/g.test(loc) ? true : false);
        if (!isMobile) {
            // add class bank
            for (let i = 0; i < listBank.length; i++) {
                const element = listBank[i];
                var targetClass = element.closest('.item').children[0];
                var img = element.getAttribute('src');
                img = img.split("/").at(-1).split('.')[0].toLowerCase();
                img = img == 'nofound' ? 'mandiri' : img;
                if(img) targetClass.classList.add(img);
            }
        }
    }
}, 1);
