const lvUser = $('#content-home').attr("wire:id");

var selecSitus = $(".select2-situs");
selecSitus.select2({
    dropdownParent: $('.sidebar'),
    placeholder: "Choose one",
});

document.addEventListener('livewire:load', function () {
    selecSitus.on("select2:select", function (e) {
        window.livewire.find(lvUser).changeSelectSitus(e.params.data.id);
    });
})

$('.layout-setting').click(function() {
    $("#iframe-preview").contents().find('body').toggleClass('dark-theme');
})

document.addEventListener('showModalMore', function (e) {
    var target = e.detail.target,
        img = e.detail.img;
    if (img.length > 0) {
        var targetDom = $('.modalPrevContainer');
        targetDom.children().remove();
        img.forEach((value, index) => {
            var template = $(`
                <div class="modalPrevImage">
                    <img src="${value}">
                    <div class="removePreviewImage">
                        <i class="fe fe-x"></i>
                    </div>
                </div>
            `);
            template.find('.removePreviewImage').click(function() {
                window.livewire.find(lvUser).removeImage(target, index.toString());
                template.remove();
            });
            targetDom.append(template);
        });
    }
    $("#previewIMageModal").modal("show");
});

function changeCheckbox(self) {
    var type = $(self).data('type'),
        target = $(self).data('target');
    window.livewire.find(lvUser)[`toogle_${target}_${type}`] = $(self).prop("checked");
}

$(document).ready(function() {
    if ($('#formAddSosmedDesktop .form-sosmed-container').length > 0) {
        new PerfectScrollbar('#formAddSosmedDesktop .form-sosmed-container', {
            suppressScrollX: true
        });
    }
    if ($('#formAddSosmedMobile .form-sosmed-container').length > 0) {
        new PerfectScrollbar('#formAddSosmedMobile .form-sosmed-container', {
            suppressScrollX: true
        });
    }
    if ($('#formAddbtnActionDesktop .form-sosmed-container').length > 0) {
        new PerfectScrollbar('#formAddbtnActionDesktop .form-sosmed-container', {
            suppressScrollX: true
        });
    }

    if ($('#formAddbtnActionMobile .form-sosmed-container').length > 0) {
        new PerfectScrollbar('#formAddbtnActionMobile .form-sosmed-container', {
            suppressScrollX: true
        });
    }
});

document.addEventListener('livewire:update', function (e) {
    Coloris({
        el: '.coloris',
        theme: 'polaroid',
        // parent: '.modalActionBtn',
        themeMode: 'dark',
        selectInput: true,
        focusInput: true,
        swatches: [
          '#067bc2',
          '#84bcda',
          '#80e377',
          '#ecc30b',
          '#f37748',
          '#d56062'
        ]
    });

    Coloris.setInstance('.coloris-barcode', { parent: '.sidebar' });
    Coloris.setInstance('.shadowColor', { parent: '.modalActionBtn' });

    for (let i = 0; i < $(".resize").length; i++) resize($(".resize")[i]);
})

document.addEventListener("showModalSosmed", function(e) {
    var desktop = e.detail.desktop;
    if(desktop) {
        $("#formAddSosmedDesktop").modal("show");
    }else{
        $("#formAddSosmedMobile").modal("show");
    }
});

document.addEventListener("closeModalSosmed", function(e) {
    var desktop = e.detail.desktop;
    if(desktop) {
        $("#formAddSosmedDesktop").modal("hide");
    }else{
        $("#formAddSosmedMobile").modal("hide");
    }
});

document.addEventListener("showModalBtnAction", function(e) {
    var desktop = e.detail.desktop;
    if(desktop) {
        $("#formAddbtnActionDesktop").modal("show");
    }else{
        $("#formAddbtnActionMobile").modal("show");
    }
});

document.addEventListener("closeModalBtnAction", function(e) {
    var desktop = e.detail.desktop;
    if(desktop) {
        $("#formAddbtnActionDesktop").modal("hide");
    }else{
        $("#formAddbtnActionMobile").modal("hide");
    }
});

function sampleButton(self) {
    var href = $(self).attr('href');
    var target = $(self).attr('target');

    if (href != '') window.open(href+'?target='+target,'_blank');
}

function resize(self) {
    var height = self.scrollHeight > 200 ? 200 : self.scrollHeight;
    $(self).css('height', 'auto');
    $(self).css('height', height+'px');
}

document.addEventListener('iframe:reload', () => document.getElementById("iframe-preview").contentWindow.location.reload());




