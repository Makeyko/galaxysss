$(document).ready(function () {
    $(window).resize(function () {

        ellipses1 = $(".btn-breadcrumb :nth-child(2)")
        if ($(".btn-breadcrumb a:hidden").length > 0) {
            ellipses1.show()
        } else {
            ellipses1.hide()
        }

    })

    ellipses1 = $(".btn-breadcrumb :nth-child(2)")
    if ($(".btn-breadcrumb a:hidden").length > 0) {
        ellipses1.show()
    } else {
        ellipses1.hide()
    }

});