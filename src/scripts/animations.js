import gsap from "gsap";

jQuery(document).ready(function ($) {
    // levitate animation
    if ($(".levitate").length !== 0) {
        gsap.fromTo(".levitate",
            3,
            { ease: "none", y: 10 },
            { ease: "none", y: -10, repeat: -1, yoyo: true }
        );
    }
}); 