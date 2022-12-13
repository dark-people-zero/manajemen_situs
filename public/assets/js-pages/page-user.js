const lvUser = $('#content-user').attr("wire:id");

// var ps = new PerfectScrollbar('#modalFormUser', {
//     useBothWheelAxes:true,
//     suppressScrollX:true,
// });

runScriptAccessSite();

document.addEventListener("access:site", e => runScriptAccessSite());

$("#role").SumoSelect({
    csvDispCount: 3,
    selectAll: !0,
    search: !0,
    searchText: "Enter here.",
    okCancelInMulti: !0,
    captionFormatAllSelected: "Yeah, OK, so everything.",
});

$("#role").on('sumo:closed', function(sumo) {
    window.livewire.find(lvUser).role = $(sumo.target).val();
});

document.addEventListener("collapse:fitur", e => {
    var data = e.detail.data;
    var index = e.detail.index;
    var fiturSitus = data ? data.fitur_situs : [];
    var fitur = e.detail.fitur;
    var existing = e.detail.existing;
    var target = $(`#collSite-${index}`);
    target.find('.loading').removeClass('d-flex');
    target.find('tbody').children().not('.dataFiturNull').remove();

    // kita cek apakah pada situs yang di pilih
    // sudah ada fitur nya atau belom
    if (fiturSitus.length > 0) {
        target.find('.dataFiturNull').hide();
        // jika sudah maka
        // cek filter datanya berdarsarkan desktop atau mobile
        var fiturSitusDesktop = fiturSitus.filter(e => e.type == 'desktop');
        var fiturSitusMobile = fiturSitus.filter(e => e.type == 'mobile');

        if (fiturSitusDesktop.length > 0 || fiturSitusMobile.length > 0) {
            if (fitur) {
                fitur.forEach((el,i) => {
                    var showD = fiturSitusDesktop.find(element => element.id_fitur == el.id) ? true : false;
                    var showM = fiturSitusMobile.find(element => element.id_fitur == el.id) ? true : false;
                    var htmlD = "", htmlM = "", mobile = false, desktop = false;

                    if (existing) {
                        if (existing.akses_fitur.length > 0) {
                            var x = existing.akses_fitur;
                            var found = x.find(element => element.id_fitur == el.id);
                            if (found) {
                                mobile = found.mobile;
                                desktop = found.desktop;
                            }
                        }
                    }

                    if (showD) htmlD = `
                        <div class="checkbox">
                            <div class="custom-checkbox custom-control">
                                <input type="checkbox" data-id="${el.id}" data-type="desktop" data-index="${index}" class="custom-control-input checkFitur" id="checkbox-${index}-${i}-desktop" ${desktop ? 'checked' : '' }>
                                <label for="checkbox-${index}-${i}-desktop" class="custom-control-label mt-1"></label>
                            </div>
                        </div>
                    `;


                    if (showM) htmlM = `
                        <div class="checkbox">
                            <div class="custom-checkbox custom-control">
                                <input type="checkbox" data-id="${el.id}" data-type="mobile" data-index="${index}" class="custom-control-input checkFitur" id="checkbox-${index}-${i}-mobile" ${mobile ? 'checked' : '' }>
                                <label for="checkbox-${index}-${i}-mobile" class="custom-control-label mt-1"></label>
                            </div>
                        </div>
                    `;

                    var htmlData = $(`
                        <tr>
                            <td>${el.name}</td>
                            <td class="text-center">${htmlD}</td>
                            <td class="text-center">${htmlM}</td>
                        </tr>
                    `);

                    htmlData.find('.checkFitur').change(function() {
                        var id = $(this).attr("data-id"),
                            type = $(this).attr("data-type"),
                            index = $(this).attr("data-index");

                        var target = $(this).closest('tr');
                        var data = {
                            [id]: {
                                id: id,
                                desktop: target.find('input[data-type="desktop"]').prop("checked") ?? false,
                                mobile: target.find('input[data-type="mobile"]').prop("checked") ?? false
                            }
                        };

                        window.livewire.find(lvUser).addAccessSiteVal(index,'fitur',data);
                    });

                    target.find('tbody').append(htmlData);
                });
            }
        }else{
            target.find('.dataFiturNull').show();
        }
    }else{
        target.find('.dataFiturNull').show();
    }

});

function runScriptAccessSite() {
    // ps.update();
    for (let i = 0; i < $(".SlectBox").length; i++) {
        const element = $($(".SlectBox")[i]);
        if (!element.hasClass('SumoUnder')) {

            element.SumoSelect({
                csvDispCount: 3,
                selectAll: !0,
                search: !0,
                searchText: "Enter here.",
                okCancelInMulti: !0,
                captionFormatAllSelected: "Yeah, OK, so everything.",
            });

            element.on('sumo:closed', function(sumo) {
                var target =  $(sumo.target);
                var index = target.data("index");
                window.livewire.find(lvUser).addAccessSiteVal(index,'site',target.val());
                target.closest('.classSite').find('.loading').addClass('d-flex');
            });

            element.on("sumo:opening", function(sumo) {
                var target =  $(sumo.target);
                var index = target.data("index");
                var countChild = target.find('option').not(':last-child');

                var target = $(".SlectBox");

                var ind = [];
                for (let i = 0; i < target.length; i++) {
                    const element = target[i];
                    var seIndex = element.selectedIndex;
                    var opt = element.children[seIndex];

                    if (opt.getAttribute("value") != "") ind.push(element.selectedIndex);
                }
                ind = [...new Set(ind)];

                for (let i = 0; i < countChild.length; i++) sumo.target.sumo.enableItem(i);

                ind.forEach(e => {
                    if(sumo.target.selectedIndex != e) sumo.target.sumo.disableItem(e);
                });
            })
        }
    }

    var collapseAll = document.querySelectorAll('.collapse');
    for (let i = 0; i < collapseAll.length; i++) {
        const element = collapseAll[i];
        element.addEventListener('show.bs.collapse', function (e) {
            var tr = $(`[href="#${e.target.id}"]`).closest('.SumoSelect-group').addClass('collase-show');
        })

        element.addEventListener('hide.bs.collapse', function (e) {
            var tr = $(`[href="#${e.target.id}"]`).closest('.SumoSelect-group').removeClass('collase-show');
        })
    }

    $('.checkFiturAll').change(function() {
        var type = $(this).data('type');
        $(this).closest('table').find(`.checkFitur[data-type="${type}"]`).prop("checked", $(this).prop("checked")).trigger('change');
    })

}

document.addEventListener("modalClose", e => {
    $("#formUser").modal("hide");
});

document.addEventListener("sumo:role", e => {
    if (e.detail.type == "set") {
        $("#role")[0].sumo.selectItem(e.detail.val.toString());
        // if (e.detail.val == 1) {
        //     $("#aksesMenuAndSite").hide();
        // }
    }

    if (e.detail.type == "reset") {
        var tr = $("#role").find('option[disabled="disabled"]');
        if (tr.length > 0) {
            tr.removeAttr("disabled");
            $("#role")[0].sumo.selectItem(tr[0].index);
            tr.attr("disabled", "disabled");
        }

        // $("#aksesMenuAndSite").show();
    }

});

document.addEventListener("sumo:site", e => {
    var data = e.detail.data;
    var index = e.detail.index;
    index.forEach(el => {
        var site = data[el].site;
        var target = $(`select[data-index="${el}"]`);
        target[0].sumo.selectItem(site.toString());
    });
})

document.addEventListener("logout", e => {
    $('#formLogout').submit();
})
