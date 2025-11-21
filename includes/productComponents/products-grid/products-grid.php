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
        <div id="categories-filter">
            <div class="filter-option">
                <input type="checkbox" id="cat-all" checked>
                <label for="cat-all">All Products</label>
                <span class="filter-count" id="count-all">(0)</span>
            </div>
            <!-- Dynamic categories will be loaded here -->
        </div>
    </div>

    <!-- Price Range Filter -->
    <div class="filter-section">
        <h3 class="filter-title">Price Range</h3>
        <div class="price-range">
            <div class="price-inputs">
                <input type="number" id="price-min" class="price-input" placeholder="Min" value="0">
                <input type="number" id="price-max" class="price-input" placeholder="Max" value="1000">
            </div>
        </div>
    </div>

    <!-- Rating Filter -->
    <div class="filter-section">
        <h3 class="filter-title">Rating</h3>
        <div class="filter-option">
            <input type="checkbox" id="rating-5" value="5">
            <label for="rating-5">★★★★★ (5.0)</label>
            <span class="filter-count" id="count-rating-5">(0)</span>
        </div>
        <div class="filter-option">
            <input type="checkbox" id="rating-4" value="4">
            <label for="rating-4">★★★★☆ (4.0+)</label>
            <span class="filter-count" id="count-rating-4">(0)</span>
        </div>
        <div class="filter-option">
            <input type="checkbox" id="rating-3" value="3">
            <label for="rating-3">★★★☆☆ (3.0+)</label>
            <span class="filter-count" id="count-rating-3">(0)</span>
        </div>
    </div>

    <button class="filter-btn" id="apply-filters">Apply Filters</button>
    <button class="filter-btn" id="reset-filters" style="background: #6b7280; margin-top: 10px;">Reset</button>
</aside>

<!-- Mobile Filter Toggle Button -->
<button class="mobile-filter-toggle">☰</button>

<!-- Products Section -->
<main class="products-section">
    <!-- Products Toolbar -->
    <div class="products-toolbar">
        <div class="toolbar-left">
            <div class="products-count">
                Showing <strong id="product-count">0</strong> products
            </div>
            <div class="grid-controls">
                <span>Layout:</span>
                <button class="grid-btn active" data-grid="grid-2">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                        <rect x="1" y="1" width="6" height="6" rx="1"/>
                        <rect x="9" y="1" width="6" height="6" rx="1"/>
                        <rect x="1" y="9" width="6" height="6" rx="1"/>
                        <rect x="9" y="9" width="6" height="6" rx="1"/>
                    </svg>
                </button>
                <button class="grid-btn" data-grid="grid-4">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                        <rect x="1" y="1" width="3" height="3" rx="1"/>
                        <rect x="6" y="1" width="3" height="3" rx="1"/>
                        <rect x="11" y="1" width="3" height="3" rx="1"/>
                        <rect x="1" y="6" width="3" height="3" rx="1"/>
                        <rect x="6" y="6" width="3" height="3" rx="1"/>
                        <rect x="11" y="6" width="3" height="3" rx="1"/>
                        <rect x="1" y="11" width="3" height="3" rx="1"/>
                        <rect x="6" y="11" width="3" height="3" rx="1"/>
                        <rect x="11" y="11" width="3" height="3" rx="1"/>
                    </svg>
                </button>
                <button class="grid-btn" data-grid="list-view">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                        <rect x="1" y="1" width="14" height="2" rx="1"/>
                        <rect x="1" y="7" width="14" height="2" rx="1"/>
                        <rect x="1" y="13" width="14" height="2" rx="1"/>
                    </svg>
                </button>
            </div>
        </div>
        <div class="products-sort">
            <select id="sort-select">
                <option value="featured">Sort by: Featured</option>
                <option value="price_low">Price: Low to High</option>
                <option value="price_high">Price: High to Low</option>
                <option value="newest">Newest First</option>
                <option value="rating">Best Rating</option>
            </select>
        </div>
    </div>

    <!-- Loading State -->
    <div id="loading-state" style="text-align: center; padding: 40px; display: none;">
        <p>Loading products...</p>
    </div>

    <!-- Products Grid -->
    <div class="products-grid grid-3" id="products-grid">
        <!-- Products will be loaded here dynamically -->
    </div>

    <!-- Empty State -->
    <div id="empty-state" style="text-align: center; padding: 40px; display: none;">
        <p>No products found matching your criteria.</p>
    </div>
</main>

<link rel="stylesheet" href="includes/productComponents/sidebar-filter/styles.css">
<link rel="stylesheet" href="includes/productComponents/products-grid/styles.css">
<script src="includes/productComponents/products-grid/script.js"></script>
<script src="includes/productComponents/sidebar-filter/script.js"></script>