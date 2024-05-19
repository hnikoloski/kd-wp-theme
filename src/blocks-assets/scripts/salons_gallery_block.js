import axios from "axios";
import imagesLoaded from 'imagesloaded';

jQuery(document).ready(function ($) {

    $('.kd-salons-gallery-block__toggler').on('click', function (e) {
        e.preventDefault();
        let toggleText = $(this).attr('data-active-text');
        let buttonText = $(this).find('span').text();
        const toggleTarget = $('.kd-salons-gallery-block__toggle-wrap');

        $(this).toggleClass('active');
        // Swap the places of the text and data-active-text attributes
        $(this).attr('data-active-text', buttonText);
        $(this).find('span').text(toggleText);
        toggleTarget.slideToggle();
    });

    const API_URL = `${window.location.origin}/wp-json/tamtam/v1/salons-gallery`;
    const $salonsGalleryResults = $(".kd-salons-gallery-block__gallery-results");
    const firstFilter = $('.kd-salons-gallery-block__filter').first();
    $('.kd-salons-gallery-block__filter').on('click', function (e) {
        e.preventDefault();
        if ($(this).hasClass('active')) return;
        $('.kd-salons-gallery-block__filter').removeClass('active');
        $(this).addClass('active');
        let salon_id = $(this).attr('data-salon');
        fetchAndDisplaySalons(salon_id);
    });

    fetchAndDisplaySalons(firstFilter.attr('data-salon'));

    function fetchAndDisplaySalons(salon_id) {
        $('.kd-salons-gallery-block').addClass("loading");
        axios.get(API_URL, { params: { salon_id: salon_id } })
            .then(response => displaySalons(response.data))
            .catch(error => handleError(error));
    }

    function displaySalons(images) {
        $salonsGalleryResults.empty(); // Clear existing content
        if (images.length > 0) {
            const imagesHtml = images.map(image => {
                return `<div class="gallery-item"><img src="${image.url}" alt="${image.alt}" class="gallery-image"></div>`;
            }).join('');
            $salonsGalleryResults.append(`${imagesHtml}`);



        } else {
            $salonsGalleryResults.append('<p>No images found.</p>');
        }
        $('.kd-salons-gallery-block').removeClass("loading");
    }

    function handleError(error) {
        console.error('An error occurred:', error);
        $salonsGalleryResults.html('<p>Error loading galleries.</p>');
        $('.kd-salons-gallery-block').removeClass("loading");
    }

});
