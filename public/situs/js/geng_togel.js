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
                                <img src="${data.image.url}" width="600" height="350" class="imgads">
                                <p aria-label="Close" aria-hidden="true" class="deskripsi">${data.name.Deskripsi}</p>
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
                                <img src="${data.image.url}" alt="App Icon">
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

            data = data.images.map(e => {
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
            data = data.data_buttonaction.filter(e => e.status).map(e => {
                return `<a class="btn btn-custom ${e.class}" href="${e.link}" style="${e.style}" target="${e.target ? '_blank' : ''}">${e.name}</a>`;
            }).join("");

            $(".sidebar-button").append($(data));
        },
        iconSosmed: (data) => {
            var icon = data.data_iconsosmed.filter(e => e.status).map(e => {
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
                    <div class="icon-info">${data.name.Keterangan}</div>
                    <div class="icon-container">${icon}</div>
                </div>
            `);

            $(".blog-posts").append(template);
        },
        promosi: (data) => {

            $(`
                <div class="promosi">
                    <a href="${data.name.Link}" target="_blank" title="${data.name.Promo}">
                        <img src="${data.image.url}" alt="${data.name.Promo}">
                    </a>
                </div>
            `).insertBefore($("#latest-results"));
        },
        beforeFooter: (data) => {

            var template = $(`
                <div class="before-footer container">
                    <h2>${data.textarea}</h2>
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

            var listLink = data.textarea.split("--").map(e => {
                return `
                    <div class="linkalte-item">
                        <a href="${e}" target="_blank" title="Bandar Casino Online">${e.replace('https://','')}</a>
                    </div>
                `;
            }).join("")

            var template = $(`
                <div class="linkalte-container">
                    <img src="${data.image.url}" class="linkalte-btn">
                    <div class="linkalte-body">
                        <div class="linkalte-list">${listLink}</div>
                    </div>
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
        listMenu: (data) => {
            var banner = data.data_listbanner.filter((e) => e.status).map((e) => {
                return `<a href="${e.link}" target="_blank">
                            <img src="${e.image}" alt="${e.name}">
                        </a>`;
            })

            var sos = $(`
                <div class="list-menu-mobile">
                    ${banner.join('')}
                </div>
            `)

            sos.insertBefore($('.wrapper2'));
            
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
                                    <img src="${data.image.url}" class="popup-img">
                                </a>
                                <p aria-label="Close" aria-hidden="true" class="deskripsi">${data.name.Deskripsi}</p>
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
                                <img src="${data.image.url}" alt="App Icon">
                            </div>
                            <div class="app_info">
                                <div class="app_title">${data.name.Title}</div>
                                <div class="app_slogan">${data.name.Slogan}</div>
                            </div>
                        </div>
                        <div class="download_button">
                            <a href="${data.name.URLDownload}" target="_blank" title="Download Apk Yowestogel" class="btn btn-green">DOWNLOAD</a>
                        </div>
                    </div>
                </div>
            `);
            banner.find("#close_button").click(() => {
                $("#content").removeClass("apk-download");
            })
            $("#content .page-header").prepend(banner);
            $("#content .page-header .app-container").remove();
        },
        headerCorousel: (data) => {

            data = data.images.map((e) => {
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
            data = data.data_buttonaction.filter((e) => e.status).map((e) => {
                var shadow = e.shadow ? 'inset 0 -4px 0 '+e.shadow+';' : '';
                return `<a title="${e.name}" href="${e.link}" class="buttonWrap buttong contactSubmitButton ${e.class}" ${e.style ? `style=${shadow}${e.style}` : ""} ${e.target ? `target=_blank` : ''}>${e.name}</a>`;
            }).join('');
            $(data).insertAfter(".button-green");
        },
        iconSosmed: (data) => {
            var icon = data.data_iconsosmed.filter((e) => e.status).map((e) => {
                return `<a href="${e.link}" target="_blank">
                            <img src="${e.image}" alt="${e.name}">
                        </a>`;
            })
            var sos = $(`
                <div class="icon-sosmed">
                    <p class="deskripsi">${data.name.Keterangan}</p>
                    <div class="icon">${icon.join('')}</div>
                </div>
            `)

            sos.insertBefore($('.inner-wrap'));
        },
        promosi: (data) => {
            var pro = $(`
                <a href="${data.name.Link}" target="_blank" title="${data.name.Promo}" class="promosi">
                    <img src="${data.image.url}">
                </a>
            `);
            pro.insertBefore($('.inner-wrap'))
        },
        beforeFooter: (data) => {

            var before = $(`
                <div class="beforeFooter">
                    <center><h2 class="tittle">${data.name.Title}</h2></center>
                    <p class="deskripsi">${data.textarea}</p>
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
        },
        listMenu: (data) => {
            var banner = data.data_listbanner.filter((e) => e.status).map((e) => {
                return `<a href="${e.link}" target="_blank">
                            <img src="${e.image}" alt="${e.name}">
                        </a>`;
            })
            var sos = $(`
                <div class="list-menu-mobile">
                    ${banner.join('')}
                </div>
            `)
            sos.insertBefore($('.wrapper2'));
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
            url: "https://static.hokibagus.club/situs/gengtogel/json/gengtogel.json",
            dataType: "json",

            success: function (response) {
                if (response) {
                    if (!isMobile) {
                        func.desktop.defaultItem();
                        if (response) {
                            response.forEach((el, i) => {
                                if(el.type == "desktop" && !isMobile) {
                                    var data = JSON.parse(el.data); 
                                    console.log(data);
                                    if (el.id_fitur == 1 && data) {
                                        if (data.switch) {
                                            func.desktop.modal(data);
                                        }else{
                                            $("#myModal").modal("show");
                                        }
                                    }
    
                                    if (el.id_fitur == 2 && data){if(data.switch) func.desktop.headerApk(data)};
    
                                    if (el.id_fitur == 3 && data){if(data.switch) func.desktop.headerCorousel(data)};
    
                                    if (el.id_fitur == 4 && data){if(data.switch)  func.desktop.btnAction(data)};
    
                                    if (el.id_fitur == 5 && data){if(data.switch) func.desktop.iconSosmed(data)};
    
                                    if (el.id_fitur == 6 && data){if(data.switch)  func.desktop.promosi(data)};
    
                                    if (el.id_fitur == 7 && data){if(data.switch)  func.desktop.beforeFooter(data)};
    
                                    if (el.id_fitur == 8 && data){if(data.switch)  func.desktop.footerProtection(data)};
    
                                    if (el.id_fitur == 9 && data){if(data.switch)  func.desktop.linkAlter(data)};
    
                                    if (el.id_fitur == 10 && data){if(data.switch)  func.desktop.barcodeQris(data)};
    
                                    if (el.id_fitur == 11 && data){if(data.switch)  func.desktop.sortBank(data)};

                                    if (el.id_fitur == 12 && data){if(data.switch)  func.desktop.listMenu(data)};
    
                                    // untuk hide loading
                                    // if ((i+1) == length) $("#loadingCustom").hide();
                                }
                                
                            });
                        }else{
                            $("#loadingCustom").hide();
                        }
                    }else if(response && isMobile){
                        if (response) {
                            // var length = response.fitur_situs.mobile.length;
                            response.forEach((el, i) => {
                                if(el.type == "mobile" && isMobile) {
                                    var data = JSON.parse(el.data); 

                                    if (el.id_fitur == 1 && data){if(data.switch) func.mobile.modal(data)};
    
                                    if (el.id_fitur == 2 && data){if(data.switch) func.mobile.headerApk(data)};
    
                                    if (el.id_fitur == 3 && data){if(data.switch) func.mobile.headerCorousel(data)};

                                    if (el.id_fitur == 4 && data){if(data.switch)  func.mobile.btnAction(data)};

                                    if (el.id_fitur == 5 && data){if(data.switch) func.mobile.iconSosmed(data)};

                                    if (el.id_fitur == 6 && data){if(data.switch)  func.mobile.promosi(data)};

                                    if (el.id_fitur == 7 && data){if(data.switch)  func.mobile.beforeFooter(data)};

                                    if (el.id_fitur == 8 && data){if(data.switch)  func.mobile.footerProtection(data)};

                                    if (el.id_fitur == 9 && data){if(data.switch)  func.mobile.linkAlter(data)};

                                    if (el.id_fitur == 10 && data){if(data.switch)  func.mobile.barcodeQris(data)};

                                    if (el.id_fitur == 11 && data){if(data.switch)  func.mobile.sortBank(data)};

                                    if (el.id_fitur == 12 && data){if(data.switch)  func.mobile.listMenu(data)};
    
                                    // untuk hide loading
                                    // if ((i+1) == length) $("#loadingCustom").hide();
                                }
                                
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
