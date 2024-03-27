import { Autoplay, Pagination } from 'swiper/modules';

// Import Swiper styles
import Swiper from 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.mjs'

jQuery(document).ready(function ($) {

    const heroSwiper = new Swiper('.kd-hero-block-slider', {
        modules: [Pagination],
        // 1 slide per view and loop
        slidesPerView: 1,
        loop: true,
        // Add pagination
        pagination: {
            el: '.kd-hero-block__pagination',
            clickable: true,
        },
    });
});

