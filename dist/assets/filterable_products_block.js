import{a as g}from"./axios.js";jQuery(document).ready(function(s){const a=".kd-filterable-products-block",o=".kd-filterable-products-block__filters__list__item",i=".kd-filterable-products-block__results",d=`${window.location.origin}/wp-json/tamtam/v1/filterable-products`,r=s(a);if(!r.length)return;function n(){const t=s(this);if(t.hasClass("active"))return;const l=t.attr("data-filter-slug");u(t),_(l)}function u(t){s(o).removeClass("active"),t.addClass("active")}function _(t){const l=r.find(i);s(".kd-filterable-products-block").addClass("loading"),g.get(d,{params:{promotional_group:t}}).then(e=>p(e.data,l)).catch(e=>m(e,l))}function p(t,l){let e=t.length>0?t.map(f).join(""):"<p class='no-results'>No products found</p>";l.html(e),s(".kd-filterable-products-block").removeClass("loading")}function f({permalink:t,imgUrl:l,theTitle:e,price:k,percentage_discount:c}){const b=c>0?`<span class="kd-filterable-products-block__results__item__discount-badge">-${c}%</span>`:"";return`
            <a class="kd-filterable-products-block__results__item" href="${t}">
                <div class="kd-filterable-products-block__results__item__image">
                    <img src="${l}" alt="${e}" class="full-size-img full-size-img-cover" />
                    ${b}
                </div>
                <h3 class="kd-filterable-products-block__results__item__title">${e}</h3>
                <p class="kd-filterable-products-block__results__item__price">${k}</p>
            </a>
        `}function m(t,l){console.error("Failed to fetch products:",t),l.html("<p class='error'>Failed to load products. Please try again.</p>").removeClass("loading")}s(o).on("click",n)});
