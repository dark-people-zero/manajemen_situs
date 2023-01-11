const lvUser = $('#content-form-element').attr("wire:id");

$("#type").SumoSelect({
    csvDispCount: 3,
    selectAll: false,
    search: !0,
    closeAfterClearAll: true,
    // searchText: "Enter here.",
    okCancelInMulti: true,
    // captionFormatAllSelected: "Yeah, OK, so everything.",
});

$("#type").on('sumo:closed', function(sumo) {
    window.livewire.find(lvUser).type = $(sumo.target).val();

});

$("#name").SumoSelect({
    csvDispCount: 3,
//     selectAll: false,
//     search: !0,
//     closeAfterClearAll: true,
//     searchText: "Enter here.",
//     okCancelInMulti: !0,
//     captionFormatAllSelected: "Yeah, OK, so everything.",
});

$("#name").on('sumo:closed', function(sumo) {
    window.livewire.find(lvUser).name = $(sumo.target).val();
});

document.addEventListener("sumo:name", e => {
    console.log(e.detail.val)
    if (e.detail.type == "set") {
        $("#name")[0].sumo.selectItem(e.detail.val.toString());
    }

    if (e.detail.type == "reset") {
        var tr = $("#name").find('option[disabled="disabled"]');
        if (tr.length > 0) {
            tr.removeAttr("disabled");
            $("#name")[0].sumo.selectItem(tr[0].index);
            tr.attr("disabled", "disabled");
        }
    }

});

document.addEventListener("sumo:type", e => {
    if (e.detail.type == "set") {
        e.detail.val.forEach(val => {
            $("#type")[0].sumo.selectItem(val.toString());
        });
    }

    if (e.detail.type == "reset") {
        var tr = $("#type").find('option[disabled="disabled"]');
        if (tr.length > 0) {
            tr.removeAttr("disabled");
            $("#type")[0].sumo.selectItem(tr[0].index);
            tr.attr("disabled", "disabled");
        }
    }

});


document.addEventListener("modalClose", e => {
    $("#formFitur").modal("hide");
});
