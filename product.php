<?php
session_start();

// Database connection using MySQLi
$host = "localhost";
$db_name = "munchico_db";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
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
  <title>ALL PRODUCTS – MUNCHICO | Premium Dried Fruits & Nuts Online Store</title>
  <meta name="title" content="ALL PRODUCTS – MUNCHICO | Premium Dried Fruits & Nuts Online Store" />
  <meta name="description" content="Browse our complete collection of premium dried fruits, nuts, and healthy snacks at MUNCHICO. Filter by category, find your favorites." />
  <meta name="keywords" content="dried fruits, nuts, premium snacks, healthy snacks, MUNCHICO, online store, dried figs, almonds, cashews, all products" />
  <meta name="author" content="MUNCHICO" />
  <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1" />

  <!-- ========================================================= -->
  <!-- 🌐 OPEN GRAPH -->
  <!-- ========================================================= -->
  <meta property="og:type" content="website" />
  <meta property="og:url" content="https://www.munchico.com/products" />
  <meta property="og:site_name" content="MUNCHICO" />
  <meta property="og:title" content="ALL PRODUCTS – MUNCHICO | Premium Dried Fruits & Nuts Online Store" />
  <meta property="og:description" content="Browse our complete collection of premium dried fruits, nuts, and healthy snacks." />
  <meta property="og:image" content="https://www.munchico.com/assets/images/og-image-products.jpg" />
  <meta property="og:image:width" content="1200" />
  <meta property="og:image:height" content="630" />
  <meta property="og:image:alt" content="MUNCHICO - All Products Collection" />
  <meta property="og:locale" content="en_US" />

  <!-- ========================================================= -->
  <!-- 🐦 TWITTER CARD META -->
  <!-- ========================================================= -->
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:url" content="https://www.munchico.com/products" />
  <meta name="twitter:title" content="ALL PRODUCTS – MUNCHICO | Premium Dried Fruits & Nuts Online Store" />
  <meta name="twitter:description" content="Browse our complete collection of premium dried fruits, nuts, and healthy snacks." />
  <meta name="twitter:image" content="https://www.munchico.com/assets/images/twitter-card-products.jpg" />
  <meta name="twitter:image:alt" content="MUNCHICO - All Products Collection" />
  <meta name="twitter:site" content="@munchico" />
  <meta name="twitter:creator" content="@munchico" />

  <!-- ========================================================= -->
  <!-- 🔖 FAVICONS & APP ICONS -->
  <!-- ========================================================= -->
  <link rel="icon" type="image/x-icon" href="assets/images/favicon.ico" />
  <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon-16x16.png" />
  <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicon-32x32.png" />
  <link rel="icon" type="image/png" sizes="192x192" href="assets/images/android-chrome-192x192.png" />
  <link rel="icon" type="image/png" sizes="512x512" href="assets/images/android-chrome-512x512.png" />
  <link rel="apple-touch-icon" sizes="180x180" href="assets/images/apple-touch-icon.png" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- ========================================================= -->
  <!-- 📱 PWA & WINDOWS META -->
  <!-- ========================================================= -->
  <link rel="manifest" href="site.webmanifest" />
  <meta name="theme-color" content="#ffffff" />
  <meta name="msapplication-TileColor" content="#ffffff" />
  <meta name="msapplication-config" content="browserconfig.xml" />

  <!-- ========================================================= -->
  <!-- 🔗 SEO LINKS -->
  <!-- ========================================================= -->
  <link rel="canonical" href="https://www.munchico.com/products" />
  <link rel="alternate" hreflang="en" href="https://www.munchico.com/products" />
  <link rel="alternate" hreflang="x-default" href="https://www.munchico.com/products" />

  <!-- ========================================================= -->
  <!-- ⚡ PERFORMANCE OPTIMIZATION -->
  <!-- ========================================================= -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link rel="dns-prefetch" href="https://www.google-analytics.com" />
  <link rel="preload" href="assets/css/main.css" as="style" />

  <!-- ========================================================= -->
  <!-- 🎨 STYLESHEETS -->
  <!-- ========================================================= -->
  <link rel="stylesheet" href="assets/css/main.css" />
  <link rel="stylesheet" href="assets/css/extra.css" />
  <link rel="stylesheet" href="assets/royalcssx/royal.css" />
  
  
  <!-- Products Page Specific Styles -->
  <style>
    :root {
      /* ==============================
         🌿 Brand Colors (Organic & Premium)
      ============================== */
      --primary-color: #8B5E3C;      /* Rich walnut brown – brand color */
      --primary-dark: #5A3E26;       /* Deep cocoa – hover, dark accents */
      --primary-light: #D7B899;      /* Almond tone – subtle highlights */
      
      --secondary-color: #4E944F;    /* Natural green – freshness & health */
      --accent-color: #E5A443;       /* Honey gold – CTA & premium touch */
      --danger-color: #C0392B;       /* Muted red – warnings/errors */

      /* ==============================
         🎨 Neutral Palette
      ============================== */
      --white: #ffffff;
      --black: #1A1A1A;
      --gray-50: #FFF8F0;            /* Warm ivory background */
      --gray-100: #FAF3E7;
      --gray-200: #EDE3D8;
      --gray-300: #D6C6B9;
      --gray-400: #BFAF9E;
      --gray-500: #9E8C7A;
      --gray-600: #7C6A57;
      --gray-700: #5B4D3F;
      --gray-800: #3B2F2F;
      --gray-900: #2A1E1A;

      /* ==============================
         📏 Spacing Scale
      ============================== */
      --space-xs: 0.25rem;
      --space-sm: 0.5rem;
      --space-md: 1rem;
      --space-lg: 1.5rem;
      --space-xl: 2rem;
      --space-2xl: 3rem;
      --space-3xl: 4rem;

      /* ==============================
         ✍️ Typography
      ============================== */
      --font-primary: 'Poppins', sans-serif;
      --font-secondary: 'Roboto', sans-serif;

      --font-size-xs: 0.75rem;
      --font-size-sm: 0.875rem;
      --font-size-base: 1rem;
      --font-size-lg: 1.125rem;
      --font-size-xl: 1.25rem;
      --font-size-2xl: 1.5rem;
      --font-size-3xl: 2rem;

      /* ==============================
         🔲 Border Radius
      ============================== */
      --radius-sm: 0.25rem;
      --radius-md: 0.5rem;
      --radius-lg: 0.75rem;
      --radius-xl: 1rem;
      --radius-full: 9999px;

      /* ==============================
         🌤️ Shadows
      ============================== */
      --shadow-sm: 0 1px 2px 0 rgba(91, 77, 63, 0.1);
      --shadow-md: 0 4px 6px -1px rgba(91, 77, 63, 0.15);
      --shadow-lg: 0 10px 15px -3px rgba(91, 77, 63, 0.2);
      --shadow-xl: 0 20px 25px -5px rgba(91, 77, 63, 0.25);

      /* ==============================
         📦 Layout
      ============================== */
      --container-width: 1280px;
      --container-padding: var(--space-lg);

      /* ==============================
         ⚡ Transitions
      ============================== */
      --transition-fast: 150ms ease-in-out;
      --transition-base: 250ms ease-in-out;
      --transition-slow: 350ms ease-in-out;
    }

    /* Products Page Layout */
    .products-page {
      padding: var(--space-2xl) 0;
      background-color: var(--gray-50);
      min-height: 80vh;
    }

    .products-header {
      text-align: center;
      margin-bottom: var(--space-2xl);
      padding: 0 var(--container-padding);
    }

    .products-header h1 {
      font-size: var(--font-size-3xl);
      color: var(--primary-dark);
      margin-bottom: var(--space-sm);
    }

    .products-header p {
      font-size: var(--font-size-lg);
      color: var(--gray-600);
      max-width: 600px;
      margin: 0 auto;
    }

    .products-container {
      max-width: var(--container-width);
      margin: 0 auto;
      padding: 0 var(--container-padding);
      display: flex;
      gap: var(--space-xl);
    }

    /* Categories Sidebar */
    .categories-sidebar {
      flex: 0 0 280px;
      background: var(--white);
      border-radius: var(--radius-lg);
      padding: var(--space-lg);
      box-shadow: var(--shadow-md);
      height: fit-content;
      position: sticky;
      top: 100px;
    }

    .categories-sidebar h3 {
      color: var(--primary-dark);
      margin-bottom: var(--space-lg);
      padding-bottom: var(--space-sm);
      border-bottom: 2px solid var(--primary-light);
    }

    .categories-list {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .categories-list li {
      margin-bottom: var(--space-sm);
    }

    .categories-list a {
      display: flex;
      align-items: center;
      padding: var(--space-sm) var(--space-md);
      color: var(--gray-700);
      text-decoration: none;
      border-radius: var(--radius-md);
      transition: all var(--transition-base);
    }

    .categories-list a:hover,
    .categories-list a.active {
      background-color: var(--primary-light);
      color: var(--primary-dark);
    }

    .category-icon {
      margin-right: var(--space-sm);
      width: 20px;
      text-align: center;
    }

    .category-count {
      margin-left: auto;
      background: var(--gray-200);
      color: var(--gray-600);
      padding: 2px 8px;
      border-radius: var(--radius-full);
      font-size: var(--font-size-xs);
    }

    /* Products Grid */
    .products-grid-section {
      flex: 1;
    }

    .products-controls {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: var(--space-lg);
      flex-wrap: wrap;
      gap: var(--space-md);
    }

    .products-count {
      color: var(--gray-600);
      font-size: var(--font-size-sm);
    }

    .view-options {
      display: flex;
      gap: var(--space-sm);
    }

    .view-btn {
      background: var(--white);
      border: 1px solid var(--gray-300);
      padding: var(--space-sm) var(--space-md);
      border-radius: var(--radius-md);
      cursor: pointer;
      transition: all var(--transition-fast);
    }

    .view-btn.active {
      background: var(--primary-color);
      color: var(--white);
      border-color: var(--primary-color);
    }

    .sort-select {
      padding: var(--space-sm) var(--space-md);
      border: 1px solid var(--gray-300);
      border-radius: var(--radius-md);
      background: var(--white);
      color: var(--gray-700);
    }

    /* Grid Layouts */
    .products-grid {
      display: grid;
      gap: var(--space-lg);
    }

    .grid-4-col {
      grid-template-columns: repeat(4, 1fr);
    }

    .grid-3-col {
      grid-template-columns: repeat(3, 1fr);
    }

    .grid-2-col {
      grid-template-columns: repeat(2, 1fr);
    }

    .grid-1-col {
      grid-template-columns: 1fr;
    }

    /* Product Card */
    .product-card {
      background: var(--white);
      border-radius: var(--radius-lg);
      overflow: hidden;
      box-shadow: var(--shadow-sm);
      transition: all var(--transition-base);
      position: relative;
    }

    .product-card:hover {
      transform: translateY(-5px);
      box-shadow: var(--shadow-lg);
    }

    .product-badges {
      position: absolute;
      top: var(--space-sm);
      left: var(--space-sm);
      display: flex;
      flex-direction: column;
      gap: var(--space-xs);
      z-index: 2;
    }

    .badge {
      padding: 4px 8px;
      border-radius: var(--radius-sm);
      font-size: var(--font-size-xs);
      font-weight: 600;
      text-transform: uppercase;
    }

    .badge-new {
      background: var(--secondary-color);
      color: var(--white);
    }

    .badge-hot {
      background: var(--danger-color);
      color: var(--white);
    }

    .badge-sale {
      background: var(--accent-color);
      color: var(--white);
    }

    .badge-featured {
      background: var(--primary-color);
      color: var(--white);
    }

    .product-image {
      position: relative;
      height: 200px;
      overflow: hidden;
    }

    .product-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform var(--transition-slow);
    }

    .product-card:hover .product-image img {
      transform: scale(1.05);
    }

    .product-info {
      padding: var(--space-lg);
    }

    .product-category {
      color: var(--gray-500);
      font-size: var(--font-size-sm);
      margin-bottom: var(--space-xs);
    }

    .product-title {
      font-size: var(--font-size-lg);
      color: var(--gray-800);
      margin-bottom: var(--space-sm);
      line-height: 1.3;
    }

    .product-title a {
      color: inherit;
      text-decoration: none;
    }

    .product-title a:hover {
      color: var(--primary-color);
    }

    .product-rating {
      display: flex;
      align-items: center;
      margin-bottom: var(--space-md);
    }

    .stars {
      color: var(--accent-color);
      margin-right: var(--space-sm);
    }

    .rating-count {
      color: var(--gray-500);
      font-size: var(--font-size-sm);
    }

    .product-price {
      display: flex;
      align-items: center;
      gap: var(--space-sm);
      margin-bottom: var(--space-lg);
    }

    .current-price {
      font-size: var(--font-size-xl);
      font-weight: 600;
      color: var(--primary-dark);
    }

    .original-price {
      font-size: var(--font-size-base);
      color: var(--gray-500);
      text-decoration: line-through;
    }

    .discount {
      background: var(--accent-color);
      color: var(--white);
      padding: 2px 6px;
      border-radius: var(--radius-sm);
      font-size: var(--font-size-xs);
      font-weight: 600;
    }

    .product-actions {
      display: flex;
      gap: var(--space-sm);
    }

    .btn {
      flex: 1;
      padding: var(--space-sm);
      border: none;
      border-radius: var(--radius-md);
      font-weight: 600;
      cursor: pointer;
      transition: all var(--transition-fast);
      text-align: center;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: var(--space-xs);
    }

    .btn-primary {
      background: var(--primary-color);
      color: var(--white);
    }

    .btn-primary:hover {
      background: var(--primary-dark);
    }

    .btn-secondary {
      background: var(--gray-200);
      color: var(--gray-700);
    }

    .btn-secondary:hover {
      background: var(--gray-300);
    }

    /* List View */
    .list-view .product-card {
      display: flex;
      height: 200px;
    }

    .list-view .product-image {
      flex: 0 0 200px;
      height: 100%;
    }

    .list-view .product-info {
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .list-view .product-actions {
      justify-content: flex-start;
    }

    .list-view .btn {
      flex: 0 1 auto;
    }

    /* Pagination */
    .pagination {
      display: flex;
      justify-content: center;
      margin-top: var(--space-2xl);
      gap: var(--space-sm);
    }

    .pagination a,
    .pagination span {
      padding: var(--space-sm) var(--space-md);
      border: 1px solid var(--gray-300);
      border-radius: var(--radius-md);
      text-decoration: none;
      color: var(--gray-700);
      transition: all var(--transition-fast);
    }

    .pagination a:hover,
    .pagination .current {
      background: var(--primary-color);
      color: var(--white);
      border-color: var(--primary-color);
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
      .grid-4-col {
        grid-template-columns: repeat(3, 1fr);
      }
      
      .categories-sidebar {
        flex: 0 0 240px;
      }
    }

    @media (max-width: 768px) {
      .products-container {
        flex-direction: column;
      }
      
      .categories-sidebar {
        position: static;
        margin-bottom: var(--space-lg);
      }
      
      .grid-4-col,
      .grid-3-col {
        grid-template-columns: repeat(2, 1fr);
      }
      
      .products-controls {
        flex-direction: column;
        align-items: stretch;
      }
      
      .view-options {
        justify-content: center;
      }
    }

    @media (max-width: 640px) {
      .grid-4-col,
      .grid-3-col,
      .grid-2-col {
        grid-template-columns: 1fr;
      }
      
      .list-view .product-card {
        flex-direction: column;
        height: auto;
      }
      
      .list-view .product-image {
        flex: 0 0 200px;
      }
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
  <!-- 🛍️ PRODUCTS PAGE CONTENT -->
  <!-- ========================================================= -->
  <main class="products-page">
    <!-- Products Page Header -->
    <div class="products-header">
      <h1>All Products</h1>
      <p>Discover our premium selection of dried fruits and nuts</p>
    </div>

    <!-- Products Container -->
    <div class="products-container">
      <!-- Categories Sidebar -->
      <aside class="categories-sidebar">
        <h3>Categories</h3>
        <ul class="categories-list">
          <?php
          // Fetch categories from database using MySQLi
          $categories_query = "SELECT id, category_name, category_slug, icon_class, 
                              (SELECT COUNT(*) FROM products WHERE category_id = categories.id AND is_active = 1) as product_count
                              FROM categories 
                              WHERE is_active = 1 AND parent_category_id IS NULL
                              ORDER BY display_order ASC";
          $categories_result = $conn->query($categories_query);
          
          $current_category = isset($_GET['category']) ? $_GET['category'] : '';
          
          // All categories item
          $all_active = ($current_category == '') ? 'active' : '';
          $all_count_query = "SELECT COUNT(*) as total FROM products WHERE is_active = 1";
          $all_count_result = $conn->query($all_count_query);
          $all_count = $all_count_result->fetch_assoc();
          
          echo '<li><a href="products.php" class="' . $all_active . '">';
          echo '<span class="category-icon"><i class="fas fa-th-large"></i></span>';
          echo 'All Products';
          echo '<span class="category-count">' . $all_count['total'] . '</span>';
          echo '</a></li>';
          
          // Category items
          if ($categories_result && $categories_result->num_rows > 0) {
            while($category = $categories_result->fetch_assoc()) {
              $active = ($current_category == $category['category_slug']) ? 'active' : '';
              $icon = $category['icon_class'] ? $category['icon_class'] : 'fas fa-folder';
              
              echo '<li><a href="products.php?category=' . $category['category_slug'] . '" class="' . $active . '">';
              echo '<span class="category-icon"><i class="' . $icon . '"></i></span>';
              echo htmlspecialchars($category['category_name']);
              echo '<span class="category-count">' . $category['product_count'] . '</span>';
              echo '</a></li>';
            }
          } else {
            echo '<li><a href="#">No categories found</a></li>';
          }
          ?>
        </ul>
      </aside>

      <!-- Products Grid Section -->
      <section class="products-grid-section">
        <!-- Products Controls -->
        <div class="products-controls">
          <div class="products-count">
            <?php
            // Get product count based on category filter
            $count_query = "SELECT COUNT(*) as total FROM products WHERE is_active = 1";
            if (isset($_GET['category']) && !empty($_GET['category'])) {
              $count_query .= " AND category_id IN (SELECT id FROM categories WHERE category_slug = '" . $conn->real_escape_string($_GET['category']) . "')";
            }
            
            $count_result = $conn->query($count_query);
            $product_count = $count_result->fetch_assoc();
            
            echo 'Showing ' . $product_count['total'] . ' products';
            ?>
          </div>
          
          <div class="view-options">
            <button class="view-btn active" data-view="grid-4-col" title="4 columns">
              <i class="fas fa-th-large"></i>
            </button>
            <button class="view-btn" data-view="grid-3-col" title="3 columns">
              <i class="fas fa-th"></i>
            </button>
            <button class="view-btn" data-view="grid-2-col" title="2 columns">
              <i class="fas fa-th-list"></i>
            </button>
            <button class="view-btn" data-view="list-view" title="List view">
              <i class="fas fa-list"></i>
            </button>
          </div>
          
          <select class="sort-select" id="sort-products">
            <option value="name_asc">Name (A-Z)</option>
            <option value="name_desc">Name (Z-A)</option>
            <option value="price_asc">Price (Low to High)</option>
            <option value="price_desc">Price (High to Low)</option>
            <option value="rating_desc">Highest Rated</option>
            <option value="newest">Newest First</option>
          </select>
        </div>

        <!-- Products Grid -->
        <div class="products-grid grid-4-col" id="products-grid">
          <?php
          // Fetch products based on category filter
          $products_query = "SELECT p.*, c.category_name, c.category_slug 
                            FROM products p 
                            JOIN categories c ON p.category_id = c.id 
                            WHERE p.is_active = 1";
          
          if (isset($_GET['category']) && !empty($_GET['category'])) {
            $products_query .= " AND c.category_slug = '" . $conn->real_escape_string($_GET['category']) . "'";
          }
          
          // Add sorting (default by name ascending)
          $sort = isset($_GET['sort']) ? $_GET['sort'] : 'name_asc';
          switch($sort) {
            case 'name_desc':
              $products_query .= " ORDER BY p.product_name DESC";
              break;
            case 'price_asc':
              $products_query .= " ORDER BY p.sale_price IS NOT NULL, COALESCE(p.sale_price, p.regular_price) ASC";
              break;
            case 'price_desc':
              $products_query .= " ORDER BY p.sale_price IS NOT NULL, COALESCE(p.sale_price, p.regular_price) DESC";
              break;
            case 'rating_desc':
              $products_query .= " ORDER BY p.rating DESC, p.review_count DESC";
              break;
            case 'newest':
              $products_query .= " ORDER BY p.created_at DESC";
              break;
            default:
              $products_query .= " ORDER BY p.product_name ASC";
          }
          
          $products_result = $conn->query($products_query);
          
          if ($products_result && $products_result->num_rows > 0) {
            while($product = $products_result->fetch_assoc()) {
              // Calculate discount percentage
              $discount_percentage = 0;
              if ($product['sale_price'] && $product['regular_price'] > 0) {
                $discount_percentage = round((($product['regular_price'] - $product['sale_price']) / $product['regular_price']) * 100);
              }
              
              // Determine current price
              $current_price = $product['sale_price'] ? $product['sale_price'] : $product['regular_price'];
              
              // Generate stars for rating
              $rating_stars = '';
              $full_stars = floor($product['rating']);
              $half_star = ($product['rating'] - $full_stars) >= 0.5;
              
              for ($i = 1; $i <= 5; $i++) {
                if ($i <= $full_stars) {
                  $rating_stars .= '<i class="fas fa-star"></i>';
                } elseif ($half_star && $i == $full_stars + 1) {
                  $rating_stars .= '<i class="fas fa-star-half-alt"></i>';
                } else {
                  $rating_stars .= '<i class="far fa-star"></i>';
                }
              }
              
              echo '<div class="product-card">';
              
              // Product badges
              echo '<div class="product-badges">';
              if ($product['badge_new']) {
                echo '<span class="badge badge-new">New</span>';
              }
              if ($product['badge_hot']) {
                echo '<span class="badge badge-hot">Hot</span>';
              }
              if ($product['badge_sale'] && $product['sale_price']) {
                echo '<span class="badge badge-sale">Sale</span>';
              }
              if ($product['badge_featured']) {
                echo '<span class="badge badge-featured">Featured</span>';
              }
              echo '</div>';
              
        // Product image
echo '<div class="product-image">';
echo '<a href="product-details.php?id=' . $product['id'] . '" class="product-image-link">';
// Correct relative path from products.php to rc-admin/uploads/products/
$imagePath = '';
if (!empty($product['main_image'])) {
    // Go up 1 level: from products.php to root, then to rc-admin/uploads/products/
    $imagePath = '../rc-admin/uploads/products/' . basename($product['main_image']);
} else {
    // Default placeholder image
    $imagePath = '../assets/images/placeholder-product.jpg';
}
echo '<img src="' . htmlspecialchars($imagePath) . '" 
          alt="' . htmlspecialchars($product['product_name']) . '"
          onerror="this.src=\'../assets/images/placeholder-product.jpg\';" />';
echo '</a>';
echo '</div>';
              
              // Product info
              echo '<div class="product-info">';
              echo '<div class="product-category">' . htmlspecialchars($product['category_name']) . '</div>';
              echo '<h3 class="product-title"><a href="product-details.php?slug=' . $product['product_slug'] . '">' . htmlspecialchars($product['product_name']) . '</a></h3>';
              
              // Rating
              echo '<div class="product-rating">';
              echo '<div class="stars">' . $rating_stars . '</div>';
              echo '<div class="rating-count">(' . $product['review_count'] . ')</div>';
              echo '</div>';
              
              // Price
              echo '<div class="product-price">';
              echo '<span class="current-price">$' . number_format($current_price, 2) . '</span>';
              if ($product['sale_price']) {
                echo '<span class="original-price">$' . number_format($product['regular_price'], 2) . '</span>';
                echo '<span class="discount">-' . $discount_percentage . '%</span>';
              }
              echo '</div>';
              
              // Actions
              echo '<div class="product-actions">';
              echo '<button class="btn btn-secondary" onclick="addToWishlist(' . $product['id'] . ')"><i class="far fa-heart"></i></button>';
              echo '<button class="btn btn-primary" onclick="addToCart(' . $product['id'] . ')"><i class="fas fa-shopping-cart"></i> Add to Cart</button>';
              echo '</div>';
              
              echo '</div>'; // .product-info
              echo '</div>'; // .product-card
            }
          } else {
            echo '<div class="no-products">';
            echo '<p>No products found in this category.</p>';
            echo '</div>';
          }
          ?>
        </div>

        <!-- Pagination (if needed in future) -->
        <!-- <div class="pagination">
          <a href="#" class="prev">Previous</a>
          <a href="#" class="current">1</a>
          <a href="#">2</a>
          <a href="#">3</a>
          <a href="#" class="next">Next</a>
        </div> -->
      </section>
    </div>
  </main>

  <!-- ========================================================= -->
  <!-- 📱 MOBILE DOCKER -->
  <!-- ========================================================= -->
  <?php include 'includes/mobile-docker.php' ?>

  <!-- ========================================================= -->
  <!-- 🦶 FOOTER SECTION -->
  <!-- ========================================================= -->
  <?php include 'includes/footer.php' ?>
  
  <!-- ========================================================= -->
  <!-- 🔝 BACK TO TOP BUTTON -->
  <!-- ========================================================= -->
  <?php include 'includes/components/top-to-bottom/index.php' ?>

  <!-- ========================================================= -->
  <!-- ⚡ JAVASCRIPT FILES -->
  <!-- ========================================================= -->
  <script src="assets/js/royal-css-initialization.js"></script>
  <script src="assets/js/main.js"></script>
  <script src="assets/royalcssx/royal.js"></script>
  
  <!-- Products Page JavaScript -->
  <!-- Products Page JavaScript -->
<script>
    // View options functionality
    document.addEventListener('DOMContentLoaded', function() {
        const viewButtons = document.querySelectorAll('.view-btn');
        const productsGrid = document.getElementById('products-grid');
        const sortSelect = document.getElementById('sort-products');
        
        // Set current sort option
        const urlParams = new URLSearchParams(window.location.search);
        const currentSort = urlParams.get('sort') || 'name_asc';
        sortSelect.value = currentSort;
        
        // View buttons event listeners
        viewButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                viewButtons.forEach(btn => btn.classList.remove('active'));
                
                // Add active class to clicked button
                this.classList.add('active');
                
                // Get the view type
                const viewType = this.getAttribute('data-view');
                
                // Update grid classes
                productsGrid.className = 'products-grid';
                
                if (viewType === 'list-view') {
                    productsGrid.classList.add('list-view');
                } else {
                    productsGrid.classList.add(viewType);
                }
            });
        });
        
        // Sort functionality
        sortSelect.addEventListener('change', function() {
            const selectedSort = this.value;
            const currentUrl = new URL(window.location);
            
            if (selectedSort === 'name_asc') {
                currentUrl.searchParams.delete('sort');
            } else {
                currentUrl.searchParams.set('sort', selectedSort);
            }
            
            window.location.href = currentUrl.toString();
        });
    });
    
    // Add to cart function
    async function addToCart(productId) {
        try {
            const response = await fetch('../ajax/add_to_cart.php', {
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
                // Show success message
                showNotification('Product added to cart!', 'success');
                // Update cart count in navbar if needed
                updateCartCount(result.cart_count);
            } else {
                showNotification(result.message, 'error');
            }
        } catch (error) {
            console.error('Error adding to cart:', error);
            showNotification('Error adding product to cart', 'error');
        }
    }
    
    // Toggle wishlist function
    async function addToWishlist(productId) {
        try {
            const response = await fetch('../ajax/toggle_wishlist.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    product_id: productId
                })
            });

            const result = await response.json();
            
            if (result.success) {
                const message = result.action === 'added' ? 
                    'Product added to wishlist!' : 
                    'Product removed from wishlist!';
                showNotification(message, 'success');
            } else {
                showNotification(result.message, 'error');
            }
        } catch (error) {
            console.error('Error toggling wishlist:', error);
            showNotification('Error updating wishlist', 'error');
        }
    }
    
    // Update cart count in navbar
    async function updateCartCount(count) {
        // If you have a cart count element in navbar, update it here
        const cartCountElement = document.querySelector('.cart-count');
        if (cartCountElement) {
            cartCountElement.textContent = count;
        }
    }
    
    // Notification function
    function showNotification(message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = `
            <span>${message}</span>
            <button onclick="this.parentElement.remove()">&times;</button>
        `;
        
        // Add styles for notification
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 12px 20px;
            background: ${type === 'success' ? '#4E944F' : type === 'error' ? '#C0392B' : '#8B5E3C'};
            color: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 10000;
            display: flex;
            align-items: center;
            gap: 10px;
            max-width: 300px;
            animation: slideIn 0.3s ease-out;
        `;
        
        // Add close button styles
        notification.querySelector('button').style.cssText = `
            background: none;
            border: none;
            color: white;
            font-size: 18px;
            cursor: pointer;
            padding: 0;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        `;
        
        document.body.appendChild(notification);
        
        // Auto remove after 3 seconds
        setTimeout(() => {
            if (notification.parentElement) {
                notification.remove();
            }
        }, 3000);
    }
</script>
</body>
</html>
<?php
// Close database connection
$conn->close();
?>