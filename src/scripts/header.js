jQuery(document).ready(function ($) {
    $("#page").css("padding-top", $("#masthead").outerHeight());
    $(window).scroll(function () {
        var sticky = $("#masthead .top-bar"),
            scroll = $(window).scrollTop();

        if (scroll >= 100) {
            sticky.slideUp();
            $("#masthead").addClass("sticky");
            $('#back-to-top').addClass('active');
        } else {
            sticky.slideDown();
            $("#masthead").removeClass("sticky");
            $('#back-to-top').removeClass('active');
        }
    });
    $('#back-to-top').on('click', function (e) {
        e.preventDefault();
        $('html, body').animate({ scrollTop: 0 }, 100);
    });
    $("#menu-trigger").on("click", function () {
        $("body").toggleClass("menu-open");
        $(this).toggleClass("active");
        $("#masthead .main-navigation").toggleClass("active");
    });

    $('.mob-menu-close').on('click', function () {
        $("body").removeClass("menu-open");
        $("#menu-trigger").removeClass("active");
        $("#masthead .main-navigation").removeClass("active");
    });


    // Attach event handler for the search button click
    $("#masthead .main-navigation #search-trigger").on("click", function (e) {
        e.preventDefault();

        $(this).toggle();
        // Toggle the 'active' state of the form
        $("#masthead .main-navigation ul").toggle();

        $('#masthead .main-navigation .search-form').toggleClass('active');
    });

    $('#masthead .main-navigation .search-close').on('click', function (e) {
        e.preventDefault();
        $("#masthead .main-navigation #search-trigger").toggle();
        $("#masthead .main-navigation ul").toggle();
        $('#masthead .main-navigation .search-form').toggleClass('active');
    });

});
