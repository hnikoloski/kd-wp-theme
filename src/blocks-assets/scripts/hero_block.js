// import '../sass/_hero_block.scss'
import Swiper from 'swiper';
import { Pagination } from 'swiper/modules';

// import Swiper and modules styles
import 'swiper/css';
import 'swiper/css/pagination';

import "../sass/_hero_block.scss";
jQuery(document).ready(function ($) {
    // init Swiper:
    const swiper = new Swiper('.kd-hero-block-slider', {
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