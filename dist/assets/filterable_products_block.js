import{a as u}from"./axios.js";jQuery(document).ready(function(o){const t=o(".kd-filterable-products-block");if(!t.length)return;const c=t.find(".kd-filterable-products-block__filters__list__item");let d=window.location.origin+"/wp-json/tamtam/v1/filterable-products";c.on("click",function(i){i.preventDefault(),c.removeClass("active"),o(this).addClass("active");let a=o(this).attr("data-filter-slug");t.find(".kd-filterable-products-block__results").addClass("loading"),u.get(d,{params:{promotional_group:a}}).then(e=>{let r=e.data,s="";r.length>0?(r.forEach(l=>{s+=_(l.permalink,l.imgUrl,l.theTitle,l.price,l.percentage_discount)}),t.find(".kd-filterable-products-block__results").html(s)):t.find(".kd-filterable-products-block__results").html("<p class='no-results'>No products found</p>"),t.find(".kd-filterable-products-block__results").removeClass("loading")}).catch(e=>{console.log(e)})});function _(i,a,e,r,s){let l="";return console.log(s),s>0&&(l=`<span class="kd-filterable-products-block__results__item__discount-badge">${s}%</span>`),`
        <a class="kd-filterable-products-block__results__item" href="${i}">
        <div class="kd-filterable-products-block__results__item__image">
            <img src="${a}" alt="${e}" class="full-size-img full-size-img-cover" />
            ${l}
        </div>
        <h3 class="kd-filterable-products-block__results__item__title">${e}</h3>
        <p class="kd-filterable-products-block__results__item__price">${r}</p>
    </a>
        `}});
