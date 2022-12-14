$(document).ready(function () {
    $("#but1").click(function () {
        $("body").removeClass("timer-alert");
        var t = $("#message").val();
        "" == t && (t = "Your message"), swal(t);
    }),
        $("#but2").click(function () {
            var t = $("#message").val();
            $("body").removeClass("timer-alert");
            var e = $("#title").val();
            "" == t && (t = "Your message"),
                "" == e && (e = "Your message"),
                swal(e, t);
        }),
        $("#but3").click(function () {
            var t = $("#message").val();
            $("body").removeClass("timer-alert");
            var e = $("#title").val();
            "" == t && (t = "Your message"),
                "" == e && (e = "Your message"),
                swal({
                    title: e,
                    text: t,
                    imageUrl:
                        "http://127.0.0.1:8000/assets/img/brand/favicon.png",
                });
        }),
        $("#but4").click(function () {
            var t = $("#message").val();
            $("body").addClass("timer-alert");
            var e = $("#title").val();
            "" == t && (t = "Your message"),
                "" == e && (e = "Your message"),
                (t += "(close after 2 seconds)"),
                swal({ title: e, text: t, timer: 2e3, showConfirmButton: !1 });
        }),
        $("#click").click(function () {
            $("body").removeClass("timer-alert");
            var t = $("#type").val();
            swal({ title: "Title", text: "Your message", type: t });
        }),
        $("#prompt").click(function () {
            swal(
                {
                    title: "Add",
                    text: "Enter your message",
                    type: "input",
                    showCancelButton: !0,
                    closeOnConfirm: !1,
                    inputPlaceholder: "Your message",
                },
                function (t) {
                    "" != t && swal("Input", "You have entered : " + t);
                }
            );
        }),
        $("#confirm").click(function () {
            swal({
                title: "Alert",
                text: "Are you really want to exit",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Exit",
                cancelButtonText: "Stay on the page",
            });
        }),
        $("#click").click(function () {
            swal(
                "Congratulations!",
                "Your message has been succesfully sent",
                "success"
            );
        }),
        $("#click1").click(function () {
            swal({
                title: "Alert",
                text: "Waring alert",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Exit",
                cancelButtonText: "Stay on the page",
            });
        }),
        $("#click2").click(function () {
            swal({
                title: "Alert",
                text: "Danger alert",
                type: "error",
                showCancelButton: !0,
                confirmButtonText: "Exit",
                cancelButtonText: "Stay on the page",
            });
        });
});
