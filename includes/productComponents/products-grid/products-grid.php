<!-- Products Section -->
<main class="products-section">
  <!-- Products Toolbar -->
  <div class="products-toolbar">
    <div class="toolbar-left">
      <div class="products-count">
        Showing <strong>6</strong> products
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
      <select>
        <option>Sort by: Featured</option>
        <option>Price: Low to High</option>
        <option>Price: High to Low</option>
        <option>Newest First</option>
        <option>Best Rating</option>
      </select>
    </div>
  </div>

  <!-- Products Grid -->
  <div class="products-grid grid-3" id="products-grid">
    <!-- Product 1: Almonds -->
    <article class="product-card">
      <div class="product-image">
        <img src="https://via.placeholder.com/300x300?text=Almonds" alt="Premium Almonds" loading="lazy">
        <div class="product-badges">
          <span class="badge badge-sale">Sale</span>
        </div>
      </div>
      <div class="product-info">
        <h3 class="product-title">Premium California Almonds</h3>
        <div class="product-rating">
          <span>★★★★★</span> <small>(312)</small>
        </div>
        <div class="product-price">
          <span class="price-current">$12.99</span>
          <span class="price-old">$16.99</span>
        </div>
        <button class="btn-add-to-cart">Add to Cart</button>
      </div>
    </article>

    <!-- Product 2: Cashews -->
    <article class="product-card">
      <div class="product-image">
        <img src="https://via.placeholder.com/300x300?text=Almonds" alt="Premium Almonds" loading="lazy">
        <div class="product-badges">
          <span class="badge badge-new">New</span>
        </div>
      </div>
      <div class="product-info">
        <h3 class="product-title">Roasted & Salted Cashews</h3>
        <div class="product-rating">
          <span>★★★★☆</span> <small>(245)</small>
        </div>
        <div class="product-price">
          <span class="price-current">$14.99</span>
        </div>
        <button class="btn-add-to-cart">Add to Cart</button>
      </div>
    </article>

    <!-- Product 3: Walnuts -->
    <article class="product-card">
      <div class="product-image">
        <img src="https://via.placeholder.com/300x300?text=Almonds" alt="Premium Almonds" loading="lazy">
      </div>
      <div class="product-info">
        <h3 class="product-title">Organic Walnut Halves</h3>
        <div class="product-rating">
          <span>★★★★★</span> <small>(189)</small>
        </div>
        <div class="product-price">
          <span class="price-current">$11.99</span>
        </div>
        <button class="btn-add-to-cart">Add to Cart</button>
      </div>
    </article>

    <!-- Product 4: Raisins -->
    <article class="product-card">
      <div class="product-image">
        <img src="https://via.placeholder.com/300x300?text=Almonds" alt="Premium Almonds" loading="lazy">
        <div class="product-badges">
          <span class="badge badge-hot">Hot</span>
        </div>
      </div>
      <div class="product-info">
        <h3 class="product-title">Seedless Golden Raisins</h3>
        <div class="product-rating">
          <span>★★★★☆</span> <small>(278)</small>
        </div>
        <div class="product-price">
          <span class="price-current">$8.99</span>
        </div>
        <button class="btn-add-to-cart">Add to Cart</button>
      </div>
    </article>

    <!-- Product 5: Pistachios -->
    <article class="product-card">
      <div class="product-image">
        <img src="https://via.placeholder.com/300x300?text=Almonds" alt="Premium Almonds" loading="lazy">
      </div>
      <div class="product-info">
        <h3 class="product-title">Roasted Pistachios (In-Shell)</h3>
        <div class="product-rating">
          <span>★★★★★</span> <small>(367)</small>
        </div>
        <div class="product-price">
          <span class="price-current">$15.99</span>
          <span class="price-old">$19.99</span>
        </div>
        <button class="btn-add-to-cart">Add to Cart</button>
      </div>
    </article>

    <!-- Product 6: Dried Apricots -->
    <article class="product-card">
      <div class="product-image">
        <img src="https://via.placeholder.com/300x300?text=Almonds" alt="Premium Almonds" loading="lazy">
      </div>
      <div class="product-info">
        <h3 class="product-title">Turkish Dried Apricots</h3>
        <div class="product-rating">
          <span>★★★★☆</span> <small>(203)</small>
        </div>
        <div class="product-price">
          <span class="price-current">$10.99</span>
        </div>
        <button class="btn-add-to-cart">Add to Cart</button>
      </div>
    </article>
    
  </div>
</main>

<link rel="stylesheet" href="includes/productComponents/products-grid/styles.css">
<script src="includes/productComponents/products-grid/script.js"></script>