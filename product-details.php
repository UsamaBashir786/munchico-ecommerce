<?php
session_start();

// Database connection
$host = "localhost";
$db_name = "munchico_db";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get product ID from URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch product details
$product_query = "SELECT p.*, c.category_name, c.category_slug 
                  FROM products p 
                  JOIN categories c ON p.category_id = c.id 
                  WHERE p.id = ? AND p.is_active = 1";
$stmt = $conn->prepare($product_query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$product_result = $stmt->get_result();
$product = $product_result->fetch_assoc();

if (!$product) {
    // Product not found
    header("Location: products.php");
    exit();
}

// Fetch related products (same category)
$related_query = "SELECT id, product_name, product_slug, main_image, regular_price, sale_price, rating 
                  FROM products 
                  WHERE category_id = ? AND id != ? AND is_active = 1 
                  LIMIT 4";
$stmt_related = $conn->prepare($related_query);
$stmt_related->bind_param("ii", $product['category_id'], $product_id);
$stmt_related->execute();
$related_products = $stmt_related->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['product_name']); ?> - MUNCHICO</title>
    
    <!-- Include your existing CSS files -->
    <link rel="stylesheet" href="assets/css/main.css" />
    <link rel="stylesheet" href="assets/css/extra.css" />
    <link rel="stylesheet" href="assets/royalcssx/royal.css" />
    
    <style>
        .product-details-page {
            padding: var(--space-2xl) 0;
            background-color: var(--gray-50);
            min-height: 80vh;
        }
        
        .product-container {
            max-width: var(--container-width);
            margin: 0 auto;
            padding: 0 var(--container-padding);
        }
        
        .product-breadcrumb {
            margin-bottom: var(--space-lg);
            color: var(--gray-600);
        }
        
        .product-breadcrumb a {
            color: var(--primary-color);
            text-decoration: none;
        }
        
        .product-breadcrumb a:hover {
            text-decoration: underline;
        }
        
        .product-detail {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: var(--space-2xl);
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: var(--space-2xl);
            box-shadow: var(--shadow-md);
            margin-bottom: var(--space-2xl);
        }
        
        .product-gallery {
            position: relative;
        }
        
        .main-image {
            width: 100%;
            border-radius: var(--radius-lg);
            overflow: hidden;
        }
        
        .main-image img {
            width: 100%;
            height: 400px;
            object-fit: cover;
        }
        
        .gallery-thumbnails {
            display: flex;
            gap: var(--space-sm);
            margin-top: var(--space-md);
        }
        
        .thumbnail {
            width: 80px;
            height: 80px;
            border-radius: var(--radius-md);
            overflow: hidden;
            cursor: pointer;
            border: 2px solid transparent;
        }
        
        .thumbnail.active {
            border-color: var(--primary-color);
        }
        
        .thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .product-info {
            padding: var(--space-lg);
        }
        
        .product-category {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: var(--space-sm);
        }
        
        .product-title {
            font-size: var(--font-size-3xl);
            color: var(--gray-800);
            margin-bottom: var(--space-lg);
        }
        
        .product-rating {
            display: flex;
            align-items: center;
            gap: var(--space-sm);
            margin-bottom: var(--space-lg);
        }
        
        .stars {
            color: var(--accent-color);
        }
        
        .rating-count {
            color: var(--gray-600);
        }
        
        .product-price {
            display: flex;
            align-items: center;
            gap: var(--space-md);
            margin-bottom: var(--space-lg);
        }
        
        .current-price {
            font-size: var(--font-size-2xl);
            font-weight: 700;
            color: var(--primary-dark);
        }
        
        .original-price {
            font-size: var(--font-size-lg);
            color: var(--gray-500);
            text-decoration: line-through;
        }
        
        .discount {
            background: var(--accent-color);
            color: var(--white);
            padding: var(--space-xs) var(--space-sm);
            border-radius: var(--radius-sm);
            font-weight: 600;
        }
        
        .product-description {
            margin-bottom: var(--space-lg);
            line-height: 1.6;
            color: var(--gray-700);
        }
        
        .product-specifications {
            margin-bottom: var(--space-lg);
        }
        
        .specifications-title {
            font-weight: 600;
            margin-bottom: var(--space-sm);
            color: var(--gray-800);
        }
        
        .specifications-list {
            color: var(--gray-700);
            white-space: pre-line;
        }
        
        .product-actions {
            display: flex;
            gap: var(--space-md);
            margin-bottom: var(--space-lg);
        }
        
        .quantity-selector {
            display: flex;
            align-items: center;
            gap: var(--space-sm);
            margin-bottom: var(--space-lg);
        }
        
        .quantity-btn {
            width: 40px;
            height: 40px;
            border: 1px solid var(--gray-300);
            background: var(--white);
            border-radius: var(--radius-md);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .quantity-input {
            width: 60px;
            height: 40px;
            border: 1px solid var(--gray-300);
            border-radius: var(--radius-md);
            text-align: center;
            font-weight: 600;
        }
        
        .btn {
            padding: var(--space-md) var(--space-xl);
            border: none;
            border-radius: var(--radius-md);
            font-weight: 600;
            cursor: pointer;
            transition: all var(--transition-fast);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: var(--space-sm);
        }
        
        .btn-primary {
            background: var(--primary-color);
            color: var(--white);
            flex: 2;
        }
        
        .btn-primary:hover {
            background: var(--primary-dark);
        }
        
        .btn-secondary {
            background: var(--gray-200);
            color: var(--gray-700);
            flex: 1;
        }
        
        .btn-secondary:hover {
            background: var(--gray-300);
        }
        
        .stock-status {
            display: flex;
            align-items: center;
            gap: var(--space-sm);
            margin-bottom: var(--space-lg);
        }
        
        .in-stock {
            color: var(--secondary-color);
            font-weight: 600;
        }
        
        .out-of-stock {
            color: var(--danger-color);
            font-weight: 600;
        }
        
        .related-products {
            margin-top: var(--space-2xl);
        }
        
        .related-title {
            font-size: var(--font-size-2xl);
            color: var(--primary-dark);
            margin-bottom: var(--space-lg);
            text-align: center;
        }
        
        .related-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: var(--space-lg);
        }
        
        @media (max-width: 768px) {
            .product-detail {
                grid-template-columns: 1fr;
                gap: var(--space-lg);
            }
            
            .related-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (max-width: 640px) {
            .related-grid {
                grid-template-columns: 1fr;
            }
            
            .product-actions {
                flex-direction: column;
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
    <!-- 🛍️ PRODUCT DETAILS CONTENT -->
    <!-- ========================================================= -->
    <main class="product-details-page">
        <div class="product-container">
            <!-- Breadcrumb -->
            <div class="product-breadcrumb">
                <a href="products.php">Products</a> &gt; 
                <a href="products.php?category=<?php echo $product['category_slug']; ?>"><?php echo htmlspecialchars($product['category_name']); ?></a> &gt; 
                <span><?php echo htmlspecialchars($product['product_name']); ?></span>
            </div>

            <!-- Product Detail Section -->
            <div class="product-detail">
                <!-- Product Gallery -->
                <div class="product-gallery">
                    <div class="main-image">
                        <?php
                        $mainImagePath = '../rc-admin/uploads/products/' . basename($product['main_image']);
                        ?>
                        <img src="<?php echo htmlspecialchars($mainImagePath); ?>" 
                             alt="<?php echo htmlspecialchars($product['product_name']); ?>"
                             onerror="this.src='../assets/images/placeholder-product.jpg';" />
                    </div>
                    
                    <?php if (!empty($product['gallery_images'])): ?>
                    <div class="gallery-thumbnails">
                        <?php
                        $gallery_images = explode(',', $product['gallery_images']);
                        foreach($gallery_images as $index => $gallery_image):
                            $galleryImagePath = '../rc-admin/uploads/products/' . basename(trim($gallery_image));
                        ?>
                        <div class="thumbnail <?php echo $index === 0 ? 'active' : ''; ?>" 
                             onclick="changeMainImage('<?php echo htmlspecialchars($galleryImagePath); ?>', this)">
                            <img src="<?php echo htmlspecialchars($galleryImagePath); ?>" 
                                 alt="<?php echo htmlspecialchars($product['product_name']); ?> - Image <?php echo $index + 1; ?>"
                                 onerror="this.src='../assets/images/placeholder-product.jpg';" />
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Product Info -->
                <div class="product-info">
                    <div class="product-category"><?php echo htmlspecialchars($product['category_name']); ?></div>
                    <h1 class="product-title"><?php echo htmlspecialchars($product['product_name']); ?></h1>
                    
                    <div class="product-rating">
                        <div class="stars">
                            <?php
                            $full_stars = floor($product['rating']);
                            $half_star = ($product['rating'] - $full_stars) >= 0.5;
                            
                            for ($i = 1; $i <= 5; $i++) {
                                if ($i <= $full_stars) {
                                    echo '<i class="fas fa-star"></i>';
                                } elseif ($half_star && $i == $full_stars + 1) {
                                    echo '<i class="fas fa-star-half-alt"></i>';
                                } else {
                                    echo '<i class="far fa-star"></i>';
                                }
                            }
                            ?>
                        </div>
                        <div class="rating-count">(<?php echo $product['review_count']; ?> reviews)</div>
                    </div>
                    
                    <div class="product-price">
                        <?php if ($product['sale_price']): ?>
                            <span class="current-price">$<?php echo number_format($product['sale_price'], 2); ?></span>
                            <span class="original-price">$<?php echo number_format($product['regular_price'], 2); ?></span>
                            <?php
                            $discount_percentage = round((($product['regular_price'] - $product['sale_price']) / $product['regular_price']) * 100);
                            ?>
                            <span class="discount">-<?php echo $discount_percentage; ?>%</span>
                        <?php else: ?>
                            <span class="current-price">$<?php echo number_format($product['regular_price'], 2); ?></span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="stock-status">
                        <?php if ($product['stock_status'] == 'in_stock'): ?>
                            <span class="in-stock"><i class="fas fa-check-circle"></i> In Stock</span>
                        <?php else: ?>
                            <span class="out-of-stock"><i class="fas fa-times-circle"></i> Out of Stock</span>
                        <?php endif; ?>
                        <?php if ($product['stock_quantity'] > 0): ?>
                            <span>(<?php echo $product['stock_quantity']; ?> available)</span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="product-description">
                        <?php echo nl2br(htmlspecialchars($product['short_description'])); ?>
                    </div>
                    
                    <?php if (!empty($product['specifications'])): ?>
                    <div class="product-specifications">
                        <div class="specifications-title">Specifications:</div>
                        <div class="specifications-list"><?php echo nl2br(htmlspecialchars($product['specifications'])); ?></div>
                    </div>
                    <?php endif; ?>
                    
                    <div class="quantity-selector">
                        <label for="quantity">Quantity:</label>
                        <button class="quantity-btn" onclick="decreaseQuantity()">-</button>
                        <input type="number" id="quantity" class="quantity-input" value="1" min="1" max="<?php echo $product['stock_quantity']; ?>">
                        <button class="quantity-btn" onclick="increaseQuantity()">+</button>
                    </div>
                    
                    <div class="product-actions">
                        <button class="btn btn-primary" onclick="addToCart(<?php echo $product['id']; ?>)">
                            <i class="fas fa-shopping-cart"></i> Add to Cart
                        </button>
                        <button class="btn btn-secondary" onclick="addToWishlist(<?php echo $product['id']; ?>)">
                            <i class="far fa-heart"></i> Wishlist
                        </button>
                    </div>
                </div>
            </div>

            <!-- Related Products -->
            <?php if ($related_products->num_rows > 0): ?>
            <div class="related-products">
                <h2 class="related-title">You May Also Like</h2>
                <div class="related-grid">
                    <?php while($related_product = $related_products->fetch_assoc()): ?>
                    <div class="product-card">
                        <div class="product-image">
                            <a href="product-details.php?id=<?php echo $related_product['id']; ?>">
                                <?php
                                $relatedImagePath = '../rc-admin/uploads/products/' . basename($related_product['main_image']);
                                ?>
                                <img src="<?php echo htmlspecialchars($relatedImagePath); ?>" 
                                     alt="<?php echo htmlspecialchars($related_product['product_name']); ?>"
                                     onerror="this.src='../assets/images/placeholder-product.jpg';" />
                            </a>
                        </div>
                        <div class="product-info">
                            <h3 class="product-title">
                                <a href="product-details.php?id=<?php echo $related_product['id']; ?>">
                                    <?php echo htmlspecialchars($related_product['product_name']); ?>
                                </a>
                            </h3>
                            <div class="product-price">
                                <?php if ($related_product['sale_price']): ?>
                                    <span class="current-price">$<?php echo number_format($related_product['sale_price'], 2); ?></span>
                                    <span class="original-price">$<?php echo number_format($related_product['regular_price'], 2); ?></span>
                                <?php else: ?>
                                    <span class="current-price">$<?php echo number_format($related_product['regular_price'], 2); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>
            <?php endif; ?>
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
    
    <script>
    // Gallery image switching
    function changeMainImage(src, element) {
        document.querySelector('.main-image img').src = src;
        document.querySelectorAll('.thumbnail').forEach(thumb => {
            thumb.classList.remove('active');
        });
        element.classList.add('active');
    }
    
    // Quantity controls
    function increaseQuantity() {
        const quantityInput = document.getElementById('quantity');
        const max = parseInt(quantityInput.max);
        if (quantityInput.value < max) {
            quantityInput.value = parseInt(quantityInput.value) + 1;
        }
    }
    
    function decreaseQuantity() {
        const quantityInput = document.getElementById('quantity');
        if (quantityInput.value > 1) {
            quantityInput.value = parseInt(quantityInput.value) - 1;
        }
    }
    
    // Add to cart function
    async function addToCart(productId) {
        const quantity = document.getElementById('quantity').value;
        
        try {
            const response = await fetch('../ajax/add_to_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: parseInt(quantity)
                })
            });

            const result = await response.json();
            
            if (result.success) {
                showNotification(`Added ${quantity} item(s) to cart!`, 'success');
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
    
    // Add CSS animation for notification
    const style = document.createElement('style');
    style.textContent = `
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
    `;
    document.head.appendChild(style);
</script>
</body>
</html>
<?php
// Close database connection
$conn->close();
?>