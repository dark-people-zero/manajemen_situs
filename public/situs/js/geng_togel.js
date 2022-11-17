(function () {
    "use strict";
    window.dataLayer = window.dataLayer || [];
    function gtag() {
        dataLayer.push(arguments);
    }
    gtag("js", new Date());

    gtag("config", "UA-112804824-15");

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
                <div class="before-footer container">
                    <h2 class="tittle">${data.title}</h2>
                    <div class="deskripsi">${data.deskripsi}</div>
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

            $("#footer .footer-main .footer-bottom").append(template);
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
        defaultItem: () => {
            let template = $(`
                <div class="contact-us on">
                    <div class="contact-btnOn">
                        <img src="https://cdn.areabermain.club/slider/gengtoto/open.jpg">
                    </div>
                    <div class="contact-UsArea">
                        <div class="area">
                            <img src="https://cdn.areabermain.club/gengtoto/images/contacts/contactus_gengtoto.png">
                            <div class="contact-number">
                                <div class="contact-number-item">+6282137753501</div>
                                <div class="contact-number-item wa2">+6281292936069</div>
                            </div>
                        </div>
                        <div class="contact-btnOf">
                            <img src="https://cdn.areabermain.club/slider/gengtoto/close.jpg">
                        </div>
                    </div>
                </div>
            `);

            template.find(".contact-btnOn").click(function() {
                $(this).closest(".contact-us").toggleClass("on");
            });

            template.find(".contact-btnOf").click(function() {
                $(this).closest(".contact-us").toggleClass("on");
            });

            $("body").append(template);
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
            url: "/config/3",
            dataType: "json",
            success: function (response) {
                response = {
                    "id": 3,
                    "name": "Geng Togel",
                    "status_desktop": 1,
                    "status_mobile": 1,
                    "url_desktop_dev": "/situs/geng_togel/desktop",
                    "url_desktop_prod": "https://gengtogel176.com/",
                    "url_mobile_dev": "/situs/geng_togel/mobile",
                    "url_mobile_prod": "https://gengtogel176.com/m",
                    "created_at": "2022-10-11T15:24:48.000000Z",
                    "updated_at": "2022-11-12T17:19:51.000000Z",
                    "fitur_situs": {
                        "desktop": [
                            {
                                "id": 398,
                                "id_situs": 3,
                                "id_fitur": 1,
                                "type": "desktop",
                                "status": 1,
                                "data": {
                                    "file": "https://static.hokibagus.club/situs/geng togel/desktop/popup modal/gengtoto_popup_extra_bonus_slot.png",
                                    "deskripsi": "Klik di mana saja untuk menutup"
                                },
                                "created_at": "2022-11-12T17:18:43.000000Z",
                                "updated_at": "2022-11-17T10:33:40.000000Z"
                            },
                            {
                                "id": 399,
                                "id_situs": 3,
                                "id_fitur": 2,
                                "type": "desktop",
                                "status": 0,
                                "data": {
                                    "url": null,
                                    "file": "",
                                    "title": null,
                                    "slogan": null
                                },
                                "created_at": "2022-11-12T17:18:43.000000Z",
                                "updated_at": "2022-11-17T10:33:40.000000Z"
                            },
                            {
                                "id": 400,
                                "id_situs": 3,
                                "id_fitur": 3,
                                "type": "desktop",
                                "status": 0,
                                "data": [],
                                "created_at": "2022-11-12T17:18:43.000000Z",
                                "updated_at": "2022-11-12T17:21:24.000000Z"
                            },
                            {
                                "id": 401,
                                "id_situs": 3,
                                "id_fitur": 4,
                                "type": "desktop",
                                "status": 0,
                                "data": [],
                                "created_at": "2022-11-12T17:18:43.000000Z",
                                "updated_at": "2022-11-12T17:21:24.000000Z"
                            },
                            {
                                "id": 402,
                                "id_situs": 3,
                                "id_fitur": 5,
                                "type": "desktop",
                                "status": 0,
                                "data": {
                                    "ket": null,
                                    "data": []
                                },
                                "created_at": "2022-11-12T17:18:43.000000Z",
                                "updated_at": "2022-11-17T10:33:40.000000Z"
                            },
                            {
                                "id": 403,
                                "id_situs": 3,
                                "id_fitur": 6,
                                "type": "desktop",
                                "status": 1,
                                "data": {
                                    "link": "https://gengtogel176.com/register.php",
                                    "name": "Agen Togel Online Aman Terpercaya",
                                    "image": "https://static.hokibagus.club/situs/geng togel/desktop/promosi/gengtoto_banner_bonus.gif"
                                },
                                "created_at": "2022-11-12T17:18:43.000000Z",
                                "updated_at": "2022-11-17T10:33:40.000000Z"
                            },
                            {
                                "id": 404,
                                "id_situs": 3,
                                "id_fitur": 7,
                                "type": "desktop",
                                "status": 1,
                                "data": {
                                    "title": "SELAMAT DATANG DI GENGTOTO.COM",
                                    "deskripsi": "<div class=\"title-2\">BANDAR ONLINE TERPERCAYA</div>\n<p><a href=\"https://togelgeng176.com/\" >Gengtoto.com</a> adalah bandar online terpercaya yang menyediakan permainan tebak angka/togel dengan pasaran terbesar yaitu togel cambodia, togel sydney, togel singapura, togel taiwan, dan togel hongkong dengan diskon serta hadiah terbesar. Selain penyedia permainan togel <b>Gengtoto.com</b> juga menyediakan beragam jenis live game terpopuler.</p>\n<hr>\n<p><a href=\"https://togelgeng176.com/\" >Gengtoto.com</a> berkomitmen untuk menjaga data yang didaftarkan oleh seluruh member sebagai data yang bersifat sangat rahasia. Pilihan bank yang tersedia untuk bertransaksi juga sangat bervariasi: Bank BCA, Bank Mandiri, Bank BNI, Bank BRI , Bank CIMB , Bank Maybank , Bank BSI dan Bank Danamon. Customer service yang aktif 7x24 jam, dengan pelayanan terbaik, cepat dan tepat ! Daftar dan jadilah member dari situs togel online terbaik saat ini !</p>\n<img src=\"https://cdn.areabermain.club/images/ft_banner.png\">"
                                },
                                "created_at": "2022-11-12T17:18:43.000000Z",
                                "updated_at": "2022-11-17T10:33:40.000000Z"
                            },
                            {
                                "id": 405,
                                "id_situs": 3,
                                "id_fitur": 8,
                                "type": "desktop",
                                "status": 0,
                                "data": {
                                    "link": null,
                                    "name": null,
                                    "image": ""
                                },
                                "created_at": "2022-11-12T17:18:43.000000Z",
                                "updated_at": "2022-11-17T10:33:40.000000Z"
                            },
                            {
                                "id": 406,
                                "id_situs": 3,
                                "id_fitur": 9,
                                "type": "desktop",
                                "status": 1,
                                "data": {
                                    "image": "https://static.hokibagus.club/situs/geng togel/desktop/link alternatif/linkalternatifgeng.jpg",
                                    "listLink": [
                                        "https://linkr.bio/gengtoto",
                                        "https://rebrand.ly/gengtoto888",
                                        "https://gengtogel176.com/"
                                    ]
                                },
                                "created_at": "2022-11-12T17:18:43.000000Z",
                                "updated_at": "2022-11-17T10:33:40.000000Z"
                            },
                            {
                                "id": 407,
                                "id_situs": 3,
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
                                "created_at": "2022-11-12T17:18:43.000000Z",
                                "updated_at": "2022-11-17T10:33:40.000000Z"
                            },
                            {
                                "id": 408,
                                "id_situs": 3,
                                "id_fitur": 11,
                                "type": "desktop",
                                "status": 0,
                                "data": [
                                    ""
                                ],
                                "created_at": "2022-11-12T17:18:43.000000Z",
                                "updated_at": "2022-11-12T17:21:24.000000Z"
                            }
                        ],
                        "mobile": [
                            {
                                "id": 409,
                                "id_situs": 3,
                                "id_fitur": 1,
                                "type": "mobile",
                                "status": 1,
                                "data": {
                                    "file": "https://static.hokibagus.club/situs/geng togel/mobile/popup modal/gengtoto_popup_extrabonusslot.png",
                                    "deskripsi": "Klik di mana saja untuk menutup"
                                },
                                "created_at": "2022-11-12T17:18:43.000000Z",
                                "updated_at": "2022-11-17T10:33:40.000000Z"
                            },
                            {
                                "id": 410,
                                "id_situs": 3,
                                "id_fitur": 2,
                                "type": "mobile",
                                "status": 1,
                                "data": {
                                    "url": "https://bit.ly/gengapk",
                                    "file": "https://static.hokibagus.club/situs/geng togel/mobile/header apk/Gengtotoicon.png",
                                    "title": "APLIKASI GENGTOTO",
                                    "slogan": "Silahkan diklik pada tombol Download"
                                },
                                "created_at": "2022-11-12T17:18:43.000000Z",
                                "updated_at": "2022-11-17T10:33:40.000000Z"
                            },
                            {
                                "id": 411,
                                "id_situs": 3,
                                "id_fitur": 3,
                                "type": "mobile",
                                "status": 1,
                                "data": [
                                    "https://static.hokibagus.club/situs/geng togel/mobile/header corousel/gengtoto_slidermobile_bonusextra.jpg",
                                    "https://static.hokibagus.club/situs/geng togel/mobile/header corousel/gengtoto_slidermobile_tipebet2.jpg",
                                    "https://static.hokibagus.club/situs/geng togel/mobile/header corousel/gengtoto_slidermobile_allbonus.jpg"
                                ],
                                "created_at": "2022-11-12T17:18:43.000000Z",
                                "updated_at": "2022-11-17T10:33:40.000000Z"
                            },
                            {
                                "id": 412,
                                "id_situs": 3,
                                "id_fitur": 4,
                                "type": "mobile",
                                "status": 1,
                                "data": [
                                    {
                                        "link": "https://rtpslotgeng.com/",
                                        "name": "RTP Slot",
                                        "class": "btn-light",
                                        "style": "background-color: #e67e22;",
                                        "shadow": "#1b693c",
                                        "status": true,
                                        "target": null
                                    },
                                    {
                                        "link": "https://togelgeng176.com/m/promotion.php",
                                        "name": "Promo",
                                        "class": "btn-light",
                                        "style": "background-color: #f1c40f;",
                                        "shadow": "#1b693c",
                                        "status": true,
                                        "target": null
                                    },
                                    {
                                        "link": "https://gengtoto.laporkeluhan.net/",
                                        "name": "Keluhan Member",
                                        "class": "btn-light",
                                        "style": "background-color: #2980b9;",
                                        "shadow": "#1b693c",
                                        "status": true,
                                        "target": true
                                    },
                                    {
                                        "link": "https://linklist.bio/www.gengtoto.com",
                                        "name": "Lain-Lain",
                                        "class": "btn-light",
                                        "style": "background-color: #c0392b;",
                                        "shadow": "#1b693c",
                                        "status": true,
                                        "target": null
                                    }
                                ],
                                "created_at": "2022-11-12T17:18:43.000000Z",
                                "updated_at": "2022-11-17T10:33:40.000000Z"
                            },
                            {
                                "id": 413,
                                "id_situs": 3,
                                "id_fitur": 5,
                                "type": "mobile",
                                "status": 1,
                                "data": {
                                    "ket": "Klik icon sosmed di bawah ini untuk hubungi operator :",
                                    "data": [
                                        {
                                            "link": "https://api.whatsapp.com/send?phone=6282137753501",
                                            "name": "Whatsapp1 GENGTOTO",
                                            "image": "https://static.hokibagus.club/situs/geng togel/mobile/icon sosmed/gengtoto_contact_wa1.png",
                                            "status": true
                                        },
                                        {
                                            "link": "https://api.whatsapp.com/send/?phone=%2B6281292936069",
                                            "name": "Whatsapp2 GENGTOTO",
                                            "image": "https://static.hokibagus.club/situs/geng togel/mobile/icon sosmed/gengtoto_contact_wa2.png",
                                            "status": true
                                        },
                                        {
                                            "link": "https://www.facebook.com/Gengtoto77-767433036785109/",
                                            "name": "Facebook GENGTOTO",
                                            "image": "https://static.hokibagus.club/situs/geng togel/mobile/icon sosmed/gengfb.png",
                                            "status": true
                                        },
                                        {
                                            "link": "https://www.youtube.com/channel/UCfhxbZqj8tAqEvG7TDcTzGQ",
                                            "name": "Youtube GENGTOTO",
                                            "image": "https://static.hokibagus.club/situs/geng togel/mobile/icon sosmed/gengyt.png",
                                            "status": true
                                        }
                                    ]
                                },
                                "created_at": "2022-11-12T17:18:43.000000Z",
                                "updated_at": "2022-11-17T10:33:40.000000Z"
                            },
                            {
                                "id": 414,
                                "id_situs": 3,
                                "id_fitur": 6,
                                "type": "mobile",
                                "status": 1,
                                "data": {
                                    "link": "https://gengtogel176.com/m/register.",
                                    "name": "Agen Togel Online Aman Terpercaya",
                                    "image": "https://static.hokibagus.club/situs/geng togel/mobile/promosi/gengtoto_banner_bonus.gif"
                                },
                                "created_at": "2022-11-12T17:18:43.000000Z",
                                "updated_at": "2022-11-17T10:33:40.000000Z"
                            },
                            {
                                "id": 415,
                                "id_situs": 3,
                                "id_fitur": 7,
                                "type": "mobile",
                                "status": 1,
                                "data": {
                                    "title": "Situs Agen Togel Online Resmi, Terbaik Dan Terpercaya",
                                    "deskripsi": "Gengtoto.com adalah bandar online terpercaya yang menyediakan permainan tebak angka/togel dengan pasaran terbesar yaitu togel cambodia, togel sydney, togel singapura, togel taiwan, dan togel hongkong dengan diskon serta hadiah terbesar. Selain penyedia permainan togel gengtoto.com juga menyediakan beragam jenis live game terpopuler."
                                },
                                "created_at": "2022-11-12T17:18:43.000000Z",
                                "updated_at": "2022-11-17T10:33:40.000000Z"
                            },
                            {
                                "id": 416,
                                "id_situs": 3,
                                "id_fitur": 8,
                                "type": "mobile",
                                "status": 1,
                                "data": {
                                    "link": "https://www.dmca.com/Protection/Status.aspx?ID=b7e1ad05-2187-4abf-8078-8ed9c1a6c018&refurl=https://gengtogel176.com/m/",
                                    "name": "DMCA.com Protection Status",
                                    "image": "https://static.hokibagus.club/situs/geng togel/mobile/footer protection/_dmca_premi_badge_5.png"
                                },
                                "created_at": "2022-11-12T17:18:43.000000Z",
                                "updated_at": "2022-11-17T10:33:40.000000Z"
                            },
                            {
                                "id": 417,
                                "id_situs": 3,
                                "id_fitur": 9,
                                "type": "mobile",
                                "status": 0,
                                "data": {
                                    "image": "",
                                    "listLink": [
                                        ""
                                    ]
                                },
                                "created_at": "2022-11-12T17:18:43.000000Z",
                                "updated_at": "2022-11-17T10:33:40.000000Z"
                            },
                            {
                                "id": 418,
                                "id_situs": 3,
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
                                "created_at": "2022-11-12T17:18:43.000000Z",
                                "updated_at": "2022-11-17T10:33:40.000000Z"
                            },
                            {
                                "id": 419,
                                "id_situs": 3,
                                "id_fitur": 11,
                                "type": "mobile",
                                "status": 0,
                                "data": [
                                    ""
                                ],
                                "created_at": "2022-11-12T17:18:43.000000Z",
                                "updated_at": "2022-11-12T17:21:24.000000Z"
                            }
                        ]
                    }
                }
                if (response) {
                    if (response.status_desktop && !isMobile) {
                        func.desktop.defaultItem();
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
