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
    $("#masthead form .search-btn").on("click", function (event) {
        // Prevent the default action if the button is disabled
        if ($(this).hasClass("disabled")) {
            event.preventDefault();

            // Toggle the 'active' state of the form
            $("#masthead form").toggleClass("active");

            // Toggle 'search-open' class on the masthead
            $("#masthead").toggleClass("search-open");

            // Remove 'disabled' class from the button
            $(this).removeClass("disabled");
        }
    });

    // Attach event handler for the close button click
    $("#masthead form .search-close").on("click", function (event) {
        event.preventDefault();

        // Toggle the 'active' state of the form
        $("#masthead form").toggleClass("active");

        // Toggle 'search-open' class on the masthead
        $("#masthead").toggleClass("search-open");

        // Add 'disabled' class back to the search button
        $("#masthead form .search-btn").addClass("disabled");
    });
});
