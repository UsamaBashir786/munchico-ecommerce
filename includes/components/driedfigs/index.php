<?php
require_once 'config/database.php';

class CategoryProducts
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getCategoriesWithProducts()
    {
        $categories = [];

        // Get featured categories
        $categoryQuery = "SELECT id, category_name, category_slug 
                         FROM categories 
                         WHERE parent_category_id IS NULL 
                         AND is_active = 1 
                         AND show_on_homepage = 1 
                         ORDER BY display_order 
                         LIMIT 4";

        $stmt = $this->conn->prepare($categoryQuery);
        $stmt->execute();
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Get products for each category
        foreach ($categories as &$category) {
            $productQuery = "SELECT p.* 
                           FROM products p 
                           INNER JOIN categories c ON p.category_id = c.id 
                           WHERE (c.id = ? OR c.parent_category_id = ?) 
                           AND p.is_active = 1 
                           ORDER BY p.created_at DESC 
                           LIMIT 8";

            $stmt = $this->conn->prepare($productQuery);
            $stmt->execute([$category['id'], $category['id']]);
            $category['products'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $categories;
    }
}

$categoryHandler = new CategoryProducts();
$categoriesWithProducts = $categoryHandler->getCategoriesWithProducts();
?>

<!-- Swiper CSS -->
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

<?php foreach ($categoriesWithProducts as $category): ?>
    <section class="category-products-section" aria-labelledby="category-<?php echo $category['category_slug']; ?>">
        <div class="container">
            <h2 id="category-<?php echo $category['category_slug']; ?>" class="category-section-title">
                <span class="title-decorator">—</span>
                <?php echo htmlspecialchars($category['category_name']); ?>
                <span class="title-decorator">—</span>
            </h2>

            <?php if (!empty($category['products'])): ?>
                <div class="swiper category-swiper-<?php echo $category['category_slug']; ?>">
                    <div class="swiper-wrapper">
                        <?php foreach ($category['products'] as $product): ?>
                            <div class="swiper-slide">
                                <div class="product-card" data-product-id="<?php echo $product['id']; ?>">
                                    <!-- Product Image Container -->
                                    <div class="product-image-wrapper">
                                        <!-- Badges -->
                                        <div class="product-badges">
                                            <?php if ($product['badge_new']): ?>
                                                <span class="badge badge-new">NEW</span>
                                            <?php endif; ?>

                                            <?php if ($product['badge_featured']): ?>
                                                <span class="badge badge-featured">FEATURED</span>
                                            <?php endif; ?>
                                        </div>

                                        <?php if ($product['discount_percentage'] > 0): ?>
                                            <span class="discount-badge">-<?php echo $product['discount_percentage']; ?>%</span>
                                        <?php endif; ?>

                                        <!-- Quick Actions -->
                                        <div class="quick-actions">
                                            <button class="quick-action-btn wishlist-btn"
                                                data-product-id="<?php echo $product['id']; ?>"
                                                aria-label="Add to wishlist"
                                                title="Add to wishlist">
                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
                                                </svg>
                                            </button>
                                            <button class="quick-action-btn cart-btn"
                                                data-product-id="<?php echo $product['id']; ?>"
                                                aria-label="Add to cart"
                                                title="Add to cart">
                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z" />
                                                    <line x1="3" y1="6" x2="21" y2="6" />
                                                    <path d="M16 10a4 4 0 0 1-8 0" />
                                                </svg>
                                            </button>
                                            <button class="quick-action-btn view-btn"
                                                data-product-id="<?php echo $product['id']; ?>"
                                                aria-label="Quick view"
                                                title="Quick view">
                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                                    <circle cx="12" cy="12" r="3" />
                                                </svg>
                                            </button>
                                        </div>
<!-- Product Image -->
<a href="product-details.php?id=<?php echo $product['id']; ?>" class="product-image-link">
    <?php
    // Correct relative path from includes/components/driedfigs/ to rc-admin/uploads/products/
    $imagePath = '';
    if (!empty($product['main_image'])) {
        // Go up 3 levels: driedfigs -> components -> includes -> root
        $imagePath = '../../../rc-admin/uploads/products/' . basename($product['main_image']);
    } else {
        // Default placeholder image
        $imagePath = '../../../assets/images/placeholder-product.jpg';
    }
    ?>
    <img src="<?php echo htmlspecialchars($imagePath); ?>"
        alt="<?php echo htmlspecialchars($product['product_name']); ?>"
        class="product-image"
        onerror="this.src='../../../assets/images/placeholder-product.jpg';" />
</a>

                                        <!-- Order Now Button (Hover) -->
                                        <a href="product-details.php?id=<?php echo $product['id']; ?>" class="order-now-overlay-btn">
                                            ORDER NOW
                                        </a>
                                    </div>

                                    <!-- Product Info -->
                                    <div class="product-info">
                                        <a href="product-details.php?id=<?php echo $product['id']; ?>" class="product-title-link">
                                            <h3 class="product-title"><?php echo htmlspecialchars($product['product_name']); ?></h3>
                                        </a>

                                        <div class="product-rating-wrapper">
                                            <div class="product-stars">
                                                <?php
                                                $rating = floor($product['rating']);
                                                for ($i = 1; $i <= 5; $i++):
                                                ?>
                                                    <span class="star <?php echo $i <= $rating ? 'filled' : 'empty'; ?>">★</span>
                                                <?php endfor; ?>
                                            </div>
                                            <span class="product-review-count"><?php echo $product['review_count']; ?> Reviews</span>
                                        </div>

                                        <div class="product-pricing">
                                            <?php if ($product['sale_price']): ?>
                                                <span class="price-sale">Rs.<?php echo number_format($product['sale_price'], 2); ?></span>
                                                <span class="price-regular">Rs.<?php echo number_format($product['regular_price'], 2); ?></span>
                                            <?php else: ?>
                                                <span class="price-sale">Rs.<?php echo number_format($product['regular_price'], 2); ?></span>
                                            <?php endif; ?>
                                        </div>

                                        <div class="product-actions-row">
                                            <button class="btn-primary btn-add-cart"
                                                data-product-id="<?php echo $product['id']; ?>">
                                                Add to Cart
                                            </button>
                                            <a href="product-details.php?id=<?php echo $product['id']; ?>" class="btn-secondary btn-view">
                                                View Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Navigation -->
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-pagination"></div>
                </div>
            <?php else: ?>
                <div class="no-products-message">
                    <p>No products found in this category.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php endforeach; ?>

<!-- Notification Toast -->
<div id="toastNotification" class="toast-notification">
    <span id="toastMessage"></span>
</div>

<style>
    /* ===== Category Products Section ===== */
    .category-products-section {
        padding: 80px 0;
        background: #ffffff;
    }

    .category-products-section:nth-child(even) {
        background: #fafafa;
    }

    .container {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 24px;
    }

    /* ===== Section Title ===== */
    .category-section-title {
        text-align: center;
        font-size: 2.5rem;
        font-weight: 700;
        color: #1a202c;
        margin-bottom: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 20px;
        font-family: 'Poppins', sans-serif;
    }

    .title-decorator {
        color: #ea580c;
        font-weight: 300;
        font-size: 2rem;
    }

    /* ===== Swiper Container ===== */
    .swiper {
        width: 100%;
        padding: 30px 0 50px 0;
    }

    .swiper-wrapper {
        align-items: stretch;
    }

    .swiper-slide {
        height: auto;
        /* display: flex; */
    }

    /* ===== Product Card ===== */
    .product-card {
        background: #ffffff;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        height: 100%;
        display: flex;
        flex-direction: column;
        border: 1px solid #f3f4f6;
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.12);
        border-color: #ea580c;
    }

    /* ===== Product Image Wrapper ===== */
    .product-image-wrapper {
        position: relative;
        background: linear-gradient(135deg, #fef3e7 0%, #fde2c4 100%);
        padding: 40px 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 280px;
        overflow: hidden;
    }

    .product-image-link {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
    }

    .product-image {
        width: 100%;
        max-width: 200px;
        height: auto;
        object-fit: contain;
        transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .product-card:hover .product-image {
        transform: scale(1.08);
    }

    /* ===== Badges ===== */
    .product-badges {
        position: absolute;
        top: 16px;
        left: 87px;
        display: flex;
        flex-direction: column;
        gap: 8px;
        z-index: 2;
    }

    .badge {
        padding: 5px 37px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #ffffff;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    .badge-new {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    .badge-featured {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
    }

    .discount-badge {
        position: absolute;
        top: 16px;
        right: 16px;
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        color: #ffffff;
        padding: 8px 14px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 700;
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
        z-index: 2;
    }

    /* ===== Quick Actions ===== */
    .quick-actions {
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        display: flex;
        flex-direction: column;
        gap: 10px;
        opacity: 0;
        transition: opacity 0.3s ease, transform 0.3s ease;
        z-index: 3;
    }

    .product-card:hover .quick-actions {
        opacity: 1;
    }

    .quick-action-btn {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: #ffffff;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        color: #374151;
    }

    .quick-action-btn:hover {
        background: #ea580c;
        color: #ffffff;
        transform: scale(1.1);
        box-shadow: 0 6px 16px rgba(234, 88, 12, 0.4);
    }

    .quick-action-btn.added {
        background: #ea580c;
        color: #ffffff;
    }

    .quick-action-btn svg {
        width: 20px;
        height: 20px;
    }

    /* ===== Order Now Overlay Button ===== */
    .order-now-overlay-btn {
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%) translateY(20px);
        background: #ffffff;
        color: #ea580c;
        padding: 12px 32px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 14px;
        text-decoration: none;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        opacity: 0;
        transition: all 0.3s ease;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
        z-index: 2;
    }

    .product-card:hover .order-now-overlay-btn {
        opacity: 1;
        transform: translateX(-50%) translateY(0);
    }

    .order-now-overlay-btn:hover {
        background: #ea580c;
        color: #ffffff;
        box-shadow: 0 6px 20px rgba(234, 88, 12, 0.4);
    }

    /* ===== Product Info ===== */
    .product-info {
        padding: 24px;
        display: flex;
        flex-direction: column;
        gap: 12px;
        flex: 1;
    }

    .product-title-link {
        text-decoration: none;
        color: inherit;
    }

    .product-title {
        font-size: 18px;
        font-weight: 600;
        color: #1a202c;
        margin: 0;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        transition: color 0.3s ease;
    }

    .product-title-link:hover .product-title {
        color: #ea580c;
    }

    /* ===== Rating ===== */
    .product-rating-wrapper {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .product-stars {
        display: flex;
        gap: 2px;
    }

    .star {
        font-size: 16px;
        color: #d1d5db;
    }

    .star.filled {
        color: #fbbf24;
    }

    .product-review-count {
        font-size: 13px;
        color: #6b7280;
        font-weight: 500;
    }

    /* ===== Pricing ===== */
    .product-pricing {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 8px 0;
    }

    .price-sale {
        font-size: 22px;
        font-weight: 700;
        color: #ea580c;
    }

    .price-regular {
        font-size: 16px;
        color: #9ca3af;
        text-decoration: line-through;
        font-weight: 500;
    }

    /* ===== Action Buttons ===== */
    .product-actions-row {
        display: flex;
        gap: 10px;
        margin-top: auto;
    }

    .btn-primary,
    .btn-secondary {
        flex: 1;
        padding: 12px 16px;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        text-align: center;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-primary {
        background: linear-gradient(135deg, #ea580c 0%, #dc2626 100%);
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(234, 88, 12, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(234, 88, 12, 0.4);
    }

    .btn-secondary {
        background: #f3f4f6;
        color: #374151;
        border: 2px solid #e5e7eb;
    }

    .btn-secondary:hover {
        background: #e5e7eb;
        border-color: #d1d5db;
        transform: translateY(-2px);
    }

    /* ===== Loading State ===== */
    .btn-loading {
        opacity: 0.7;
        pointer-events: none;
        position: relative;
    }

    .btn-loading::after {
        content: '';
        position: absolute;
        width: 16px;
        height: 16px;
        border: 2px solid transparent;
        border-top: 2px solid currentColor;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    /* ===== Swiper Navigation ===== */
    .swiper-button-next,
    .swiper-button-prev {
        width: 50px;
        height: 50px;
        background: #ffffff;
        border: 2px solid #e5e7eb;
        border-radius: 50%;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .swiper-button-next:after,
    .swiper-button-prev:after {
        font-size: 20px;
        font-weight: 900;
        color: #ea580c;
    }

    .swiper-button-next:hover,
    .swiper-button-prev:hover {
        background: #ea580c;
        border-color: #ea580c;
        transform: scale(1.1);
    }

    .swiper-button-next:hover:after,
    .swiper-button-prev:hover:after {
        color: #ffffff;
    }

    /* ===== Swiper Pagination ===== */
    .swiper-pagination {
        bottom: 0 !important;
    }

    .swiper-pagination-bullet {
        width: 10px;
        height: 10px;
        background: #d1d5db;
        opacity: 1;
        transition: all 0.3s ease;
    }

    .swiper-pagination-bullet-active {
        background: #ea580c;
        width: 28px;
        border-radius: 5px;
    }

    /* ===== No Products Message ===== */
    .no-products-message {
        text-align: center;
        padding: 60px 20px;
        color: #6b7280;
        font-size: 18px;
    }

    /* ===== Toast Notification ===== */
    .toast-notification {
        position: fixed;
        top: 24px;
        right: 24px;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #ffffff;
        padding: 16px 24px;
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
        z-index: 10000;
        transform: translateX(150%);
        transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        font-weight: 600;
        font-size: 15px;
    }

    .toast-notification.show {
        transform: translateX(0);
    }

    .toast-notification.error {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
    }

    /* ===== Responsive Design ===== */
    @media (max-width: 1024px) {
        .category-section-title {
            font-size: 2rem;
        }

        .product-image-wrapper {
            min-height: 240px;
        }
    }

    @media (max-width: 768px) {
        .category-products-section {
            padding: 50px 0;
        }

        .category-section-title {
            font-size: 1.75rem;
            margin-bottom: 30px;
        }

        .title-decorator {
            font-size: 1.5rem;
        }

        .swiper-button-next,
        .swiper-button-prev {
            width: 40px;
            height: 40px;
        }

        .swiper-button-next:after,
        .swiper-button-prev:after {
            font-size: 16px;
        }

        .product-actions-row {
            flex-direction: column;
        }

        .quick-actions {
            opacity: 1;
            transform: translateY(-50%) scale(0.9);
        }

        .order-now-overlay-btn {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
            font-size: 12px;
            padding: 10px 24px;
        }
    }

    @media (max-width: 480px) {
        .container {
            padding: 0 16px;
        }

        .product-image-wrapper {
            min-height: 200px;
            padding: 30px 15px;
        }

        .product-image {
            max-width: 150px;
        }

        .product-info {
            padding: 16px;
        }

        .product-title {
            font-size: 16px;
        }

        .price-sale {
            font-size: 18px;
        }

        .toast-notification {
            top: 16px;
            right: 16px;
            left: 16px;
            padding: 14px 20px;
            font-size: 14px;
        }
    }
</style>

<!-- Swiper JS -->
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize all category sliders
        <?php foreach ($categoriesWithProducts as $category): ?>
            <?php if (!empty($category['products'])): ?>
                new Swiper(".category-swiper-<?php echo $category['category_slug']; ?>", {
                    slidesPerView: 1,
                    spaceBetween: 20,
                    loop: <?php echo count($category['products']) > 4 ? 'true' : 'false'; ?>,
                    autoplay: {
                        delay: 4000,
                        disableOnInteraction: false,
                        pauseOnMouseEnter: true,
                    },
                    pagination: {
                        el: ".category-swiper-<?php echo $category['category_slug']; ?> .swiper-pagination",
                        clickable: true,
                        dynamicBullets: true,
                    },
                    navigation: {
                        nextEl: ".category-swiper-<?php echo $category['category_slug']; ?> .swiper-button-next",
                        prevEl: ".category-swiper-<?php echo $category['category_slug']; ?> .swiper-button-prev",
                    },
                    breakpoints: {
                        480: {
                            slidesPerView: 1,
                            spaceBetween: 20
                        },
                        640: {
                            slidesPerView: 2,
                            spaceBetween: 20
                        },
                        768: {
                            slidesPerView: 2,
                            spaceBetween: 24
                        },
                        1024: {
                            slidesPerView: 3,
                            spaceBetween: 28
                        },
                        1280: {
                            slidesPerView: 4,
                            spaceBetween: 30
                        },
                    },
                });
            <?php endif; ?>
        <?php endforeach; ?>

        // AJAX Helper Function
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

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const contentType = response.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    throw new Error('Server returned non-JSON response');
                }

                const result = await response.json();

                if (result.error) {
                    throw new Error(result.error);
                }

                return result;
            } catch (error) {
                console.error('Request failed:', error);
                showToast(error.message || 'Something went wrong. Please try again.', 'error');
                throw error;
            }
        }

        // Add to Cart
        document.querySelectorAll('.cart-btn, .btn-add-cart').forEach(button => {
            button.addEventListener('click', async function(e) {
                e.preventDefault();
                const productId = this.getAttribute('data-product-id');

                this.classList.add('btn-loading');
                this.disabled = true;

                try {
                    const result = await makeRequest('ajax/add_to_cart.php', 'POST', {
                        product_id: productId,
                        quantity: 1
                    });

                    if (result.success) {
                        showToast(result.message || 'Product added to cart!');
                        updateCartCount(result.cart_count);

                        // Add visual feedback
                        this.classList.add('added');
                        setTimeout(() => this.classList.remove('added'), 2000);
                    }
                } catch (error) {
                    console.error('Add to cart failed:', error);
                } finally {
                    this.classList.remove('btn-loading');
                    this.disabled = false;
                }
            });
        });

        // Wishlist Toggle
        document.querySelectorAll('.wishlist-btn').forEach(button => {
            button.addEventListener('click', async function(e) {
                e.preventDefault();
                e.stopPropagation();
                const productId = this.getAttribute('data-product-id');

                this.classList.add('btn-loading');
                this.disabled = true;

                try {
                    const result = await makeRequest('ajax/toggle_wishlist.php', 'POST', {
                        product_id: productId
                    });

                    if (result.success) {
                        showToast(result.message);

                        if (result.action === 'added') {
                            this.classList.add('added');
                            this.querySelector('svg').setAttribute('fill', 'currentColor');
                        } else {
                            this.classList.remove('added');
                            this.querySelector('svg').setAttribute('fill', 'none');
                        }
                    }
                } catch (error) {
                    console.error('Wishlist toggle failed:', error);
                } finally {
                    this.classList.remove('btn-loading');
                    this.disabled = false
                }
            });
        });

        // Quick View
        document.querySelectorAll('.view-btn').forEach(button => {
            button.addEventListener('click', async function(e) {
                e.preventDefault();
                e.stopPropagation();
                const productId = this.getAttribute('data-product-id');

                this.classList.add('btn-loading');

                try {
                    const result = await makeRequest('ajax/get_product_details.php', 'POST', {
                        product_id: productId
                    });

                    if (result.success) {
                        openQuickViewModal(result.product);
                    }
                } catch (error) {
                    console.error('Quick view failed:', error);
                } finally {
                    this.classList.remove('btn-loading');
                }
            });
        });

        // Quick View Modal Function
        function openQuickViewModal(product) {
            // Create modal HTML
            const modalHTML = `
            <div class="quick-view-modal" id="quickViewModal">
                <div class="modal-overlay"></div>
                <div class="modal-content">
                    <button class="modal-close-btn" aria-label="Close quick view">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                    
                    <div class="modal-body">
                        <div class="product-gallery">
                            <div class="main-image">
                                <img src="${product.main_image}" alt="${product.product_name}" id="mainProductImage" />
                            </div>
                            ${product.gallery_images && product.gallery_images.length > 0 ? `
                            <div class="gallery-thumbnails">
                                ${product.gallery_images.map((img, index) => `
                                    <div class="thumbnail ${index === 0 ? 'active' : ''}" data-image="${img}">
                                        <img src="${img}" alt="${product.product_name} - View ${index + 1}" />
                                    </div>
                                `).join('')}
                            </div>
                            ` : ''}
                        </div>
                        
                        <div class="product-details">
                            <h2 class="product-title">${product.product_name}</h2>
                            
                            <div class="product-rating">
                                <div class="stars">
                                    ${generateStarRating(product.rating)}
                                </div>
                                <span class="review-count">${product.review_count} Reviews</span>
                            </div>
                            
                            <div class="product-pricing">
                                ${product.sale_price ? `
                                    <span class="sale-price">Rs.${parseFloat(product.sale_price).toFixed(2)}</span>
                                    <span class="regular-price">Rs.${parseFloat(product.regular_price).toFixed(2)}</span>
                                    ${product.discount_percentage > 0 ? `
                                        <span class="discount-badge">Save ${product.discount_percentage}%</span>
                                    ` : ''}
                                ` : `
                                    <span class="sale-price">Rs.${parseFloat(product.regular_price).toFixed(2)}</span>
                                `}
                            </div>
                            
                            <div class="product-description">
                                <p>${product.short_description || 'No description available.'}</p>
                            </div>
                            
                            <div class="product-actions">
                                <div class="quantity-selector">
                                    <button class="quantity-btn minus-btn" type="button">-</button>
                                    <input type="number" class="quantity-input" value="1" min="1" max="10" />
                                    <button class="quantity-btn plus-btn" type="button">+</button>
                                </div>
                                
                                <button class="add-to-cart-btn primary-btn" data-product-id="${product.id}">
                                    Add to Cart
                                </button>
                                
                                <button class="wishlist-btn secondary-btn" data-product-id="${product.id}">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
                                    </svg>
                                    Wishlist
                                </button>
                            </div>
                            
                            <div class="product-meta">
                                <div class="meta-item">
                                    <strong>SKU:</strong> ${product.sku || 'N/A'}
                                </div>
                                <div class="meta-item">
                                    <strong>Category:</strong> ${product.category_name || 'N/A'}
                                </div>
                                <div class="meta-item">
                                    <strong>Availability:</strong> 
                                    <span class="stock-status ${product.stock_quantity > 0 ? 'in-stock' : 'out-of-stock'}">
                                        ${product.stock_quantity > 0 ? 'In Stock' : 'Out of Stock'}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;

            // Add modal to body
            document.body.insertAdjacentHTML('beforeend', modalHTML);

            // Initialize modal functionality
            initializeQuickViewModal();
        }

        // Generate star rating HTML
        function generateStarRating(rating) {
            let stars = '';
            const fullStars = Math.floor(rating);
            const hasHalfStar = rating % 1 >= 0.5;

            for (let i = 1; i <= 5; i++) {
                if (i <= fullStars) {
                    stars += '<span class="star filled">★</span>';
                } else if (i === fullStars + 1 && hasHalfStar) {
                    stars += '<span class="star half">★</span>';
                } else {
                    stars += '<span class="star">★</span>';
                }
            }
            return stars;
        }

        // Initialize quick view modal
        function initializeQuickViewModal() {
            const modal = document.getElementById('quickViewModal');
            const closeBtn = modal.querySelector('.modal-close-btn');
            const overlay = modal.querySelector('.modal-overlay');

            // Close modal events
            [closeBtn, overlay].forEach(element => {
                element.addEventListener('click', () => {
                    modal.remove();
                });
            });

            // Escape key to close
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    modal.remove();
                }
            });

            // Thumbnail click events
            const thumbnails = modal.querySelectorAll('.thumbnail');
            const mainImage = modal.querySelector('#mainProductImage');

            thumbnails.forEach(thumb => {
                thumb.addEventListener('click', () => {
                    // Remove active class from all thumbnails
                    thumbnails.forEach(t => t.classList.remove('active'));
                    // Add active class to clicked thumbnail
                    thumb.classList.add('active');
                    // Update main image
                    mainImage.src = thumb.getAttribute('data-image');
                });
            });

            // Quantity selector
            const quantityInput = modal.querySelector('.quantity-input');
            const minusBtn = modal.querySelector('.minus-btn');
            const plusBtn = modal.querySelector('.plus-btn');

            minusBtn.addEventListener('click', () => {
                const currentValue = parseInt(quantityInput.value);
                if (currentValue > 1) {
                    quantityInput.value = currentValue - 1;
                }
            });

            plusBtn.addEventListener('click', () => {
                const currentValue = parseInt(quantityInput.value);
                if (currentValue < 10) {
                    quantityInput.value = currentValue + 1;
                }
            });

            // Add to cart in modal
            const addToCartBtn = modal.querySelector('.add-to-cart-btn');
            addToCartBtn.addEventListener('click', async function() {
                const productId = this.getAttribute('data-product-id');
                const quantity = parseInt(quantityInput.value);

                this.classList.add('btn-loading');
                this.disabled = true;

                try {
                    const result = await makeRequest('ajax/add_to_cart.php', 'POST', {
                        product_id: productId,
                        quantity: quantity
                    });

                    if (result.success) {
                        showToast(result.message || 'Product added to cart!');
                        updateCartCount(result.cart_count);
                        modal.remove();
                    }
                } catch (error) {
                    console.error('Add to cart failed:', error);
                } finally {
                    this.classList.remove('btn-loading');
                    this.disabled = false;
                }
            });

            // Wishlist in modal
            const wishlistBtn = modal.querySelector('.wishlist-btn');
            wishlistBtn.addEventListener('click', async function() {
                const productId = this.getAttribute('data-product-id');

                this.classList.add('btn-loading');
                this.disabled = true;

                try {
                    const result = await makeRequest('ajax/toggle_wishlist.php', 'POST', {
                        product_id: productId
                    });

                    if (result.success) {
                        showToast(result.message);
                        if (result.action === 'added') {
                            this.classList.add('added');
                        } else {
                            this.classList.remove('added');
                        }
                    }
                } catch (error) {
                    console.error('Wishlist toggle failed:', error);
                } finally {
                    this.classList.remove('btn-loading');
                    this.disabled = false;
                }
            });
        }

        // Update cart count in header
        function updateCartCount(count) {
            const cartCountElements = document.querySelectorAll('.cart-count, .header-cart-count');
            cartCountElements.forEach(element => {
                element.textContent = count;
                element.style.display = count > 0 ? 'flex' : 'none';
            });
        }

        // Show toast notification
        function showToast(message, type = 'success') {
            const toast = document.getElementById('toastNotification');
            const toastMessage = document.getElementById('toastMessage');

            toastMessage.textContent = message;
            toast.className = 'toast-notification';
            toast.classList.add(type);

            // Show toast
            setTimeout(() => {
                toast.classList.add('show');
            }, 100);

            // Hide toast after 3 seconds
            setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }

        // Product card click handling (excluding interactive elements)
        document.querySelectorAll('.product-card').forEach(card => {
            card.addEventListener('click', function(e) {
                // Don't trigger if click was on interactive elements
                if (e.target.closest('.quick-action-btn') ||
                    e.target.closest('.btn-add-cart') ||
                    e.target.closest('.btn-view') ||
                    e.target.closest('.order-now-overlay-btn')) {
                    return;
                }

                // Otherwise, navigate to product details
                const productId = this.getAttribute('data-product-id');
                window.location.href = `product-details.php?id=${productId}`;
            });
        });

        // Keyboard navigation for accessibility
        document.addEventListener('keydown', function(e) {
            // Enter key on product cards
            if (e.key === 'Enter' && e.target.classList.contains('product-card')) {
                const productId = e.target.getAttribute('data-product-id');
                window.location.href = `product-details.php?id=${productId}`;
            }
        });

        // Lazy loading for images
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                });
            });

            document.querySelectorAll('img[data-src]').forEach(img => {
                imageObserver.observe(img);
            });
        }
    });

    // Additional CSS for Quick View Modal
    const quickViewStyles = `
.quick-view-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 10000;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.modal-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    backdrop-filter: blur(4px);
}

.modal-content {
    position: relative;
    background: #ffffff;
    border-radius: 20px;
    max-width: 900px;
    width: 100%;
    max-height: 90vh;
    overflow: hidden;
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
    animation: modalSlideIn 0.3s ease-out;
}

@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: translateY(-50px) scale(0.9);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

.modal-close-btn {
    position: absolute;
    top: 20px;
    right: 20px;
    width: 44px;
    height: 44px;
    border: none;
    background: #ffffff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 10;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    transition: all 0.3s ease;
}

.modal-close-btn:hover {
    background: #ea580c;
    color: #ffffff;
    transform: scale(1.1);
}

.modal-body {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0;
    max-height: 80vh;
    overflow: hidden;
}

.product-gallery {
    padding: 40px;
    background: #f8fafc;
    border-right: 1px solid #e5e7eb;
}

.main-image {
    text-align: center;
    margin-bottom: 20px;
}

.main-image img {
    max-width: 100%;
    height: 300px;
    object-fit: contain;
}

.gallery-thumbnails {
    display: flex;
    gap: 10px;
    justify-content: center;
    flex-wrap: wrap;
}

.thumbnail {
    width: 60px;
    height: 60px;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    overflow: hidden;
    cursor: pointer;
    transition: all 0.3s ease;
}

.thumbnail.active,
.thumbnail:hover {
    border-color: #ea580c;
}

.thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.product-details {
    padding: 40px;
    overflow-y: auto;
}

.product-details .product-title {
    font-size: 24px;
    font-weight: 700;
    color: #1a202c;
    margin-bottom: 15px;
}

.product-rating {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 20px;
}

.product-rating .stars {
    display: flex;
    gap: 2px;
}

.product-rating .star {
    color: #d1d5db;
    font-size: 18px;
}

.product-rating .star.filled {
    color: #fbbf24;
}

.product-rating .star.half {
    background: linear-gradient(90deg, #fbbf24 50%, #d1d5db 50%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.review-count {
    color: #6b7280;
    font-size: 14px;
}

.product-pricing {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 20px;
}

.sale-price {
    font-size: 28px;
    font-weight: 700;
    color: #ea580c;
}

.regular-price {
    font-size: 18px;
    color: #9ca3af;
    text-decoration: line-through;
}

.discount-badge {
    background: #dc2626;
    color: #ffffff;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 700;
}

.product-description {
    margin-bottom: 25px;
    line-height: 1.6;
    color: #4b5563;
}

.product-actions {
    display: flex;
    gap: 15px;
    margin-bottom: 25px;
    align-items: center;
}

.quantity-selector {
    display: flex;
    align-items: center;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    overflow: hidden;
}

.quantity-btn {
    width: 44px;
    height: 44px;
    border: none;
    background: #f8fafc;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    font-weight: 600;
    transition: background 0.3s ease;
}

.quantity-btn:hover {
    background: #e5e7eb;
}

.quantity-input {
    width: 60px;
    height: 44px;
    border: none;
    text-align: center;
    font-size: 16px;
    font-weight: 600;
    background: #ffffff;
}

.quantity-input::-webkit-outer-spin-button,
.quantity-input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

.primary-btn {
    flex: 1;
    padding: 12px 24px;
    background: linear-gradient(135deg, #ea580c 0%, #dc2626 100%);
    color: #ffffff;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.primary-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(234, 88, 12, 0.4);
}

.secondary-btn {
    padding: 12px 16px;
    background: #f3f4f6;
    color: #374151;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
}

.secondary-btn:hover {
    background: #e5e7eb;
    border-color: #d1d5db;
}

.secondary-btn.added {
    background: #ea580c;
    color: #ffffff;
    border-color: #ea580c;
}

.product-meta {
    border-top: 1px solid #e5e7eb;
    padding-top: 20px;
}

.meta-item {
    display: flex;
    justify-content: between;
    margin-bottom: 8px;
    font-size: 14px;
}

.meta-item strong {
    color: #374151;
    min-width: 100px;
}

.stock-status.in-stock {
    color: #059669;
    font-weight: 600;
}

.stock-status.out-of-stock {
    color: #dc2626;
    font-weight: 600;
}

@media (max-width: 768px) {
    .modal-body {
        grid-template-columns: 1fr;
        max-height: 95vh;
    }
    
    .product-gallery {
        border-right: none;
        border-bottom: 1px solid #e5e7eb;
        padding: 20px;
    }
    
    .product-details {
        padding: 20px;
    }
    
    .product-actions {
        flex-direction: column;
    }
    
    .quantity-selector {
        width: 100%;
        justify-content: center;
    }
}

@media (max-width: 480px) {
    .quick-view-modal {
        padding: 10px;
    }
    
    .modal-content {
        border-radius: 12px;
    }
    
    .main-image img {
        height: 200px;
    }
}
`;

    // Add quick view styles to document
    const styleSheet = document.createElement('style');
    styleSheet.textContent = quickViewStyles;
    document.head.appendChild(styleSheet);
</script>
