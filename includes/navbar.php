<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
$isLoggedIn = isset($_SESSION['user_id']) || isset($_SESSION['logged_in']);
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
    <span class="icons-span position-relative cart-icon" onclick="window.location.href='cart.php'" title="Shopping Cart">
      <span class="badge bounce-in">0</span>
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" stroke="currentColor" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
        <circle cx="9" cy="21" r="1"></circle>
        <circle cx="20" cy="21" r="1"></circle>
        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
      </svg>
    </span>        
    <span class="icons-span position-relative wishlist-icon" title="Wishlist">
      <span class="badge bounce-in">0</span>
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" stroke="currentColor" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
      </svg>
    </span>
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