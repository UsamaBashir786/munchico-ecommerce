// Products Grid Component JavaScript
class ProductsGrid {
  constructor() {
    this.products = [];
    this.filteredProducts = [];
    this.currentLayout = 'grid-3';
    this.init();
  }

  async init() {
    await this.loadProducts();
    this.bindEvents();
    this.renderProducts();
  }

  async loadProducts() {
    // Mock product data - dry fruits (6 products)
    this.products = [
      {
        id: 1,
        name: "Premium California Almonds",
        category: "Nuts",
        price: 12.99,
        originalPrice: 16.99,
        discount: 24,
        rating: 5,
        reviews: 312,
        image: "https://images.unsplash.com/photo-1610832958506-aa56368176cf?w=400&h=300&fit=crop",
        organic: true,
        inStock: true
      },
      {
        id: 2,
        name: "Roasted & Salted Cashews",
        category: "Nuts",
        price: 14.99,
        originalPrice: null,
        discount: 0,
        rating: 4,
        reviews: 245,
        image: "https://images.unsplash.com/photo-1599599810769-bcde5a160d32?w=500&q=80",
        organic: false,
        inStock: true
      },
      {
        id: 3,
        name: "Organic Walnut Halves",
        category: "Nuts",
        price: 11.99,
        originalPrice: null,
        discount: 0,
        rating: 5,
        reviews: 189,
        image: "https://images.unsplash.com/photo-1599599810769-bcde5a160d32?w=500&q=80",
        organic: true,
        inStock: true
      },
      {
        id: 4,
        name: "Seedless Golden Raisins",
        category: "Dried Fruits",
        price: 8.99,
        originalPrice: null,
        discount: 0,
        rating: 4,
        reviews: 278,
        image: "https://images.unsplash.com/photo-1610832958506-aa56368176cf?w=400&h=300&fit=crop",
        organic: false,
        inStock: true
      },
      {
        id: 5,
        name: "Roasted Pistachios (In-Shell)",
        category: "Nuts",
        price: 15.99,
        originalPrice: 19.99,
        discount: 20,
        rating: 5,
        reviews: 367,
        image: "https://images.unsplash.com/photo-1610832958506-aa56368176cf?w=400&h=300&fit=crop",
        organic: false,
        inStock: true
      },
      {
        id: 6,
        name: "Turkish Dried Apricots",
        category: "Dried Fruits",
        price: 10.99,
        originalPrice: null,
        discount: 0,
        rating: 4,
        reviews: 203,
        image: "https://images.unsplash.com/photo-1508736793122-f516e3ba5569?w=400&h=300&fit=crop",
        organic: true,
        inStock: true
      }
    ];
    this.filteredProducts = [...this.products];
  }

  bindEvents() {
    // Grid layout controls
    const gridBtns = document.querySelectorAll('.grid-btn');
    gridBtns.forEach(btn => {
      btn.addEventListener('click', (e) => this.changeGridLayout(e.currentTarget));
    });

    // Sort functionality
    const sortSelect = document.querySelector('.products-sort select');
    if (sortSelect) {
      sortSelect.addEventListener('change', (e) => this.sortProducts(e.target.value));
    }

    // Listen for filter events from sidebar
    document.addEventListener('filtersApplied', (e) => {
      this.applyFilters(e.detail.filters);
    });

    // Add to cart buttons (event delegation)
    document.addEventListener('click', (e) => {
      if (e.target.matches('.add-to-cart-btn')) {
        this.handleAddToCart(e.target);
      }
    });
  }

  changeGridLayout(button) {
    const gridType = button.dataset.grid;
    
    // Update active state
    document.querySelectorAll('.grid-btn').forEach(btn => btn.classList.remove('active'));
    button.classList.add('active');
    
    // Apply layout class
    const productsGrid = document.getElementById('products-grid');
    productsGrid.className = `products-grid ${gridType}`;
    this.currentLayout = gridType;
  }

  sortProducts(sortBy) {
    const sorted = [...this.filteredProducts];
    
    switch (sortBy) {
      case 'Price: Low to High':
        sorted.sort((a, b) => a.price - b.price);
        break;
      case 'Price: High to Low':
        sorted.sort((a, b) => b.price - a.price);
        break;
      case 'Best Rating':
        sorted.sort((a, b) => b.rating - a.rating || b.reviews - a.reviews);
        break;
      case 'Newest First':
        // Using negative ID as proxy for newest
        sorted.sort((a, b) => b.id - a.id);
        break;
      default:
        // Featured: original order
        sorted.sort((a, b) => a.id - b.id);
    }
    
    this.filteredProducts = sorted;
    this.renderProducts();
  }

  applyFilters(filters) {
    this.filteredProducts = this.products.filter(product => {
      // Category filter
      if (filters.categories?.length > 0 && !filters.categories.includes('all')) {
        const match = filters.categories.some(cat => 
          product.category.toLowerCase().includes(cat.toLowerCase())
        );
        if (!match) return false;
      }

      // Price range
      const minPrice = parseFloat(filters.priceRange?.min) || 0;
      const maxPrice = parseFloat(filters.priceRange?.max) || Infinity;
      if (product.price < minPrice || product.price > maxPrice) return false;

      // Quality: organic
      if (filters.quality?.includes('organic') && !product.organic) return false;

      // Rating filter
      if (filters.rating?.length > 0) {
        const minRating = Math.max(...filters.rating.map(r => parseInt(r)));
        if (product.rating < minRating) return false;
      }

      return true;
    });

    this.updateProductsCount();
    this.renderProducts();
  }

  updateProductsCount() {
    const countElement = document.querySelector('.products-count strong');
    if (countElement) {
      countElement.textContent = this.filteredProducts.length;
    }
  }

  renderProducts() {
    const grid = document.getElementById('products-grid');
    if (!grid) return;

    grid.innerHTML = this.filteredProducts
      .map(product => this.createProductCard(product))
      .join('');
  }

  createProductCard(product) {
    const stars = this.generateStarRating(product.rating);
    const discountBadge = product.discount > 0 
      ? `<span class="discount-badge">${product.discount}% OFF</span>` 
      : '';
    const organicBadge = product.organic 
      ? '<span class="organic-badge">ORGANIC</span>' 
      : '';
    const originalPrice = product.originalPrice 
      ? `<span class="original-price">$${product.originalPrice.toFixed(2)}</span>` 
      : '';

    return `
      <div class="product-card" data-product-id="${product.id}">
        <div class="product-image-wrapper">
          ${discountBadge}
          ${organicBadge}
          <img src="${product.image}" alt="${product.name}" class="product-image" loading="lazy">
        </div>
        <div class="product-info">
          <div class="product-category">${product.category}</div>
          <h3 class="product-name">${product.name}</h3>
          <div class="product-rating">
            <div class="stars">${stars}</div>
            <span class="rating-count">(${product.reviews})</span>
          </div>
          <div class="product-price">
            <span class="current-price">$${product.price.toFixed(2)}</span>
            ${originalPrice}
          </div>
          <button class="add-to-cart-btn">Add to Cart</button>
        </div>
      </div>
    `;
  }

  generateStarRating(rating) {
    return Array.from({ length: 5 }, (_, i) => 
      `<span class="star${i < rating ? '' : ' empty'}">★</span>`
    ).join('');
  }

  handleAddToCart(button) {
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
  }
}

// Initialize when DOM is fully loaded
document.addEventListener('DOMContentLoaded', () => {
  new ProductsGrid();
});