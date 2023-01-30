const lvUser = $('#content-site-data').attr("wire:id");

$(".SlectBox").SumoSelect({
    csvDispCount: 3,
    selectAll: !0,
    search: !0,
    searchText: "Enter here.",
    okCancelInMulti: !0,
    captionFormatAllSelected: "Yeah, OK, so everything.",
})

document.addEventListener('livewire:load', function () {
    $("#fiturDesktop").on('sumo:closed', function(sumo) {
        window.livewire.find(lvUser).fiturDesktop = $(sumo.target).val();
    });

    $("#fiturMobile").on('sumo:closed', function(sumo) {
        window.livewire.find(lvUser).fiturMobile = $(sumo.target).val();
    });

    document.getElementById('formSiteData').addEventListener('hidden.bs.modal', event => {
        window.livewire.find(lvUser).closeModal = false;
    })
})

document.addEventListener('sumo:reset', event => {
    $('#fiturDesktop')[0].sumo.unSelectAll();
    $('#fiturMobile')[0].sumo.unSelectAll();
});
document.addEventListener('sumo:select', event => {
    var data = event.detail;

    data.desktop.forEach(e => {
        $("#fiturDesktop")[0].sumo.selectItem(`${e}`);
    });
    data.mobile.forEach(e => {
        $("#fiturMobile")[0].sumo.selectItem(`${e}`);
    });
});


