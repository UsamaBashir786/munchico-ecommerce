<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Check if user is logged in
$isLoggedIn = isset($_SESSION['user_id']) || isset($_SESSION['logged_in']);

// Get cart and wishlist counts from database
require_once 'config/database.php';
$cartCount = 0;
$wishlistCount = 0;

if ($isLoggedIn && isset($_SESSION['user_id'])) {
  try {
    $database = new Database();
    $pdo = $database->getConnection();

    // Get cart count
    $stmt = $pdo->prepare("SELECT SUM(quantity) as total_count FROM cart WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $cartResult = $stmt->fetch();
    $cartCount = $cartResult['total_count'] ?? 0;

    // Get wishlist count
    $stmt = $pdo->prepare("SELECT COUNT(*) as total_count FROM wishlist WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $wishlistResult = $stmt->fetch();
    $wishlistCount = $wishlistResult['total_count'] ?? 0;
  } catch (Exception $e) {
    error_log("Error fetching counts: " . $e->getMessage());
  }
}
?>

<header class="top-bar flex-between px-xl py-md">
  <!--=========Number Side=========== -->
  <div class="flex align-items-center gap-sm helpline-section rc-zoom-in-up">
    <div class="helpline-icon-wrapper">
      <img src="assets/royal-icons/helpline-icon.png" alt="Helpline Icon">
      <span class="pulse-ring"></span>
    </div>
    <div class="helpline-content">
      <span class="font-bold helpline-label">24/7 Support</span>
      <a href="tel:03XXXXXXXXX" class="helpline-number">03XXXXXXXXX</a>
    </div>
  </div>

  <!--=========Icon Side=========== -->
  <div class="gap-xl flex header-icons rc-zoom-in-up">
    <!-- Cart Icon with Dropdown -->
    <div class="dropdown-container">
      <span class="icons-span position-relative cart-icon" title="Shopping Cart">
        <span class="badge bounce-in cart-badge"><?php echo $cartCount; ?></span>
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" stroke="currentColor" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
          <circle cx="9" cy="21" r="1"></circle>
          <circle cx="20" cy="21" r="1"></circle>
          <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
        </svg>
      </span>
      <div class="dropdown-content cart-dropdown">
        <div class="dropdown-header">
          <h3>Shopping Cart</h3>
          <span class="cart-count"><?php echo $cartCount; ?> item(s)</span>
        </div>
        <div class="dropdown-items" id="cart-dropdown-items">
          <!-- Cart items will be loaded here via AJAX -->
          <div class="loading-spinner">Loading...</div>
        </div>
        <div class="dropdown-footer">
          <div class="cart-total">
            <span>Total:</span>
            <span class="total-amount" id="cart-total-amount">Rs. 0.00</span>
          </div>
          <a href="cart.php" class="btn btn-primary btn-block">View Cart</a>
          <a href="checkout.php" class="btn btn-outline btn-block">Checkout</a>
        </div>
      </div>
    </div>

    <!-- Wishlist Icon with Dropdown -->
    <div class="dropdown-container">
      <span class="icons-span position-relative wishlist-icon" title="Wishlist">
        <span class="badge bounce-in wishlist-badge"><?php echo $wishlistCount; ?></span>
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" stroke="currentColor" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
          <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
        </svg>
      </span>
      <div class="dropdown-content wishlist-dropdown">
        <div class="dropdown-header">
          <h3>Wishlist</h3>
          <span class="wishlist-count"><?php echo $wishlistCount; ?> item(s)</span>
        </div>
        <div class="dropdown-items" id="wishlist-dropdown-items">
          <!-- Wishlist items will be loaded here via AJAX -->
          <div class="loading-spinner">Loading...</div>
        </div>
        <div class="dropdown-footer">
          <a href="wishlist.php" class="btn btn-primary btn-block">View Wishlist</a>
        </div>
      </div>
    </div>
  </div>
</header>

<!-- Main Navigation: Logo, menu, search, cart -->
<nav class="navbar px-xl rc-both" aria-label="Primary Navigation">
  <div class="logo rc-zoom-in-sm rc-delay-150" onclick="window.location.href='index.php'">
    <img class="cursor-pointer logo-image" width="120px" src="assets/img/logo.png" alt="Logo">
  </div>

  <ul class="nav-links">
    <li class="nav-item"><a href="index.php" class="nav-link rc-zoom-in-up">Home</a></li>
    <li class="nav-item"><a href="product.php" class="nav-link rc-zoom-in-up">Shop</a></li>
    <li class="nav-item"><a href="product.php" class="nav-link rc-zoom-in-up">New Arrivals</a></li>
    <li class="nav-item"><a href="product.php" class="nav-link rc-zoom-in-up">All Products</a></li>
    <li class="nav-item"><a href="product.php" class="nav-link rc-zoom-in-up">Collection</a></li>
    <li class="nav-item"><a href="login.php" class="nav-link rc-zoom-in-up">Account</a></li>
    <li class="nav-item"><a href="#" class="nav-link rc-zoom-in-up">Track Order</a></li>
  </ul>

  <div class="search-bar rc-distance-sm rc-delay-250">
    <button class="icon-button search-button" aria-label="Search">
      <svg class="search-svg" xmlns="http://www.w3.org/2000/svg" width="34" height="34" stroke="currentColor" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
        <circle cx="11" cy="11" r="8"></circle>
        <path d="m21 21-4.35-4.35"></path>
      </svg>
    </button>
    <button class="icon-button menu-button" aria-label="Menu">
      <svg class="menu-svg" xmlns="http://www.w3.org/2000/svg" width="34" height="34" stroke="currentColor" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
        <line x1="3" y1="6" x2="21" y2="6"></line>
        <line x1="3" y1="12" x2="21" y2="12"></line>
        <line x1="3" y1="18" x2="21" y2="18"></line>
      </svg>
    </button>

    <?php if ($isLoggedIn): ?>
      <!-- Show Logout button with left arrow when logged in -->
      <a href="logout.php" class="" style="display: flex; align-items: center; gap: 0.5rem;">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" stroke="currentColor" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
          <line x1="19" y1="12" x2="5" y2="12"></line>
          <polyline points="12 19 5 12 12 5"></polyline>
        </svg>
        Logout
      </a>
    <?php else: ?>
      <!-- Show Login and Register buttons when not logged in -->
      <a href="login.php" class="login-button btn btn-primary">Login</a>
      <a href="register.php" class="register-button btn btn-outline">Register</a>
    <?php endif; ?>
  </div>
</nav>

<style>
  /* Dropdown Styles */
  .dropdown-container {
    position: relative;
    display: inline-block;
    z-index: 10000;
    /* Add this */
  }

  .dropdown-content {
    display: none;
    position: absolute;
    top: 100%;
    right: 0;
    width: 350px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    border: 1px solid #e5e7eb;
    z-index: 10001;
    /* Increased z-index */
    margin-top: 10px;
    opacity: 0;
    transform: translateY(-10px);
    transition: all 0.3s ease;
  }

  .dropdown-content.show {
    display: block;
    opacity: 1;
    transform: translateY(0);
  }

  /* Ensure the header has proper z-index */
  .top-bar {
    position: relative;
    z-index: 9999;
    /* Lower than dropdown but higher than other content */
  }

  /* Make sure navbar doesn't interfere */
  .navbar {
    position: relative;
    z-index: 9998;
    /* Lower than header */
  }

  /* Add this to ensure dropdown stays on top of everything */
  .dropdown-content {
    z-index: 10002 !important;
    /* Maximum priority */
  }

  /* Header icons should have higher z-index */
  .header-icons {
    position: relative;
    z-index: 10000;
  }

  .icons-span {
    cursor: pointer;
    padding: 8px;
    border-radius: 8px;
    transition: all 0.3s ease;
    position: relative;
    z-index: 10001;
    /* Higher than container */
  }

  /* Rest of your existing CSS remains the same */
  .dropdown-header {
    padding: 20px;
    border-bottom: 1px solid #e5e7eb;
    background: #f9fafb;
    border-radius: 12px 12px 0 0;
  }

  .dropdown-header h3 {
    margin: 0 0 5px 0;
    font-size: 18px;
    font-weight: 600;
    color: #1f2937;
  }

  .dropdown-header .cart-count,
  .dropdown-header .wishlist-count {
    font-size: 14px;
    color: #6b7280;
  }

  .dropdown-items {
    max-height: 300px;
    overflow-y: auto;
    padding: 10px;
  }

  .dropdown-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    border-radius: 8px;
    transition: background-color 0.2s ease;
    margin-bottom: 8px;
  }

  .dropdown-item:hover {
    background: #f9fafb;
  }

  .dropdown-item-image {
    width: 50px;
    height: 50px;
    border-radius: 6px;
    object-fit: cover;
    flex-shrink: 0;
  }

  .dropdown-item-details {
    flex: 1;
    min-width: 0;
  }

  .dropdown-item-name {
    font-size: 14px;
    font-weight: 500;
    color: #1f2937;
    margin: 0 0 4px 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .dropdown-item-price {
    font-size: 14px;
    font-weight: 600;
    color: #ea580c;
    margin: 0 0 4px 0;
  }

  .dropdown-item-quantity {
    font-size: 12px;
    color: #6b7280;
  }

  .dropdown-item-actions {
    display: flex;
    gap: 8px;
  }

  .dropdown-item-action {
    background: none;
    border: none;
    color: #6b7280;
    cursor: pointer;
    padding: 4px;
    border-radius: 4px;
    transition: all 0.2s ease;
  }

  .dropdown-item-action:hover {
    color: #ea580c;
    background: #fef7ed;
  }

  .dropdown-item-action.remove:hover {
    color: #dc2626;
    background: #fef2f2;
  }

  .dropdown-footer {
    padding: 20px;
    border-top: 1px solid #e5e7eb;
    background: #f9fafb;
    border-radius: 0 0 12px 12px;
  }

  .cart-total {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
    font-weight: 600;
    font-size: 16px;
  }

  .total-amount {
    color: #ea580c;
    font-size: 18px;
  }

  .btn-block {
    display: block;
    width: 100%;
    text-align: center;
    margin-bottom: 8px;
  }

  .empty-state {
    text-align: center;
    padding: 40px 20px;
    color: #6b7280;
  }

  .empty-state svg {
    margin-bottom: 15px;
    opacity: 0.5;
  }

  .empty-state p {
    margin: 0;
    font-size: 14px;
  }

  .loading-spinner {
    text-align: center;
    padding: 30px;
    color: #6b7280;
  }

  /* Badge styles */
  .badge {
    position: absolute;
    top: -8px;
    right: -8px;
    background: #ea580c;
    color: white;
    border-radius: 50%;
    width: 18px;
    height: 18px;
    font-size: 11px;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid white;
    z-index: 10002;
    /* Higher z-index for badges */
  }

  /* Hover effects */
  .icons-span {
    cursor: pointer;
    padding: 8px;
    border-radius: 8px;
    transition: all 0.3s ease;
    position: relative;
    z-index: 10001;
  }

  .icons-span:hover {
    /* background: #f3f4f6; */
    transform: translateY(-2px);
  }

  /* Animation for badge updates */
  @keyframes pulse {
    0% {
      transform: scale(1);
    }

    50% {
      transform: scale(1.1);
    }

    100% {
      transform: scale(1);
    }
  }

  .badge.update {
    animation: pulse 0.3s ease;
  }

  /* Mobile responsiveness */
  @media (max-width: 768px) {
    .dropdown-content {
      width: 300px;
      right: -50px;
      z-index: 10002 !important;
    }
  }

  @media (max-width: 480px) {
    .dropdown-content {
      width: 280px;
      right: -80px;
      z-index: 10002 !important;
    }
  }

  /* Add this to ensure dropdown stays on top of all other elements */
  .dropdown-content {
    z-index: 10002 !important;
    position: fixed !important;
    /* Change to fixed positioning */
  }

  /* Update the positioning for fixed dropdowns */
  .cart-dropdown {
    position: fixed !important;
    top: 80px !important;
    /* Adjust based on your header height */
    right: 20px !important;
    margin-top: 0 !important;
  }

  .wishlist-dropdown {
    position: fixed !important;
    top: 80px !important;
    /* Adjust based on your header height */
    right: 20px !important;
    margin-top: 0 !important;
  }

  .dropdown-item svg {
    color: var(--black);
  }
</style>

<script>
  // Dropdown functionality
  document.addEventListener('DOMContentLoaded', function() {
    // Initialize dropdowns
    initDropdowns();
    // Load initial data
    loadCartDropdown();
    loadWishlistDropdown();
  });

  function initDropdowns() {
    // Cart dropdown
    const cartIcon = document.querySelector('.cart-icon');
    const cartDropdown = document.querySelector('.cart-dropdown');

    if (cartIcon && cartDropdown) {
      cartIcon.addEventListener('click', function(e) {
        e.stopPropagation();
        e.preventDefault();

        // Calculate position for fixed dropdown
        const rect = cartIcon.getBoundingClientRect();
        cartDropdown.style.top = (rect.bottom + window.scrollY + 10) + 'px';
        cartDropdown.style.right = (window.innerWidth - rect.right) + 'px';

        cartDropdown.classList.toggle('show');
        // Close other dropdowns
        document.querySelectorAll('.dropdown-content').forEach(dropdown => {
          if (dropdown !== cartDropdown) {
            dropdown.classList.remove('show');
          }
        });
        // Refresh cart data when opening
        if (cartDropdown.classList.contains('show')) {
          loadCartDropdown();
        }
      });
    }

    // Wishlist dropdown
    const wishlistIcon = document.querySelector('.wishlist-icon');
    const wishlistDropdown = document.querySelector('.wishlist-dropdown');

    if (wishlistIcon && wishlistDropdown) {
      wishlistIcon.addEventListener('click', function(e) {
        e.stopPropagation();
        e.preventDefault();

        // Calculate position for fixed dropdown
        const rect = wishlistIcon.getBoundingClientRect();
        wishlistDropdown.style.top = (rect.bottom + window.scrollY + 10) + 'px';
        wishlistDropdown.style.right = (window.innerWidth - rect.right) + 'px';

        wishlistDropdown.classList.toggle('show');
        // Close other dropdowns
        document.querySelectorAll('.dropdown-content').forEach(dropdown => {
          if (dropdown !== wishlistDropdown) {
            dropdown.classList.remove('show');
          }
        });
        // Refresh wishlist data when opening
        if (wishlistDropdown.classList.contains('show')) {
          loadWishlistDropdown();
        }
      });
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
      // Check if click is outside dropdown containers
      if (!e.target.closest('.dropdown-container')) {
        document.querySelectorAll('.dropdown-content').forEach(dropdown => {
          dropdown.classList.remove('show');
        });
      }
    });

    // Close dropdowns on scroll
    window.addEventListener('scroll', function() {
      document.querySelectorAll('.dropdown-content').forEach(dropdown => {
        dropdown.classList.remove('show');
      });
    });

    // Close dropdowns on window resize
    window.addEventListener('resize', function() {
      document.querySelectorAll('.dropdown-content').forEach(dropdown => {
        dropdown.classList.remove('show');
      });
    });
  }

  async function loadCartDropdown() {
    const container = document.getElementById('cart-dropdown-items');
    if (!container) return;

    try {
      container.innerHTML = '<div class="loading-spinner">Loading...</div>';

      const response = await fetch('ajax/get_cart_dropdown.php');
      const data = await response.json();

      if (data.success) {
        if (data.items && data.items.length > 0) {
          container.innerHTML = data.items.map(item => `
                    <div class="dropdown-item" data-cart-id="${item.cart_id}">
                        <img src="${item.main_image}" alt="${item.product_name}" class="dropdown-item-image">
                        <div class="dropdown-item-details">
                            <h4 class="dropdown-item-name">${item.product_name}</h4>
                            <div class="dropdown-item-price">Rs. ${parseFloat(item.price).toFixed(2)}</div>
                            <div class="dropdown-item-quantity">Qty: ${item.quantity}</div>
                        </div>
                        <div class="dropdown-item-actions">
                            <button class="dropdown-item-action remove" onclick="removeFromCart(${item.cart_id})" title="Remove">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                `).join('');

          // Update total
          document.getElementById('cart-total-amount').textContent = `Rs. ${parseFloat(data.total).toFixed(2)}`;
          // Update count in header
          document.querySelector('.dropdown-header .cart-count').textContent = `${data.total_count} item(s)`;
        } else {
          container.innerHTML = `
                    <div class="empty-state">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>
                        <p>Your cart is empty</p>
                    </div>
                `;
          document.getElementById('cart-total-amount').textContent = 'Rs. 0.00';
          document.querySelector('.dropdown-header .cart-count').textContent = '0 item(s)';
        }

        // Update badge
        updateCartBadge(data.total_count || 0);
      } else {
        throw new Error(data.message || 'Failed to load cart');
      }
    } catch (error) {
      console.error('Error loading cart dropdown:', error);
      container.innerHTML = '<div class="empty-state"><p>Error loading cart</p></div>';
    }
  }

  async function loadWishlistDropdown() {
    const container = document.getElementById('wishlist-dropdown-items');
    if (!container) return;

    try {
      container.innerHTML = '<div class="loading-spinner">Loading...</div>';

      const response = await fetch('ajax/get_wishlist_dropdown.php');
      const data = await response.json();

      if (data.success) {
        if (data.items && data.items.length > 0) {
          container.innerHTML = data.items.map(item => `
                    <div class="dropdown-item" data-wishlist-id="${item.wishlist_id}">
                        <img src="${item.main_image}" alt="${item.product_name}" class="dropdown-item-image">
                        <div class="dropdown-item-details">
                            <h4 class="dropdown-item-name">${item.product_name}</h4>
                            <div class="dropdown-item-price">Rs. ${parseFloat(item.price).toFixed(2)}</div>
                        </div>
                        <div class="dropdown-item-actions">
                            <button class="dropdown-item-action" onclick="addToCartFromWishlist(${item.product_id})" title="Add to Cart">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="9" cy="21" r="1"></circle>
                                    <circle cx="20" cy="21" r="1"></circle>
                                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                </svg>
                            </button>
                            <button class="dropdown-item-action remove" onclick="removeFromWishlist(${item.wishlist_id})" title="Remove">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                `).join('');

          // Update count in header
          document.querySelector('.dropdown-header .wishlist-count').textContent = `${data.total_count} item(s)`;
        } else {
          container.innerHTML = `
                    <div class="empty-state">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                        </svg>
                        <p>Your wishlist is empty</p>
                    </div>
                `;
          document.querySelector('.dropdown-header .wishlist-count').textContent = '0 item(s)';
        }

        // Update badge
        updateWishlistBadge(data.total_count || 0);
      } else {
        throw new Error(data.message || 'Failed to load wishlist');
      }
    } catch (error) {
      console.error('Error loading wishlist dropdown:', error);
      container.innerHTML = '<div class="empty-state"><p>Error loading wishlist</p></div>';
    }
  }

  function updateCartBadge(count) {
    const badge = document.querySelector('.cart-badge');
    if (badge) {
      badge.textContent = count;
      badge.classList.add('update');
      setTimeout(() => badge.classList.remove('update'), 300);
    }
  }

  function updateWishlistBadge(count) {
    const badge = document.querySelector('.wishlist-badge');
    if (badge) {
      badge.textContent = count;
      badge.classList.add('update');
      setTimeout(() => badge.classList.remove('update'), 300);
    }
  }

  // Action functions
  async function removeFromCart(cartId) {
    try {
      const response = await fetch('ajax/remove_from_cart.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          cart_id: cartId
        })
      });

      const result = await response.json();

      if (result.success) {
        // Reload cart dropdown
        loadCartDropdown();
        // Show notification
        showNotification('Item removed from cart');
      } else {
        throw new Error(result.message || 'Failed to remove item');
      }
    } catch (error) {
      console.error('Error removing from cart:', error);
      showNotification('Error removing item from cart', 'error');
    }
  }

  async function removeFromWishlist(wishlistId) {
    try {
      const response = await fetch('ajax/remove_from_wishlist.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          wishlist_id: wishlistId
        })
      });

      const result = await response.json();

      if (result.success) {
        // Reload wishlist dropdown
        loadWishlistDropdown();
        // Show notification
        showNotification('Item removed from wishlist');
      } else {
        throw new Error(result.message || 'Failed to remove item');
      }
    } catch (error) {
      console.error('Error removing from wishlist:', error);
      showNotification('Error removing item from wishlist', 'error');
    }
  }

  async function addToCartFromWishlist(productId) {
    try {
      const response = await fetch('ajax/add_to_cart.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          product_id: productId,
          quantity: 1
        })
      });

      const result = await response.json();

      if (result.success) {
        // Reload both dropdowns
        loadCartDropdown();
        loadWishlistDropdown();
        // Show notification
        showNotification('Item added to cart');
      } else {
        throw new Error(result.message || 'Failed to add item to cart');
      }
    } catch (error) {
      console.error('Error adding to cart:', error);
      showNotification('Error adding item to cart', 'error');
    }
  }

  // Enhanced AJAX function for other pages
  async function makeRequest(url, method = 'POST', data = null) {
    try {
      const options = {
        method: method,
        headers: {
          'Content-Type': 'application/json',
        },
        credentials: 'same-origin'
      };

      if (data) {
        options.body = JSON.stringify(data);
      }

      const response = await fetch(url, options);

      // Check if response is JSON
      const contentType = response.headers.get('content-type');
      if (!contentType || !contentType.includes('application/json')) {
        const text = await response.text();
        console.error('Non-JSON response:', text.substring(0, 200));
        throw new Error('Server returned non-JSON response');
      }

      const result = await response.json();

      if (!response.ok) {
        throw new Error(result.message || `HTTP error! status: ${response.status}`);
      }

      return result;
    } catch (error) {
      console.error('Request failed:', error);

      // Show user-friendly error message
      if (error.message.includes('non-JSON')) {
        showNotification('Server error. Please try again later.', 'error');
      } else {
        showNotification(error.message || 'Something went wrong. Please try again.', 'error');
      }

      throw error;
    }
  }

  function showNotification(message, type = 'success') {
    // Create notification element if it doesn't exist
    let notification = document.getElementById('navbar-notification');
    if (!notification) {
      notification = document.createElement('div');
      notification.id = 'navbar-notification';
      notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 25px;
            border-radius: 8px;
            color: white;
            font-weight: 500;
            z-index: 10003;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            transform: translateX(150%);
            transition: transform 0.3s ease;
        `;
      document.body.appendChild(notification);
    }

    // Set style based on type
    if (type === 'error') {
      notification.style.background = '#dc2626';
    } else {
      notification.style.background = '#10b981';
    }

    notification.textContent = message;
    notification.style.transform = 'translateX(0)';

    // Auto hide after 3 seconds
    setTimeout(() => {
      notification.style.transform = 'translateX(150%)';
    }, 3000);
  }

  // Global function to update counts (can be called from other pages)
  function updateNavbarCounts() {
    loadCartDropdown();
    loadWishlistDropdown();
  }

  // Close all dropdowns (useful for mobile)
  function closeAllDropdowns() {
    document.querySelectorAll('.dropdown-content').forEach(dropdown => {
      dropdown.classList.remove('show');
    });
  }

  // Keyboard accessibility
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
      closeAllDropdowns();
    }
  });

  // Export functions for global use
  window.updateNavbarCounts = updateNavbarCounts;
  window.closeAllDropdowns = closeAllDropdowns;
  window.removeFromCart = removeFromCart;
  window.removeFromWishlist = removeFromWishlist;
  window.addToCartFromWishlist = addToCartFromWishlist;
</script>