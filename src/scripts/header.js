jQuery(document).ready(function ($) {
    $("#page").css("padding-top", $("#masthead").outerHeight());
    $(window).scroll(function () {
        var sticky = $("#masthead .top-bar"),
            scroll = $(window).scrollTop();

        if (scroll >= 100) {
            sticky.slideUp();
            $("#masthead").addClass("sticky");
        } else {
            sticky.slideDown();
            $("#masthead").removeClass("sticky");
        }
    });

    $("#menu-trigger").on("click", function () {
        $("body").toggleClass("menu-open");
        $(this).toggleClass("active");
        $("#masthead .main-navigation").toggleClass("active");

    });

});
