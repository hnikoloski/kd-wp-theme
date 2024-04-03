import "../sass/contact_block.scss";
import mapboxgl from 'mapbox-gl';
import 'mapbox-gl/dist/mapbox-gl.css';
jQuery(document).ready(function ($) {
    const contactBlockSelector = $(".kd-contact-block");
    if (!contactBlockSelector.length) return;

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

    // Add markers to the map for each location
    locations.forEach(location => {
        new mapboxgl.Marker()
            .setLngLat([location.lng, location.lat])
            .setPopup(new mapboxgl.Popup({ offset: 25 }) // Add popups
                .setText(location.store_name))
            .addTo(map)
    });

    // Bounds for the map
    const bounds = new mapboxgl.LngLatBounds();
    locations.forEach(location => {
        bounds.extend([location.lng, location.lat]);
    });

    // Fit the map to the bounds
    map.fitBounds(bounds, {
        padding: { top: 50, bottom: 50, left: 50, right: 50 }
    });


});