import axios from 'axios';

jQuery(document).ready(function ($) {
    const homeUrl = window.location.origin;
    const apiBase = `${homeUrl}/wp-json/tamtam/v1`;
    const $categoryItems = $('.products-page__content-filters__category__item');
    const $brandsList = $('.products-page__content-filters__brand__list');
    const $productsParams = $('#products-params');

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

    function updateBrandSelection() {
        const selectedBrands = [];
        $brandsList.find('.active').each(function () {
            selectedBrands.push($(this).attr('data-brand'));
        });
        $productsParams.find('input[name="brand"]').val(selectedBrands.join(','));
    }
});