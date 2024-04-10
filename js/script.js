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
