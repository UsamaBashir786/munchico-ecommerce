<?php
// Start session and get cart data
session_start();
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$total = 0;
foreach ($cart as $item) {
    $total += $item['price'] * $item['quantity'];
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
  <title>Checkout - MUNCHICO | Premium Dried Fruits & Nuts</title>
  <meta name="description" content="Complete your purchase of premium dried fruits and nuts at MUNCHICO. Secure checkout with multiple payment options." />

  <!-- ========================================================= -->
  <!-- 🌐 OPEN GRAPH META -->
  <!-- ========================================================= -->
  <meta property="og:title" content="Checkout - MUNCHICO" />
  <meta property="og:description" content="Complete your purchase of premium dried fruits and nuts" />
  <meta property="og:type" content="website" />
  <meta property="og:url" content="https://www.munchico.com/checkout" />

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
    /* Checkout Specific Styles */
    .checkout-section {
      padding: var(--space-xl) 0;
      background: var(--gray-50);
      min-height: 100vh;
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

    .checkout-header {
      text-align: center;
      margin-bottom: var(--space-2xl);
    }

    .checkout-header h1 {
      font-size: var(--font-size-3xl);
      font-weight: 700;
      color: var(--gray-900);
      margin-bottom: var(--space-sm);
    }

    .checkout-header p {
      color: var(--gray-600);
      font-size: var(--font-size-lg);
    }

    .checkout-container {
      display: grid;
      grid-template-columns: 1.5fr 1fr;
      gap: var(--space-2xl);
      max-width: 1200px;
      margin: 0 auto;
    }

    /* Form Styles */
    .checkout-form-section {
      background: var(--white);
      padding: var(--space-2xl);
      border-radius: var(--radius-lg);
      box-shadow: var(--shadow-md);
    }

    .form-section {
      margin-bottom: var(--space-2xl);
      padding-bottom: var(--space-xl);
      border-bottom: 1px solid var(--gray-200);
    }

    .form-section:last-child {
      border-bottom: none;
      margin-bottom: 0;
    }

    .section-title {
      display: flex;
      align-items: center;
      gap: var(--space-sm);
      font-size: var(--font-size-xl);
      font-weight: 600;
      color: var(--gray-900);
      margin-bottom: var(--space-lg);
    }

    .section-title svg {
      color: var(--primary-color);
    }

    .form-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: var(--space-lg);
    }

    .form-group {
      display: flex;
      flex-direction: column;
    }

    .form-group.full-width {
      grid-column: 1 / -1;
    }

    .form-group label {
      font-weight: 500;
      color: var(--gray-700);
      margin-bottom: var(--space-sm);
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
      padding: var(--space-md);
      border: 2px solid var(--gray-200);
      border-radius: var(--radius-md);
      font-size: var(--font-size-base);
      transition: var(--transition-fast);
      background: var(--white);
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
      outline: none;
      border-color: var(--primary-color);
      box-shadow: 0 0 0 3px rgba(139, 94, 60, 0.1);
    }

    .form-group textarea {
      resize: vertical;
      min-height: 100px;
    }

    /* Order Summary */
    .order-summary {
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

    .order-items {
      margin-bottom: var(--space-lg);
    }

    .order-item {
      display: flex;
      gap: var(--space-md);
      padding: var(--space-md) 0;
      border-bottom: 1px solid var(--gray-100);
    }

    .order-item:last-child {
      border-bottom: none;
    }

    .item-image {
      width: 60px;
      height: 60px;
      border-radius: var(--radius-md);
      object-fit: cover;
    }

    .item-details {
      flex: 1;
    }

    .item-name {
      font-weight: 500;
      color: var(--gray-900);
      margin-bottom: var(--space-xs);
    }

    .item-meta {
      font-size: var(--font-size-sm);
      color: var(--gray-600);
    }

    .item-price {
      font-weight: 600;
      color: var(--primary-color);
    }

    .summary-totals {
      border-top: 2px solid var(--gray-200);
      padding-top: var(--space-lg);
    }

    .total-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: var(--space-md);
    }

    .total-label {
      color: var(--gray-600);
    }

    .total-value {
      font-weight: 500;
      color: var(--gray-900);
    }

    .total-row.grand-total {
      font-size: var(--font-size-lg);
      font-weight: 700;
      color: var(--primary-color);
      padding-top: var(--space-md);
      border-top: 1px solid var(--gray-200);
    }

    .shipping-notice {
      background: var(--gray-100);
      padding: var(--space-md);
      border-radius: var(--radius-md);
      margin: var(--space-lg) 0;
      text-align: center;
      font-size: var(--font-size-sm);
      color: var(--gray-600);
    }

    /* Payment Methods */
    .payment-methods {
      margin: var(--space-xl) 0;
      display: flex;
      flex-direction: column;
    }

    .payment-option {
      display: flex;
      align-items: center;
      gap: 62px;
      padding: var(--space-md);
      border: 2px solid var(--gray-200);
      border-radius: var(--radius-md);
      margin-bottom: var(--space-md);
      cursor: pointer;
      transition: var(--transition-fast);
    }

    .payment-option:hover {
      border-color: var(--primary-color);
    }

    .payment-option.selected {
      border-color: var(--primary-color);
      background: var(--primary-light);
    }

    .payment-option input[type="radio"] {
      margin: 0;
    }

    .payment-icon {
      width: 40px;
      height: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: var(--gray-100);
      border-radius: var(--radius-sm);
    }

    .payment-details {
      flex: 1;
    }

    .payment-name {
      font-weight: 500;
      color: var(--gray-900);
      margin-bottom: var(--space-xs);
    }

    .payment-description {
      font-size: var(--font-size-sm);
      color: var(--gray-600);
    }

    /* Place Order Button */
    .place-order-btn {
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
    }

    .place-order-btn:hover {
      background: #D89533;
      transform: translateY(-2px);
      box-shadow: var(--shadow-lg);
    }

    .place-order-btn:disabled {
      background: var(--gray-400);
      cursor: not-allowed;
      transform: none;
      box-shadow: none;
    }

    /* Security Badge */
    .security-badge {
      text-align: center;
      margin-top: var(--space-lg);
      padding-top: var(--space-lg);
      border-top: 1px solid var(--gray-200);
    }

    .security-badge p {
      color: var(--gray-600);
      font-size: var(--font-size-sm);
      margin-bottom: var(--space-sm);
    }

    .security-icons {
      display: flex;
      justify-content: center;
      gap: var(--space-md);
    }

    .security-icon {
      width: 40px;
      height: 40px;
      background: var(--gray-100);
      border-radius: var(--radius-sm);
      display: flex;
      align-items: center;
      justify-content: center;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
      .checkout-container {
        grid-template-columns: 1fr;
        gap: var(--space-xl);
      }

      .order-summary {
        position: static;
      }
    }

    @media (max-width: 768px) {
      .checkout-form-section {
        padding: var(--space-xl);
      }

      .form-grid {
        grid-template-columns: 1fr;
      }

      .checkout-header h1 {
        font-size: var(--font-size-2xl);
      }

      .section-title {
        font-size: var(--font-size-lg);
      }
    }

    @media (max-width: 480px) {
      .checkout-form-section {
        padding: var(--space-lg);
      }

      .order-summary {
        padding: var(--space-lg);
      }

      .payment-option {
        flex-direction: column;
        text-align: center;
      }
    }

    /* Form Validation */
    .form-group.error input,
    .form-group.error select,
    .form-group.error textarea {
      border-color: var(--danger-color);
    }

    .error-message {
      color: var(--danger-color);
      font-size: var(--font-size-sm);
      margin-top: var(--space-xs);
    }

    .success-message {
      background: var(--secondary-color);
      color: var(--white);
      padding: var(--space-md);
      border-radius: var(--radius-md);
      text-align: center;
      margin-bottom: var(--space-lg);
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
  <!-- 🛒 CHECKOUT SECTION -->
  <!-- ========================================================= -->
  <section class="checkout-section">
    <!-- Breadcrumb -->
    <div class="breadcrumb-container">
      <div class="container">
        <nav class="breadcrumb">
          <a href="index.php">Home</a>
          <span class="separator">/</span>
          <a href="cart.php">Shopping Cart</a>
          <span class="separator">/</span>
          <span class="current">Checkout</span>
        </nav>
      </div>
    </div>

    <div class="container">
      <div class="checkout-header">
        <h1>Checkout</h1>
        <p>Complete your order with secure payment</p>
      </div>

      <div class="checkout-container">
        <!-- Checkout Form -->
        <div class="checkout-form-section">
          <form id="checkout-form" class="checkout-form">
            <!-- Contact Information -->
            <div class="form-section">
              <h3 class="section-title">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                </svg>
                Contact Information
              </h3>
              <div class="form-grid">
                <div class="form-group">
                  <label for="email">Email Address *</label>
                  <input type="email" id="email" name="email" required placeholder="your@email.com">
                </div>
                <div class="form-group">
                  <label for="phone">Phone Number *</label>
                  <input type="tel" id="phone" name="phone" required placeholder="+92 300 1234567">
                </div>
              </div>
            </div>

            <!-- Shipping Address -->
            <div class="form-section">
              <h3 class="section-title">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                </svg>
                Shipping Address
              </h3>
              <div class="form-grid">
                <div class="form-group">
                  <label for="firstName">First Name *</label>
                  <input type="text" id="firstName" name="firstName" required placeholder="Ali">
                </div>
                <div class="form-group">
                  <label for="lastName">Last Name *</label>
                  <input type="text" id="lastName" name="lastName" required placeholder="Ahmed">
                </div>
                <div class="form-group full-width">
                  <label for="address">Street Address *</label>
                  <input type="text" id="address" name="address" required placeholder="House #123, Street #45">
                </div>
                <div class="form-group">
                  <label for="city">City *</label>
                  <input type="text" id="city" name="city" required placeholder="Karachi">
                </div>
                <div class="form-group">
                  <label for="state">Province *</label>
                  <select id="state" name="state" required>
                    <option value="">Select Province</option>
                    <option value="sindh">Sindh</option>
                    <option value="punjab">Punjab</option>
                    <option value="kpk">Khyber Pakhtunkhwa</option>
                    <option value="balochistan">Balochistan</option>
                    <option value="islamabad">Islamabad Capital Territory</option>
                    <option value="gilgit">Gilgit-Baltistan</option>
                    <option value="ajk">Azad Jammu & Kashmir</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="postalCode">Postal Code *</label>
                  <input type="text" id="postalCode" name="postalCode" required placeholder="74000">
                </div>
              </div>
            </div>

            <!-- Shipping Method -->
            <div class="form-section">
              <h3 class="section-title">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M20 8h-3V4H3c-1.1 0-2 .9-2 2v11h2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3h2v-5l-3-4zM6 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm13.5-9l1.96 2.5H17V9.5h2.5zm-1.5 9c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/>
                </svg>
                Shipping Method
              </h3>
              <div class="shipping-options">
                <div class="payment-option selected">
                  <input type="radio" name="shipping" id="standard" value="standard" checked>
                  <div class="payment-details">
                    <div class="payment-name">Standard Delivery</div>
                    <div class="payment-description">3-5 business days - Free</div>
                  </div>
                  <div class="payment-price">Free</div>
                </div>
                <div class="payment-option">
                  <input type="radio" name="shipping" id="express" value="express">
                  <div class="payment-details">
                    <div class="payment-name">Express Delivery</div>
                    <div class="payment-description">1-2 business days</div>
                  </div>
                  <div class="payment-price">Rs. 250</div>
                </div>
              </div>
            </div>

            <!-- Payment Method -->
            <div class="form-section">
              <h3 class="section-title">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z"/>
                </svg>
                Payment Method
              </h3>
              <div class="payment-methods">
                <div class="payment-option selected">
                  <input type="radio" name="payment" id="cod" value="cod" checked>
                  <div class="payment-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                      <path d="M18 6h-2c0-2.21-1.79-4-4-4S8 3.79 8 6H6c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm-6-2c1.1 0 2 .9 2 2h-4c0-1.1.9-2 2-2zm6 16H6V8h2v2c0 .55.45 1 1 1s1-.45 1-1V8h4v2c0 .55.45 1 1 1s1-.45 1-1V8h2v12z"/>
                    </svg>
                  </div>
                  <div class="payment-details">
                    <div class="payment-name">Cash on Delivery</div>
                    <div class="payment-description">Pay when you receive your order</div>
                  </div>
                </div>
                <div class="payment-option">
                  <input type="radio" name="payment" id="jazzcash" value="jazzcash">
                  <div class="payment-icon">
                    <span style="font-weight: bold; color: #E91E63;">JazzCash</span>
                  </div>
                  <div class="payment-details">
                    <div class="payment-name">JazzCash</div>
                    <div class="payment-description">Pay securely with JazzCash</div>
                  </div>
                </div>
                <div class="payment-option">
                  <input type="radio" name="payment" id="easypaisa" value="easypaisa">
                  <div class="payment-icon">
                    <span style="font-weight: bold; color: #00A859;">EasyPaisa</span>
                  </div>
                  <div class="payment-details">
                    <div class="payment-name">EasyPaisa</div>
                    <div class="payment-description">Pay securely with EasyPaisa</div>
                  </div>
                </div>
                <div class="payment-option">
                  <input type="radio" name="payment" id="bank" value="bank">
                  <div class="payment-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                      <path d="M11.5 1L2 6v2h19V6l-9.5-5zm4.5 9v7h3v-7h-3zM2 22h19v-3H2v3zm14-12v7h3v-7h-3zm-5 0v7h3v-7h-3zm-4 0v7h3v-7H7z"/>
                    </svg>
                  </div>
                  <div class="payment-details">
                    <div class="payment-name">Bank Transfer</div>
                    <div class="payment-description">Transfer directly to our bank account</div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Order Notes -->
            <div class="form-section">
              <h3 class="section-title">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 14H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                </svg>
                Order Notes (Optional)
              </h3>
              <div class="form-group full-width">
                <textarea id="notes" name="notes" placeholder="Any special instructions for your order..."></textarea>
              </div>
            </div>
          </form>
        </div>

        <!-- Order Summary -->
        <div class="order-summary">
          <h3 class="summary-header">Order Summary</h3>
          
          <div class="order-items">
            <?php if (empty($cart)): ?>
              <div class="empty-cart">
                <p>Your cart is empty</p>
                <a href="products.php" class="btn primary-btn">Continue Shopping</a>
              </div>
            <?php else: ?>
              <?php foreach ($cart as $item): ?>
                <div class="order-item">
                  <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" class="item-image">
                  <div class="item-details">
                    <div class="item-name"><?php echo $item['name']; ?></div>
                    <div class="item-meta">
                      Size: <?php echo $item['size']; ?> • Qty: <?php echo $item['quantity']; ?>
                    </div>
                  </div>
                  <div class="item-price">Rs. <?php echo number_format($item['price'] * $item['quantity'], 2); ?></div>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>

          <div class="summary-totals">
            <div class="total-row">
              <span class="total-label">Subtotal</span>
              <span class="total-value">Rs. <?php echo number_format($total, 2); ?></span>
            </div>
            <div class="total-row">
              <span class="total-label">Shipping</span>
              <span class="total-value" id="shipping-cost">Free</span>
            </div>
            <div class="total-row">
              <span class="total-label">Tax</span>
              <span class="total-value">Rs. <?php echo number_format($total * 0.05, 2); ?></span>
            </div>
            <div class="total-row grand-total">
              <span class="total-label">Total</span>
              <span class="total-value" id="grand-total">Rs. <?php echo number_format($total * 1.05, 2); ?></span>
            </div>
          </div>

          <div class="shipping-notice">
            <strong>Free Shipping</strong> on all orders across Pakistan
          </div>

          <button type="submit" form="checkout-form" class="place-order-btn" <?php echo empty($cart) ? 'disabled' : ''; ?>>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
              <path d="M19 4h-1V3c0-.55-.45-1-1-1s-1 .45-1 1v1H8V3c0-.55-.45-1-1-1s-1 .45-1 1v1H5c-1.11 0-1.99.9-1.99 2L3 20a2 2 0 002 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10zm-8-2l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/>
            </svg>
            Place Order
          </button>

          <div class="security-badge">
            <p>Your payment information is secure and encrypted</p>
            <div class="security-icons">
              <div class="security-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z"/>
                </svg>
              </div>
              <div class="security-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zM12 17c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
                </svg>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
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
    // Checkout Form JavaScript
    document.addEventListener('DOMContentLoaded', function() {
      const checkoutForm = document.getElementById('checkout-form');
      const placeOrderBtn = document.querySelector('.place-order-btn');
      const shippingOptions = document.querySelectorAll('input[name="shipping"]');
      const paymentOptions = document.querySelectorAll('input[name="payment"]');
      
      // Shipping cost calculation
      let shippingCost = 0;
      const subtotal = <?php echo $total; ?>;
      const taxRate = 0.05;
      
      function updateTotals() {
        const tax = subtotal * taxRate;
        const grandTotal = subtotal + tax + shippingCost;
        
        document.getElementById('shipping-cost').textContent = shippingCost === 0 ? 'Free' : `Rs. ${shippingCost.toFixed(2)}`;
        document.getElementById('grand-total').textContent = `Rs. ${grandTotal.toFixed(2)}`;
      }
      
      // Shipping option change
      shippingOptions.forEach(option => {
        option.addEventListener('change', function() {
          if (this.value === 'express') {
            shippingCost = 250;
          } else {
            shippingCost = 0;
          }
          updateTotals();
        });
      });
      
      // Payment option selection
      paymentOptions.forEach(option => {
        option.addEventListener('change', function() {
          document.querySelectorAll('.payment-option').forEach(opt => {
            opt.classList.remove('selected');
          });
          this.closest('.payment-option').classList.add('selected');
        });
      });
      
      // Form validation and submission
      checkoutForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (validateForm()) {
          placeOrderBtn.disabled = true;
          placeOrderBtn.innerHTML = `
            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
              <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
            </svg>
            Processing...
          `;
          
          // Simulate order processing
          setTimeout(() => {
            processOrder();
          }, 2000);
        }
      });
      
      function validateForm() {
        let isValid = true;
        const requiredFields = checkoutForm.querySelectorAll('[required]');
        
        // Remove existing error messages
        document.querySelectorAll('.error-message').forEach(msg => msg.remove());
        document.querySelectorAll('.form-group').forEach(group => group.classList.remove('error'));
        
        // Validate required fields
        requiredFields.forEach(field => {
          if (!field.value.trim()) {
            isValid = false;
            field.closest('.form-group').classList.add('error');
            const errorMsg = document.createElement('div');
            errorMsg.className = 'error-message';
            errorMsg.textContent = 'This field is required';
            field.closest('.form-group').appendChild(errorMsg);
          }
        });
        
        // Validate email
        const emailField = document.getElementById('email');
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (emailField.value && !emailRegex.test(emailField.value)) {
          isValid = false;
          emailField.closest('.form-group').classList.add('error');
          const errorMsg = document.createElement('div');
          errorMsg.className = 'error-message';
          errorMsg.textContent = 'Please enter a valid email address';
          emailField.closest('.form-group').appendChild(errorMsg);
        }
        
        // Validate phone (Pakistan format)
        const phoneField = document.getElementById('phone');
        const phoneRegex = /^(\+92|0)[0-9]{10}$/;
        if (phoneField.value && !phoneRegex.test(phoneField.value.replace(/\s/g, ''))) {
          isValid = false;
          phoneField.closest('.form-group').classList.add('error');
          const errorMsg = document.createElement('div');
          errorMsg.className = 'error-message';
          errorMsg.textContent = 'Please enter a valid Pakistan phone number';
          phoneField.closest('.form-group').appendChild(errorMsg);
        }
        
        return isValid;
      }
      
      function processOrder() {
        const formData = new FormData(checkoutForm);
        const orderData = {
          contact: {
            email: formData.get('email'),
            phone: formData.get('phone')
          },
          shipping: {
            firstName: formData.get('firstName'),
            lastName: formData.get('lastName'),
            address: formData.get('address'),
            city: formData.get('city'),
            state: formData.get('state'),
            postalCode: formData.get('postalCode')
          },
          shippingMethod: formData.get('shipping'),
          paymentMethod: formData.get('payment'),
          notes: formData.get('notes'),
          cart: <?php echo json_encode($cart); ?>,
          totals: {
            subtotal: subtotal,
            shipping: shippingCost,
            tax: subtotal * taxRate,
            total: subtotal + (subtotal * taxRate) + shippingCost
          }
        };
        
        // Save order to localStorage (simulate server submission)
        const orders = JSON.parse(localStorage.getItem('orders')) || [];
        const orderId = 'ORD-' + Date.now();
        orderData.orderId = orderId;
        orderData.status = 'confirmed';
        orderData.date = new Date().toISOString();
        orders.push(orderData);
        localStorage.setItem('orders', JSON.stringify(orders));
        
        // Clear cart
        localStorage.removeItem('cart');
        sessionStorage.removeItem('cart');
        
        // Redirect to confirmation page
        window.location.href = `order-confirmation.php?order_id=${orderId}`;
      }
      
      // Initialize payment option selection
      document.querySelectorAll('.payment-option').forEach(option => {
        option.addEventListener('click', function() {
          const radio = this.querySelector('input[type="radio"]');
          if (radio) {
            radio.checked = true;
            document.querySelectorAll('.payment-option').forEach(opt => {
              opt.classList.remove('selected');
            });
            this.classList.add('selected');
          }
        });
      });
      
      // Initialize shipping option selection
      document.querySelectorAll('.shipping-options .payment-option').forEach(option => {
        option.addEventListener('click', function() {
          const radio = this.querySelector('input[type="radio"]');
          if (radio) {
            radio.checked = true;
            document.querySelectorAll('.shipping-options .payment-option').forEach(opt => {
              opt.classList.remove('selected');
            });
            this.classList.add('selected');
            
            // Update shipping cost
            if (radio.value === 'express') {
              shippingCost = 250;
            } else {
              shippingCost = 0;
            }
            updateTotals();
          }
        });
      });
    });
  </script>
</body>
</html>