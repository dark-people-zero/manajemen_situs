(function () {
    "use strict";
    window.dataLayer = window.dataLayer || [];
    function gtag() {
        dataLayer.push(arguments);
    }
    gtag("js", new Date());

    gtag("config", "G-XRK7N3620T");

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
                    <a href="${e.link}" target="_blank" class="item">
                        <img src="${e.image}">
                        <span>${e.name}</span>
                    </a>
                `;
            }).join("");

            var template = $(`<div class="footer-sosmed">${icon}</div>`);

            $("#footer .footer-main .footer-link").prepend(template);
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
                <a title="${data.name}" class="dmca-badge" href="${data.link}" target="_blank">
                    <img alt="${data.name}" src="${data.image}">
                </a>
            `);

            $("#footer .footer-bottom .copyright").append(template);
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

            var link = $(`
                <div class="footer-link">
                    <div class="footer-link-default">
                        <a class="bottomnv_active" href="/index.php">Home</a>
                        <a href="/how-to-play.php">Cara Bermain</a>
                        <a href="/hasil_lengkap.php">histori nomor</a>
                        <a href="/bukumimpi.php">buku mimpi</a>
                        <a href="/support2.php">bantuan</a>
                        <a href="/inforeferral.php">refferal</a>
                        <a href="/promotion.php">promosi</a>
                        <a href="register.php">daftar</a>
                    </div>
                </div>
            `);

            main.append(link);
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
            url: "/config/1",
            dataType: "json",
            success: function (response) {
                response = {
                    "id": 19,
                    "name": "Zia Togel",
                    "status_desktop": 1,
                    "status_mobile": 1,
                    "url_desktop_dev": "/situs/zia_togel/desktop",
                    "url_desktop_prod": "https://ziatogel176.com/",
                    "url_mobile_dev": "/situs/zia_togel/m",
                    "url_mobile_prod": "https://ziatogel176.com/m",
                    "created_at": "2022-10-11T15:24:48.000000Z",
                    "updated_at": "2022-10-25T01:13:01.000000Z",
                    "fitur_situs": {
                        "desktop": [
                            {
                                "id": 1,
                                "id_situs": 19,
                                "id_fitur": 1,
                                "type": "desktop",
                                "status": 1,
                                "data": {
                                    "file": "https://static.hokibagus.club/danatoto/images/etc/danatoto_logo_app.png",
                                    "deskripsi": "Klik di mana saja untuk menutup"
                                },
                                "created_at": "2022-10-18T18:53:46.000000Z",
                                "updated_at": "2022-10-24T23:47:38.000000Z"
                            },
                            {
                                "id": 2,
                                "id_situs": 19,
                                "id_fitur": 2,
                                "type": "desktop",
                                "status": 1,
                                "data": {
                                    "url": "https://bit.ly/ApkZia",
                                    "file": "https://static.hokibagus.club/situs/zia togel/desktop/header apk/ziatogel_profile.jpg",
                                    "title": "aplikasi ziatogel",
                                    "slogan": "Kini telah tersedia Aplikasi Android"
                                },
                                "created_at": "2022-10-18T18:53:46.000000Z",
                                "updated_at": "2022-10-24T23:47:38.000000Z"
                            },
                            {
                                "id": 3,
                                "id_situs": 19,
                                "id_fitur": 3,
                                "type": "desktop",
                                "status": 1,
                                "data": [
                                    "https://static.hokibagus.club/situs/zia togel/desktop/header corousel/ziatogel_slidermobile_prosesdeposit.jpg",
                                    "https://static.hokibagus.club/situs/zia togel/desktop/header corousel/ziatogel_slidermobile_tipebet.jpg",
                                    "https://static.hokibagus.club/situs/zia togel/desktop/header corousel/ziatogel_slidermobile_allbonus.jpg",
                                    "https://static.hokibagus.club/situs/zia togel/desktop/header corousel/ziatogel_popup_bri.png"
                                ],
                                "created_at": "2022-10-18T18:53:46.000000Z",
                                "updated_at": "2022-10-24T23:47:38.000000Z"
                            },
                            {
                                "id": 4,
                                "id_situs": 19,
                                "id_fitur": 4,
                                "type": "desktop",
                                "status": 1,
                                "data": [
                                    {
                                        "link": "https://rtpslotzia.com/",
                                        "name": "RTP Slot",
                                        "class": "btn-secondary",
                                        "style": null,
                                        "shadow": "#1b693c",
                                        "status": true,
                                        "target": true
                                    },
                                    {
                                        "link": "https://togelzia176.com/m/promotion.php",
                                        "name": "Promo",
                                        "class": "btn-warning",
                                        "style": null,
                                        "shadow": "#1b693c",
                                        "status": true,
                                        "target": true
                                    },
                                    {
                                        "link": "https://ziatogel.laporkeluhan.net/",
                                        "name": "Keluhan ",
                                        "class": "btn-info",
                                        "style": null,
                                        "shadow": "#1b693c",
                                        "status": true,
                                        "target": true
                                    },
                                    {
                                        "link": "https://linklist.bio/ziatogel88",
                                        "name": "Lain-Lai",
                                        "class": "btn-success",
                                        "style": null,
                                        "shadow": "#1b693c",
                                        "status": true,
                                        "target": true
                                    }
                                ],
                                "created_at": "2022-10-18T18:53:46.000000Z",
                                "updated_at": "2022-10-24T23:47:38.000000Z"
                            },
                            {
                                "id": 5,
                                "id_situs": 19,
                                "id_fitur": 5,
                                "type": "desktop",
                                "status": 1,
                                "data": {
                                    "ket": "Klik icon sosmed di bawah ini untuk hubungi operator :",
                                    "data": [
                                        {
                                            "link": "https://api.whatsapp.com/send/?phone=6281376779265&text=Halo+bossku+saya+butuh+bantuan.",
                                            "name": "DingdongTogel",
                                            "image": "https://cdn.areabermain.club/slider/dingdongtogel/facebook.png",
                                            "status": true
                                        },
                                        {
                                            "link": "https://www.instagram.com/ziatogel88/",
                                            "name": "DingdongTogel",
                                            "image": "https://cdn.areabermain.club/slider/dingdongtogel/twitter.png",
                                            "status": true
                                        },
                                        {
                                            "link": "https://www.facebook.com/ziatogel889",
                                            "name": "DingdongTogel",
                                            "image": "https://cdn.areabermain.club/slider/dingdongtogel/instagram.png",
                                            "status": true
                                        },
                                        {
                                            "link": "https://www.youtube.com/channel/UCp3gfAsZlwBrTXGUSFlsIWA",
                                            "name": "DingdongTogel",
                                            "image": "https://cdn.areabermain.club/slider/dingdongtogel/wordpress.png",
                                            "status": true
                                        },
                                        {
                                            "link": "https://www.youtube.com/channel/UCp3gfAsZlwBrTXGUSFlsIWA",
                                            "name": "DingdongTogel",
                                            "image": "https://cdn.areabermain.club/slider/dingdongtogel/youtube.png",
                                            "status": true
                                        }
                                    ]
                                },
                                "created_at": "2022-10-18T18:53:46.000000Z",
                                "updated_at": "2022-10-24T23:47:38.000000Z"
                            },
                            {
                                "id": 6,
                                "id_situs": 19,
                                "id_fitur": 6,
                                "type": "desktop",
                                "status": 1,
                                "data": {
                                    "link": "https://ziatogel176.com/register.php",
                                    "name": "prpmo ziatogel",
                                    "image": "https://static.hokibagus.club/situs/zia togel/desktop/promosi/ziatogel_promo_bonus (1).gif"
                                },
                                "created_at": "2022-10-18T18:53:46.000000Z",
                                "updated_at": "2022-10-24T23:47:38.000000Z"
                            },
                            {
                                "id": 7,
                                "id_situs": 19,
                                "id_fitur": 7,
                                "type": "desktop",
                                "status": 1,
                                "data": {
                                    "title": "Situs zia Togel",
                                    "deskripsi": "ZIATOGEL merupakan Situs Bandar Online terpercaya yang menyediakan Pasaran Togel Terlengkap, berbagai LiveGames Terpopuler & Permainan Slot terbaik.Hanya dengan minimal deposit sebesar Rp.10.000,- *GABUNG SEKARANG JUGA DAN NIKMATI SENSASI PERMAINANNYA"
                                },
                                "created_at": "2022-10-18T18:53:46.000000Z",
                                "updated_at": "2022-10-24T23:47:38.000000Z"
                            },
                            {
                                "id": 8,
                                "id_situs": 19,
                                "id_fitur": 8,
                                "type": "desktop",
                                "status": 1,
                                "data": {
                                    "link": "https://www.dmca.com/Protection/Status.aspx?ID=b7e1ad05-2187-4abf-8078-8ed9c1a6c018",
                                    "name": "DMCA.com Protection Status",
                                    "image": "https://static.hokibagus.club/situs/zia togel/desktop/footer protection/_dmca_premi_badge_5.png"
                                },
                                "created_at": "2022-10-18T18:53:46.000000Z",
                                "updated_at": "2022-10-24T23:47:38.000000Z"
                            },
                            {
                                "id": 9,
                                "id_situs": 19,
                                "id_fitur": 9,
                                "type": "desktop",
                                "status": 1,
                                "data": {
                                    "image": "https://static.hokibagus.club/situs/zia togel/desktop/link alternatif/ziatogel_linkalternatif.png",
                                    "listLink": [
                                        "https://linkr.bio/ziatogel",
                                        "https://rebrand.ly/ziatogel",
                                        "https://ziatogel176.com"
                                    ]
                                },
                                "created_at": "2022-10-18T18:53:46.000000Z",
                                "updated_at": "2022-10-24T23:47:38.000000Z"
                            },
                            {
                                "id": 10,
                                "id_situs": 19,
                                "id_fitur": 10,
                                "type": "desktop",
                                "status": 1,
                                "data": {
                                    "name": "barcode qris",
                                    "color": "#ffffff",
                                    "image": "https://static.hokibagus.club/situs/zia togel/desktop/barcode qris/2840676.jpg",
                                    "shadow": "#196a7d",
                                    "background": "#2abf32"
                                },
                                "created_at": "2022-10-18T18:53:46.000000Z",
                                "updated_at": "2022-10-24T23:47:38.000000Z"
                            },
                            {
                                "id": 11,
                                "id_situs": 19,
                                "id_fitur": 11,
                                "type": "desktop",
                                "status": 1,
                                "data": [
                                    "BCA",
                                    "DANAMON",
                                    "BRI",
                                    "BNI",
                                    "MANDIRI",
                                    "CIMB",
                                    "OVO",
                                    "GOPAY",
                                    "DANA",
                                    "LINKAJA",
                                    "BSI",
                                    "MAYBANK"
                                ],
                                "created_at": "2022-10-18T18:53:46.000000Z",
                                "updated_at": "2022-10-24T23:47:38.000000Z"
                            }
                        ],
                        "mobile": [
                            {
                                "id": 12,
                                "id_situs": 19,
                                "id_fitur": 1,
                                "type": "mobile",
                                "status": 1,
                                "data": {
                                    "file": "https://static.hokibagus.club/situs/zia togel/mobile/popup modal/ziatogel_popup_bri.png",
                                    "deskripsi": "Klik di mana saja untuk menutup"
                                },
                                "created_at": "2022-10-18T18:53:46.000000Z",
                                "updated_at": "2022-10-24T23:47:38.000000Z"
                            },
                            {
                                "id": 13,
                                "id_situs": 19,
                                "id_fitur": 2,
                                "type": "mobile",
                                "status": 1,
                                "data": {
                                    "url": "https://bit.ly/ApkZia",
                                    "file": "https://static.hokibagus.club/situs/zia togel/mobile/header apk/ziatogel_profile.jpg",
                                    "title": "aplikasi ziatogel",
                                    "slogan": "Kini telah tersedia Aplikasi Android"
                                },
                                "created_at": "2022-10-18T18:53:46.000000Z",
                                "updated_at": "2022-10-24T23:47:38.000000Z"
                            },
                            {
                                "id": 14,
                                "id_situs": 19,
                                "id_fitur": 3,
                                "type": "mobile",
                                "status": 1,
                                "data": [
                                    "https://static.hokibagus.club/situs/zia togel/mobile/header corousel/ziatogel_slidermobile_prosesdeposit.jpg",
                                    "https://static.hokibagus.club/situs/zia togel/mobile/header corousel/ziatogel_slidermobile_tipebet.jpg",
                                    "https://static.hokibagus.club/situs/zia togel/mobile/header corousel/ziatogel_slidermobile_allbonus.jpg",
                                    "https://static.hokibagus.club/situs/zia togel/mobile/header corousel/ziatogel_popup_bri.png"
                                ],
                                "created_at": "2022-10-18T18:53:46.000000Z",
                                "updated_at": "2022-10-24T23:47:38.000000Z"
                            },
                            {
                                "id": 15,
                                "id_situs": 19,
                                "id_fitur": 4,
                                "type": "mobile",
                                "status": 1,
                                "data": [
                                    {
                                        "link": "https://rtpslotzia.com/",
                                        "name": "RTP Slot",
                                        "class": "btn-secondary",
                                        "style": null,
                                        "shadow": "#1b693c",
                                        "status": true,
                                        "target": true
                                    },
                                    {
                                        "link": "https://togelzia176.com/m/promotion.php",
                                        "name": "Promo",
                                        "class": "btn-warning",
                                        "style": null,
                                        "shadow": "#1b693c",
                                        "status": true,
                                        "target": true
                                    },
                                    {
                                        "link": "https://togelzia176.com/m/promotion.php",
                                        "name": "Keluhan Member",
                                        "class": "btn-info",
                                        "style": null,
                                        "shadow": "#1b693c",
                                        "status": true,
                                        "target": true
                                    },
                                    {
                                        "link": "https://linklist.bio/ziatogel88",
                                        "name": "Lain-Lain",
                                        "class": "btn-success",
                                        "style": null,
                                        "shadow": "#1b693c",
                                        "status": true,
                                        "target": true
                                    }
                                ],
                                "created_at": "2022-10-18T18:53:46.000000Z",
                                "updated_at": "2022-10-24T23:47:38.000000Z"
                            },
                            {
                                "id": 16,
                                "id_situs": 19,
                                "id_fitur": 5,
                                "type": "mobile",
                                "status": 1,
                                "data": {
                                    "ket": "Klik icon sosmed di bawah ini untuk hubungi operator :",
                                    "data": [
                                        {
                                            "link": "https://api.whatsapp.com/send/?phone=6281376779265&text=Halo+bossku+saya+butuh+bantuan.",
                                            "name": "Whatsapp",
                                            "image": "https://static.hokibagus.club/situs/zia togel/mobile/icon sosmed/ziatogel_contact_wa.png",
                                            "status": true
                                        },
                                        {
                                            "link": "https://www.instagram.com/ziatogel88/",
                                            "name": "Instagram",
                                            "image": "https://static.hokibagus.club/situs/zia togel/mobile/icon sosmed/ziatogel_contact_instagram.png",
                                            "status": true
                                        },
                                        {
                                            "link": "https://www.facebook.com/ziatogel889",
                                            "name": "Facebook",
                                            "image": "https://static.hokibagus.club/situs/zia togel/mobile/icon sosmed/ziatogel_contact_fb.png",
                                            "status": true
                                        },
                                        {
                                            "link": "https://www.youtube.com/channel/UCp3gfAsZlwBrTXGUSFlsIWA",
                                            "name": "Youtube",
                                            "image": "https://static.hokibagus.club/situs/zia togel/mobile/icon sosmed/ziatogel_contact_yt.png",
                                            "status": true
                                        }
                                    ]
                                },
                                "created_at": "2022-10-18T18:53:46.000000Z",
                                "updated_at": "2022-10-24T23:47:38.000000Z"
                            },
                            {
                                "id": 17,
                                "id_situs": 19,
                                "id_fitur": 6,
                                "type": "mobile",
                                "status": 1,
                                "data": {
                                    "link": "https://ziatogel176.com/register.php",
                                    "name": "Promo",
                                    "image": "https://static.hokibagus.club/dingdongtogel/images/banner/dingdongtogel_banner_bonus.gif"
                                },
                                "created_at": "2022-10-18T18:53:46.000000Z",
                                "updated_at": "2022-10-24T23:47:38.000000Z"
                            },
                            {
                                "id": 18,
                                "id_situs": 19,
                                "id_fitur": 7,
                                "type": "mobile",
                                "status": 1,
                                "data": {
                                    "title": "Situs Bandar Togel Online Resmi Terpercaya",
                                    "deskripsi": "ZIATOGEL MERUPAKAN SITUS TOGEL TERPERCAYA DENGAN PASARAN TOGEL TERLENGKAP, LIVE GAMES TERPOPULER & PERMAINAN SLOT TERBAIK."
                                },
                                "created_at": "2022-10-18T18:53:46.000000Z",
                                "updated_at": "2022-10-24T23:47:38.000000Z"
                            },
                            {
                                "id": 19,
                                "id_situs": 19,
                                "id_fitur": 8,
                                "type": "mobile",
                                "status": 1,
                                "data": {
                                    "link": "https://www.dmca.com/Protection/Status.aspx?ID=b7e1ad05-2187-4abf-8078-8ed9c1a6c018",
                                    "name": "DMCA.com Protection Status",
                                    "image": "https://static.hokibagus.club/situs/zia togel/mobile/footer protection/_dmca_premi_badge_5.png"
                                },
                                "created_at": "2022-10-18T18:53:46.000000Z",
                                "updated_at": "2022-10-24T23:47:38.000000Z"
                            },
                            {
                                "id": 20,
                                "id_situs": 19,
                                "id_fitur": 9,
                                "type": "mobile",
                                "status": 1,
                                "data": {
                                    "image": "https://static.hokibagus.club/situs/zia togel/mobile/link alternatif/ziatogel_linkalternatif.png",
                                    "listLink": [
                                        "https://linkr.bio/ziatogel",
                                        "https://rebrand.ly/ziatogel",
                                        "https://ziatogel176.com",
                                        "https://ziatogel176.com"
                                    ]
                                },
                                "created_at": "2022-10-18T18:53:46.000000Z",
                                "updated_at": "2022-10-24T23:47:38.000000Z"
                            },
                            {
                                "id": 21,
                                "id_situs": 19,
                                "id_fitur": 10,
                                "type": "mobile",
                                "status": 1,
                                "data": {
                                    "name": "barcode qris",
                                    "color": "#ffffff",
                                    "image": "https://static.hokibagus.club/situs/zia togel/mobile/barcode qris/2840676.jpg",
                                    "shadow": "#196a7d",
                                    "background": "#d52121"
                                },
                                "created_at": "2022-10-18T18:53:46.000000Z",
                                "updated_at": "2022-10-24T23:47:38.000000Z"
                            },
                            {
                                "id": 22,
                                "id_situs": 19,
                                "id_fitur": 11,
                                "type": "mobile",
                                "status": 1,
                                "data": [
                                    "BCA",
                                    "DANAMON",
                                    "BRI",
                                    "BNI",
                                    "MANDIRI",
                                    "CIMB",
                                    "OVO",
                                    "GOPAY",
                                    "DANA",
                                    "LINKAJA",
                                    "BSI",
                                    "MAYBANK"
                                ],
                                "created_at": "2022-10-18T18:53:46.000000Z",
                                "updated_at": "2022-10-24T23:47:38.000000Z"
                            }
                        ]
                    }
                }
                func.desktop.defaultFooter();
                if (response) {
                    if (response.status_desktop && !isMobile) {
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
