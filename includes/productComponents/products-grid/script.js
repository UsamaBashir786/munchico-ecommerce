// Products Grid Component with API Integration
class ProductsGrid {
  constructor() {
    this.products = [];
    this.filteredProducts = [];
    this.categories = [];
    this.currentLayout = 'grid-3';
    this.filters = {
      category_id: 'all',
      min_price: 0,
      max_price: 1000,
      min_rating: 0,
      sort_by: 'featured'
    };
    this.init();
  }

  async init() {
    await this.loadCategories();
    await this.loadProducts();
    this.bindEvents();
    this.renderProducts();
  }

  async loadCategories() {
    try {
      const response = await fetch('api/get-categories.php');
      const data = await response.json();
      
      if (data.success) {
        this.categories = data.categories;
        this.renderCategoryFilters();
      }
    } catch (error) {
      console.error('Error loading categories:', error);
    }
  }

  renderCategoryFilters() {
    const container = document.getElementById('categories-filter');
    if (!container) return;

    // Keep the "All Products" option
    const allOption = container.querySelector('.filter-option');
    const totalCount = this.categories.reduce((sum, cat) => sum + cat.product_count, 0);
    document.getElementById('count-all').textContent = `(${totalCount})`;

    // Add category options
    this.categories.forEach(category => {
      const filterOption = document.createElement('div');
      filterOption.className = 'filter-option';
      filterOption.innerHTML = `
        <input type="checkbox" id="cat-${category.id}" value="${category.id}">
        <label for="cat-${category.id}">${category.name}</label>
        <span class="filter-count">(${category.product_count})</span>
      `;
      container.appendChild(filterOption);
    });
  }

  async loadProducts() {
    try {
      this.showLoading(true);
      
      // Build query string
      const params = new URLSearchParams();
      if (this.filters.category_id !== 'all') {
        params.append('category_id', this.filters.category_id);
      }
      params.append('min_price', this.filters.min_price);
      params.append('max_price', this.filters.max_price);
      params.append('min_rating', this.filters.min_rating);
      params.append('sort_by', this.filters.sort_by);

      const response = await fetch(`api/get-products.php?${params.toString()}`);
      const data = await response.json();
      
      if (data.success) {
        this.products = data.products;
        this.filteredProducts = data.products;
        this.updateProductsCount();
        this.renderProducts();
      } else {
        this.showError('Failed to load products');
      }
    } catch (error) {
      console.error('Error loading products:', error);
      this.showError('Error loading products');
    } finally {
      this.showLoading(false);
    }
  }

  showLoading(show) {
    const loading = document.getElementById('loading-state');
    const grid = document.getElementById('products-grid');
    
    if (loading) loading.style.display = show ? 'block' : 'none';
    if (grid) grid.style.display = show ? 'none' : 'grid';
  }

  showError(message) {
    const grid = document.getElementById('products-grid');
    if (grid) {
      grid.innerHTML = `
        <div style="grid-column: 1 / -1; text-align: center; padding: 40px;">
          <p style="color: #ef4444;">${message}</p>
        </div>
      `;
    }
  }

  bindEvents() {
    // Grid layout controls
    const gridBtns = document.querySelectorAll('.grid-btn');
    gridBtns.forEach(btn => {
      btn.addEventListener('click', (e) => this.changeGridLayout(e.currentTarget));
    });

    // Sort functionality
    const sortSelect = document.getElementById('sort-select');
    if (sortSelect) {
      sortSelect.addEventListener('change', (e) => {
        this.filters.sort_by = this.convertSortValue(e.target.value);
        this.loadProducts();
      });
    }

    // Apply filters button
    const applyBtn = document.getElementById('apply-filters');
    if (applyBtn) {
      applyBtn.addEventListener('click', () => this.applyFilters());
    }

    // Reset filters button
    const resetBtn = document.getElementById('reset-filters');
    if (resetBtn) {
      resetBtn.addEventListener('click', () => this.resetFilters());
    }

    // Add to cart buttons (event delegation)
    document.addEventListener('click', (e) => {
      if (e.target.matches('.add-to-cart-btn')) {
        this.handleAddToCart(e.target);
      }
    });
  }

  convertSortValue(value) {
    const sortMap = {
      'featured': 'featured',
      'Price: Low to High': 'price_low',
      'Price: High to Low': 'price_high',
      'Newest First': 'newest',
      'Best Rating': 'rating'
    };
    return sortMap[value] || value;
  }

  applyFilters() {
    // Get selected categories
    const categoryCheckboxes = document.querySelectorAll('#categories-filter input[type="checkbox"]:checked');
    const selectedCategories = Array.from(categoryCheckboxes)
      .map(cb => cb.value)
      .filter(val => val); // Remove empty values
    
    if (selectedCategories.length === 0 || document.getElementById('cat-all').checked) {
      this.filters.category_id = 'all';
    } else {
      this.filters.category_id = selectedCategories[0]; // For simplicity, use first selected
    }

    // Get price range
    const minPrice = document.getElementById('price-min');
    const maxPrice = document.getElementById('price-max');
    if (minPrice) this.filters.min_price = parseFloat(minPrice.value) || 0;
    if (maxPrice) this.filters.max_price = parseFloat(maxPrice.value) || 1000;

    // Get rating filter
    const ratingCheckboxes = document.querySelectorAll('[id^="rating-"]:checked');
    if (ratingCheckboxes.length > 0) {
      const ratings = Array.from(ratingCheckboxes).map(cb => parseFloat(cb.value));
      this.filters.min_rating = Math.max(...ratings);
    } else {
      this.filters.min_rating = 0;
    }

    // Reload products with filters
    this.loadProducts();

    // Close mobile sidebar
    this.closeSidebar();
  }

  resetFilters() {
    // Reset checkboxes
    document.querySelectorAll('#categories-filter input[type="checkbox"]').forEach(cb => {
      cb.checked = cb.id === 'cat-all';
    });
    document.querySelectorAll('[id^="rating-"]').forEach(cb => cb.checked = false);

    // Reset price inputs
    const minPrice = document.getElementById('price-min');
    const maxPrice = document.getElementById('price-max');
    if (minPrice) minPrice.value = 0;
    if (maxPrice) maxPrice.value = 1000;

    // Reset filters object
    this.filters = {
      category_id: 'all',
      min_price: 0,
      max_price: 1000,
      min_rating: 0,
      sort_by: 'featured'
    };

    // Reload products
    this.loadProducts();
  }

  closeSidebar() {
    const sidebar = document.querySelector('.sidebar-filter');
    const overlay = document.querySelector('.sidebar-overlay');
    if (sidebar) sidebar.classList.remove('active');
    if (overlay) overlay.classList.remove('active');
  }

  changeGridLayout(button) {
    const gridType = button.dataset.grid;
    
    document.querySelectorAll('.grid-btn').forEach(btn => btn.classList.remove('active'));
    button.classList.add('active');
    
    const productsGrid = document.getElementById('products-grid');
    productsGrid.className = `products-grid ${gridType}`;
    this.currentLayout = gridType;
  }

  updateProductsCount() {
    const countElement = document.getElementById('product-count');
    if (countElement) {
      countElement.textContent = this.filteredProducts.length;
    }
  }

  renderProducts() {
    const grid = document.getElementById('products-grid');
    const emptyState = document.getElementById('empty-state');
    
    if (!grid) return;

    if (this.filteredProducts.length === 0) {
      grid.style.display = 'none';
      if (emptyState) emptyState.style.display = 'block';
      return;
    }

    grid.style.display = 'grid';
    if (emptyState) emptyState.style.display = 'none';

    grid.innerHTML = this.filteredProducts
      .map(product => this.createProductCard(product))
      .join('');
  }

createProductCard(product) {
    const stars = this.generateStarRating(product.rating);
    
    // Badge logic
    let badges = '';
    if (product.badges.sale || product.discount > 0) {
      badges += `<span class="discount-badge">${product.discount}% OFF</span>`;
    }
    if (product.badges.new) {
      badges += '<span class="organic-badge">NEW</span>';
    }
    if (product.badges.hot) {
      badges += '<span class="organic-badge" style="background: #ef4444;">HOT</span>';
    }
    
    const originalPrice = product.originalPrice 
      ? `<span class="original-price">$${product.originalPrice.toFixed(2)}</span>` 
      : '';

    const stockStatus = product.inStock 
      ? '' 
      : '<span style="color: #ef4444; font-size: 12px;">Out of Stock</span>';

    // Improved image handling with fallback
    const imageSrc = product.image || 'assets/images/placeholder-product.jpg';

    return `
      <div class="product-card" data-product-id="${product.id}">
        <a href="product-details.php?id=${product.id}" class="product-image-wrapper">
          ${badges}
          <img src="${imageSrc}" 
               alt="${product.name}" 
               class="product-image" 
               loading="lazy" 
               onerror="this.onerror=null; this.src='assets/images/placeholder-product.jpg';">
        </a>
        <div class="product-info">
          <div class="product-category">${product.category}</div>
          <h3 class="product-name">
            <a href="product-details.php?id=${product.id}" style="text-decoration: none; color: inherit;">
              ${product.name}
            </a>
          </h3>
          <div class="product-rating">
            <div class="stars">${stars}</div>
            <span class="rating-count">(${product.reviews})</span>
          </div>
          <div class="product-price">
            <span class="current-price">$${product.price.toFixed(2)}</span>
            ${originalPrice}
          </div>
          ${stockStatus}
          <button class="add-to-cart-btn" ${!product.inStock ? 'disabled' : ''}>
            ${product.inStock ? 'Add to Cart' : 'Out of Stock'}
          </button>
        </div>
      </div>
    `;
  }

  generateStarRating(rating) {
    return Array.from({ length: 5 }, (_, i) => 
      `<span class="star${i < Math.floor(rating) ? '' : ' empty'}">★</span>`
    ).join('');
  }

  handleAddToCart(button) {
    if (button.disabled) return;

    const productCard = button.closest('.product-card');
    const productId = productCard.dataset.productId;
    const product = this.products.find(p => p.id == productId);

    // Visual feedback
    const originalText = button.textContent;
    button.textContent = 'Added! ✓';
    button.disabled = true;

    setTimeout(() => {
      button.textContent = originalText;
      button.disabled = false;
    }, 2000);

    // Dispatch cart event
    document.dispatchEvent(new CustomEvent('productAddedToCart', {
      detail: { product }
    }));

    console.log('Added to cart:', product);
  }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
  new ProductsGrid();
});