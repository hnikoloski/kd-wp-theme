import axios from 'axios';
jQuery(document).ready(function ($) {
    const homeUrl = window.location.origin;
    const apiBase = `${homeUrl}/wp-json/tamtam/v1`;
    const $categoryItems = $('.products-page__content-filters__category__item');
    const $brandsList = $('.products-page__content-filters__brand__list');
    const $productsParams = $('#products-params');
    const $resultsContainer = $('.products-page__content__products__results');
    const $pagination = $('.products-page__content__products__pagination');
    const $sortSelect = $('.products-page__content__products__header__actions__sort select');

    $categoryItems.on('click', function (e) {
        e.preventDefault();
        const $this = $(this);
        if ($this.hasClass('active') || $this.parent().hasClass('loading')) return;
        $productsParams.find('input[name="brand"]').val('');
        $this.parent().addClass('loading');
        $brandsList.empty().removeClass('active');
        $categoryItems.removeClass('active');
        $this.addClass('active');
        $productsParams.find('input[name="category"]').val($this.attr('data-category'));

        const categoryId = $this.attr('data-category');
        axios.get(`${apiBase}/category-brands`, { params: { category: categoryId } })
            .then(response => {
                const brands = response.data;
                if (brands.length === 0) {
                    $brandsList.append('<li class="empty">No brands available for this category.</li>');
                } else {
                    brands.forEach(brand => {
                        $brandsList.append(`<li class="products-page__content-filters__brand__list__item" data-brand="${brand.id}">${brand.name}</li>`);
                    });
                    $brandsList.addClass('active');
                }
            })
            .catch(error => {
                console.error('Error fetching brands:', error);
                $brandsList.append('<li class="error">No brands available for this category.</li>');
            })
            .finally(() => {
                $this.parent().removeClass('loading');
            });
    });

    $brandsList.on('click', '.products-page__content-filters__brand__list__item', function () {
        $(this).toggleClass('active');
        updateBrandSelection();
    });

    $sortSelect.on('change', function () {
        $productsParams.find('input[name="sort"]').val($(this).val());
        fetchProducts(); // Fetch products after sorting
    });

    function updateBrandSelection() {
        const selectedBrands = [];
        $brandsList.find('.active').each(function () {
            selectedBrands.push($(this).attr('data-brand'));
        });
        $productsParams.find('input[name="brand"]').val(selectedBrands.join(','));
        fetchProducts(); // Fetch products after brand selection
    }

    function fetchProducts() {
        const categoryId = $productsParams.find('input[name="category"]').val();
        const brands = $productsParams.find('input[name="brand"]').val();
        const currentPage = $productsParams.find('input[name="page"]').val() || 1;

        axios.get(`${apiBase}/category-brand-products`, { params: { category: categoryId, brands: brands, page: currentPage, sort: $sortSelect.val() } })
            .then(response => {
                const { products, total, max_num_pages } = response.data;
                $resultsContainer.html(''); // Clear existing products
                if (products.length === 0) {
                    $resultsContainer.append('<div class="empty">No products found.</div>');
                } else {
                    products.forEach(product => {
                        const productHtml = productCardComponent(product);
                        $resultsContainer.append(productHtml);
                    });
                }

                // Add pagination
                if (max_num_pages > 1) {
                    $pagination.empty();
                    const paginationHtml = paginationMarkup(currentPage, max_num_pages);
                    $pagination.html(paginationHtml);
                    $pagination.removeClass('d-none');
                } else {
                    $pagination.empty().addClass('d-none');
                }

            })
            .catch(error => {
                console.error('Error fetching products:', error);
                $resultsContainer.append('<div>Error loading products.</div>');
            });
    }

    // Handle pagination link clicks
    $(document).on('click', '.products-page__content__products__pagination a', function (e) {
        e.preventDefault();
        const page = $(this).data('page');
        $productsParams.find('input[name="page"]').val(page);
        fetchProducts();
    });

    fetchProducts(); // Fetch products with the initial page


    $('.products-page__content__products__header__actions__grid-selector__item i').on('click', function () {
        const $this = $(this).parent();
        if ($this.hasClass('active')) return;
        $('.products-page__content__products__header__actions__grid-selector__item').removeClass('active');
        $this.addClass('active');
        $resultsContainer.css('--columns', $this.attr('data-grid'));
    });
});



function paginationMarkup(current_page, total_pages, base_url = window.location.origin + window.location.pathname) {
    const currentPage = parseInt(current_page, 10);
    const totalPages = parseInt(total_pages, 10);
    let paginationMarkup = `
    <div class="products-page__content__products__pagination__wrapper pagination">`;
    if (currentPage > 1) {
        paginationMarkup += `<a href="${base_url}?page=${currentPage - 1}" data-page="${currentPage - 1}" class="products-page__content__products__pagination__item--prev" rel="prev" aria-label="Previous Page"><i></i></a>`;
    }
    for (let i = 1; i <= totalPages; i++) {
        paginationMarkup += (i === currentPage) ? `<span class="products-page__content__products__pagination__item products-page__content__products__pagination__item--current current" aria-current="page">${i}</span>` : `<a href="${base_url}?page=${i}" data-page="${i}" class="page larger products-page__content__products__pagination__item" title="Page ${i}">${i}</a>`;
    }
    if (currentPage < totalPages) {
        paginationMarkup += `<a href="${base_url}?page=${currentPage + 1}" data-page="${currentPage + 1}" class="products-page__content__products__pagination__item--next" rel="next" aria-label="Next Page"><i></i></a>`;
    }
    paginationMarkup += `</div>`;
    return paginationMarkup;
}

function productCardComponent(product) {
    // Only show the discount badge if there is a percentage discount greater than 0
    const discountBadge = product.percentage_discount > 0 ? `<span class="kd-filterable-products-block__results__item__discount-badge">-${product.percentage_discount}%</span>` : '';
    // Assuming you might add a description field later or it's optionally included
    const productDescription = product.description ? `<p class="kd-filterable-products-block__results__item__description">${product.description}</p>` : '';
    // Use the price from the product data, already includes currency based on your data
    const productPrice = `<p class="kd-filterable-products-block__results__item__price">${product.price}</p>`;

    return `<a class="kd-filterable-products-block__results__item" href="${product.permalink}">
                <div class="kd-filterable-products-block__results__item__image">
                    <img src="${product.imgUrl}" alt="${product.theTitle}" class="full-size-img full-size-img-cover">
                    ${discountBadge}
                </div>
                <h3 class="kd-filterable-products-block__results__item__title">${product.theTitle}</h3>
                ${productDescription}
                ${productPrice}
            </a>`;
}
