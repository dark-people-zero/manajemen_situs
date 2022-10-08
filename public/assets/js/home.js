var config = null;
var idActive = null;

$selecSitus = $(".select2-situs");
$selecSitus.select2({
    dropdownParent: $('.sidebar'),
    placeholder: "Choose one",
    ajax: {
        url: '/data-situs',
        dataType: 'json',
        processResults: function (data) {
            return {
                results: data.map((e) => {
                    e.text = e.name;
                    return e;
                })
            };
        }
    }
});

$(".header-icon-svgs-prev").click(function() {
    var url = $(this).attr("data-url");
    if(url) {
        $("#iframe-preview").attr("src", url)
        $(".header-icon-svgs-prev").removeClass("active");
        $(this).addClass("active");

        if($(this).hasClass("mobile")) {
            $("#iframe-preview").addClass("iframe-preview--mobile")
        }else{
            $("#iframe-preview").removeClass("iframe-preview--mobile")
        }
    }
})

$selecSitus.on("select2:select", function (e) {
    $frame = $("#iframe-preview");
    $defaultInfo = $("#defaultInfo");
    $areaPengaturan = $("#areaPengaturan");
    $data = e.params.data;
    $device = $data.device;
    iconPrev($device);
    $frame.removeClass("iframe-preview--mobile");
    $areaPengaturan.removeClass("show");
    if ($device.desktop.status) {
        $frame.attr("src", $device.desktop.url);
        $areaPengaturan.addClass("show");
    } else if($device.mobile.status) {
        $frame.attr("src", $device.mobile.url).addClass("iframe-preview--mobile");
        $areaPengaturan.addClass("show");
    } else {
        $frame.attr("src", "/underconstruction");
        $areaPengaturan.removeClass("show");
    }

    function iconPrev(device) {
        var desktop = $(".header-icon-svgs-prev.desktop");
        var mobile = $(".header-icon-svgs-prev.mobile");
        var tabdesktop = $('a[href="#desktop"]');
        var tabmobile = $('a[href="#mobile"]');
        var tabpanedesktop = $('#desktop');
        var tabpanemobile = $('#mobile');

        desktop.attr("data-url", device.desktop.status ? device.desktop.url : "/underconstruction");
        mobile.attr("data-url", device.mobile.status ? device.mobile.url : "/underconstruction");

        if (device.desktop.status) {
            desktop.addClass("active");
            mobile.removeClass("active");

            // untuk tab
            tabdesktop.addClass("active");
            tabpanedesktop.addClass("active");
            tabmobile.removeClass("active");
            tabpanemobile.removeClass("active");
        }else{
            desktop.removeClass("active");
            mobile.addClass("active");

            // untuk tab
            tabdesktop.removeClass("active");
            tabpanedesktop.removeClass("active");
            tabmobile.addClass("active");
            tabpanemobile.addClass("active");
        }
    }

    $defaultInfo.addClass("d-none");
    $frame.removeClass("d-none");

    $.getJSON(`/situs/config/${$data.id}.json`,
        function (data, textStatus, jqXHR) {
            config = data;
            idActive = $data.id;
            setValue(config, idActive);

        }
    ).fail(() => config = null)
});

$('a[data-bs-toggle="tab"]').click(function() {
    $type = $(this).attr("href").replace("#","");
    $(`.header-icon-svgs-prev.${$type}`).click();
    $(".sidebar-right").addClass("sidebar-open");
})

// function setValue(data, type) {
//     // set untuk desktop
//     setDekstop(data.desktop);
// }

// function setDekstop(data) {
//     var togglePromosi = $('#formDesktop input[name="promosi"]');
//     var toogleLinkAlter = $('#formDesktop input[name="linkAlter"]');
//     if (data.promosi) {
//         $("#promosiArea").show();
//         if (data.promosi.status) {
//             togglePromosi.prop('checked', data.promosi.status);

//             // set input
//             $('#formDesktop input[name="namaPromosi"]').val(data.promosi.name);
//             $('#formDesktop input[name="urlPromosi"]').val(data.promosi.link);
//             $("#previewImagePromosi img").attr("src", data.promosi.img);
//             $("#previewImagePromosi").removeClass("d-none");
//             var target = togglePromosi.closest(".custom-switch").attr("href");
//             $(target).collapse("show");
//         }else{
//             togglePromosi.prop('checked', false);
//         }
//     }else{
//         $("#promosiArea").hide();
//     }

//     if (data.linkAlter) {
//         $("#linkAlterArea").show();
//         if (data.linkAlter.status) {
//             toogleLinkAlter.prop('checked', data.linkAlter.status);

//             // set input
//             var urlAlter = $('#formDesktop textarea[name="urlAlter"]');
//             urlAlter.val(data.linkAlter.listLink.join(" | "));

//             setTimeout(() => {
//                 urlAlter.css("height", urlAlter[0].scrollHeight+"px");
//             }, 5);

//             $("#previewImageLinkAlter img").attr("src", data.linkAlter.img);
//             $("#previewImageLinkAlter").removeClass("d-none");

//             var target = toogleLinkAlter.closest(".custom-switch").attr("href");
//             $(target).collapse("show");
//         }else{
//             toogleLinkAlter.prop('checked', false);
//         }
//     }else{
//         $("#linkAlterArea").hide();
//     }
// }

// $("#formDesktop").submit(function(e) {
//     e.preventDefault();
//     console.log( $( this ).serialize() );
//     console.log(config);
//     console.log(idActive);
// })
