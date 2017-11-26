var callme = {
    errors: !1, init: function (a) {
        $(document).on("click", a, function () {
            callme.open()
        }), $(document).on("click", "#callback-buttonclose", function () {
            callme.close()
        }), $(document).on("click", "#callback-submit", function () {
            callme.submit()
        })
    }, open: function () {
        1 == $("#callback").attr("data-loaded") ? ($("#callBack").fadeIn(1), $("#ref").trigger("click")) : $.ajax({
            url: "/index.php?route=information/contact/callme",
            type: "get",
            success: function (a) {
                $("body").prepend(a), $("#callBack").fadeIn(1), $("#callback-submit").parents(".modal-footer").show(), $("#ref").trigger("click")
            }
        })
    }, close: function () {
        $("#callBack").fadeOut(1)
    }, submit: function () {
        data = this.collectData(), this.errors = this.validate(data), this.errors || $.ajax({
            url: "/index.php?route=information/contact/callme",
            type: "post",
            dataType: "json",
            data: data,
            success: function (a) {
                $("#callBack > *").each(function () {
                    $(this).removeClass("error")
                }), void 0 != a.status && void 0 != a.text ? (console.log("1"), $("#callback-submit").parent().append('<span id="callMeStatus" style="display: none;">' + a.text + "</span>"), $("#callback-submit").hide(), $("#callMeStatus").fadeIn(150), setTimeout(function () {
                    $("#callMeStatus").fadeOut(150), callme.close()
                }, 2e3, callme)) : a.errors && (console.log("2"), $(a.errors).each(function (a, e) {
                    console.log(a, e), $("#callback-name" + e).addClass("error")
                }))
            },
            error: function () {
                alert("Internal server error :( <br> Please contact system administrator.")
            }
        })
    }, collectData: function () {
        return data = {}, data.name = $("#callback-name").val(), data.phone = $("#callback-phone").val().replace(/[^\d\.]/g, ""), data.comment = $("#callback-comment").val(), data
    }, validate: function (a) {
        // a.name.length < 3 ? (this.erros = !0, $("#callback-name").addClass("error")) : $("#callback-name").removeClass("error"),
        this.errors = !1, a.phone.length < 6 ? (this.erros = !0, $("#callback-phone").addClass("error")) : $("#callback-phone").removeClass("error")
    }
};