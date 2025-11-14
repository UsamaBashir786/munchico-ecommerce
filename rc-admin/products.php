<?php
// products.php - Products Management Page
session_start();

$page_title = "Products";
$current_page = "products";

// Example product data
$products = [
    [
        'id' => 1,
        'name' => 'Organic Almonds',
        'sku' => 'DRF-ALM-001',
        'category' => 'Nuts',
        'price' => '$12.99',
        'stock' => 156,
        'status' => 'Active',
        'image' => 'assets/images/products/almonds.jpg',
        'sales' => 245,
        'rating' => 4.8
    ],
    [
        'id' => 2,
        'name' => 'Dried Apricots',
        'sku' => 'DRF-APR-002',
        'category' => 'Dried Fruits',
        'price' => '$8.99',
        'stock' => 89,
        'status' => 'Active',
        'image' => 'assets/images/products/apricots.jpg',
        'sales' => 189,
        'rating' => 4.6
    ],
    [
        'id' => 3,
        'name' => 'Premium Cashews',
        'sku' => 'DRF-CSH-003',
        'category' => 'Nuts',
        'price' => '$15.99',
        'stock' => 12,
        'status' => 'Low Stock',
        'image' => 'assets/images/products/cashews.jpg',
        'sales' => 312,
        'rating' => 4.9
    ],
    [
        'id' => 4,
        'name' => 'Medjool Dates',
        'sku' => 'DRF-DAT-004',
        'category' => 'Dried Fruits',
        'price' => '$10.99',
        'stock' => 234,
        'status' => 'Active',
        'image' => 'assets/images/products/dates.jpg',
        'sales' => 456,
        'rating' => 4.7
    ],
    [
        'id' => 5,
        'name' => 'Walnuts Premium',
        'sku' => 'DRF-WAL-005',
        'category' => 'Nuts',
        'price' => '$13.99',
        'stock' => 0,
        'status' => 'Out of Stock',
        'image' => 'assets/images/products/walnuts.jpg',
        'sales' => 178,
        'rating' => 4.5
    ],
    [
        'id' => 6,
        'name' => 'Chia Seeds',
        'sku' => 'DRF-CHI-006',
        'category' => 'Seeds',
        'price' => '$6.99',
        'stock' => 145,
        'status' => 'Active',
        'image' => 'assets/images/products/chia.jpg',
        'sales' => 267,
        'rating' => 4.6
    ]
];

$stats = [
    'total_products' => 248,
    'active' => 215,
    'low_stock' => 12,
    'out_of_stock' => 5
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> | ADMIN PANEL</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/products.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="admin-wrapper">
        <?php include 'includes/sidebar.php'; ?>

        <div class="main-content">
            <header class="top-header">
                <div class="header-left">
                    <button class="toggle-sidebar" id="toggleSidebar">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1>Products Management</h1>
                </div>
                <div class="header-right">
                    <button class="btn btn-secondary">
                        <i class="fas fa-file-export"></i> Export
                    </button>
                    <button class="btn btn-primary" onclick="window.location.href='add-product.php'">
                        <i class="fas fa-plus"></i> Add New Product
                    </button>
                </div>
            </header>

            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="stat-details">
                        <p class="stat-label">Total Products</p>
                        <h3 class="stat-value"><?php echo $stats['total_products']; ?></h3>
                        <span class="stat-change positive"><i class="fas fa-arrow-up"></i> 12% from last month</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-details">
                        <p class="stat-label">Active Products</p>
                        <h3 class="stat-value"><?php echo $stats['active']; ?></h3>
                        <span class="stat-change">86.7% of total</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="stat-details">
                        <p class="stat-label">Low Stock</p>
                        <h3 class="stat-value"><?php echo $stats['low_stock']; ?></h3>
                        <span class="stat-change warning">Needs attention</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <div class="stat-details">
                        <p class="stat-label">Out of Stock</p>
                        <h3 class="stat-value"><?php echo $stats['out_of_stock']; ?></h3>
                        <span class="stat-change">Requires restocking</span>
                    </div>
                </div>
            </div>

            <!-- Filters and Search -->
            <div class="filters-bar">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchProducts" placeholder="Search products by name or SKU...">
                </div>
                <div class="filters">
                    <select id="filterCategory">
                        <option value="">All Categories</option>
                        <option value="nuts">Nuts</option>
                        <option value="dried-fruits">Dried Fruits</option>
                        <option value="seeds">Seeds</option>
                        <option value="organic">Organic Products</option>
                    </select>
                    <select id="filterStatus">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="low-stock">Low Stock</option>
                        <option value="out-of-stock">Out of Stock</option>
                        <option value="inactive">Inactive</option>
                    </select>
                    <select id="sortBy">
                        <option value="newest">Newest First</option>
                        <option value="oldest">Oldest First</option>
                        <option value="name-asc">Name (A-Z)</option>
                        <option value="name-desc">Name (Z-A)</option>
                        <option value="price-low">Price (Low to High)</option>
                        <option value="price-high">Price (High to Low)</option>
                        <option value="stock-low">Stock (Low to High)</option>
                    </select>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="products-grid">
                <?php foreach($products as $product): ?>
                <div class="product-card" data-product-id="<?php echo $product['id']; ?>">
                    <div class="product-header">
                        <input type="checkbox" class="product-checkbox" value="<?php echo $product['id']; ?>">
                        <span class="product-status badge-<?php echo strtolower(str_replace(' ', '-', $product['status'])); ?>">
                            <?php echo $product['status']; ?>
                        </span>
                    </div>
                    
                    <div class="product-image">
                        <img src="https://via.placeholder.com/300x300/f3f4f6/667eea?text=<?php echo urlencode($product['name']); ?>" alt="<?php echo $product['name']; ?>">
                        <div class="product-overlay">
                            <button class="btn-icon" onclick="quickView(<?php echo $product['id']; ?>)" title="Quick View">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn-icon" onclick="editProduct(<?php echo $product['id']; ?>)" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="product-body">
                        <div class="product-category"><?php echo $product['category']; ?></div>
                        <h3 class="product-name"><?php echo $product['name']; ?></h3>
                        <div class="product-sku">SKU: <?php echo $product['sku']; ?></div>
                        
                        <div class="product-rating">
                            <?php 
                            $rating = $product['rating'];
                            for($i = 1; $i <= 5; $i++) {
                                if($i <= floor($rating)) {
                                    echo '<i class="fas fa-star"></i>';
                                } elseif($i <= ceil($rating)) {
                                    echo '<i class="fas fa-star-half-alt"></i>';
                                } else {
                                    echo '<i class="far fa-star"></i>';
                                }
                            }
                            ?>
                            <span class="rating-value"><?php echo $product['rating']; ?></span>
                        </div>
                        
                        <div class="product-meta">
                            <div class="meta-item">
                                <i class="fas fa-box"></i>
                                <span>Stock: <strong><?php echo $product['stock']; ?></strong></span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-shopping-cart"></i>
                                <span>Sales: <strong><?php echo $product['sales']; ?></strong></span>
                            </div>
                        </div>
                        
                        <div class="product-footer">
                            <div class="product-price"><?php echo $product['price']; ?></div>
                            <div class="product-actions">
                                <button class="btn-action btn-edit" onclick="editProduct(<?php echo $product['id']; ?>)" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn-action btn-duplicate" onclick="duplicateProduct(<?php echo $product['id']; ?>)" title="Duplicate">
                                    <i class="fas fa-copy"></i>
                                </button>
                                <button class="btn-action btn-delete" onclick="deleteProduct(<?php echo $product['id']; ?>)" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <div class="pagination">
                <button class="btn btn-secondary btn-sm" disabled>
                    <i class="fas fa-chevron-left"></i> Previous
                </button>
                <div class="pagination-info">
                    Showing 1-6 of <?php echo $stats['total_products']; ?> products
                </div>
                <button class="btn btn-secondary btn-sm">
                    Next <i class="fas fa-chevron-right"></i>
                </button>
            </div>

            <?php include 'includes/footer.php'; ?>
        </div>
    </div>

    <script src="assets/js/script.js"></script>
    <script src="assets/js/products.js"></script>
</body>
</html>