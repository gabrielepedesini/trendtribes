// accordion in product pages

const accordions = document.querySelectorAll('.product-detail-title');

accordions.forEach(el => {
    el.addEventListener('click', () => {
        const accordion = el.closest('.product-summary-accordion');
        accordion.classList.toggle('open-accordion');
    });
});