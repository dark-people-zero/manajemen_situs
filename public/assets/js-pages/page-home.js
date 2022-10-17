const lvUser = $('#content-home').attr("wire:id");

var selecSitus = $(".select2-situs");
selecSitus.select2({
    dropdownParent: $('.sidebar'),
    placeholder: "Choose one",
});

document.addEventListener('livewire:load', function () {
    selecSitus.on("select2:select", function (e) {
        window.livewire.find(lvUser).idSitus = e.params.data.id;
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

document.addEventListener('testing', function (e) {
    console.log(e.detail);
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
});

document.addEventListener('livewire:update', function (e) {
    Coloris({
        el: '.shadowColor',
        theme: 'polaroid',
        parent: '.modalActionBtn',
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
})

function editorMirror(target) {
    var saveTarget = target.getAttribute("data-target");
    var optionCodeMirrorBtnActionDesktop = {
        theme: "yonce",
        height: "auto",
        viewportMargin: Infinity,
        mode: {
            name: "javascript",
            json: true,
            statementIndent: 2
        },
        lineNumbers: true,
        lineWrapping: true,
        indentWithTabs: false,
        tabSize: 2,
        autoCloseTags: true,
        autoCloseBrackets: true,
        foldGutter: true,
        gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter"],
        value: "asasas"
    };
    var editor = CodeMirror.fromTextArea(target, optionCodeMirrorBtnActionDesktop);

    var panel = $(`
        <div class="panel">
            <span>Masukkan pengaturan disini.</span>
            <div>
                <a href="javascript:void(0)" class="fullsceen">
                    <i class="fa fa-expand"></i>
                </a>
                <a href="javascript:void(0)" class="minimize">
                    <i class="fa fa-compress"></i>
                </a>
            </div>
        </div>
    `);

    panel.find(".fullsceen").click(function() {
        if (!document.fullscreenElement) {
            $(this).closest('.panel').parent()[0]?.requestFullscreen()
            editor.setOption("fullScreen", !editor.getOption("fullScreen"));
            $(this).closest('.panel').addClass("fullScreen-panel");
        }
    });

    panel.find(".minimize").click(function() {
        if (document.fullscreenElement) {
            document.exitFullscreen();
            if (editor.getOption("fullScreen")) editor.setOption("fullScreen", false);
            $(this).closest('.panel').removeClass("fullScreen-panel");

        }
    });

    editor.addPanel(panel[0], {
        position: "top",
        stable: true
    });

    editor.on("change", function(ed,a) {
        const val = ed.doc.getValue();
        window.livewire.find(lvUser)[saveTarget] = val;
    });

    setTimeout(() => {
        panel.parent()[0].addEventListener("fullscreenchange", function(e) {
            if (!document.fullscreenElement) {
                if (editor.getOption("fullScreen")) editor.setOption("fullScreen", false);
                $(e.target).find('.panel').removeClass("fullScreen-panel");
            }
        })
    }, 1000);
}

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

    console.log(e.detail);
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




