<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- ========================================================= -->
  <!-- ⚙️ BASIC CONFIGURATION -->
  <!-- ========================================================= -->
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  
  <!-- ========================================================= -->
  <!-- 🏠 PAGE TITLE & META INFO -->
  <!-- Essential for SEO and browser tab display -->
  <!-- ========================================================= -->
  <title>PRODUCT DETAILS – MUNCHICO | Premium Dried Fruits & Nuts Online Store</title>
  <meta name="title" content="HOME – MUNCHICO | Premium Dried Fruits & Nuts Online Store" />
  <meta name="description" content="Shop premium dried fruits, nuts, and snacks at MUNCHICO. Exclusive deals, top quality products, and fast delivery. Your trusted online store for healthy snacking." />
  <meta name="keywords" content="dried fruits, nuts, premium snacks, healthy snacks, MUNCHICO, online store, dried figs, almonds, cashews" />
  <meta name="author" content="MUNCHICO" />
  <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1" />

  <!-- ========================================================= -->
  <!-- 🌐 OPEN GRAPH (Facebook / LinkedIn Preview) -->
  <!-- Helps control how your site appears when shared -->
  <!-- ========================================================= -->
  <meta property="og:type" content="website" />
  <meta property="og:url" content="https://www.munchico.com/" />
  <meta property="og:site_name" content="MUNCHICO" />
  <meta property="og:title" content="HOME – MUNCHICO | Premium Dried Fruits & Nuts Online Store" />
  <meta property="og:description" content="Shop premium dried fruits, nuts, and snacks at MUNCHICO. Exclusive deals, top quality products, and fast delivery." />
  <meta property="og:image" content="https://www.munchico.com/assets/images/og-image.jpg" />
  <meta property="og:image:width" content="1200" />
  <meta property="og:image:height" content="630" />
  <meta property="og:image:alt" content="MUNCHICO - Premium Dried Fruits & Nuts" />
  <meta property="og:locale" content="en_US" />

  <!-- ========================================================= -->
  <!-- 🐦 TWITTER CARD META -->
  <!-- For rich link previews on Twitter/X -->
  <!-- ========================================================= -->
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:url" content="https://www.munchico.com/" />
  <meta name="twitter:title" content="HOME – MUNCHICO | Premium Dried Fruits & Nuts Online Store" />
  <meta name="twitter:description" content="Shop premium dried fruits, nuts, and snacks at MUNCHICO. Exclusive deals, top quality products, and fast delivery." />
  <meta name="twitter:image" content="https://www.munchico.com/assets/images/twitter-card.jpg" />
  <meta name="twitter:image:alt" content="MUNCHICO - Premium Dried Fruits & Nuts" />
  <meta name="twitter:site" content="@munchico" />
  <meta name="twitter:creator" content="@munchico" />

  <!-- ========================================================= -->
  <!-- 🔖 FAVICONS & APP ICONS -->
  <!-- For browser tabs, mobile shortcuts, and PWA -->
  <!-- ========================================================= -->
  <link rel="icon" type="image/x-icon" href="assets/images/favicon.ico" />
  <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon-16x16.png" />
  <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicon-32x32.png" />
  <link rel="icon" type="image/png" sizes="192x192" href="assets/images/android-chrome-192x192.png" />
  <link rel="icon" type="image/png" sizes="512x512" href="assets/images/android-chrome-512x512.png" />
  <link rel="apple-touch-icon" sizes="180x180" href="assets/images/apple-touch-icon.png" />

  <!-- ========================================================= -->
  <!-- 📱 PWA & WINDOWS META -->
  <!-- Controls how the app behaves on mobile and Windows -->
  <!-- ========================================================= -->
  <link rel="manifest" href="site.webmanifest" />
  <meta name="theme-color" content="#ffffff" />
  <meta name="msapplication-TileColor" content="#ffffff" />
  <meta name="msapplication-config" content="browserconfig.xml" />

  <!-- ========================================================= -->
  <!-- 🔗 SEO LINKS -->
  <!-- Canonical & language alternate versions -->
  <!-- ========================================================= -->
  <link rel="canonical" href="https://www.munchico.com/" />
  <link rel="alternate" hreflang="en" href="https://www.munchico.com/" />
  <link rel="alternate" hreflang="x-default" href="https://www.munchico.com/" />

  <!-- ========================================================= -->
  <!-- ⚡ PERFORMANCE OPTIMIZATION -->
  <!-- Preconnect & preload for faster loading -->
  <!-- ========================================================= -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link rel="dns-prefetch" href="https://www.google-analytics.com" />
  <link rel="preload" href="assets/css/main.css" as="style" />

  <!-- ========================================================= -->
  <!-- 🧩 STRUCTURED DATA (JSON-LD) -->
  <!-- Enhances SEO with schema.org data -->
  <!-- ========================================================= -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@graph": [
      {
        "@type": "WebSite",
        "name": "MUNCHICO",
        "url": "https://www.munchico.com",
        "description": "Premium dried fruits, nuts, and healthy snacks online store",
        "potentialAction": {
          "@type": "SearchAction",
          "target": "https://www.munchico.com/search?q={search_term_string}",
          "query-input": "required name=search_term_string"
        }
      },
      {
        "@type": "Organization",
        "name": "MUNCHICO",
        "url": "https://www.munchico.com",
        "logo": "https://www.munchico.com/assets/images/logo.png",
        "sameAs": [
          "https://www.facebook.com/munchico",
          "https://www.instagram.com/munchico",
          "https://www.twitter.com/munchico",
          "https://www.linkedin.com/company/munchico"
        ],
        "contactPoint": {
          "@type": "ContactPoint",
          "telephone": "+1-XXX-XXX-XXXX",
          "contactType": "Customer Service",
          "areaServed": "US",
          "availableLanguage": ["English"]
        }
      }
    ]
  }
  </script>

  <!-- ========================================================= -->
  <!-- 🎨 STYLESHEETS -->
  <!-- Core and extra styling files for layout and design -->
  <!-- ========================================================= -->
  <!-- 🌐 Main global styles -->
  <link rel="stylesheet" href="assets/css/main.css" />

  <!-- ✨ Additional custom tweaks and overrides -->
  <link rel="stylesheet" href="assets/css/extra.css" />

  <!-- 👑 Royal CSS Framework (Custom UI components) -->
  <link rel="stylesheet" href="assets/royalcssx/royal.css" />
</head>


<body>
  <!-- ========================================================= -->
  <!-- 🌀 PRELOADER SECTION -->
  <!-- Displays a loading animation before the content appears -->
  <!-- ========================================================= -->
  <?php include 'includes/components/preloader/index.php' ?>

  <!-- ========================================================= -->
  <!-- 🚀 NAVIGATION BAR -->
  <!-- Contains logo, menus, and main navigation links -->
  <!-- ========================================================= -->
  <?php include 'includes/navbar.php' ?>

  <!-- ========================================================= -->
  <!-- 📢 ANNOUNCEMENT BAR -->
  <!-- Displays latest updates or promotions in a marquee style -->
  <!-- ========================================================= -->
  <?php include 'includes/components/announcements/index.php' ?>


  <!-- ========================================================= -->
<!-- 🛍️ PRODUCT DETAILS SECTION -->
<!-- Complete product details with gallery, info, and actions -->
<!-- ========================================================= -->
<section class="product-details-section">
  <!-- Breadcrumb Navigation -->
  <div class="breadcrumb-container">
    <div class="container">
      <nav class="breadcrumb">
        <a href="index.php">Home</a>
        <span class="separator">/</span>
        <a href="products.php">Products</a>
        <span class="separator">/</span>
        <a href="products.php?category=nuts">Premium Nuts</a>
        <span class="separator">/</span>
        <span class="current">California Almonds</span>
      </nav>
    </div>
  </div>

  <!-- Main Product Container -->
  <div class="product-details-container container">
    <!-- Product Gallery -->
    <div class="product-gallery">
      <div class="gallery-main">
        <div class="main-image-wrapper">
          <img src="https://images.unsplash.com/photo-1599599810769-bcde5a160d32?w=600&q=80" alt="California Almonds" class="main-image" id="main-product-image">
          <span class="organic-badge">ORGANIC</span>
          <span class="discount-badge">25% OFF</span>
        </div>
        <div class="gallery-actions">
          <button class="action-btn wishlist-btn" data-product-id="1">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
              <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
            </svg>
            Add to Wishlist
          </button>
          <button class="action-btn share-btn">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
              <path d="M18 16.08c-.76 0-1.44.3-1.96.77L8.91 12.7c.05-.23.09-.46.09-.7s-.04-.47-.09-.7l7.05-4.11c.54.5 1.25.81 2.04.81 1.66 0 3-1.34 3-3s-1.34-3-3-3-3 1.34-3 3c0 .24.04.47.09.7L8.04 9.81C7.5 9.31 6.79 9 6 9c-1.66 0-3 1.34-3 3s1.34 3 3 3c.79 0 1.5-.31 2.04-.81l7.12 4.16c-.05.21-.08.43-.08.65 0 1.61 1.31 2.92 2.92 2.92 1.61 0 2.92-1.31 2.92-2.92s-1.31-2.92-2.92-2.92z"/>
            </svg>
            Share Product
          </button>
        </div>
      </div>

      <div class="gallery-thumbnails">
        <div class="thumbnail active" data-image="https://images.unsplash.com/photo-1599599810769-bcde5a160d32?w=600&q=80">
          <img src="https://images.unsplash.com/photo-1599599810769-bcde5a160d32?w=150&q=80" alt="Almonds thumbnail">
        </div>
        <div class="thumbnail" data-image="https://images.unsplash.com/photo-1599599810769-bcde5a160d32?w=600&q=80&1">
          <img src="https://images.unsplash.com/photo-1599599810769-bcde5a160d32?w=150&q=80&1" alt="Almonds closeup">
        </div>
        <div class="thumbnail" data-image="https://images.unsplash.com/photo-1599599810769-bcde5a160d32?w=600&q=80&2">
          <img src="https://images.unsplash.com/photo-1599599810769-bcde5a160d32?w=150&q=80&2" alt="Almonds packaging">
        </div>
        <div class="thumbnail" data-image="https://images.unsplash.com/photo-1599599810769-bcde5a160d32?w=600&q=80&3">
          <img src="https://images.unsplash.com/photo-1599599810769-bcde5a160d32?w=150&q=80&3" alt="Almonds nutrition">
        </div>
      </div>
    </div>

    <!-- Product Information -->
    <div class="product-info">
      <div class="product-header">
        <span class="product-category">Premium Nuts</span>
        <h1 class="product-title">California Almonds</h1>
        <div class="product-rating">
          <div class="stars">
            <span class="star">★</span>
            <span class="star">★</span>
            <span class="star">★</span>
            <span class="star">★</span>
            <span class="star">★</span>
          </div>
          <span class="rating-value">5.0</span>
          <span class="rating-count">(145 reviews)</span>
          <a href="#reviews" class="see-reviews">See all reviews</a>
        </div>
      </div>

      <div class="product-pricing">
        <div class="price-container">
          <span class="current-price">$18.99</span>
          <span class="original-price">$24.99</span>
          <span class="discount-percent">Save 25%</span>
        </div>
        <div class="price-note">Price includes all taxes</div>
      </div>

      <div class="product-description">
        <p>Premium California almonds, carefully selected and roasted to perfection. These organic almonds are rich in nutrients, packed with protein, and perfect for healthy snacking. Sourced directly from California's finest orchards.</p>
        
        <div class="highlight-features">
          <div class="feature">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
              <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
            </svg>
            <span>100% Organic Certified</span>
          </div>
          <div class="feature">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
              <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
            </svg>
            <span>No Added Preservatives</span>
          </div>
          <div class="feature">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
              <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
            </svg>
            <span>Rich in Protein & Fiber</span>
          </div>
          <div class="feature">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
              <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
            </svg>
            <span>Freshly Roasted</span>
          </div>
        </div>
      </div>

      <!-- Product Options -->
      <div class="product-options">
        <div class="option-group">
          <label class="option-label">Size:</label>
          <div class="size-options">
            <button class="size-option active" data-size="500g" data-price="18.99">500g</button>
            <button class="size-option" data-size="1kg" data-price="34.99">1kg</button>
            <button class="size-option" data-size="2kg" data-price="64.99">2kg</button>
          </div>
        </div>

        <div class="option-group">
          <label class="option-label">Quantity:</label>
          <div class="quantity-selector">
            <button class="quantity-btn minus-btn">-</button>
            <input type="number" class="quantity-input" value="1" min="1" max="10">
            <button class="quantity-btn plus-btn">+</button>
          </div>
        </div>
      </div>

      <!-- Add to Cart Section -->
      <div class="add-to-cart-section">
        <div class="stock-info">
          <span class="stock-status in-stock">In Stock</span>
          <span class="delivery-info">Free delivery in 2-3 days</span>
        </div>
        
        <div class="cart-actions">
          <button class="add-to-cart-btn primary-btn">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
              <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/>
            </svg>
            Add to Cart
          </button>
          <button class="buy-now-btn secondary-btn">
            Buy Now
          </button>
        </div>
      </div>

      <!-- Product Meta -->
      <div class="product-meta">
        <div class="meta-item">
          <span class="meta-label">SKU:</span>
          <span class="meta-value">ALM-CA-500</span>
        </div>
        <div class="meta-item">
          <span class="meta-label">Category:</span>
          <span class="meta-value">Premium Nuts</span>
        </div>
        <div class="meta-item">
          <span class="meta-label">Tags:</span>
          <span class="meta-value">Organic, Almonds, Healthy, Snacks</span>
        </div>
      </div>
    </div>
  </div>

  <!-- Product Tabs Section -->
  <div class="product-tabs-container container">
    <div class="tabs-navigation">
      <button class="tab-btn active" data-tab="description">Description</button>
      <button class="tab-btn" data-tab="nutrition">Nutrition Facts</button>
      <button class="tab-btn" data-tab="reviews">Reviews (145)</button>
      <button class="tab-btn" data-tab="shipping">Shipping & Returns</button>
    </div>

    <div class="tabs-content">
      <!-- Description Tab -->
      <div class="tab-panel active" id="description">
        <div class="tab-content">
          <h3>Product Description</h3>
          <p>Our California Almonds are carefully selected from the finest orchards in California's Central Valley. Each almond is hand-picked and roasted to perfection to bring out its natural flavor and crunch.</p>
          
          <div class="description-features">
            <div class="feature-column">
              <h4>Key Features:</h4>
              <ul>
                <li>100% Organic Certified</li>
                <li>No Added Salt or Oil</li>
                <li>Rich in Vitamin E and Magnesium</li>
                <li>Excellent Source of Protein</li>
                <li>Low in Saturated Fat</li>
              </ul>
            </div>
            <div class="feature-column">
              <h4>Storage Instructions:</h4>
              <ul>
                <li>Store in a cool, dry place</li>
                <li>Keep away from direct sunlight</li>
                <li>Best consumed within 6 months</li>
                <li>Refrigerate for longer shelf life</li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <!-- Nutrition Tab -->
      <div class="tab-panel" id="nutrition">
        <div class="tab-content">
          <h3>Nutrition Facts</h3>
          <div class="nutrition-table">
            <div class="nutrition-header">
              <span>Amount Per Serving (30g)</span>
            </div>
            <div class="nutrition-row">
              <span class="nutrient">Calories</span>
              <span class="value">170</span>
            </div>
            <div class="nutrition-row">
              <span class="nutrient">Total Fat</span>
              <span class="value">15g</span>
            </div>
            <div class="nutrition-row sub-row">
              <span class="nutrient">Saturated Fat</span>
              <span class="value">1g</span>
            </div>
            <div class="nutrition-row">
              <span class="nutrient">Protein</span>
              <span class="value">6g</span>
            </div>
            <div class="nutrition-row">
              <span class="nutrient">Carbohydrates</span>
              <span class="value">6g</span>
            </div>
            <div class="nutrition-row sub-row">
              <span class="nutrient">Dietary Fiber</span>
              <span class="value">3g</span>
            </div>
            <div class="nutrition-row sub-row">
              <span class="nutrient">Sugars</span>
              <span class="value">1g</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Reviews Tab -->
      <div class="tab-panel" id="reviews">
        <div class="tab-content">
          <h3>Customer Reviews</h3>
          <div class="reviews-summary">
            <div class="overall-rating">
              <div class="rating-score">5.0</div>
              <div class="rating-stars">
                <span class="star">★</span>
                <span class="star">★</span>
                <span class="star">★</span>
                <span class="star">★</span>
                <span class="star">★</span>
              </div>
              <div class="rating-count">Based on 145 reviews</div>
            </div>
            <div class="rating-bars">
              <div class="rating-bar">
                <span class="star-label">5 stars</span>
                <div class="bar-container">
                  <div class="bar-fill" style="width: 92%"></div>
                </div>
                <span class="percentage">92%</span>
              </div>
              <div class="rating-bar">
                <span class="star-label">4 stars</span>
                <div class="bar-container">
                  <div class="bar-fill" style="width: 6%"></div>
                </div>
                <span class="percentage">6%</span>
              </div>
              <div class="rating-bar">
                <span class="star-label">3 stars</span>
                <div class="bar-container">
                  <div class="bar-fill" style="width: 2%"></div>
                </div>
                <span class="percentage">2%</span>
              </div>
            </div>
          </div>

          <div class="reviews-list">
            <!-- Sample Review -->
            <div class="review-item">
              <div class="review-header">
                <div class="reviewer-info">
                  <span class="reviewer-name">Sarah Johnson</span>
                  <div class="review-rating">
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                  </div>
                </div>
                <span class="review-date">2 days ago</span>
              </div>
              <div class="review-content">
                <p>These almonds are absolutely fantastic! So fresh and crunchy. Perfect for my morning yogurt and afternoon snacks. Will definitely order again!</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Shipping Tab -->
      <div class="tab-panel" id="shipping">
        <div class="tab-content">
          <h3>Shipping & Returns</h3>
          <div class="shipping-info">
            <h4>Delivery Information</h4>
            <ul>
              <li>Free standard shipping on orders over $50</li>
              <li>Express shipping available at additional cost</li>
              <li>Estimated delivery: 2-3 business days</li>
              <li>We ship to all 50 US states</li>
            </ul>
            
            <h4>Return Policy</h4>
            <ul>
              <li>30-day return policy for unopened products</li>
              <li>Full refund or exchange available</li>
              <li>Return shipping is free</li>
              <li>Contact customer service for returns</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Related Products -->
  <div class="related-products-container container">
    <div class="section-header">
      <h2>You May Also Like</h2>
      <a href="products.php" class="view-all">View All</a>
    </div>
    <div class="related-products-grid">
      <!-- Related products will be loaded here -->
    </div>
  </div>
</section>

<style>
/* Product Details Styles */
.product-details-section {
  padding: var(--space-xl) 0;
  background: var(--gray-50);
}

.breadcrumb-container {
  background: var(--white);
  padding: var(--space-md) 0;
  border-bottom: 1px solid var(--gray-200);
  margin-bottom: var(--space-xl);
}

.breadcrumb {
  display: flex;
  align-items: center;
  gap: var(--space-sm);
  font-size: var(--font-size-sm);
}

.breadcrumb a {
  color: var(--gray-600);
  text-decoration: none;
  transition: var(--transition-fast);
}

.breadcrumb a:hover {
  color: var(--primary-color);
}

.breadcrumb .separator {
  color: var(--gray-400);
}

.breadcrumb .current {
  color: var(--primary-color);
  font-weight: 500;
}

.product-details-container {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: var(--space-2xl);
  margin-bottom: var(--space-3xl);
}

/* Product Gallery */
.product-gallery {
  display: flex;
  flex-direction: column;
  gap: var(--space-lg);
}

.gallery-main {
  position: relative;
}

.main-image-wrapper {
  position: relative;
  border-radius: var(--radius-lg);
  overflow: hidden;
  background: var(--white);
  box-shadow: var(--shadow-md);
}

.main-image {
  width: 100%;
  height: 500px;
  object-fit: cover;
  display: block;
}

.organic-badge {
  position: absolute;
  top: var(--space-lg);
  left: var(--space-lg);
  background: var(--secondary-color);
  color: var(--white);
  padding: var(--space-sm) var(--space-md);
  border-radius: var(--radius-full);
  font-size: var(--font-size-sm);
  font-weight: 600;
  text-transform: uppercase;
}

.discount-badge {
  position: absolute;
  top: var(--space-lg);
  right: var(--space-lg);
  background: var(--danger-color);
  color: var(--white);
  padding: var(--space-sm) var(--space-md);
  border-radius: var(--radius-full);
  font-size: var(--font-size-sm);
  font-weight: 700;
}

.gallery-actions {
  display: flex;
  gap: var(--space-md);
  margin-top: var(--space-lg);
}

.action-btn {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: var(--space-sm);
  padding: var(--space-md);
  background: var(--white);
  border: 2px solid var(--gray-200);
  border-radius: var(--radius-md);
  font-weight: 500;
  cursor: pointer;
  transition: var(--transition-base);
}

.action-btn:hover {
  border-color: var(--primary-color);
  color: var(--primary-color);
}

.gallery-thumbnails {
  display: flex;
  gap: var(--space-md);
}

.thumbnail {
  flex: 1;
  border: 2px solid var(--gray-200);
  border-radius: var(--radius-md);
  overflow: hidden;
  cursor: pointer;
  transition: var(--transition-fast);
}

.thumbnail.active {
  border-color: var(--primary-color);
}

.thumbnail img {
  width: 100%;
  height: 80px;
  object-fit: cover;
  display: block;
}

/* Product Info */
.product-info {
  padding: var(--space-lg);
}

.product-header {
  margin-bottom: var(--space-xl);
}

.product-category {
  display: inline-block;
  background: var(--primary-light);
  color: var(--primary-dark);
  padding: var(--space-xs) var(--space-sm);
  border-radius: var(--radius-full);
  font-size: var(--font-size-xs);
  font-weight: 600;
  text-transform: uppercase;
  margin-bottom: var(--space-sm);
}

.product-title {
  font-size: var(--font-size-3xl);
  font-weight: 700;
  color: var(--gray-900);
  margin-bottom: var(--space-md);
  line-height: 1.2;
}

.product-rating {
  display: flex;
  align-items: center;
  gap: var(--space-sm);
  flex-wrap: wrap;
}

.stars {
  display: flex;
  gap: 2px;
}

.star {
  color: var(--accent-color);
  font-size: var(--font-size-lg);
}

.rating-value {
  font-weight: 600;
  color: var(--gray-900);
}

.rating-count {
  color: var(--gray-600);
}

.see-reviews {
  color: var(--primary-color);
  text-decoration: none;
  font-weight: 500;
}

/* Pricing */
.product-pricing {
  margin-bottom: var(--space-xl);
  padding: var(--space-lg);
  background: var(--gray-100);
  border-radius: var(--radius-lg);
}

.price-container {
  display: flex;
  align-items: center;
  gap: var(--space-md);
  margin-bottom: var(--space-sm);
}

.current-price {
  font-size: var(--font-size-3xl);
  font-weight: 700;
  color: var(--primary-color);
}

.original-price {
  font-size: var(--font-size-xl);
  color: var(--gray-500);
  text-decoration: line-through;
}

.discount-percent {
  background: var(--danger-color);
  color: var(--white);
  padding: var(--space-xs) var(--space-sm);
  border-radius: var(--radius-full);
  font-size: var(--font-size-sm);
  font-weight: 600;
}

.price-note {
  color: var(--gray-600);
  font-size: var(--font-size-sm);
}

/* Product Description */
.product-description {
  margin-bottom: var(--space-xl);
}

.product-description p {
  color: var(--gray-700);
  line-height: 1.6;
  margin-bottom: var(--space-lg);
}

.highlight-features {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: var(--space-md);
}

.feature {
  display: flex;
  align-items: center;
  gap: var(--space-sm);
  color: var(--gray-700);
}

.feature svg {
  color: var(--secondary-color);
}

/* Product Options */
.product-options {
  margin-bottom: var(--space-xl);
}

.option-group {
  margin-bottom: var(--space-lg);
}

.option-label {
  display: block;
  font-weight: 600;
  color: var(--gray-900);
  margin-bottom: var(--space-sm);
}

.size-options {
  display: flex;
  gap: var(--space-md);
}

.size-option {
  padding: var(--space-md) var(--space-lg);
  border: 2px solid var(--gray-200);
  border-radius: var(--radius-md);
  background: var(--white);
  cursor: pointer;
  transition: var(--transition-fast);
  font-weight: 500;
}

.size-option.active {
  border-color: var(--primary-color);
  background: var(--primary-color);
  color: var(--white);
}

.quantity-selector {
  display: flex;
  align-items: center;
  gap: var(--space-sm);
  max-width: 150px;
}

.quantity-btn {
  width: 40px;
  height: 40px;
  border: 2px solid var(--gray-200);
  background: var(--white);
  border-radius: var(--radius-md);
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 600;
  transition: var(--transition-fast);
}

.quantity-btn:hover {
  border-color: var(--primary-color);
  color: var(--primary-color);
}

.quantity-input {
  width: 60px;
  height: 40px;
  border: 2px solid var(--gray-200);
  border-radius: var(--radius-md);
  text-align: center;
  font-weight: 600;
}

/* Add to Cart Section */
.add-to-cart-section {
  background: var(--white);
  padding: var(--space-xl);
  border-radius: var(--radius-lg);
  box-shadow: var(--shadow-md);
  margin-bottom: var(--space-xl);
}

.stock-info {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: var(--space-lg);
}

.stock-status {
  padding: var(--space-xs) var(--space-sm);
  border-radius: var(--radius-full);
  font-size: var(--font-size-sm);
  font-weight: 600;
}

.stock-status.in-stock {
  background: var(--secondary-color);
  color: var(--white);
}

.delivery-info {
  color: var(--gray-600);
  font-size: var(--font-size-sm);
}

.cart-actions {
  display: flex;
  gap: var(--space-md);
}

.primary-btn, .secondary-btn {
  flex: 1;
  padding: var(--space-lg) var(--space-xl);
  border: none;
  border-radius: var(--radius-lg);
  font-weight: 600;
  font-size: var(--font-size-lg);
  cursor: pointer;
  transition: var(--transition-base);
  display: flex;
  align-items: center;
  justify-content: center;
  gap: var(--space-sm);
}

.primary-btn {
  background: var(--accent-color);
  color: var(--white);
}

.primary-btn:hover {
  background: #D89533;
  transform: translateY(-2px);
  box-shadow: var(--shadow-lg);
}

.secondary-btn {
  background: var(--primary-color);
  color: var(--white);
}

.secondary-btn:hover {
  background: var(--primary-dark);
  transform: translateY(-2px);
  box-shadow: var(--shadow-lg);
}

/* Product Meta */
.product-meta {
  display: flex;
  flex-direction: column;
  gap: var(--space-sm);
  padding-top: var(--space-lg);
  border-top: 1px solid var(--gray-200);
}

.meta-item {
  display: flex;
  gap: var(--space-sm);
}

.meta-label {
  font-weight: 600;
  color: var(--gray-700);
  min-width: 80px;
}

.meta-value {
  color: var(--gray-600);
}

/* Product Tabs */
.product-tabs-container {
  margin-bottom: var(--space-3xl);
}

.tabs-navigation {
  display: flex;
  border-bottom: 2px solid var(--gray-200);
  margin-bottom: var(--space-xl);
}

.tab-btn {
  padding: var(--space-lg) var(--space-xl);
  background: none;
  border: none;
  font-weight: 600;
  color: var(--gray-600);
  cursor: pointer;
  transition: var(--transition-fast);
  border-bottom: 3px solid transparent;
  margin-bottom: -2px;
}

.tab-btn.active {
  color: var(--primary-color);
  border-bottom-color: var(--primary-color);
}

.tab-panel {
  display: none;
}

.tab-panel.active {
  display: block;
}

.tab-content {
  padding: var(--space-xl);
  background: var(--white);
  border-radius: var(--radius-lg);
  box-shadow: var(--shadow-sm);
}

.tab-content h3 {
  margin-bottom: var(--space-lg);
  color: var(--gray-900);
}

.description-features {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: var(--space-2xl);
  margin-top: var(--space-lg);
}

.feature-column h4 {
  margin-bottom: var(--space-md);
  color: var(--gray-800);
}

.feature-column ul {
  list-style: none;
  padding: 0;
}

.feature-column li {
  padding: var(--space-xs) 0;
  color: var(--gray-700);
  position: relative;
  padding-left: var(--space-lg);
}

.feature-column li:before {
  content: "•";
  color: var(--primary-color);
  position: absolute;
  left: 0;
}

/* Nutrition Table */
.nutrition-table {
  max-width: 400px;
  border: 1px solid var(--gray-200);
  border-radius: var(--radius-md);
  overflow: hidden;
}

.nutrition-header {
  padding: var(--space-md);
  background: var(--primary-color);
  color: var(--white);
  font-weight: 600;
  text-align: center;
}

.nutrition-row {
  display: flex;
  justify-content: space-between;
  padding: var(--space-md);
  border-bottom: 1px solid var(--gray-200);
}

.nutrition-row:last-child {
  border-bottom: none;
}

.nutrition-row.sub-row {
  padding-left: var(--space-2xl);
  font-size: var(--font-size-sm);
  color: var(--gray-600);
}

.nutrient {
  font-weight: 500;
}

.value {
  font-weight: 600;
}

/* Reviews */
.reviews-summary {
  display: grid;
  grid-template-columns: auto 1fr;
  gap: var(--space-2xl);
  margin-bottom: var(--space-2xl);
  padding: var(--space-xl);
  background: var(--gray-100);
  border-radius: var(--radius-lg);
}

.overall-rating {
  text-align: center;
}

.rating-score {
  font-size: var(--font-size-3xl);
  font-weight: 700;
  color: var(--gray-900);
  margin-bottom: var(--space-sm);
}

.rating-count {
  color: var(--gray-600);
  font-size: var(--font-size-sm);
}

.rating-bars {
  display: flex;
  flex-direction: column;
  gap: var(--space-sm);
}

.rating-bar {
  display: flex;
  align-items: center;
  gap: var(--space-md);
}

.star-label {
  min-width: 60px;
  font-size: var(--font-size-sm);
}

.bar-container {
  flex: 1;
  height: 8px;
  background: var(--gray-200);
  border-radius: var(--radius-full);
  overflow: hidden;
}

.bar-fill {
  height: 100%;
  background: var(--accent-color);
  border-radius: var(--radius-full);
}

.percentage {
  min-width: 40px;
  text-align: right;
  font-size: var(--font-size-sm);
  font-weight: 600;
}

.review-item {
  padding: var(--space-xl);
  border: 1px solid var(--gray-200);
  border-radius: var(--radius-lg);
  margin-bottom: var(--space-lg);
}

.review-header {
  display: flex;
  justify-content: space-between;
  align-items: start;
  margin-bottom: var(--space-md);
}

.reviewer-info {
  display: flex;
  flex-direction: column;
  gap: var(--space-xs);
}

.reviewer-name {
  font-weight: 600;
  color: var(--gray-900);
}

.review-date {
  color: var(--gray-500);
  font-size: var(--font-size-sm);
}

.review-content p {
  color: var(--gray-700);
  line-height: 1.6;
}

/* Related Products */
.related-products-container {
  margin-bottom: var(--space-3xl);
}

.section-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: var(--space-xl);
}

.section-header h2 {
  font-size: var(--font-size-2xl);
  font-weight: 700;
  color: var(--gray-900);
}

.view-all {
  color: var(--primary-color);
  text-decoration: none;
  font-weight: 600;
}

.related-products-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: var(--space-xl);
}

/* Responsive Design */
@media (max-width: 1024px) {
  .product-details-container {
    gap: var(--space-xl);
  }
  
  .highlight-features {
    grid-template-columns: 1fr;
  }
  
  .description-features {
    grid-template-columns: 1fr;
    gap: var(--space-xl);
  }
}

@media (max-width: 768px) {
  .product-details-container {
    grid-template-columns: 1fr;
    gap: var(--space-2xl);
  }
  
  .gallery-thumbnails {
    flex-wrap: wrap;
  }
  
  .thumbnail {
    flex: 0 0 calc(25% - var(--space-md));
  }
  
  .cart-actions {
    flex-direction: column;
  }
  
  .tabs-navigation {
    flex-wrap: wrap;
  }
  
  .tab-btn {
    flex: 1;
    min-width: 120px;
  }
  
  .reviews-summary {
    grid-template-columns: 1fr;
    gap: var(--space-xl);
  }
}

@media (max-width: 480px) {
  .product-title {
    font-size: var(--font-size-2xl);
  }
  
  .price-container {
    flex-direction: column;
    align-items: start;
    gap: var(--space-sm);
  }
  
  .size-options {
    flex-wrap: wrap;
  }
  
  .gallery-actions {
    flex-direction: column;
  }
}
</style>

<script>
// Product Details JavaScript
document.addEventListener('DOMContentLoaded', function() {
  // Image Gallery
  const thumbnails = document.querySelectorAll('.thumbnail');
  const mainImage = document.getElementById('main-product-image');
  
  thumbnails.forEach(thumb => {
    thumb.addEventListener('click', function() {
      // Remove active class from all thumbnails
      thumbnails.forEach(t => t.classList.remove('active'));
      // Add active class to clicked thumbnail
      this.classList.add('active');
      // Update main image
      const newImageSrc = this.getAttribute('data-image');
      mainImage.src = newImageSrc;
    });
  });

  // Size Selection
  const sizeOptions = document.querySelectorAll('.size-option');
  const currentPrice = document.querySelector('.current-price');
  
  sizeOptions.forEach(option => {
    option.addEventListener('click', function() {
      // Remove active class from all options
      sizeOptions.forEach(opt => opt.classList.remove('active'));
      // Add active class to clicked option
      this.classList.add('active');
      // Update price
      const newPrice = this.getAttribute('data-price');
      currentPrice.textContent = `$${newPrice}`;
    });
  });

  // Quantity Selector
  const minusBtn = document.querySelector('.minus-btn');
  const plusBtn = document.querySelector('.plus-btn');
  const quantityInput = document.querySelector('.quantity-input');
  
  minusBtn.addEventListener('click', function() {
    let currentValue = parseInt(quantityInput.value);
    if (currentValue > 1) {
      quantityInput.value = currentValue - 1;
    }
  });
  
  plusBtn.addEventListener('click', function() {
    let currentValue = parseInt(quantityInput.value);
    if (currentValue < 10) {
      quantityInput.value = currentValue + 1;
    }
  });

  // Tab Navigation
  const tabBtns = document.querySelectorAll('.tab-btn');
  const tabPanels = document.querySelectorAll('.tab-panel');
  
  tabBtns.forEach(btn => {
    btn.addEventListener('click', function() {
      const targetTab = this.getAttribute('data-tab');
      
      // Remove active class from all buttons and panels
      tabBtns.forEach(b => b.classList.remove('active'));
      tabPanels.forEach(p => p.classList.remove('active'));
      
      // Add active class to clicked button and corresponding panel
      this.classList.add('active');
      document.getElementById(targetTab).classList.add('active');
    });
  });

  // Add to Cart Functionality
  const addToCartBtn = document.querySelector('.add-to-cart-btn');
  const buyNowBtn = document.querySelector('.buy-now-btn');
  
  addToCartBtn.addEventListener('click', function() {
    const productData = {
      id: 1,
      name: 'California Almonds',
      price: parseFloat(currentPrice.textContent.replace('$', '')),
      quantity: parseInt(quantityInput.value),
      size: document.querySelector('.size-option.active').getAttribute('data-size'),
      image: mainImage.src
    };
    
    // Add to cart logic
    addToCart(productData);
    
    // Show success message
    showMessage('Product added to cart!', 'success');
  });
  
  buyNowBtn.addEventListener('click', function() {
    const productData = {
      id: 1,
      name: 'California Almonds',
      price: parseFloat(currentPrice.textContent.replace('$', '')),
      quantity: parseInt(quantityInput.value),
      size: document.querySelector('.size-option.active').getAttribute('data-size'),
      image: mainImage.src
    };
    
    // Add to cart and redirect to checkout
    addToCart(productData);
    window.location.href = 'checkout.php';
  });

  // Wishlist Functionality
  const wishlistBtn = document.querySelector('.wishlist-btn');
  wishlistBtn.addEventListener('click', function() {
    const productId = this.getAttribute('data-product-id');
    toggleWishlist(productId);
  });

  // Share Functionality
  const shareBtn = document.querySelector('.share-btn');
  shareBtn.addEventListener('click', function() {
    if (navigator.share) {
      navigator.share({
        title: 'California Almonds - MUNCHICO',
        text: 'Check out these amazing California Almonds from MUNCHICO!',
        url: window.location.href,
      });
    } else {
      // Fallback for browsers that don't support Web Share API
      navigator.clipboard.writeText(window.location.href);
      showMessage('Link copied to clipboard!', 'success');
    }
  });

  // Helper Functions
  function addToCart(product) {
    // Get existing cart from localStorage or initialize empty array
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    
    // Check if product already exists in cart
    const existingProductIndex = cart.findIndex(item => 
      item.id === product.id && item.size === product.size
    );
    
    if (existingProductIndex > -1) {
      // Update quantity if product exists
      cart[existingProductIndex].quantity += product.quantity;
    } else {
      // Add new product to cart
      cart.push(product);
    }
    
    // Save updated cart to localStorage
    localStorage.setItem('cart', JSON.stringify(cart));
    
    // Update cart count in navbar (if exists)
    updateCartCount();
  }
  
  function toggleWishlist(productId) {
    let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
    const productIndex = wishlist.findIndex(id => id === productId);
    
    if (productIndex > -1) {
      // Remove from wishlist
      wishlist.splice(productIndex, 1);
      wishlistBtn.innerHTML = `
        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
          <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
        </svg>
        Add to Wishlist
      `;
      showMessage('Removed from wishlist', 'info');
    } else {
      // Add to wishlist
      wishlist.push(productId);
      wishlistBtn.innerHTML = `
        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
          <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" fill="red"/>
        </svg>
        Added to Wishlist
      `;
      showMessage('Added to wishlist!', 'success');
    }
    
    localStorage.setItem('wishlist', JSON.stringify(wishlist));
  }
  
  function updateCartCount() {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    
    // Update cart count in navbar (if exists)
    const cartCountElements = document.querySelectorAll('.cart-count');
    cartCountElements.forEach(element => {
      element.textContent = totalItems;
    });
  }
  
  function showMessage(message, type) {
    // Create toast message
    const toast = document.createElement('div');
    toast.className = `toast-message toast-${type}`;
    toast.textContent = message;
    
    // Style the toast
    toast.style.cssText = `
      position: fixed;
      top: 20px;
      right: 20px;
      padding: 12px 20px;
      background: ${type === 'success' ? '#4CAF50' : '#2196F3'};
      color: white;
      border-radius: 4px;
      z-index: 10000;
      box-shadow: 0 2px 10px rgba(0,0,0,0.2);
    `;
    
    document.body.appendChild(toast);
    
    // Remove toast after 3 seconds
    setTimeout(() => {
      toast.remove();
    }, 3000);
  }

  // Initialize wishlist button state
  const wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
  const productId = wishlistBtn.getAttribute('data-product-id');
  if (wishlist.includes(productId)) {
    wishlistBtn.innerHTML = `
      <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" fill="red"/>
      </svg>
      Added to Wishlist
    `;
  }
});
</script>

  <!-- ========================================================= -->
  <!-- 📱 MOBILE DOCKER -->
  <!-- Mobile navigation bottom dock for quick access -->
  <!-- ========================================================= -->
  <?php include 'includes/mobile-docker.php' ?>

  <!-- ========================================================= -->
  <!-- 🦶 FOOTER SECTION -->
  <!-- Contains contact info, social links, and legal pages -->
  <!-- ========================================================= -->
  <?php include 'includes/footer.php' ?>
  <?php include 'includes/components/top-to-bottom/index.php' ?>
  <!-- ========================================================= -->
  <!-- ⚡ JAVASCRIPT FILES -->
  <!-- Handles dynamic behavior, initialization, and components -->
  <!-- ========================================================= -->
  <script src="assets/js/royal-css-initialization.js"></script>
  <script src="assets/js/main.js"></script>
  <script src="assets/royalcssx/royal.js"></script>
</body>



</html>