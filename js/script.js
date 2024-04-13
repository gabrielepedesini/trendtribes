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

// sale counter

const headerSale = document.querySelector('.header-sale');

if (headerSale.classList.contains('header-counter')) {

    const counter = document.querySelector('.display-counter');

    if (headerSale.classList.contains('date')) {

        var dateString = counter.textContent;
    
        var parts = dateString.split('-');
        var year = parseInt(parts[0]);
        var month = parseInt(parts[1]) - 1;
        var day = parseInt(parts[2]);
    
        var endDate = new Date(year, month, day, 23, 59, 59);
    
        var localOffset = new Date().getTimezoneOffset() * 60000; 
        endDate = new Date(endDate.getTime() - localOffset);
    
        function updateCountdown() {
            
            var now = new Date();
            var timeDifference = endDate.getTime() - now.getTime();
    
            var days = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
            var hours = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((timeDifference % (1000 * 60)) / 1000);
    
            if (timeDifference > 0) {
                if (days === 0) {
                    counter.innerHTML = hours + "h " + minutes + "m " + seconds + "s";
                } else if (days === 0 && hours === 0) {
                    counter.innerHTML = minutes + "m " + seconds + "s";
                } else if (days === 0 && hours === 0 && minutes === 0) {
                    counter.innerHTML = seconds + "s";
                } else {
                    counter.innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s";
                }
                setTimeout(updateCountdown, 1000);
            } else {
                counter.innerHTML = "Countdown expired";
            }
        }
    
        updateCountdown();
    
    } else {

        var now = new Date();

        var endDate = new Date(now);
        endDate.setDate(endDate.getDate() + 1);
        endDate.setHours(0, 0, 0, 0);

        function updateCountdown() {
            var now = new Date();

            var timeDifference = endDate.getTime() - now.getTime();

            var days = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
            var hours = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((timeDifference % (1000 * 60)) / 1000);

            if (timeDifference > 0) {
                if (days === 0) {
                    counter.innerHTML = hours + "h " + minutes + "m " + seconds + "s";
                } else if (days === 0 && hours === 0) {
                    counter.innerHTML = minutes + "m " + seconds + "s";
                } else if (days === 0 && hours === 0 && minutes === 0) {
                    counter.innerHTML = seconds + "s";
                } else {
                    counter.innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s";
                }
                setTimeout(updateCountdown, 1000);
            } else {
                
                endDate.setDate(endDate.getDate() + 1);
                endDate.setHours(0, 0, 0, 0);
                setTimeout(updateCountdown, 1000);
            }
        }

        updateCountdown();

    }
}

// header with sales

if (headerSale.classList.contains('header-counter')) {
    header.classList.add('header-with-sales');
}