// accordion in product pages

const accordions = document.querySelectorAll('.product-detail-title');

accordions.forEach(el => {
    el.addEventListener('click', () => {
        const accordion = el.closest('.product-summary-accordion');
        accordion.classList.toggle('open-accordion');
    });
});

// review hide/show list

document.addEventListener("DOMContentLoaded", function() {

    var reviews = document.getElementsByClassName('review');

    var showAllButton = document.createElement('a');
    showAllButton.textContent = 'View All';
    showAllButton.classList.add('show-all-reviews-btn');

    for (var i = 3; i < reviews.length; i++) {
        reviews[i].style.display = 'none';
    }

    var buttonContainer = document.createElement('div');
    buttonContainer.classList.add('show-all-reviews-button-container');
    buttonContainer.appendChild(showAllButton);
    reviews[reviews.length - 1].parentNode.appendChild(buttonContainer);

    showAllButton.addEventListener('click', function() {
        for (var i = 3; i < reviews.length; i++) {
            if (reviews[i].style.display === 'none') {
                reviews[i].style.display = '';
                showAllButton.textContent = 'Close';
            } else {
                reviews[i].style.display = 'none';
                showAllButton.textContent = 'View All';
            }
        }
    });
});
