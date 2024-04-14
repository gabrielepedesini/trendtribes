// swiper for reviews

var swiper = new Swiper(".mySwiper", {
    spaceBetween: 25,
    grabCursor: true,
    centeredSlides: true, 
    slidesPerView: 3,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    breakpoints: {
        1000: {
            centeredSlides: false, 
            slidesPerView: 3,
        },
    }
});

