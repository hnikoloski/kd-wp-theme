import axios from 'axios';

jQuery(document).ready(function ($) {
    const filterableProductsBlockSelector = ".kd-filterable-products-block";
    const filterItemSelector = ".kd-filterable-products-block__filters__list__item";
    const resultsSelector = ".kd-filterable-products-block__results";
    const API_URL = `${window.location.origin}/wp-json/tamtam/v1/filterable-products`;

    const $filterableProductsBlock = $(filterableProductsBlockSelector);

    if (!$filterableProductsBlock.length) return;

    function handleClickOnFilterItem() {
        const $filterItem = $(this);
        if ($filterItem.hasClass("active")) return;
        const promotionalGroup = $filterItem.attr("data-filter-slug");

        setActiveFilterItem($filterItem);
        fetchAndDisplayProducts(promotionalGroup);
    }

    function setActiveFilterItem($item) {
        $(filterItemSelector).removeClass("active");
        $item.addClass("active");
    }

    function fetchAndDisplayProducts(group) {
        const $results = $filterableProductsBlock.find(resultsSelector);
        $('.kd-filterable-products-block').addClass("loading");

        axios.get(API_URL, { params: { promotional_group: group } })
            .then(response => displayProducts(response.data, $results))
            .catch(error => handleError(error, $results));
    }

    function displayProducts(products, $results) {
        let markup = products.length > 0 ? products.map(productMarkup).join('') : "<p class='no-results'>No products found</p>";
        $results.html(markup);
        $('.kd-filterable-products-block').removeClass("loading");
    }

    function productMarkup({ permalink, imgUrl, theTitle, price, percentage_discount }) {
        const discountMarkup = percentage_discount > 0 ? `<span class="kd-filterable-products-block__results__item__discount-badge">-${percentage_discount}%</span>` : '';
        return `
            <a class="kd-filterable-products-block__results__item" href="${permalink}">
                <div class="kd-filterable-products-block__results__item__image">
                    <img src="${imgUrl}" alt="${theTitle}" class="full-size-img full-size-img-cover" />
                    ${discountMarkup}
                </div>
                <h3 class="kd-filterable-products-block__results__item__title">${theTitle}</h3>
                <p class="kd-filterable-products-block__results__item__price">${price}</p>
            </a>
        `;
    }

    function handleError(error, $results) {
        console.error("Failed to fetch products:", error);
        $results.html("<p class='error'>Failed to load products. Please try again.</p>").removeClass("loading");
    }

    $(filterItemSelector).on("click", handleClickOnFilterItem);
});
