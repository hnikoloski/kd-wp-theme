import "../sass/contact_block.scss";
import mapboxgl from 'mapbox-gl';
import 'mapbox-gl/dist/mapbox-gl.css';
import axios from "axios";

jQuery(document).ready(function ($) {
    const contactBlockSelector = $(".kd-contact-block");
    if (!contactBlockSelector.length) return;
    function initMap() {

        // Get mapbox token from .env
        const MAPBOX_TOKEN = import.meta.env.VITE_MAP_BOX_KEY;
        mapboxgl.accessToken = MAPBOX_TOKEN;

        const storeLocations = $("#store-locations").val();
        if (!storeLocations) return; // Ensure there's data before proceeding

        // Decode the base64 encoded string
        const decodedLocations = atob(storeLocations);
        const locations = JSON.parse(decodedLocations);

        // Assuming there are locations, find the center for the initial view
        if (locations.length === 0) return;
        const centerLocation = locations[0]; // Use the first location as the map center or calculate the geographical center.

        const map = new mapboxgl.Map({
            container: 'map', // container ID
            style: 'mapbox://styles/nhristijan/cluka2in2012v01pi3fca1184', // style URL
            center: [centerLocation.lng, centerLocation.lat], // starting position [lng, lat]
            zoom: 12 // starting zoom
        });
        const bounds = new mapboxgl.LngLatBounds();

        // Add markers to the map for each location
        locations.forEach(location => {
            new mapboxgl.Marker()
                .setLngLat([location.lng, location.lat])
                .setPopup(new mapboxgl.Popup({ offset: 25 }) // Add popups
                    .setText(location.store_name))
                .addTo(map)
            bounds.extend([location.lng, location.lat])

        });


        setTimeout(() => {
            // Fit the map to the bounds
            map.fitBounds(bounds, {
                padding: { top: 50, bottom: 50, left: 50, right: 50 }
            });
        }, 200);

    }

    initMap();


    $('.kd-contact-block__form').on('submit', function (e) {
        e.preventDefault();
        const $form = $(this);

        $form.addClass('loading');

        // Reference to the response message div
        const $responseDiv = $form.find('.kd-contact-block__form__response');

        // Clear existing errors, success messages, and response classes
        $form.find('.error').removeClass('error');
        $form.find('.input-error-message').remove(); // Remove any existing error messages
        $responseDiv.empty().removeClass('error-message success-message'); // Clear and reset the response div classes

        const formData = $form.serialize();
        const API_URL = `${window.location.origin}/wp-json/tamtam/v1/contact-form`;

        axios.post(API_URL, formData)
            .then(response => {
                if (response.data.status === 'success') {
                    $form.trigger('reset'); // Reset form fields
                    // Add success message and class
                    $responseDiv.text("Message sent successfully").addClass('success-message');
                } else if (response.data.status === 'error') {
                    // Show error message and add error class
                    $responseDiv.text(response.data.message || "Failed to send message. Please try again.").addClass('error-message');

                    // Highlight and display error messages for invalid fields
                    if (response.data.errors) {
                        Object.keys(response.data.errors).forEach(function (key) {
                            const $input = $form.find(`[name="${key}"]`);
                            $input.addClass('error'); // Highlight the field with an error
                            // Append error message below the input field
                            $input.after(`<div class="input-error-message">${response.data.errors[key]}</div>`);
                        });
                    }
                }
            })
            .catch(error => {
                console.error("Failed to send message:", error);
                // Show error message and add error class on catch
                $responseDiv.text("Failed to send message. Please try again.").addClass('error-message');
            }).finally(() => {
                $form.removeClass('loading');
            });
    });
});