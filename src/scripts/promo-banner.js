jQuery(document).ready(function ($) {

    if (!$("#promotional-banner").length) {
        return;
    }

    var $promoBanner = $("#promotional-banner");

    // Function to show the promotional banner after 5 seconds
    function showPromoBannerAfterDelay() {
        setTimeout(function () {
            $promoBanner.addClass('active');
            setTimeout(function () {
                $promoBanner.find('.promotional-banner__content').addClass('active')
            }, 500);
            $('body').addClass('overflow-hidden'); // Prevent scrolling when banner is active
            // Set the timestamp in local storage to the current time
            var now = new Date().getTime();
            localStorage.setItem("promoBannerLastView", now);
        }, 5000); // 5 seconds delay
    }

    function closePromoBanner() {
        $promoBanner.removeClass('active');
        $('body').removeClass('overflow-hidden'); // Restore scrolling when banner is closed
        // Optionally, update local storage to prevent immediate reappearance
        var now = new Date().getTime();
        localStorage.setItem("promoBannerLastView", now);
    }

    // Check local storage for the last time the promo banner was shown
    var lastShownTimestamp = localStorage.getItem("promoBannerLastView");
    var now = new Date().getTime();

    // Calculate the difference in hours between now and the last shown time
    var hoursSinceLastShown = Math.floor((now - lastShownTimestamp) / (1000 * 60 * 60));

    // Check if the banner has not been shown in the past 12 hours
    if (hoursSinceLastShown >= 12 || !lastShownTimestamp) {
        showPromoBannerAfterDelay();
    } else {
        closePromoBanner(); // This ensures the body doesn't get stuck in an overflow-hidden state
    }

    // Close banner when Escape key is pressed
    $(document).on('keydown', function (e) {
        if (e.key === "Escape" && $promoBanner.hasClass('active')) {
            closePromoBanner();
        }
    });

    // Close banner when close button is clicked
    $promoBanner.on('click', '.promotional-banner__content__close-button', function () {
        closePromoBanner();
    });
});
