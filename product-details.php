<?php
session_start();
require_once 'config/database.php';

// Get product ID from URL
$product_id = $_GET['id'] ?? 0;

// Fetch product details from database
$database = new Database();
$conn = $database->getConnection();

$query = "SELECT p.*, c.category_name, c.category_slug, 
                 parent.category_name as parent_category_name,
                 parent.category_slug as parent_category_slug
          FROM products p 
          INNER JOIN categories c ON p.category_id = c.id 
          LEFT JOIN categories parent ON c.parent_category_id = parent.id
          WHERE p.id = ? AND p.is_active = 1";

$stmt = $conn->prepare($query);
$stmt->execute([$product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

// If product not found, redirect to 404
if (!$product) {
    header("Location: 404.php");
    exit;
}

// Fix image paths
$main_image_path = '../../../rc-admin/uploads/products/' . basename($product['main_image']);
$gallery_images = [];
if (!empty($product['gallery_images'])) {
    $images = explode(',', $product['gallery_images']);
    foreach ($images as $image) {
        $gallery_images[] = '../../../rc-admin/uploads/products/' . basename(trim($image));
    }
}

// Fetch related products
$related_query = "SELECT p.* 
                 FROM products p 
                 WHERE p.category_id = ? 
                 AND p.id != ? 
                 AND p.is_active = 1 
                 ORDER BY p.created_at DESC 
                 LIMIT 4";
$related_stmt = $conn->prepare($related_query);
$related_stmt->execute([$product['category_id'], $product_id]);
$related_products = $related_stmt->fetchAll(PDO::FETCH_ASSOC);

// Calculate discount percentage if sale price exists
$discount_percentage = 0;
if ($product['sale_price'] && $product['sale_price'] < $product['regular_price']) {
    $discount_percentage = round((($product['regular_price'] - $product['sale_price']) / $product['regular_price']) * 100);
}

// Generate stars for rating
function generateStars($rating) {
    $fullStars = floor($rating);
    $halfStar = ($rating - $fullStars) >= 0.5;
    $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
    
    $stars = '';
    for ($i = 1; $i <= 5; $i++) {
        if ($i <= $fullStars) {
            $stars .= '<span class="star filled">★</span>';
        } else if ($i == $fullStars + 1 && $halfStar) {
            $stars .= '<span class="star half">★</span>';
        } else {
            $stars .= '<span class="star">☆</span>';
        }
    }
    
    return $stars;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  
  <title><?php echo htmlspecialchars($product['product_name']); ?> – MUNCHICO | Premium Dried Fruits & Nuts Online Store</title>
  <meta name="description" content="<?php echo htmlspecialchars($product['short_description']); ?>" />
  <meta name="keywords" content="<?php echo htmlspecialchars($product['meta_keywords'] ?? $product['product_name'] . ', ' . $product['category_name']); ?>" />
  <meta name="author" content="MUNCHICO" />
  <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1" />

  <!-- Open Graph Meta -->
  <meta property="og:type" content="product" />
  <meta property="og:url" content="https://www.munchico.com/product-details.php?id=<?php echo $product_id; ?>" />
  <meta property="og:site_name" content="MUNCHICO" />
  <meta property="og:title" content="<?php echo htmlspecialchars($product['product_name']); ?>" />
  <meta property="og:description" content="<?php echo htmlspecialchars($product['short_description']); ?>" />
  <meta property="og:image" content="https://www.munchico.com/<?php echo $main_image_path; ?>" />
  <meta property="og:image:width" content="1200" />
  <meta property="og:image:height" content="630" />
  <meta property="og:image:alt" content="<?php echo htmlspecialchars($product['product_name']); ?>" />
  <meta property="og:locale" content="en_US" />
  <meta property="product:price:amount" content="<?php echo $product['sale_price'] ?? $product['regular_price']; ?>" />
  <meta property="product:price:currency" content="USD" />

  <!-- Twitter Card Meta -->
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:url" content="https://www.munchico.com/product-details.php?id=<?php echo $product_id; ?>" />
  <meta name="twitter:title" content="<?php echo htmlspecialchars($product['product_name']); ?>" />
  <meta name="twitter:description" content="<?php echo htmlspecialchars($product['short_description']); ?>" />
  <meta name="twitter:image" content="https://www.munchico.com/<?php echo $main_image_path; ?>" />
  <meta name="twitter:image:alt" content="<?php echo htmlspecialchars($product['product_name']); ?>" />
  <meta name="twitter:site" content="@munchico" />
  <meta name="twitter:creator" content="@munchico" />

  <!-- Favicons -->
  <link rel="icon" type="image/x-icon" href="assets/images/favicon.ico" />
  <link rel="apple-touch-icon" sizes="180x180" href="assets/images/apple-touch-icon.png" />

  <!-- PWA -->
  <link rel="manifest" href="site.webmanifest" />
  <meta name="theme-color" content="#ffffff" />

  <!-- SEO Links -->
  <link rel="canonical" href="https://www.munchico.com/product-details.php?id=<?php echo $product_id; ?>" />

  <!-- Performance -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />

  <!-- Structured Data -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "Product",
    "name": "<?php echo htmlspecialchars($product['product_name']); ?>",
    "description": "<?php echo htmlspecialchars($product['short_description']); ?>",
    "image": "https://www.munchico.com/<?php echo $main_image_path; ?>",
    "sku": "<?php echo $product['id']; ?>",
    "brand": {
      "@type": "Brand",
      "name": "MUNCHICO"
    },
    "offers": {
      "@type": "Offer",
      "url": "https://www.munchico.com/product-details.php?id=<?php echo $product_id; ?>",
      "priceCurrency": "USD",
      "price": "<?php echo $product['sale_price'] ?? $product['regular_price']; ?>",
      "availability": "https://schema.org/InStock",
      "seller": {
        "@type": "Organization",
        "name": "MUNCHICO"
      }
    },
    "aggregateRating": {
      "@type": "AggregateRating",
      "ratingValue": "<?php echo $product['rating']; ?>",
      "reviewCount": "<?php echo $product['review_count']; ?>"
    }
  }
  </script>

  <!-- Stylesheets -->
  <link rel="stylesheet" href="assets/css/main.css" />
  <link rel="stylesheet" href="assets/css/extra.css" />
  <link rel="stylesheet" href="assets/royalcssx/royal.css" />
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
      object-fit: contain;
      display: block;
      background: var(--gray-50);
    }

    .discount-badge, .new-badge, .featured-badge {
      position: absolute;
      top: var(--space-lg);
      padding: var(--space-sm) var(--space-md);
      border-radius: var(--radius-full);
      font-size: var(--font-size-sm);
      font-weight: 700;
      color: var(--white);
      z-index: 2;
    }

    .discount-badge {
      right: var(--space-lg);
      background: var(--danger-color);
    }

    .new-badge {
      left: var(--space-lg);
      background: var(--success-color);
    }

    .featured-badge {
      left: var(--space-lg);
      background: var(--primary-color);
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
      color: var(--gray-300);
      font-size: var(--font-size-lg);
    }

    .star.filled {
      color: var(--accent-color);
    }

    .star.half {
      background: linear-gradient(90deg, var(--accent-color) 50%, var(--gray-300) 50%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
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
      background: var(--success-color);
      color: var(--white);
    }

    .stock-status.out-of-stock {
      background: var(--danger-color);
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
      background: var(--primary-color);
      color: var(--white);
    }

    .primary-btn:hover {
      background: var(--primary-dark);
      transform: translateY(-2px);
      box-shadow: var(--shadow-lg);
    }

    .secondary-btn {
      background: var(--accent-color);
      color: var(--white);
    }

    .secondary-btn:hover {
      background: #D89533;
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

    /* Specifications */
    .specifications {
      display: flex;
      flex-direction: column;
      gap: var(--space-md);
    }

    .spec-row {
      display: flex;
      justify-content: space-between;
      padding: var(--space-md);
      border-bottom: 1px solid var(--gray-200);
    }

    .spec-row:last-child {
      border-bottom: none;
    }

    .spec-label {
      font-weight: 600;
      color: var(--gray-700);
    }

    .spec-value {
      color: var(--gray-600);
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

    /* Shipping Info */
    .shipping-info h4 {
      margin: var(--space-lg) 0 var(--space-md) 0;
      color: var(--gray-800);
    }

    .shipping-info ul {
      list-style: none;
      padding: 0;
    }

    .shipping-info li {
      padding: var(--space-xs) 0;
      color: var(--gray-700);
      position: relative;
      padding-left: var(--space-lg);
    }

    .shipping-info li:before {
      content: "•";
      color: var(--primary-color);
      position: absolute;
      left: 0;
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

    .related-product-card {
      background: var(--white);
      border-radius: var(--radius-lg);
      overflow: hidden;
      box-shadow: var(--shadow-md);
      transition: var(--transition-base);
    }

    .related-product-card:hover {
      transform: translateY(-4px);
      box-shadow: var(--shadow-lg);
    }

    .related-product-card .product-image {
      position: relative;
      height: 200px;
      overflow: hidden;
    }

    .related-product-card .product-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .product-badge {
      position: absolute;
      top: var(--space-md);
      left: var(--space-md);
      padding: var(--space-xs) var(--space-sm);
      border-radius: var(--radius-full);
      font-size: var(--font-size-xs);
      font-weight: 600;
      color: var(--white);
    }

    .product-badge.new {
      background: var(--success-color);
    }

    .related-product-card .product-info {
      padding: var(--space-lg);
    }

    .related-product-card .product-name {
      font-size: var(--font-size-lg);
      font-weight: 600;
      color: var(--gray-900);
      margin-bottom: var(--space-sm);
    }

    .related-product-card .product-price {
      display: flex;
      align-items: center;
      gap: var(--space-sm);
      margin-bottom: var(--space-md);
    }

    .related-product-card .current-price {
      font-size: var(--font-size-xl);
      font-weight: 700;
      color: var(--primary-color);
    }

    .related-product-card .original-price {
      font-size: var(--font-size-md);
      color: var(--gray-500);
      text-decoration: line-through;
    }

    .view-product-btn {
      display: block;
      width: 100%;
      padding: var(--space-md);
      background: var(--primary-color);
      color: var(--white);
      text-align: center;
      text-decoration: none;
      border-radius: var(--radius-md);
      font-weight: 600;
      transition: var(--transition-fast);
    }

    .view-product-btn:hover {
      background: var(--primary-dark);
    }

    /* Toast Notification */
    .toast-message {
      position: fixed;
      top: 20px;
      right: 20px;
      padding: 12px 20px;
      color: white;
      border-radius: 4px;
      z-index: 10000;
      box-shadow: 0 2px 10px rgba(0,0,0,0.2);
      animation: slideIn 0.3s ease-out;
    }

    .toast-success {
      background: var(--success-color);
    }

    .toast-info {
      background: var(--info-color);
    }

    .toast-error {
      background: var(--danger-color);
    }

    @keyframes slideIn {
      from {
        transform: translateX(100%);
        opacity: 0;
      }
      to {
        transform: translateX(0);
        opacity: 1;
      }
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
      
      .main-image {
        height: 300px;
      }
    }
  </style>
</head>

<body>
  <!-- Preloader -->
  <?php include 'includes/components/preloader/index.php' ?>

  <!-- Navigation Bar -->
  <?php include 'includes/navbar.php' ?>

  <!-- Announcement Bar -->
  <?php include 'includes/components/announcements/index.php' ?>

  <!-- Product Details Section -->
  <section class="product-details-section">
    <!-- Breadcrumb Navigation -->
    <div class="breadcrumb-container">
      <div class="container">
        <nav class="breadcrumb">
          <a href="index.php">Home</a>
          <span class="separator">/</span>
          <a href="products.php">Products</a>
          <span class="separator">/</span>
          <?php if ($product['parent_category_slug']): ?>
          <a href="products.php?category=<?php echo $product['parent_category_slug']; ?>">
            <?php echo htmlspecialchars($product['parent_category_name']); ?>
          </a>
          <span class="separator">/</span>
          <?php endif; ?>
          <a href="products.php?category=<?php echo $product['category_slug']; ?>">
            <?php echo htmlspecialchars($product['category_name']); ?>
          </a>
          <span class="separator">/</span>
          <span class="current"><?php echo htmlspecialchars($product['product_name']); ?></span>
        </nav>
      </div>
    </div>

    <!-- Main Product Container -->
    <div class="product-details-container container">
      <!-- Product Gallery -->
      <div class="product-gallery">
        <div class="gallery-main">
          <div class="main-image-wrapper">
            <img src="<?php echo $main_image_path; ?>" 
                 alt="<?php echo htmlspecialchars($product['product_name']); ?>" 
                 class="main-image" 
                 id="main-product-image"
                 onerror="this.src='../../../assets/images/placeholder-product.jpg';">
            
            <?php if ($discount_percentage > 0): ?>
            <span class="discount-badge">-<?php echo $discount_percentage; ?>%</span>
            <?php endif; ?>
            
            <?php if ($product['badge_new']): ?>
            <span class="new-badge">NEW</span>
            <?php endif; ?>
            
            <?php if ($product['badge_featured']): ?>
            <span class="featured-badge">FEATURED</span>
            <?php endif; ?>
          </div>
          <div class="gallery-actions">
            <button class="action-btn wishlist-btn" data-product-id="<?php echo $product['id']; ?>">
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

        <?php if (!empty($gallery_images)): ?>
        <div class="gallery-thumbnails">
          <div class="thumbnail active" data-image="<?php echo $main_image_path; ?>">
            <img src="<?php echo $main_image_path; ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>">
          </div>
          <?php foreach ($gallery_images as $index => $image): ?>
          <div class="thumbnail" data-image="<?php echo $image; ?>">
            <img src="<?php echo $image; ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?> - Image <?php echo $index + 2; ?>">
          </div>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
      </div>

      <!-- Product Information -->
      <div class="product-info">
        <div class="product-header">
          <span class="product-category"><?php echo htmlspecialchars($product['category_name']); ?></span>
          <h1 class="product-title"><?php echo htmlspecialchars($product['product_name']); ?></h1>
          <div class="product-rating">
            <div class="stars">
              <?php echo generateStars($product['rating']); ?>
            </div>
            <span class="rating-value"><?php echo $product['rating']; ?></span>
            <span class="rating-count">(<?php echo $product['review_count']; ?> reviews)</span>
            <?php if ($product['enable_reviews']): ?>
            <a href="#reviews" class="see-reviews">See all reviews</a>
            <?php endif; ?>
          </div>
        </div>

        <div class="product-pricing">
          <div class="price-container">
            <span class="current-price">Rs.<?php echo number_format($product['sale_price'] ?? $product['regular_price'], 2); ?></span>
            <?php if ($product['sale_price']): ?>
            <span class="original-price">Rs.<?php echo number_format($product['regular_price'], 2); ?></span>
            <span class="discount-percent">Save <?php echo $discount_percentage; ?>%</span>
            <?php endif; ?>
          </div>
          <div class="price-note">Price includes all taxes</div>
        </div>

        <div class="product-description">
          <p><?php echo htmlspecialchars($product['short_description']); ?></p>
          
          <div class="highlight-features">
            <div class="feature">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
              </svg>
              <span>Premium Quality</span>
            </div>
            <div class="feature">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
              </svg>
              <span>Natural Ingredients</span>
            </div>
            <div class="feature">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
              </svg>
              <span>Fresh & Healthy</span>
            </div>
            <div class="feature">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
              </svg>
              <span>Carefully Packaged</span>
            </div>
          </div>
        </div>

        <!-- Product Options -->
        <div class="product-options">
          <?php if ($product['size']): ?>
          <div class="option-group">
            <label class="option-label">Size:</label>
            <div class="size-options">
              <?php
              $sizes = explode(',', $product['size']);
              foreach ($sizes as $index => $size):
                $size = trim($size);
                $price = $product['sale_price'] ?? $product['regular_price'];
                // Simple price calculation based on size
                if (strpos($size, 'kg') !== false) {
                  $multiplier = (float)str_replace('kg', '', $size);
                  $price = $product['regular_price'] * $multiplier;
                  if ($product['sale_price']) {
                    $price = $product['sale_price'] * $multiplier;
                  }
                }
              ?>
              <button class="size-option <?php echo $index === 0 ? 'active' : ''; ?>" 
                      data-size="<?php echo $size; ?>" 
                      data-price="<?php echo number_format($price, 2); ?>">
                <?php echo $size; ?>
              </button>
              <?php endforeach; ?>
            </div>
          </div>
          <?php endif; ?>

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
            <span class="stock-status <?php echo $product['stock_status'] === 'in_stock' ? 'in-stock' : 'out-of-stock'; ?>">
              <?php echo ucfirst(str_replace('_', ' ', $product['stock_status'])); ?>
            </span>
            <?php if ($product['stock_status'] === 'in_stock'): ?>
            <span class="delivery-info">Free delivery in 2-3 days</span>
            <?php endif; ?>
          </div>
          
          <div class="cart-actions">
            <button class="add-to-cart-btn primary-btn" 
                    data-product-id="<?php echo $product['id']; ?>"
                    data-product-name="<?php echo htmlspecialchars($product['product_name']); ?>"
                    data-product-price="<?php echo $product['sale_price'] ?? $product['regular_price']; ?>"
                    data-product-image="<?php echo $main_image_path; ?>">
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
            <span class="meta-value"><?php echo $product['sku'] ? htmlspecialchars($product['sku']) : 'N/A'; ?></span>
          </div>
          <div class="meta-item">
            <span class="meta-label">Category:</span>
            <span class="meta-value"><?php echo htmlspecialchars($product['category_name']); ?></span>
          </div>
          <div class="meta-item">
            <span class="meta-label">Weight:</span>
            <span class="meta-value"><?php echo $product['weight'] ? $product['weight'] . ' kg' : 'N/A'; ?></span>
          </div>
        </div>
      </div>
    </div>

    <!-- Product Tabs Section -->
    <div class="product-tabs-container container">
      <div class="tabs-navigation">
        <button class="tab-btn active" data-tab="description">Description</button>
        <button class="tab-btn" data-tab="specifications">Specifications</button>
        <?php if ($product['enable_reviews']): ?>
        <button class="tab-btn" data-tab="reviews">Reviews (<?php echo $product['review_count']; ?>)</button>
        <?php endif; ?>
        <button class="tab-btn" data-tab="shipping">Shipping & Returns</button>
      </div>

      <div class="tabs-content">
        <!-- Description Tab -->
        <div class="tab-panel active" id="description">
          <div class="tab-content">
            <h3>Product Description</h3>
            <p><?php echo nl2br(htmlspecialchars($product['full_description'] ?: 'No detailed description available.')); ?></p>
            
            <div class="description-features">
              <div class="feature-column">
                <h4>Key Features:</h4>
                <ul>
                  <li>Premium quality ingredients</li>
                  <li>Natural and healthy</li>
                  <li>Rich in nutrients</li>
                  <li>Perfect for snacking</li>
                  <li>Carefully packaged</li>
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

        <!-- Specifications Tab -->
        <div class="tab-panel" id="specifications">
          <div class="tab-content">
            <h3>Product Specifications</h3>
            <?php if ($product['specifications']): ?>
            <div class="specifications">
              <?php
              $specs = explode(',', $product['specifications']);
              foreach ($specs as $spec):
                if (trim($spec)):
                  $parts = explode(':', $spec, 2);
                  if (count($parts) === 2):
              ?>
              <div class="spec-row">
                <span class="spec-label"><?php echo trim($parts[0]); ?>:</span>
                <span class="spec-value"><?php echo trim($parts[1]); ?></span>
              </div>
              <?php
                  endif;
                endif;
              endforeach;
              ?>
            </div>
            <?php else: ?>
            <p>No specifications available for this product.</p>
            <?php endif; ?>
          </div>
        </div>

        <!-- Reviews Tab -->
        <?php if ($product['enable_reviews']): ?>
        <div class="tab-panel" id="reviews">
          <div class="tab-content">
            <h3>Customer Reviews</h3>
            <div class="reviews-summary">
              <div class="overall-rating">
                <div class="rating-score"><?php echo $product['rating']; ?></div>
                <div class="rating-stars">
                  <?php echo generateStars($product['rating']); ?>
                </div>
                <div class="rating-count">Based on <?php echo $product['review_count']; ?> reviews</div>
              </div>
              <div class="rating-bars">
                <div class="rating-bar">
                  <span class="star-label">5 stars</span>
                  <div class="bar-container">
                    <div class="bar-fill" style="width: 80%"></div>
                  </div>
                  <span class="percentage">80%</span>
                </div>
                <div class="rating-bar">
                  <span class="star-label">4 stars</span>
                  <div class="bar-container">
                    <div class="bar-fill" style="width: 15%"></div>
                  </div>
                  <span class="percentage">15%</span>
                </div>
                <div class="rating-bar">
                  <span class="star-label">3 stars</span>
                  <div class="bar-container">
                    <div class="bar-fill" style="width: 3%"></div>
                  </div>
                  <span class="percentage">3%</span>
                </div>
                <div class="rating-bar">
                  <span class="star-label">2 stars</span>
                  <div class="bar-container">
                    <div class="bar-fill" style="width: 1%"></div>
                  </div>
                  <span class="percentage">1%</span>
                </div>
                <div class="rating-bar">
                  <span class="star-label">1 star</span>
                  <div class="bar-container">
                    <div class="bar-fill" style="width: 1%"></div>
                  </div>
                  <span class="percentage">1%</span>
                </div>
              </div>
            </div>

            <div class="reviews-list">
              <div class="review-item">
                <div class="review-header">
                  <div class="reviewer-info">
                    <span class="reviewer-name">Sarah Johnson</span>
                    <div class="review-rating">
                      <?php echo generateStars(5); ?>
                    </div>
                  </div>
                  <span class="review-date">2 days ago</span>
                </div>
                <div class="review-content">
                  <p>Absolutely love this product! The quality is exceptional and it tastes amazing. Will definitely order again!</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php endif; ?>

        <!-- Shipping Tab -->
        <div class="tab-panel" id="shipping">
          <div class="tab-content">
            <h3>Shipping & Returns</h3>
            <div class="shipping-info">
              <h4>Delivery Information</h4>
              <ul>
                <li>Free standard shipping on orders over Rs.2000</li>
                <li>Express shipping available at additional cost</li>
                <li>Estimated delivery: 2-3 business days</li>
                <li>We ship nationwide</li>
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
    <?php if (!empty($related_products)): ?>
    <div class="related-products-container container">
      <div class="section-header">
        <h2>You May Also Like</h2>
        <a href="products.php?category=<?php echo $product['category_slug']; ?>" class="view-all">View All</a>
      </div>
      <div class="related-products-grid">
        <?php foreach ($related_products as $related_product): 
          $related_image_path = '../../../rc-admin/uploads/products/' . basename($related_product['main_image']);
        ?>
        <div class="related-product-card">
          <div class="product-image">
            <img src="<?php echo $related_image_path; ?>" 
                 alt="<?php echo htmlspecialchars($related_product['product_name']); ?>"
                 onerror="this.src='../../../assets/images/placeholder-product.jpg';">
            <?php if ($related_product['badge_new']): ?>
            <span class="product-badge new">NEW</span>
            <?php endif; ?>
          </div>
          <div class="product-info">
            <h3 class="product-name"><?php echo htmlspecialchars($related_product['product_name']); ?></h3>
            <div class="product-price">
              <span class="current-price">Rs.<?php echo number_format($related_product['sale_price'] ?? $related_product['regular_price'], 2); ?></span>
              <?php if ($related_product['sale_price']): ?>
              <span class="original-price">Rs.<?php echo number_format($related_product['regular_price'], 2); ?></span>
              <?php endif; ?>
            </div>
            <a href="product-details.php?id=<?php echo $related_product['id']; ?>" class="view-product-btn">View Product</a>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>
  </section>

  <!-- Mobile Docker -->
  <?php include 'includes/mobile-docker.php' ?>

  <!-- Footer -->
  <?php include 'includes/footer.php' ?>
  <?php include 'includes/components/top-to-bottom/index.php' ?>

  <!-- JavaScript -->
  <script src="assets/js/royal-css-initialization.js"></script>
  <script src="assets/js/main.js"></script>
  <script src="assets/royalcssx/royal.js"></script>

  <script>
  document.addEventListener('DOMContentLoaded', function() {
    // Image Gallery
    const thumbnails = document.querySelectorAll('.thumbnail');
    const mainImage = document.getElementById('main-product-image');
    
    thumbnails.forEach(thumb => {
      thumb.addEventListener('click', function() {
        thumbnails.forEach(t => t.classList.remove('active'));
        this.classList.add('active');
        const newImageSrc = this.getAttribute('data-image');
        mainImage.src = newImageSrc;
      });
    });

    // Size Selection
    const sizeOptions = document.querySelectorAll('.size-option');
    const currentPrice = document.querySelector('.current-price');
    
    sizeOptions.forEach(option => {
      option.addEventListener('click', function() {
        sizeOptions.forEach(opt => opt.classList.remove('active'));
        this.classList.add('active');
        const newPrice = this.getAttribute('data-price');
        currentPrice.textContent = `Rs.${newPrice}`;
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
        
        tabBtns.forEach(b => b.classList.remove('active'));
        tabPanels.forEach(p => p.classList.remove('active'));
        
        this.classList.add('active');
        document.getElementById(targetTab).classList.add('active');
      });
    });

    // Add to Cart Functionality
    const addToCartBtn = document.querySelector('.add-to-cart-btn');
    const buyNowBtn = document.querySelector('.buy-now-btn');
    
    addToCartBtn.addEventListener('click', function() {
      const productId = this.getAttribute('data-product-id');
      const productName = this.getAttribute('data-product-name');
      const productPrice = parseFloat(this.getAttribute('data-product-price'));
      const productImage = this.getAttribute('data-product-image');
      const selectedSize = document.querySelector('.size-option.active')?.getAttribute('data-size') || 'Default';
      const quantity = parseInt(quantityInput.value);
      
      const productData = {
        id: productId,
        name: productName,
        price: productPrice,
        quantity: quantity,
        size: selectedSize,
        image: productImage
      };
      
      addToCart(productData);
      showMessage('Product added to cart!', 'success');
    });
    
    buyNowBtn.addEventListener('click', function() {
      const productId = addToCartBtn.getAttribute('data-product-id');
      const productName = addToCartBtn.getAttribute('data-product-name');
      const productPrice = parseFloat(addToCartBtn.getAttribute('data-product-price'));
      const productImage = addToCartBtn.getAttribute('data-product-image');
      const selectedSize = document.querySelector('.size-option.active')?.getAttribute('data-size') || 'Default';
      const quantity = parseInt(quantityInput.value);
      
      const productData = {
        id: productId,
        name: productName,
        price: productPrice,
        quantity: quantity,
        size: selectedSize,
        image: productImage
      };
      
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
          title: document.title,
          text: 'Check out this amazing product from MUNCHICO!',
          url: window.location.href,
        });
      } else {
        navigator.clipboard.writeText(window.location.href);
        showMessage('Link copied to clipboard!', 'success');
      }
    });

    // Helper Functions
    function addToCart(product) {
      let cart = JSON.parse(localStorage.getItem('cart')) || [];
      
      const existingProductIndex = cart.findIndex(item => 
        item.id === product.id && item.size === product.size
      );
      
      if (existingProductIndex > -1) {
        cart[existingProductIndex].quantity += product.quantity;
      } else {
        cart.push(product);
      }
      
      localStorage.setItem('cart', JSON.stringify(cart));
      updateCartCount();
    }
    
    function toggleWishlist(productId) {
      let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
      const productIndex = wishlist.findIndex(id => id === productId);
      
      if (productIndex > -1) {
        wishlist.splice(productIndex, 1);
        wishlistBtn.innerHTML = `
          <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
          </svg>
          Add to Wishlist
        `;
        showMessage('Removed from wishlist', 'info');
      } else {
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
      
      const cartCountElements = document.querySelectorAll('.cart-count');
      cartCountElements.forEach(element => {
        element.textContent = totalItems;
        element.style.display = totalItems > 0 ? 'flex' : 'none';
      });
    }
    
    function showMessage(message, type) {
      const toast = document.createElement('div');
      toast.className = `toast-message toast-${type}`;
      toast.textContent = message;
      
      document.body.appendChild(toast);
      
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
</body>
</html>