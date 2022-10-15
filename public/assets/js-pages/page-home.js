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
