$(function () {
    (window.asd = $(".SlectBox").SumoSelect({
        csvDispCount: 3,
        selectAll: !0,
        captionFormatAllSelected: "Yeah, OK, so everything.",

    })),
        (window.Search = $(".search-box").SumoSelect({
            csvDispCount: 3,
            search: !0,
            searchText: "Enter here.",
        })),
        (window.sb = $(".SlectBox-grp-src").SumoSelect({
            csvDispCount: 3,
            search: !0,
            searchText: "Enter here.",
            selectAll: !0,
        })),
        $(".testselect1").SumoSelect(),
        $(".testselect2").SumoSelect(),
        $(".selectsum1").SumoSelect({ okCancelInMulti: !0, selectAll: !0 }),
        $(".selectsum2").SumoSelect({ selectAll: !0 });
});
