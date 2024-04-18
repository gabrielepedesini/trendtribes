// show all categories in filters

document.addEventListener("DOMContentLoaded", function() {
    let categories = document.querySelectorAll('.product-category');
    const toggleButton = document.querySelector('.btn-show-categories');
  
    function hideCategories() {
        for (var i = 3; i < categories.length; i++) {
            categories[i].style.display = 'none';
        }
        toggleButton.textContent = 'View All';
    }
  
    function showAllCategories() {
        for (var i = 0; i < categories.length; i++) {
            categories[i].style.display = 'block';
        }
        toggleButton.textContent = 'Close';
    }
  
    hideCategories();
  
    toggleButton.addEventListener('click', function() {
        var isHidden = categories[3].style.display === 'none';
    
        if (isHidden) {
            showAllCategories();
        } else {
            hideCategories();
        }
    });
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

    const url = window.location.href;
    const urlParts = url.split('?');

    if (urlParts.length < 2 || urlParts[1].trim() === '') {
        return;
    }

    const newUrl = urlParts[0];

    history.replaceState(null, '', newUrl);

    location.reload();
}

removeFilters.addEventListener('click', function() {
    removeFiltersFromURL();
});
