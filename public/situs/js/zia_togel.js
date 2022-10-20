var baseUrl = "http://127.0.0.1:8000/";

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
                            <a href="https://bit.ly/ApkZia" target="_blank" title="Download Apk Ziatogel" class="btn btn-green">DOWNLOAD</a>
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
            });
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





        promosi: (data) => {
            $(`
                <a href="${data.link}" target="_blank" title="${data.name}" class="promosi">
                    <img src="${data.img}">
                </a>
            `).insertBefore($("#latest-results"));
        },
        linkAlter: (data) => {
            console.log(data);
            var list = $(`
                <div class="linkalte-container">
                    <img src="${data.img}" class="linkalte-btn">
                    <ul class="linkalte-body"></ul>
                </div>
            `);

            data.listLink.forEach(e => {
                list.find("ul").append($(`
                    <li>
                        <a href="${e}" class="linkalte-item" target="_blank" title="Bandar Casino Online">${e.replace('https://','')}</a>
                    </li>
                `));
            });

            $('body').append(list);

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
        headerCorousel: (data) => {
            data = data.map((e) => {
                return `<div> <img src="${e}"></div>`;
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
                var shadow = e.shadow ? 'inset 0 -4px 0 '+e.shadow+';' : '';
                return `<a title="${e.name}" href="${e.link}" class="buttonWrap buttong contactSubmitButton ${e.class}" style="${shadow}${e.style}" target="${e.target ? '_blank' : ''}">${e.name}</a>`;
            }).join('');
            $(data).insertAfter(".button-green");
        },
        iconSosmed: (data) => {
            var icon = data.filter((e) => e.status).map((e) => {
                return `<a href="${e.link}" target="_blank">
                            <img src="${e.image}" alt="${e.name}">
                        </a>`;
            })

            var sos = $(`
                <div class="icon-sosmed">
                    <p class="deskripsi">Klik icon sosmed di bawah ini untuk hubungi operator :</p>
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
            url: baseUrl+"config/19",
            dataType: "json",
            success: function (response) {
                console.log(response);
                if (response) {
                    if (response.status_desktop && !isMobile) {
                        console.log("ini desktop");
                        if (response.fitur_situs.desktop) {
                            var length = response.fitur_situs.desktop.length;
                            response.fitur_situs.desktop.forEach((el, i) => {
                                if (el.id == 1) {
                                    if (el.status) {
                                        func.desktop.modal(el.data);
                                    }else{
                                        $("#myModal").modal("show");
                                    }
                                }

                                if (el.id == 2 && el.status) func.desktop.headerApk(el.data);

                                if (el.id == 3 && el.status) func.desktop.headerCorousel(el.data);

                                // untuk hide loading
                                if ((i+1) == length) $("#loadingCustom").hide();
                            });
                        }else{
                            $("#loadingCustom").hide();
                        }
                    }else if(response.status_mobile && isMobile){
                        console.log("ini mobile");
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

        // $.getJSON("/situs/config/zia_togel.json",
        //     function (data, textStatus, jqXHR) {
        //         if (textStatus == 'success') {
        //             if (isMobile) {
        //                 if(data.mobile.headerApk) {
        //                     if(data.mobile.headerApk.status) func.mobile.headerApk(data.mobile.headerApk);
        //                 }

        //                 if(data.mobile.banner) {
        //                     if(data.mobile.banner.status) func.mobile.banner(data.mobile.banner.data);
        //                 }

        //                 if (data.mobile.btnAction) {
        //                     if (data.mobile.btnAction.length > 0) func.mobile.btnAction(data.mobile.btnAction);
        //                 }

        //                 if (data.mobile.iconSosmed) {
        //                     if (data.mobile.iconSosmed.data.length > 0) func.mobile.iconSosmed(data.mobile.iconSosmed);
        //                 }

        //                 if (data.mobile.promosi) {
        //                     if (data.mobile.promosi.status) func.mobile.promosi(data.mobile.promosi);
        //                 }

        //                 if (data.mobile.beforeFooter) {
        //                     if (data.mobile.beforeFooter.status) func.mobile.beforeFooter(data.mobile.beforeFooter);
        //                 }

        //                 if (data.mobile.footerProtection) {
        //                     if (data.mobile.footerProtection.status) func.mobile.footerProtection(data.mobile.footerProtection);
        //                 }

        //                 if (data.mobile.modalPopup) {
        //                     if (data.mobile.modalPopup.status) func.mobile.modalPopup(data.mobile.modalPopup);
        //                 }
        //             }else{
        //                 if (data.desktop) {
        //                     if (data.desktop.promosi.status) func.desktop.promosi(data.desktop.promosi);
        //                 }

        //                 if (data.desktop.linkAlter) {
        //                     if (data.desktop.linkAlter.status) func.desktop.linkAlter(data.desktop.linkAlter);
        //                 }
        //             }

        //         }
        //     }
        // );
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
// var insertClass = setInterval(() => {
//     var listBank = document.querySelectorAll('.bankscroll .owl-item .item');
//     if (listBank.length > 0) {
//         clearInterval(insertClass);
//         var loc = document.location.href;
//         var isMobile = /\/m\//g.test(loc) ? true : (/\/m/g.test(loc) ? true : false);
//         if (!isMobile) {
//             // add class bank
//             for (let i = 0; i < listBank.length; i++) {
//                 const element = listBank[i];
//                 var targetClass = element.children[0];
//                 var img = element.children[1].currentSrc;
//                 img = img.split("/").at(-1).split('.')[0].toLowerCase();
//                 img = img == 'nofound' ? 'mandiri' : img;
//                 targetClass.classList.add(img);
//             }
//         }
//     }
// }, 1);


var replaceCorouselBank = setInterval(() => {
    var targetReplace = document.querySelector('.bankscroll');
    var listImg = document.querySelectorAll('.bankscroll .owl-item .item img');
    var urutan = [
        'BCA',
        'MANDIRI',
        'BRI',
        'BNI',
        'DANAMON',
        'CIMB',
        'OVO',
        'GOPAY',
        'DANA',
        'LINKAJA',
        'BSI',
        'MAYBANK',
    ];

    if (listImg.length > 0) {
        clearInterval(replaceCorouselBank);
        var div = document.createElement("div");
        div.classList.add("bankscroll");

        urutan.forEach(urut => {
            urut = urut.toLocaleLowerCase();
            for (let i = 0; i < listImg.length; i++) {
                const element = listImg[i];
                const img = element.getAttribute("src").split("/").at(-1);
                if (img.toLocaleLowerCase().indexOf(urut) > -1) {
                    var x = element.closest('.item');
                    x.children[0].classList.add(urut);
                    div.appendChild(x);
                }else{
                    if (urut == 'mandiri') {
                        var urut2 = 'nofound';
                        if (img.toLocaleLowerCase().indexOf(urut2) > -1) {
                            var x = element.closest('.item');
                            x.children[0].classList.add(urut);
                            div.appendChild(x);
                        }
                    }
                }
            }
        });

        $(div).owlCarousel({ autoPlay: 5000, items: 5, itemsDesktop: false });

        targetReplace.parentNode.insertBefore(div, targetReplace);
        targetReplace.remove();
    }
}, 1);
