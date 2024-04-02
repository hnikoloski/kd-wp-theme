import "../sass/filterable_products_block.scss";
import axios from 'axios';

jQuery(document).ready(function ($) {
    const $filterableProductsBlock = $(".kd-filterable-products-block");

    if (!$filterableProductsBlock.length) {
        return;
    }

    const $filterItem = $filterableProductsBlock.find(".kd-filterable-products-block__filters__list__item");
    let API_URL = window.location.origin + '/wp-json/tamtam/v1/filterable-products';
    $filterItem.on("click", function (e) {
        e.preventDefault();
        $filterItem.removeClass("active");
        $(this).addClass("active");

        let promotional_group = $(this).attr("data-filter-slug");
        $filterableProductsBlock.find(".kd-filterable-products-block__results").addClass("loading");

        axios.get(API_URL, {
            params: {
                promotional_group: promotional_group
            }
        }).then((response) => {
            let products = response.data;
            let productsMarkup = '';

            if (products.length > 0) {
                products.forEach(product => {
                    productsMarkup += productCardComponent(product.permalink, product.imgUrl, product.theTitle, product.price, product.percentage_discount);
                });
                $filterableProductsBlock.find(".kd-filterable-products-block__results").html(productsMarkup);
            } else {
                $filterableProductsBlock.find(".kd-filterable-products-block__results").html("<p class='no-results'>No products found</p>");
            }
            $filterableProductsBlock.find(".kd-filterable-products-block__results").removeClass("loading");
        }).catch((error) => {
            console.log(error);
        });
    });


    function productCardComponent(permalink, imgUrl, theTitle, price, percentage_discount) {
        let disckountMarkup = '';
        console.log(percentage_discount);
        if (percentage_discount > 0) {
            disckountMarkup = `<span class="kd-filterable-products-block__results__item__discount-badge">-${percentage_discount}%</span>`;
        }
        return `
        <a class="kd-filterable-products-block__results__item" href="${permalink}">
        <div class="kd-filterable-products-block__results__item__image">
            <img src="${imgUrl}" alt="${theTitle}" class="full-size-img full-size-img-cover" />
            ${disckountMarkup}
        </div>
        <h3 class="kd-filterable-products-block__results__item__title">${theTitle}</h3>
        <p class="kd-filterable-products-block__results__item__price">${price}</p>
    </a>
        `
    }
});