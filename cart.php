<?php
// Start session and get cart data
session_start();
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$total = 0;
$itemCount = 0;

foreach ($cart as $item) {
    $total += $item['price'] * $item['quantity'];
    $itemCount += $item['quantity'];
}
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
  <!-- ========================================================= -->
  <title>Shopping Cart - MUNCHICO | Premium Dried Fruits & Nuts</title>
  <meta name="description" content="Review your shopping cart at MUNCHICO. Premium dried fruits and nuts with secure checkout." />

  <!-- ========================================================= -->
  <!-- 🌐 OPEN GRAPH META -->
  <!-- ========================================================= -->
  <meta property="og:title" content="Shopping Cart - MUNCHICO" />
  <meta property="og:description" content="Review your shopping cart with premium dried fruits and nuts" />
  <meta property="og:type" content="website" />
  <meta property="og:url" content="https://www.munchico.com/cart" />

  <!-- ========================================================= -->
  <!-- 🔖 FAVICONS -->
  <!-- ========================================================= -->
  <link rel="icon" type="image/x-icon" href="assets/images/favicon.ico" />

  <!-- ========================================================= -->
  <!-- ⚡ PERFORMANCE OPTIMIZATION -->
  <!-- ========================================================= -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Roboto:wght@400;500&display=swap" rel="stylesheet" />

  <!-- ========================================================= -->
  <!-- 🎨 STYLESHEETS -->
  <!-- ========================================================= -->
  <link rel="stylesheet" href="assets/css/main.css" />
  <link rel="stylesheet" href="assets/css/extra.css" />
  <link rel="stylesheet" href="assets/royalcssx/royal.css" />

  <style>
    /* Cart Specific Styles */
    .cart-section {
      padding: var(--space-xl) 0;
      background: var(--gray-50);
      min-height: 70vh;
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

    .cart-header {
      text-align: center;
      margin-bottom: var(--space-2xl);
    }

    .cart-header h1 {
      font-size: var(--font-size-3xl);
      font-weight: 700;
      color: var(--gray-900);
      margin-bottom: var(--space-sm);
    }

    .cart-header p {
      color: var(--gray-600);
      font-size: var(--font-size-lg);
    }

    .cart-container {
      display: grid;
      grid-template-columns: 1fr 400px;
      gap: var(--space-2xl);
      max-width: 1200px;
      margin: 0 auto;
    }

    /* Cart Items */
    .cart-items-section {
      background: var(--white);
      padding: var(--space-2xl);
      border-radius: var(--radius-lg);
      box-shadow: var(--shadow-md);
    }

    .cart-items-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: var(--space-xl);
      padding-bottom: var(--space-md);
      border-bottom: 2px solid var(--gray-200);
    }

    .cart-items-title {
      font-size: var(--font-size-xl);
      font-weight: 600;
      color: var(--gray-900);
    }

    .item-count {
      color: var(--gray-600);
      font-size: var(--font-size-sm);
    }

    .cart-items {
      margin-bottom: var(--space-xl);
    }

    .cart-item {
      display: grid;
      grid-template-columns: 100px 1fr auto auto;
      gap: var(--space-lg);
      padding: var(--space-lg) 0;
      border-bottom: 1px solid var(--gray-200);
      align-items: center;
    }

    .cart-item:last-child {
      border-bottom: none;
    }

    .item-image {
      width: 100px;
      height: 100px;
      border-radius: var(--radius-md);
      object-fit: cover;
    }

    .item-details {
      display: flex;
      flex-direction: column;
      gap: var(--space-sm);
    }

    .item-name {
      font-size: var(--font-size-lg);
      font-weight: 600;
      color: var(--gray-900);
      margin-bottom: var(--space-xs);
    }

    .item-category {
      font-size: var(--font-size-sm);
      color: var(--gray-500);
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .item-meta {
      display: flex;
      gap: var(--space-md);
      font-size: var(--font-size-sm);
      color: var(--gray-600);
    }

    .item-size {
      background: var(--gray-100);
      padding: var(--space-xs) var(--space-sm);
      border-radius: var(--radius-sm);
    }

    .item-actions {
      display: flex;
      gap: var(--space-md);
      margin-top: var(--space-sm);
    }

    .action-btn {
      background: none;
      border: none;
      color: var(--gray-500);
      cursor: pointer;
      padding: var(--space-xs);
      border-radius: var(--radius-sm);
      transition: var(--transition-fast);
      display: flex;
      align-items: center;
      gap: var(--space-xs);
      font-size: var(--font-size-sm);
    }

    .action-btn:hover {
      color: var(--primary-color);
      background: var(--gray-100);
    }

    .action-btn.remove:hover {
      color: var(--danger-color);
    }

    /* Quantity Selector */
    .quantity-selector {
      display: flex;
      align-items: center;
      gap: var(--space-sm);
      background: var(--gray-100);
      border-radius: var(--radius-md);
      padding: var(--space-xs);
      width: fit-content;
    }

    .quantity-btn {
      width: 32px;
      height: 32px;
      border: none;
      background: var(--white);
      border-radius: var(--radius-sm);
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 600;
      transition: var(--transition-fast);
      color: var(--gray-700);
    }

    .quantity-btn:hover {
      background: var(--primary-color);
      color: var(--white);
    }

    .quantity-btn:disabled {
      opacity: 0.5;
      cursor: not-allowed;
    }

    .quantity-btn:disabled:hover {
      background: var(--white);
      color: var(--gray-700);
    }

    .quantity-input {
      width: 50px;
      text-align: center;
      border: none;
      background: transparent;
      font-weight: 600;
      font-size: var(--font-size-base);
      color: var(--gray-900);
    }

    .quantity-input:focus {
      outline: none;
    }

    /* Item Price */
    .item-price {
      text-align: right;
    }

    .current-price {
      font-size: var(--font-size-lg);
      font-weight: 700;
      color: var(--primary-color);
      margin-bottom: var(--space-xs);
    }

    .original-price {
      font-size: var(--font-size-sm);
      color: var(--gray-500);
      text-decoration: line-through;
    }

    .item-total {
      font-size: var(--font-size-lg);
      font-weight: 700;
      color: var(--gray-900);
      text-align: right;
    }

    /* Empty Cart */
    .empty-cart {
      text-align: center;
      padding: var(--space-3xl);
    }

    .empty-cart-icon {
      font-size: 4rem;
      color: var(--gray-300);
      margin-bottom: var(--space-lg);
    }

    .empty-cart h3 {
      font-size: var(--font-size-xl);
      color: var(--gray-700);
      margin-bottom: var(--space-sm);
    }

    .empty-cart p {
      color: var(--gray-600);
      margin-bottom: var(--space-xl);
    }

    .shopping-btn {
      display: inline-flex;
      align-items: center;
      gap: var(--space-sm);
      padding: var(--space-lg) var(--space-xl);
      background: var(--primary-color);
      color: var(--white);
      text-decoration: none;
      border-radius: var(--radius-lg);
      font-weight: 600;
      transition: var(--transition-base);
    }

    .shopping-btn:hover {
      background: var(--primary-dark);
      transform: translateY(-2px);
      box-shadow: var(--shadow-lg);
    }

    /* Cart Summary */
    .cart-summary {
      background: var(--white);
      padding: var(--space-2xl);
      border-radius: var(--radius-lg);
      box-shadow: var(--shadow-md);
      height: fit-content;
      position: sticky;
      top: var(--space-lg);
    }

    .summary-header {
      font-size: var(--font-size-xl);
      font-weight: 600;
      color: var(--gray-900);
      margin-bottom: var(--space-lg);
      padding-bottom: var(--space-md);
      border-bottom: 2px solid var(--gray-200);
    }

    .summary-details {
      margin-bottom: var(--space-xl);
    }

    .summary-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: var(--space-md);
      padding: var(--space-sm) 0;
    }

    .summary-label {
      color: var(--gray-600);
    }

    .summary-value {
      font-weight: 500;
      color: var(--gray-900);
    }

    .summary-row.total {
      border-top: 2px solid var(--gray-200);
      padding-top: var(--space-lg);
      margin-top: var(--space-lg);
      font-size: var(--font-size-lg);
      font-weight: 700;
    }

    .summary-row.total .summary-value {
      color: var(--primary-color);
      font-size: var(--font-size-xl);
    }

    .shipping-notice {
      background: var(--secondary-color);
      color: var(--white);
      padding: var(--space-md);
      border-radius: var(--radius-md);
      text-align: center;
      margin-bottom: var(--space-lg);
      font-size: var(--font-size-sm);
    }

    .checkout-btn {
      width: 100%;
      padding: var(--space-lg);
      background: var(--accent-color);
      color: var(--white);
      border: none;
      border-radius: var(--radius-lg);
      font-size: var(--font-size-lg);
      font-weight: 600;
      cursor: pointer;
      transition: var(--transition-base);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: var(--space-sm);
      margin-bottom: var(--space-lg);
    }

    .checkout-btn:hover {
      background: #D89533;
      transform: translateY(-2px);
      box-shadow: var(--shadow-lg);
    }

    .checkout-btn:disabled {
      background: var(--gray-400);
      cursor: not-allowed;
      transform: none;
      box-shadow: none;
    }

    .continue-shopping {
      text-align: center;
    }

    .continue-link {
      color: var(--primary-color);
      text-decoration: none;
      font-weight: 500;
      display: inline-flex;
      align-items: center;
      gap: var(--space-sm);
      transition: var(--transition-fast);
    }

    .continue-link:hover {
      color: var(--primary-dark);
    }

    /* Promo Code */
    .promo-code {
      margin: var(--space-xl) 0;
      padding: var(--space-lg);
      background: var(--gray-100);
      border-radius: var(--radius-lg);
    }

    .promo-title {
      font-weight: 600;
      color: var(--gray-900);
      margin-bottom: var(--space-md);
    }

    .promo-form {
      display: flex;
      gap: var(--space-sm);
    }

    .promo-input {
      flex: 1;
      padding: var(--space-md);
      border: 2px solid var(--gray-200);
      border-radius: var(--radius-md);
      font-size: var(--font-size-base);
    }

    .promo-input:focus {
      outline: none;
      border-color: var(--primary-color);
    }

    .apply-btn {
      padding: var(--space-md) var(--space-lg);
      background: var(--primary-color);
      color: var(--white);
      border: none;
      border-radius: var(--radius-md);
      font-weight: 600;
      cursor: pointer;
      transition: var(--transition-fast);
    }

    .apply-btn:hover {
      background: var(--primary-dark);
    }

    /* Recommended Products */
    .recommended-products {
      margin-top: var(--space-3xl);
      padding-top: var(--space-2xl);
      border-top: 2px solid var(--gray-200);
    }

    .recommended-header {
      font-size: var(--font-size-xl);
      font-weight: 600;
      color: var(--gray-900);
      margin-bottom: var(--space-xl);
      text-align: center;
    }

    .recommended-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: var(--space-lg);
    }

    /* Mobile Actions */
    .mobile-cart-actions {
      display: none;
      position: fixed;
      bottom: 0;
      left: 0;
      right: 0;
      background: var(--white);
      padding: var(--space-md);
      box-shadow: var(--shadow-lg);
      z-index: 100;
    }

    .mobile-total {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: var(--space-md);
    }

    .mobile-total-label {
      font-weight: 500;
      color: var(--gray-700);
    }

    .mobile-total-value {
      font-weight: 700;
      color: var(--primary-color);
      font-size: var(--font-size-lg);
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
      .cart-container {
        grid-template-columns: 1fr;
        gap: var(--space-xl);
      }

      .cart-summary {
        position: static;
      }
    }

    @media (max-width: 768px) {
      .cart-items-section {
        padding: var(--space-xl);
      }

      .cart-item {
        grid-template-columns: 80px 1fr;
        gap: var(--space-md);
        position: relative;
        padding: var(--space-lg) 0;
      }

      .item-quantity {
        grid-column: 1;
        grid-row: 2;
        margin-top: var(--space-md);
      }

      .item-price {
        grid-column: 2;
        grid-row: 1;
        text-align: right;
      }

      .item-total {
        grid-column: 2;
        grid-row: 2;
        text-align: right;
        margin-top: var(--space-md);
      }

      .item-actions {
        position: absolute;
        top: var(--space-lg);
        right: 0;
      }

      .cart-header h1 {
        font-size: var(--font-size-2xl);
      }

      .mobile-cart-actions {
        display: block;
      }

      .desktop-checkout {
        display: none;
      }
    }

    @media (max-width: 480px) {
      .cart-items-section {
        padding: var(--space-lg);
      }

      .cart-summary {
        padding: var(--space-lg);
      }

      .cart-item {
        grid-template-columns: 60px 1fr;
        gap: var(--space-sm);
      }

      .item-image {
        width: 60px;
        height: 60px;
      }

      .item-name {
        font-size: var(--font-size-base);
      }

      .promo-form {
        flex-direction: column;
      }
    }

    /* Animation */
    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .cart-item {
      animation: slideIn 0.3s ease-out;
    }

    /* Loading States */
    .loading {
      opacity: 0.6;
      pointer-events: none;
    }

    .updating::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(255, 255, 255, 0.8);
      display: flex;
      align-items: center;
      justify-content: center;
    }
  </style>
</head>

<body>
  <!-- ========================================================= -->
  <!-- 🌀 PRELOADER SECTION -->
  <!-- ========================================================= -->
  <?php include 'includes/components/preloader/index.php' ?>

  <!-- ========================================================= -->
  <!-- 🚀 NAVIGATION BAR -->
  <!-- ========================================================= -->
  <?php include 'includes/navbar.php' ?>

  <!-- ========================================================= -->
  <!-- 📢 ANNOUNCEMENT BAR -->
  <!-- ========================================================= -->
  <?php include 'includes/components/announcements/index.php' ?>

  <!-- ========================================================= -->
  <!-- 🛒 SHOPPING CART SECTION -->
  <!-- ========================================================= -->
  <section class="cart-section">
    <!-- Breadcrumb -->
    <div class="breadcrumb-container">
      <div class="container">
        <nav class="breadcrumb">
          <a href="index.php">Home</a>
          <span class="separator">/</span>
          <span class="current">Shopping Cart</span>
        </nav>
      </div>
    </div>

    <div class="container">
      <div class="cart-header">
        <h1>Shopping Cart</h1>
        <p>Review your items and proceed to checkout</p>
      </div>

      <div class="cart-container">
        <!-- Cart Items -->
        <div class="cart-items-section">
          <div class="cart-items-header">
            <h2 class="cart-items-title">Your Items</h2>
            <span class="item-count"><?php echo $itemCount; ?> item(s)</span>
          </div>

          <div class="cart-items" id="cart-items">
            <?php if (empty($cart)): ?>
              <!-- Empty Cart State -->
              <div class="empty-cart">
                <div class="empty-cart-icon">🛒</div>
                <h3>Your cart is empty</h3>
                <p>Add some delicious dried fruits and nuts to get started!</p>
                <a href="products.php" class="shopping-btn">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M11 9h2V6h3V4h-3V1h-2v3H8v2h3v3zm-4 9c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2zm-9.83-3.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.86-7.01L19.42 4h-.01l-1.1 2-2.76 5H8.53l-.13-.27L6.16 6l-.95-2-.94-2H1v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.13 0-.25-.11-.25-.25z"/>
                  </svg>
                  Start Shopping
                </a>
              </div>
            <?php else: ?>
              <!-- Cart Items List -->
              <?php foreach ($cart as $index => $item): ?>
                <div class="cart-item" data-item-id="<?php echo $index; ?>">
                  <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" class="item-image">
                  
                  <div class="item-details">
                    <h3 class="item-name"><?php echo $item['name']; ?></h3>
                    <span class="item-category"><?php echo $item['category']; ?></span>
                    <div class="item-meta">
                      <span class="item-size">Size: <?php echo $item['size']; ?></span>
                    </div>
                    <div class="item-actions">
                      <button class="action-btn remove" onclick="removeItem(<?php echo $index; ?>)">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                          <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                        </svg>
                        Remove
                      </button>
                      <button class="action-btn wishlist" onclick="moveToWishlist(<?php echo $index; ?>)">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                          <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                        Save for Later
                      </button>
                    </div>
                  </div>

                  <div class="item-quantity">
                    <div class="quantity-selector">
                      <button class="quantity-btn minus" onclick="updateQuantity(<?php echo $index; ?>, -1)">-</button>
                      <input type="number" class="quantity-input" value="<?php echo $item['quantity']; ?>" min="1" max="10" 
                             onchange="updateQuantity(<?php echo $index; ?>, 0, this.value)">
                      <button class="quantity-btn plus" onclick="updateQuantity(<?php echo $index; ?>, 1)">+</button>
                    </div>
                  </div>

                  <div class="item-price">
                    <div class="current-price">Rs. <?php echo number_format($item['price'], 2); ?></div>
                    <?php if (isset($item['originalPrice']) && $item['originalPrice'] > $item['price']): ?>
                      <div class="original-price">Rs. <?php echo number_format($item['originalPrice'], 2); ?></div>
                    <?php endif; ?>
                  </div>

                  <div class="item-total">
                    Rs. <?php echo number_format($item['price'] * $item['quantity'], 2); ?>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>

          <?php if (!empty($cart)): ?>
            <!-- Promo Code Section -->
            <div class="promo-code">
              <h4 class="promo-title">Have a promo code?</h4>
              <div class="promo-form">
                <input type="text" class="promo-input" placeholder="Enter promo code" id="promo-code">
                <button type="button" class="apply-btn" onclick="applyPromoCode()">Apply</button>
              </div>
              <div id="promo-message" style="margin-top: var(--space-sm);"></div>
            </div>
          <?php endif; ?>
        </div>

        <!-- Cart Summary -->
        <?php if (!empty($cart)): ?>
          <div class="cart-summary">
            <h3 class="summary-header">Order Summary</h3>
            
            <div class="summary-details">
              <div class="summary-row">
                <span class="summary-label">Subtotal (<?php echo $itemCount; ?> items)</span>
                <span class="summary-value" id="subtotal">Rs. <?php echo number_format($total, 2); ?></span>
              </div>
              <div class="summary-row">
                <span class="summary-label">Shipping</span>
                <span class="summary-value">Free</span>
              </div>
              <div class="summary-row">
                <span class="summary-label">Tax</span>
                <span class="summary-value" id="tax">Rs. <?php echo number_format($total * 0.05, 2); ?></span>
              </div>
              <div class="summary-row total">
                <span class="summary-label">Total</span>
                <span class="summary-value" id="grand-total">Rs. <?php echo number_format($total * 1.05, 2); ?></span>
              </div>
            </div>

            <div class="shipping-notice">
              🚚 Free shipping across Pakistan
            </div>

            <div class="desktop-checkout">
              <button class="checkout-btn" onclick="proceedToCheckout()">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M19 4h-1V3c0-.55-.45-1-1-1s-1 .45-1 1v1H8V3c0-.55-.45-1-1-1s-1 .45-1 1v1H5c-1.11 0-1.99.9-1.99 2L3 20a2 2 0 002 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10zm-8-2l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/>
                </svg>
                Proceed to Checkout
              </button>
            </div>

            <div class="continue-shopping">
              <a href="products.php" class="continue-link">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
                </svg>
                Continue Shopping
              </a>
            </div>
          </div>
        <?php endif; ?>
      </div>

      <!-- Recommended Products -->
      <?php if (!empty($cart)): ?>
        <div class="recommended-products">
          <h3 class="recommended-header">You Might Also Like</h3>
          <div class="recommended-grid" id="recommended-products">
            <!-- Recommended products will be loaded via JavaScript -->
          </div>
        </div>
      <?php endif; ?>
    </div>

    <!-- Mobile Cart Actions -->
    <?php if (!empty($cart)): ?>
      <div class="mobile-cart-actions">
        <div class="mobile-total">
          <span class="mobile-total-label">Total:</span>
          <span class="mobile-total-value" id="mobile-total">Rs. <?php echo number_format($total * 1.05, 2); ?></span>
        </div>
        <button class="checkout-btn" onclick="proceedToCheckout()">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
            <path d="M19 4h-1V3c0-.55-.45-1-1-1s-1 .45-1 1v1H8V3c0-.55-.45-1-1-1s-1 .45-1 1v1H5c-1.11 0-1.99.9-1.99 2L3 20a2 2 0 002 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10zm-8-2l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/>
          </svg>
          Checkout
        </button>
      </div>
    <?php endif; ?>
  </section>

  <!-- ========================================================= -->
  <!-- 📱 MOBILE DOCKER -->
  <!-- ========================================================= -->
  <?php include 'includes/mobile-docker.php' ?>

  <!-- ========================================================= -->
  <!-- 🦶 FOOTER SECTION -->
  <!-- ========================================================= -->
  <?php include 'includes/footer.php' ?>
  <?php include 'includes/components/top-to-bottom/index.php' ?>

  <!-- ========================================================= -->
  <!-- ⚡ JAVASCRIPT FILES -->
  <!-- ========================================================= -->
  <script src="assets/js/royal-css-initialization.js"></script>
  <script src="assets/js/main.js"></script>
  <script src="assets/royalcssx/royal.js"></script>

  <script>
    // Cart Management JavaScript
    let cart = <?php echo json_encode($cart); ?>;
    let promoDiscount = 0;

    function updateCartDisplay() {
      // Calculate totals
      let subtotal = 0;
      let itemCount = 0;
      
      cart.forEach(item => {
        subtotal += item.price * item.quantity;
        itemCount += item.quantity;
      });

      const tax = subtotal * 0.05;
      const grandTotal = subtotal + tax - promoDiscount;

      // Update display
      document.getElementById('subtotal').textContent = `Rs. ${subtotal.toFixed(2)}`;
      document.getElementById('tax').textContent = `Rs. ${tax.toFixed(2)}`;
      document.getElementById('grand-total').textContent = `Rs. ${grandTotal.toFixed(2)}`;
      document.getElementById('mobile-total').textContent = `Rs. ${grandTotal.toFixed(2)}`;
      
      // Update item count
      document.querySelector('.item-count').textContent = `${itemCount} item(s)`;
      
      // Update cart count in navbar
      updateNavbarCartCount(itemCount);
    }

    function updateQuantity(index, change, directValue = null) {
      const item = cart[index];
      
      if (directValue !== null) {
        item.quantity = parseInt(directValue);
      } else {
        item.quantity += change;
      }
      
      // Ensure quantity is within bounds
      if (item.quantity < 1) item.quantity = 1;
      if (item.quantity > 10) item.quantity = 10;
      
      // Update the input field
      const input = document.querySelector(`[data-item-id="${index}"] .quantity-input`);
      if (input) {
        input.value = item.quantity;
      }
      
      // Update the item total
      const totalElement = document.querySelector(`[data-item-id="${index}"] .item-total`);
      if (totalElement) {
        totalElement.textContent = `Rs. ${(item.price * item.quantity).toFixed(2)}`;
      }
      
      // Save cart and update display
      saveCart();
      updateCartDisplay();
    }

    function removeItem(index) {
      if (confirm('Are you sure you want to remove this item from your cart?')) {
        cart.splice(index, 1);
        
        // Remove the item from DOM
        const itemElement = document.querySelector(`[data-item-id="${index}"]`);
        if (itemElement) {
          itemElement.style.opacity = '0';
          setTimeout(() => {
            itemElement.remove();
            // Re-render if cart is empty
            if (cart.length === 0) {
              location.reload();
            }
          }, 300);
        }
        
        saveCart();
        updateCartDisplay();
      }
    }

    function moveToWishlist(index) {
      const item = cart[index];
      
      // Get existing wishlist
      let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
      
      // Check if item already in wishlist
      const existingIndex = wishlist.findIndex(wishItem => 
        wishItem.id === item.id && wishItem.size === item.size
      );
      
      if (existingIndex === -1) {
        wishlist.push(item);
        localStorage.setItem('wishlist', JSON.stringify(wishlist));
        
        // Show success message
        showMessage('Item moved to wishlist!', 'success');
        
        // Remove from cart
        removeItem(index);
      } else {
        showMessage('Item already in wishlist!', 'info');
      }
    }

    function applyPromoCode() {
      const promoCode = document.getElementById('promo-code').value.trim();
      const messageElement = document.getElementById('promo-message');
      
      // Simple promo code validation
      const validPromoCodes = {
        'WELCOME10': 0.1,  // 10% discount
        'MUNCHICO15': 0.15, // 15% discount
        'FIRSTORDER': 0.2   // 20% discount
      };
      
      if (validPromoCodes[promoCode.toUpperCase()]) {
        const discountRate = validPromoCodes[promoCode.toUpperCase()];
        const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        promoDiscount = subtotal * discountRate;
        
        messageElement.innerHTML = `
          <div style="color: var(--secondary-color); font-weight: 500;">
            ✅ Promo code applied! You saved Rs. ${promoDiscount.toFixed(2)}
          </div>
        `;
        
        updateCartDisplay();
      } else {
        messageElement.innerHTML = `
          <div style="color: var(--danger-color); font-weight: 500;">
            ❌ Invalid promo code. Please try again.
          </div>
        `;
        promoDiscount = 0;
        updateCartDisplay();
      }
    }

    function proceedToCheckout() {
      if (cart.length === 0) {
        showMessage('Your cart is empty!', 'error');
        return;
      }
      
      // Save cart to session
      saveCart();
      
      // Redirect to checkout
      window.location.href = 'checkout.php';
    }

    function saveCart() {
      // Save to localStorage
      localStorage.setItem('cart', JSON.stringify(cart));
      
      // Save to session (for PHP)
      // This would typically be done via AJAX to a PHP endpoint
      // For now, we'll rely on localStorage and page refresh
    }

    function updateNavbarCartCount(count) {
      const cartCountElements = document.querySelectorAll('.cart-count');
      cartCountElements.forEach(element => {
        element.textContent = count;
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
        background: ${type === 'success' ? '#4CAF50' : type === 'error' ? '#f44336' : '#2196F3'};
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

    // Load recommended products
    function loadRecommendedProducts() {
      const recommendedProducts = [
        {
          id: 7,
          name: "Roasted Pistachios",
          price: 28.99,
          image: "https://images.unsplash.com/photo-1602529988116-78e7d4f5c6b4?w=300&q=80",
          category: "Premium Nuts"
        },
        {
          id: 8,
          name: "Dried Apricots",
          price: 16.25,
          image: "https://images.unsplash.com/photo-1593377201810-1e862c40836a?w=300&q=80",
          category: "Dried Fruits"
        },
        {
          id: 9,
          name: "Mixed Nuts",
          price: 32.99,
          image: "https://images.unsplash.com/photo-1540910419892-4a36d2c3266c?w=300&q=80",
          category: "Premium Nuts"
        },
        {
          id: 10,
          name: "Dried Mango",
          price: 19.99,
          image: "https://images.unsplash.com/photo-1599597855854-9c5b9f2d1c5a?w=300&q=80",
          category: "Dried Fruits"
        }
      ];

      const grid = document.getElementById('recommended-products');
      if (grid) {
        grid.innerHTML = recommendedProducts.map(product => `
          <div class="product-card">
            <div class="product-image-wrapper">
              <img src="${product.image}" alt="${product.name}" class="product-image">
            </div>
            <div class="product-info">
              <div class="product-category">${product.category}</div>
              <h3 class="product-name">${product.name}</h3>
              <div class="product-price">
                <span class="current-price">Rs. ${product.price.toFixed(2)}</span>
              </div>
              <button class="add-to-cart-btn" onclick="addToCart(${product.id})">Add to Cart</button>
            </div>
          </div>
        `).join('');
      }
    }

    function addToCart(productId) {
      // This would typically fetch product details from an API
      // For now, we'll use a simplified version
      const product = {
        id: productId,
        name: "Sample Product",
        price: 19.99,
        image: "https://images.unsplash.com/photo-1599599810769-bcde5a160d32?w=300&q=80",
        category: "Premium Nuts",
        size: "500g",
        quantity: 1
      };
      
      // Add to cart array
      cart.push(product);
      saveCart();
      updateCartDisplay();
      
      showMessage('Product added to cart!', 'success');
      
      // Refresh the page to show new item
      setTimeout(() => {
        location.reload();
      }, 1000);
    }

    // Initialize when page loads
    document.addEventListener('DOMContentLoaded', function() {
      updateCartDisplay();
      loadRecommendedProducts();
      
      // Load cart from localStorage if available
      const savedCart = localStorage.getItem('cart');
      if (savedCart) {
        cart = JSON.parse(savedCart);
        updateCartDisplay();
      }
    });
  </script>
</body>
</html>