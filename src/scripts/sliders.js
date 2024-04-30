// Import Swiper and the required modules
import Swiper from 'swiper/bundle';
import { Pagination, Autoplay, Navigation } from 'swiper/modules';

import 'swiper/css';
import 'swiper/css/pagination';

// Initialize the sliders when the document is ready
jQuery(document).ready(function ($) {
    // Initialize the thumbnail slider
    const swiperProductThumbs = new Swiper('.single-product__content .product-slider-thumbs', {
        spaceBetween: 24, // Space between thumbnails
        slidesPerView: 3, // Number of visible thumbnails
        watchSlidesVisibility: true,
        watchSlidesProgress: true,
    });

    // Initialize the main slider
    const swiperProduct = new Swiper('.single-product__content .product-slider', {
        modules: [Pagination],
        slidesPerView: 1,
        loop: true,
        thumbs: {
            swiper: swiperProductThumbs, // Sync with the thumbnail slider
        },
    });


    const swiperRelatedProducts = new Swiper('.single-product__similar-products__products ', {
        modules: [Autoplay],
        loop: true,
        delay: 5000,
        spaceBetween: 59,
        slidesPerView: 3.5,
        centeredSlides: true,
        watchSlidesVisibility: true,
        watchSlidesProgress: true,
    });

    $('.brands-archive__content__single__gallery__swiper').each(function (index, element) {
        var $this = $(this); // Current swiper container

        // Create unique class selectors for the navigation elements
        var nextButton = '.swiper-button-next-' + index;
        var prevButton = '.swiper-button-prev-' + index;

        // Add unique classes to navigation buttons within this container
        $this.find('.swiper-button-next').addClass('swiper-button-next-' + index);
        $this.find('.swiper-button-prev').addClass('swiper-button-prev-' + index);

        // Initialize Swiper
        var swiper = new Swiper(element, {
            modules: [Navigation],
            loop: true,
            slidesPerView: 1,
            watchSlidesVisibility: true,
            watchSlidesProgress: true,
            centeredSlides: true,
            navigation: {
                nextEl: nextButton,
                prevEl: prevButton,
            },
        });
    });
});