jQuery(document).ready(function ($) {

    // Sets a cookie with the given name, value, and expiration in days
    function setCookie(name, value, days) {
        const expires = days ? `; expires=${new Date(Date.now() + days * 24 * 60 * 60 * 1000).toUTCString()}` : "";
        document.cookie = `${name}=${value || ""}${expires}; path=/`;
    }

    // Retrieves the value of a cookie with the given name
    function getCookie(name) {
        const cookies = `; ${document.cookie}`;
        const parts = cookies.split(`; ${name}=`);
        return parts.length === 2 ? parts.pop().split(";").shift() : undefined;
    }

    // References to elements
    const banner = $('#cookie-notice');
    const consent = getCookie('kd-cookie-consent');

    if (consent === 'accepted') {
        banner.remove();
        return;
    } else {
        banner.addClass('active');
    }

    $('#cookie-notice .btn').on('click', function (e) {
        e.preventDefault();

        // Determine the user's choice
        const isAccepted = $(this).hasClass('btn-cookie-accept');

        // Set the cookie based on user's choice
        setCookie('kd-cookie-consent', isAccepted ? 'accepted' : 'declined', isAccepted ? 7 : 1);

        // Hide the banner and remove it after 3 seconds
        banner.removeClass('active');
        setTimeout(function () {
            banner.remove();
        }, 3000);
    });
});
