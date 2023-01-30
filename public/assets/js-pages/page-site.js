const idLivewire = $('#page-site').attr("wire:id");

var selecSitus = $(".select2-situs");
selecSitus.select2({
    placeholder: "Silahkan pilih situs",
    allowClear: true
}).on("select2:open", () => {
    $('input.select2-search__field').prop('placeholder', 'Cari situs...');
}).on("change.select2", function(e) {
    var trg = e.target;
    var opt = $(trg).find('option:selected');
    var d = opt.attr("status-d");
    var m = opt.attr("status-m");
    if (Number(d) || Number(m)) {
        window.livewire.find(idLivewire)["idSitus"] = trg.value;

        if (Number(d)) {
            window.livewire.find(idLivewire)["typeSite"] = "desktop";
            window.livewire.find(idLivewire).getFitur("desktop");
        }else if(Number(m)) {
            window.livewire.find(idLivewire).getFitur("mobile");
        }else{
            window.livewire.find(idLivewire).getFitur(null);

        }
    }else{
        window.livewire.find(idLivewire)["typeSite"] = null;
        window.livewire.find(idLivewire)["idSitus"] = null;
        window.livewire.find(idLivewire)["dataFitur"] = [];
    }

});


