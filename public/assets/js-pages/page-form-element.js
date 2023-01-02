const lvUser = $('#content-form-element').attr("wire:id");

$("#type").SumoSelect({
    csvDispCount: 3,
    selectAll: !0,
    search: !0,
    searchText: "Enter here.",
    okCancelInMulti: !0,
    captionFormatAllSelected: "Yeah, OK, so everything.",
});

$("#type").on('sumo:closed', function(sumo) {
    window.livewire.find(lvUser).type = $(sumo.target).val();
});

document.addEventListener("sumo:type", e => {
    if (e.detail.type == "set") {
        $("#type")[0].sumo.selectItem(e.detail.val.toString());
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
    $("#formElement").modal("hide");
});
