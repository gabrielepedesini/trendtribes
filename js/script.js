// menu on mobile

const menu = document.querySelector('.menu');
const hamburger = document.querySelector('.hamburger');
const cross = document.querySelector('.cross');
const cover = document.querySelector('.cover');

hamburger.addEventListener('click', () => {
    menu.classList.add("menu-active");
    cover.classList.add("cover-active");
});

cross.addEventListener('click', () => {
    menu.classList.remove("menu-active");
    cover.classList.remove("cover-active");
});

cover.addEventListener('click', () => {
    menu.classList.remove("menu-active");
    cover.classList.remove("cover-active");
});

// sticky navbar 

let header = document.querySelector(".header");
let lastScrollTop = 0;
let currentScroll;

window.addEventListener("scroll", function() {
    currentScroll = window.pageYOffset || document.documentElement.scrollTop;

    if (currentScroll > lastScrollTop) {
        header.classList.add("hidden");
    } else {
        header.classList.remove("hidden");
    }

    if(currentScroll === 0) {
        header.classList.remove("header-shadow");
    } else if(currentScroll > 30) {
        header.classList.add("header-shadow");
    }

    lastScrollTop = currentScroll <= 0 ? 0 : currentScroll; 
});

// header appears on add to cart 

const addToCart = document.querySelectorAll('.add_to_cart_button');

addToCart.forEach(element => {
    element.addEventListener('click', () => {
        if(header.classList.contains('hidden')) {
            header.classList.remove("hidden");

            setTimeout(function() {
                if(currentScroll > 0) {
                    header.classList.add("hidden");
                }  
            }, 2000);
        }
    })
});

// update cart count

function updateCartCount() {
    jQuery.ajax({
        type: 'POST',
        url: woocommerce_params.ajax_url,
        data: {
            action: 'get_cart_count'
        },
        success: function(response) {
            if (response > 0) {
                jQuery('.cart-item-count').removeClass('hidden');
                jQuery('.cart-item-count').text(response);
            } else {
                jQuery('.cart-item-count').addClass('hidden');
            }
        }
    });
}

// update cart if click add to cart

jQuery(document).ready(function($) {
    $('.add_to_cart_button').on('click', function() {
        setTimeout(function() {
            updateCartCount();
        }, 500); 
    });
});

// update cart on page load

window.addEventListener('load', function() {
    updateCartCount();
});

// update cart if the user navigate back or forward

window.addEventListener("pageshow", function (event) {
    var historyTraversal = event.persisted || 
                           ( typeof window.performance != "undefined" && 
                                window.performance.navigation.type === 2 );
    if (historyTraversal) {
        setTimeout(function() {
            updateCartCount();
        }, 500); 
    }
});

// show all categories in filters

const containerCategories = document.querySelector('.container-categories');
const btnCategories = document.querySelector('.btn-show-categories');
let btnCategoriesStatus = true;

btnCategories.addEventListener('click', () => {
    if(btnCategoriesStatus) {
        containerCategories.classList.add('show-categories');
        btnCategories.textContent = 'Close';
        btnCategoriesStatus = false;
    } else {
        containerCategories.classList.remove('show-categories');
        btnCategories.textContent = 'View All';
        btnCategoriesStatus = true;
    }
});

// filters on mobile 

const filtersContainer = document.querySelector('.products-filter');
const filterBtn = document.querySelector('.mobile-filters-btn');
const filterCross = document.querySelector('.filters-cross');

filterBtn.addEventListener('click', () => {
    filtersContainer.classList.add("filters-active");
    cover.classList.add("cover-active");
});

filterCross.addEventListener('click', () => {
    filtersContainer.classList.remove("filters-active");
    cover.classList.remove("cover-active");
});

cover.addEventListener('click', () => {
    filtersContainer.classList.remove("filters-active");
    cover.classList.remove("cover-active");
});

// filter number

function getNumberOfFiltersFromCurrentURL() {
    const url = window.location.href;
    const queryString = url.split('?')[1];
    
    if (!queryString) {
        return 0;
    }

    const queryParams = queryString.split('&');
    let filterCount = 0;

    const maxPrice = document.querySelector('.max-price');
    const maxPriceValue = parseInt(maxPrice.textContent);

    queryParams.forEach(param => {
        if (param.startsWith('type_filter') || (param.startsWith('max_price=') && param !== 'max_price=' + maxPriceValue)) {
            filterCount++;
        }
    });

    if(filterCount > 0) {
        filterBtn.innerHTML += ' (' + filterCount + ')'
    }
}

window.addEventListener('load', function() {
    getNumberOfFiltersFromCurrentURL();
});

// remove all filters

const removeFilters = document.querySelector('.remove-filters');

function removeFiltersFromURL() {
    // Get the current URL
    const url = window.location.href;
    const urlParts = url.split('?');

    // If there's no query string or the query string has no filters, return
    if (urlParts.length < 2 || urlParts[1].trim() === '') {
        return;
    }

    // Construct the new URL without the query string
    const newUrl = urlParts[0];

    // Replace the current URL with the new URL without the query string
    history.replaceState(null, '', newUrl);

    location.reload();
}

removeFilters.addEventListener('click', function() {
    removeFiltersFromURL();
});