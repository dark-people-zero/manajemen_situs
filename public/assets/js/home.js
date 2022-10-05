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
    $data = e.params.data;
    $device = $data.device;
    iconPrev($device);
    $frame.removeClass("iframe-preview--mobile");
    if ($device.web.status) {
        $frame.attr("src", $device.web.url);
    } else if($device.mobile.status) {
        $frame.attr("src", $device.mobile.url).addClass("iframe-preview--mobile");
    } else {
        $frame.attr("src", "/underconstruction");
    }

    function iconPrev(device) {
        var web = $(".header-icon-svgs-prev.desktop");
        var mob = $(".header-icon-svgs-prev.mobile");

        web.attr("data-url", device.web.status ? device.web.url : "/underconstruction");
        mob.attr("data-url", device.mobile.status ? device.mobile.url : "/underconstruction");

        if (device.mobile.status) {
            mob.addClass("active");
            web.removeClass("active");
        }else{
            mob.removeClass("active");
            web.addClass("active");
        }
    }

    $defaultInfo.addClass("d-none");
    $frame.removeClass("d-none");
});
