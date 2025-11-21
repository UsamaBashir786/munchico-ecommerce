<!-- Sidebar Overlay for Mobile -->
<div class="sidebar-overlay"></div>

<!-- Sidebar Filter -->
<aside class="sidebar-filter">
    <div class="sidebar-header">
        <h2>Filters</h2>
        <button class="close-sidebar">×</button>
    </div>

    <!-- Categories Filter -->
    <div class="filter-section">
        <h3 class="filter-title">Categories</h3>
        <div class="filter-option">
            <input type="checkbox" id="cat-all" checked>
            <label for="cat-all">All Products</label>
            <span class="filter-count">(48)</span>
        </div>
        <div class="filter-option">
            <input type="checkbox" id="cat-dried-fruits">
            <label for="cat-dried-fruits">Dried Fruits</label>
            <span class="filter-count">(24)</span>
        </div>
        <div class="filter-option">
            <input type="checkbox" id="cat-nuts">
            <label for="cat-nuts">Premium Nuts</label>
            <span class="filter-count">(18)</span>
        </div>
        <div class="filter-option">
            <input type="checkbox" id="cat-seeds">
            <label for="cat-seeds">Seeds</label>
            <span class="filter-count">(6)</span>
        </div>
    </div>

    <!-- Price Range Filter -->
    <div class="filter-section">
        <h3 class="filter-title">Price Range</h3>
        <div class="price-range">
            <div class="price-inputs">
                <input type="number" class="price-input" placeholder="Min" value="10">
                <input type="number" class="price-input" placeholder="Max" value="100">
            </div>
        </div>
    </div>

    <!-- Quality Filter -->
    <div class="filter-section">
        <h3 class="filter-title">Quality</h3>
        <div class="filter-option">
            <input type="checkbox" id="organic">
            <label for="organic">Organic</label>
            <span class="filter-count">(32)</span>
        </div>
        <div class="filter-option">
            <input type="checkbox" id="premium">
            <label for="premium">Premium Grade</label>
            <span class="filter-count">(28)</span>
        </div>
    </div>

    <!-- Rating Filter -->
    <div class="filter-section">
        <h3 class="filter-title">Rating</h3>
        <div class="filter-option">
            <input type="checkbox" id="rating-5">
            <label for="rating-5">★★★★★ (5.0)</label>
            <span class="filter-count">(12)</span>
        </div>
        <div class="filter-option">
            <input type="checkbox" id="rating-4">
            <label for="rating-4">★★★★☆ (4.0+)</label>
            <span class="filter-count">(25)</span>
        </div>
        <div class="filter-option">
            <input type="checkbox" id="rating-3">
            <label for="rating-3">★★★☆☆ (3.0+)</label>
            <span class="filter-count">(11)</span>
        </div>
    </div>

    <button class="filter-btn">Apply Filters</button>
</aside>

<!-- Mobile Filter Toggle Button -->
<button class="mobile-filter-toggle">☰</button>

<link rel="stylesheet" href="includes/productComponents/sidebar-filter/styles.css">
<script src="includes/productComponents/sidebar-filter/script.js"></script>