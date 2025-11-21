document.addEventListener("DOMContentLoaded", function() {
    // Initialize category filter functionality
    initCategoryFilters();
    
    // Initialize reviews swiper
    initReviewsSwiper();
    
    // Add scroll margin to filter section
    initScrollMargin();
    
    // Add product click functionality
    initProductClicks();
});

function initCategoryFilters() {
    const items = document.querySelectorAll(".filter-item");
    
    items.forEach((item, idx) => {
        // Click event
        item.addEventListener("click", function() {
            items.forEach(i => i.classList.remove("active"));
            this.classList.add("active");
            
            const categoryId = this.getAttribute("data-category-id");
            const categoryName = this.querySelector("span").textContent;
            const categorySlug = this.getAttribute("data-category-slug");
            
            console.log("Selected category:", categoryName, "ID:", categoryId);
            
            // You can add AJAX call here to filter products
            filterProductsByCategory(categoryId, categorySlug);
        });
        
        // Keyboard accessibility
        item.setAttribute("tabindex", "0");
        item.addEventListener("keydown", function(e) {
            if (e.key === "Enter" || e.key === " ") {
                e.preventDefault();
                this.click();
            }
            if (e.key === "ArrowDown") {
                e.preventDefault();
                const next = items[idx + 1];
                if (next) next.focus();
            }
            if (e.key === "ArrowUp") {
                e.preventDefault();
                const prev = items[idx - 1];
                if (prev) prev.focus();
            }
        });
    });
}

function initReviewsSwiper() {
    const reviewsSwiper = new Swiper('.reviews-swiper', {
        direction: 'vertical',
        slidesPerView: 1,
        spaceBetween: 20,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.reviews-swiper .swiper-pagination',
            clickable: true,
        },
        breakpoints: {
            768: {
                slidesPerView: 1,
                spaceBetween: 15,
            }
        }
    });
}

function initScrollMargin() {
    const filterSection = document.querySelector('.filter-section');
    
    if (filterSection) {
        window.addEventListener('scroll', function() {
            const scrollPosition = window.pageYOffset || document.documentElement.scrollTop;
            
            if (scrollPosition > 160) {
                filterSection.style.marginTop = '5px';
            } else {
                filterSection.style.marginTop = '0';
            }
        });
    }
}

function initProductClicks() {
    const productCards = document.querySelectorAll('.product-card-mini');
    
    productCards.forEach(card => {
        card.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            if (productId) {
                window.location.href = `product-details.php?id=${productId}`;
            }
        });
        
        // Add hover effects
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
}

function filterProductsByCategory(categoryId, categorySlug) {
    // This function will filter the main products grid
    // You can implement AJAX filtering here
    
    console.log(`Filtering by category: ${categorySlug} (ID: ${categoryId})`);
    
    // Example AJAX implementation:
    /*
    fetch(`ajax/filter_products.php?category_id=${categoryId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update main products grid
                updateProductsGrid(data.products);
            }
        })
        .catch(error => {
            console.error('Error filtering products:', error);
        });
    */
}

function updateProductsGrid(products) {
    // Update the main products grid with filtered products
    // This would be implemented in your main products grid component
    console.log('Updating products grid with:', products);
}

// Global function to refresh aside data
function refreshAsideData() {
    // You can call this function to refresh the aside data
    location.reload(); // Simple reload for now
}

// Export functions for global use
window.refreshAsideData = refreshAsideData;
window.filterProductsByCategory = filterProductsByCategory;