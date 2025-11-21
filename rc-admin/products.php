<?php
// products.php - Products Management Page
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

$page_title = "Products";
$current_page = "products";

// Database connection
require_once 'config/database.php';
$conn = getDB();

// Pagination settings
$items_per_page = 12;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $items_per_page;

// Get filter parameters
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$category_filter = isset($_GET['category']) ? (int)$_GET['category'] : 0;
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';
$sort_by = isset($_GET['sort']) ? $_GET['sort'] : 'newest';

// Build WHERE clause
$where_clauses = ["p.is_active = 1"];
$params = [];
$param_types = "";

if (!empty($search)) {
    $where_clauses[] = "(p.product_name LIKE ? OR p.product_slug LIKE ?)";
    $search_param = "%$search%";
    $params[] = $search_param;
    $params[] = $search_param;
    $param_types .= "ss";
}

if (!empty($category_filter) && $category_filter > 0) {
    $where_clauses[] = "p.category_id = ?";
    $params[] = $category_filter;
    $param_types .= "i";
}

if (!empty($status_filter)) {
    switch ($status_filter) {
        case 'active':
            $where_clauses[] = "p.stock_status = 'in_stock' AND p.stock_quantity > 20";
            break;
        case 'low-stock':
            $where_clauses[] = "p.stock_status = 'in_stock' AND p.stock_quantity > 0 AND p.stock_quantity <= 20";
            break;
        case 'out-of-stock':
            $where_clauses[] = "(p.stock_status = 'out_of_stock' OR p.stock_quantity = 0)";
            break;
    }
}

$where_sql = !empty($where_clauses) ? implode(" AND ", $where_clauses) : "1=1";

// Build ORDER BY clause
$order_by = "p.created_at DESC";
switch ($sort_by) {
    case 'oldest':
        $order_by = "p.created_at ASC";
        break;
    case 'name-asc':
        $order_by = "p.product_name ASC";
        break;
    case 'name-desc':
        $order_by = "p.product_name DESC";
        break;
    case 'price-low':
        $order_by = "p.regular_price ASC";
        break;
    case 'price-high':
        $order_by = "p.regular_price DESC";
        break;
    case 'stock-low':
        $order_by = "p.stock_quantity ASC";
        break;
}

// Fetch products with category information
$sql = "SELECT 
            p.*,
            c.category_name,
            CASE 
                WHEN p.stock_quantity = 0 OR p.stock_status = 'out_of_stock' THEN 'Out of Stock'
                WHEN p.stock_quantity <= 20 THEN 'Low Stock'
                ELSE 'Active'
            END as display_status
        FROM products p
        LEFT JOIN categories c ON p.category_id = c.id
        WHERE $where_sql
        ORDER BY $order_by
        LIMIT ? OFFSET ?";

$params[] = $items_per_page;
$params[] = $offset;
$param_types .= "ii";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

if (!empty($params)) {
    $stmt->bind_param($param_types, ...$params);
}

if (!$stmt->execute()) {
    die("Execute failed: " . $stmt->error);
}

$result = $stmt->get_result();
$products = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Get total count for pagination
$count_sql = "SELECT COUNT(*) as total FROM products p WHERE $where_sql";
$count_stmt = $conn->prepare($count_sql);

if (!empty($params) && count($params) > 2) {
    $count_params = array_slice($params, 0, -2);
    $count_param_types = substr($param_types, 0, -2);
    if (!empty($count_params)) {
        $count_stmt->bind_param($count_param_types, ...$count_params);
    }
}

if (!$count_stmt->execute()) {
    die("Count execute failed: " . $count_stmt->error);
}

$count_result = $count_stmt->get_result();
$total_data = $count_result->fetch_assoc();
$total_products = $total_data ? $total_data['total'] : 0;
$count_stmt->close();

// Calculate statistics - FIXED: Proper null handling
$stats_sql = "SELECT 
    COUNT(*) as total_products,
    COALESCE(SUM(CASE WHEN stock_status = 'in_stock' AND stock_quantity > 20 THEN 1 ELSE 0 END), 0) as active,
    COALESCE(SUM(CASE WHEN stock_status = 'in_stock' AND stock_quantity > 0 AND stock_quantity <= 20 THEN 1 ELSE 0 END), 0) as low_stock,
    COALESCE(SUM(CASE WHEN stock_status = 'out_of_stock' OR stock_quantity = 0 THEN 1 ELSE 0 END), 0) as out_of_stock
FROM products
WHERE is_active = 1";

$stats_result = $conn->query($stats_sql);
$stats = $stats_result ? $stats_result->fetch_assoc() : [
    'total_products' => 0,
    'active' => 0,
    'low_stock' => 0,
    'out_of_stock' => 0
];

if ($stats_result) {
    $stats_result->close();
}

// Get categories for filter dropdown
$categories_sql = "SELECT id, category_name FROM categories WHERE is_active = 1 ORDER BY category_name";
$categories_result = $conn->query($categories_sql);
$categories = $categories_result ? $categories_result->fetch_all(MYSQLI_ASSOC) : [];

if ($categories_result) {
    $categories_result->close();
}

// Calculate pagination
$total_pages = $total_products > 0 ? ceil($total_products / $items_per_page) : 1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?> | ADMIN PANEL</title>
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
                        <h3 class="stat-value"><?php echo number_format((int)$stats['total_products']); ?></h3>
                        <span class="stat-change">All active products</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-details">
                        <p class="stat-label">Active Products</p>
                        <h3 class="stat-value"><?php echo number_format((int)$stats['active']); ?></h3>
                        <span class="stat-change">
                            <?php 
                            $active_percentage = ($stats['total_products'] > 0) ? round(($stats['active'] / $stats['total_products']) * 100, 1) : 0;
                            echo $active_percentage . '% of total';
                            ?>
                        </span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="stat-details">
                        <p class="stat-label">Low Stock</p>
                        <h3 class="stat-value"><?php echo number_format((int)$stats['low_stock']); ?></h3>
                        <span class="stat-change warning">Needs attention</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <div class="stat-details">
                        <p class="stat-label">Out of Stock</p>
                        <h3 class="stat-value"><?php echo number_format((int)$stats['out_of_stock']); ?></h3>
                        <span class="stat-change">Requires restocking</span>
                    </div>
                </div>
            </div>

            <!-- Filters and Search -->
            <div class="filters-bar">
                <form method="GET" action="" id="filterForm">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" name="search" id="searchProducts" placeholder="Search products by name or SKU..." value="<?php echo htmlspecialchars($search); ?>">
                    </div>
                    <div class="filters">
                        <select name="category" id="filterCategory" onchange="this.form.submit()">
                            <option value="">All Categories</option>
                            <?php foreach($categories as $cat): ?>
                            <option value="<?php echo (int)$cat['id']; ?>" <?php echo $category_filter == $cat['id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cat['category_name']); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <select name="status" id="filterStatus" onchange="this.form.submit()">
                            <option value="">All Status</option>
                            <option value="active" <?php echo $status_filter == 'active' ? 'selected' : ''; ?>>Active</option>
                            <option value="low-stock" <?php echo $status_filter == 'low-stock' ? 'selected' : ''; ?>>Low Stock</option>
                            <option value="out-of-stock" <?php echo $status_filter == 'out-of-stock' ? 'selected' : ''; ?>>Out of Stock</option>
                        </select>
                        <select name="sort" id="sortBy" onchange="this.form.submit()">
                            <option value="newest" <?php echo $sort_by == 'newest' ? 'selected' : ''; ?>>Newest First</option>
                            <option value="oldest" <?php echo $sort_by == 'oldest' ? 'selected' : ''; ?>>Oldest First</option>
                            <option value="name-asc" <?php echo $sort_by == 'name-asc' ? 'selected' : ''; ?>>Name (A-Z)</option>
                            <option value="name-desc" <?php echo $sort_by == 'name-desc' ? 'selected' : ''; ?>>Name (Z-A)</option>
                            <option value="price-low" <?php echo $sort_by == 'price-low' ? 'selected' : ''; ?>>Price (Low to High)</option>
                            <option value="price-high" <?php echo $sort_by == 'price-high' ? 'selected' : ''; ?>>Price (High to Low)</option>
                            <option value="stock-low" <?php echo $sort_by == 'stock-low' ? 'selected' : ''; ?>>Stock (Low to High)</option>
                        </select>
                    </div>
                </form>
            </div>

            <!-- Products Grid -->
            <div class="products-grid">
                <?php if (empty($products)): ?>
                <div class="no-products" style="text-align: center; padding: 60px 20px; grid-column: 1 / -1;">
                    <i class="fas fa-box-open" style="font-size: 64px; color: #d1d5db; margin-bottom: 20px;"></i>
                    <h3 style="color: #6b7280; margin-bottom: 10px;">No Products Found</h3>
                    <p style="color: #9ca3af;">Try adjusting your filters or search criteria</p>
                </div>
                <?php else: ?>
                <?php foreach($products as $product): ?>
                <div class="product-card" data-product-id="<?php echo (int)$product['id']; ?>">
                    <div class="product-header">
                        <input type="checkbox" class="product-checkbox" value="<?php echo (int)$product['id']; ?>">
                        <span class="product-status badge-<?php echo strtolower(str_replace(' ', '-', $product['display_status'])); ?>">
                            <?php echo htmlspecialchars($product['display_status']); ?>
                        </span>
                    </div>
                    
                    <div class="product-image">
                        <?php 
                        $image_path = !empty($product['main_image']) ? $product['main_image'] : 'https://via.placeholder.com/300x300/f3f4f6/667eea?text=' . urlencode($product['product_name']);
                        ?>
                        <img src="<?php echo htmlspecialchars($image_path); ?>" 
                             alt="<?php echo htmlspecialchars($product['product_name']); ?>"
                             onerror="this.src='https://via.placeholder.com/300x300/f3f4f6/667eea?text=No+Image'">
                        <div class="product-overlay">
                            <button class="btn-icon" onclick="quickView(<?php echo (int)$product['id']; ?>)" title="Quick View">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn-icon" onclick="editProduct(<?php echo (int)$product['id']; ?>)" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="product-body">
                        <div class="product-category"><?php echo htmlspecialchars($product['category_name'] ?? 'Uncategorized'); ?></div>
                        <h3 class="product-name"><?php echo htmlspecialchars($product['product_name']); ?></h3>
                        <div class="product-sku">SKU: <?php echo htmlspecialchars($product['product_slug']); ?></div>
                        
                        <div class="product-rating">
                            <?php 
                            $rating = (float)$product['rating'];
                            for($i = 1; $i <= 5; $i++) {
                                if($i <= floor($rating)) {
                                    echo '<i class="fas fa-star"></i>';
                                } elseif($i <= ceil($rating) && $rating > floor($rating)) {
                                    echo '<i class="fas fa-star-half-alt"></i>';
                                } else {
                                    echo '<i class="far fa-star"></i>';
                                }
                            }
                            ?>
                            <span class="rating-value"><?php echo number_format($rating, 1); ?></span>
                        </div>
                        
                        <div class="product-meta">
                            <div class="meta-item">
                                <i class="fas fa-box"></i>
                                <span>Stock: <strong><?php echo number_format((int)$product['stock_quantity']); ?></strong></span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-shopping-cart"></i>
                                <span>Sales: <strong><?php echo number_format((int)$product['sales_count']); ?></strong></span>
                            </div>
                        </div>
                        
                        <div class="product-footer">
                            <div class="product-price">
                                <?php if (!empty($product['sale_price']) && $product['sale_price'] < $product['regular_price']): ?>
                                    <span class="sale-price">$<?php echo number_format((float)$product['sale_price'], 2); ?></span>
                                    <span class="regular-price" style="text-decoration: line-through; color: #9ca3af; margin-left: 8px;">$<?php echo number_format((float)$product['regular_price'], 2); ?></span>
                                <?php else: ?>
                                    $<?php echo number_format((float)$product['regular_price'], 2); ?>
                                <?php endif; ?>
                            </div>
                            <div class="product-actions">
                                <button class="btn-action btn-edit" onclick="editProduct(<?php echo (int)$product['id']; ?>)" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn-action btn-duplicate" onclick="duplicateProduct(<?php echo (int)$product['id']; ?>)" title="Duplicate">
                                    <i class="fas fa-copy"></i>
                                </button>
                                <button class="btn-action btn-delete" onclick="deleteProduct(<?php echo (int)$product['id']; ?>)" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
            <div class="pagination">
                <?php
                $query_params = [
                    'search' => $search,
                    'category' => $category_filter > 0 ? $category_filter : null,
                    'status' => $status_filter,
                    'sort' => $sort_by
                ];
                $query_string = http_build_query(array_filter($query_params, function($value) {
                    return $value !== null && $value !== '';
                }));
                $query_prefix = !empty($query_string) ? '&' : '';
                ?>
                <button class="btn btn-secondary btn-sm" 
                        <?php echo $page <= 1 ? 'disabled' : ''; ?> 
                        onclick="window.location.href='?page=<?php echo $page - 1; ?><?php echo $query_prefix . $query_string; ?>'">
                    <i class="fas fa-chevron-left"></i> Previous
                </button>
                <div class="pagination-info">
                    Showing <?php echo number_format($offset + 1); ?>-<?php echo number_format(min($offset + $items_per_page, $total_products)); ?> of <?php echo number_format($total_products); ?> products
                </div>
                <button class="btn btn-secondary btn-sm" 
                        <?php echo $page >= $total_pages ? 'disabled' : ''; ?> 
                        onclick="window.location.href='?page=<?php echo $page + 1; ?><?php echo $query_prefix . $query_string; ?>'">
                    Next <i class="fas fa-chevron-right"></i>
                </button>
            </div>
            <?php endif; ?>

            <?php include 'includes/footer.php'; ?>
        </div>
    </div>

    <script src="assets/js/script.js"></script>
    <script src="assets/js/products.js"></script>
    <script>
    // JavaScript functions for product actions
    function quickView(productId) {
        // Implement quick view modal
        alert('Quick view for product ID: ' + productId);
    }

    function editProduct(productId) {
        window.location.href = 'edit-product.php?id=' + productId;
    }

    function duplicateProduct(productId) {
        if(confirm('Are you sure you want to duplicate this product?')) {
            // Implement duplicate functionality via AJAX
            alert('Duplicate product ID: ' + productId);
        }
    }

    function deleteProduct(productId) {
        if(confirm('Are you sure you want to delete this product? This action cannot be undone.')) {
            window.location.href = 'delete-product.php?id=' + productId;
        }
    }
    </script>
</body>
</html>