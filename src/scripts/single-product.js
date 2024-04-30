import axios from "axios";

jQuery(document).ready(function ($) {

    $('.single-product__content__info__get-price').on('click', function (e) {
        e.preventDefault();
        $('.single-product__modal').addClass('active');
        $('body').addClass('overflow-hidden');
    });
    $('.single-product__modal__dialog__close-button').on('click', function (e) {
        e.preventDefault();
        $('.single-product__modal').removeClass('active');
        $('body').removeClass('overflow-hidden');
    });

    $('.single-product__modal__dialog__form').on('submit', function (e) {
        e.preventDefault();
        const $form = $(this);

        $form.addClass('loading');

        // Reference to the response message div
        const $responseDiv = $form.find('.single-product__modal__dialog__form__response');

        // Clear existing errors, success messages, and response classes
        $form.find('.error').removeClass('error');
        $form.find('.input-error-message').remove(); // Remove any existing error messages
        $responseDiv.empty().removeClass('error-message success-message'); // Clear and reset the response div classes

        const formData = $form.serialize();
        const API_URL = `${window.location.origin}/wp-json/tamtam/v1/product-price-quote`;

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