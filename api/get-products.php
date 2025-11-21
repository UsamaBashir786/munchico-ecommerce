<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once '../config/database.php';
require_once '../config/path-helper.php';

try {
    $database = new Database();
    $db = $database->getConnection();
    
    // Get filter parameters
    $category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;
    $min_price = isset($_GET['min_price']) ? floatval($_GET['min_price']) : 0;
    $max_price = isset($_GET['max_price']) ? floatval($_GET['max_price']) : 999999;
    $sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'featured';
    $min_rating = isset($_GET['min_rating']) ? floatval($_GET['min_rating']) : 0;
    
    // Build query
    $query = "SELECT p.*, c.category_name, c.category_slug 
              FROM products p 
              LEFT JOIN categories c ON p.category_id = c.id 
              WHERE p.is_active = 1";
    
    // Apply filters
    if ($category_id && $category_id != 'all') {
        $query .= " AND p.category_id = :category_id";
    }
    
    $query .= " AND p.regular_price BETWEEN :min_price AND :max_price";
    
    if ($min_rating > 0) {
        $query .= " AND p.rating >= :min_rating";
    }
    
    // Apply sorting
    switch ($sort_by) {
        case 'price_low':
            $query .= " ORDER BY p.sale_price ASC, p.regular_price ASC";
            break;
        case 'price_high':
            $query .= " ORDER BY p.sale_price DESC, p.regular_price DESC";
            break;
        case 'rating':
            $query .= " ORDER BY p.rating DESC, p.review_count DESC";
            break;
        case 'newest':
            $query .= " ORDER BY p.created_at DESC";
            break;
        default:
            $query .= " ORDER BY p.is_featured DESC, p.created_at DESC";
    }
    
    $stmt = $db->prepare($query);
    
    // Bind parameters
    if ($category_id && $category_id != 'all') {
        $stmt->bindParam(':category_id', $category_id);
    }
    $stmt->bindParam(':min_price', $min_price);
    $stmt->bindParam(':max_price', $max_price);
    if ($min_rating > 0) {
        $stmt->bindParam(':min_rating', $min_rating);
    }
    
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Helper function to get correct image path
    function getImagePath($imagePath) {
        if (empty($imagePath)) {
            return 'assets/images/placeholder-product.jpg';
        }
        
        // If path already starts with rc-admin/, use it as is
        if (strpos($imagePath, 'rc-admin/') === 0) {
            return $imagePath;
        }
        
        // If path starts with uploads/, prepend rc-admin/
        if (strpos($imagePath, 'uploads/') === 0) {
            return 'rc-admin/' . $imagePath;
        }
        
        // Otherwise assume it's just the filename
        return 'rc-admin/uploads/products/' . basename($imagePath);
    }
    
    // Process products
    $processed_products = array_map(function($product) {
        // Calculate actual price
        $price = $product['sale_price'] ? floatval($product['sale_price']) : floatval($product['regular_price']);
        $original_price = $product['sale_price'] ? floatval($product['regular_price']) : null;
        
        // Process gallery images
        $gallery_images = [];
        if (!empty($product['gallery_images'])) {
            $gallery_array = explode(',', $product['gallery_images']);
            $gallery_images = array_map(function($img) {
                return getImagePath(trim($img));
            }, $gallery_array);
        }
        
        return [
            'id' => intval($product['id']),
            'name' => $product['product_name'],
            'slug' => $product['product_slug'],
            'category' => $product['category_name'],
            'category_slug' => $product['category_slug'],
            'short_description' => $product['short_description'],
            'price' => $price,
            'originalPrice' => $original_price,
            'discount' => intval($product['discount_percentage']),
            'rating' => floatval($product['rating']),
            'reviews' => intval($product['review_count']),
            'image' => getImagePath($product['main_image']),
            'gallery' => $gallery_images,
            'inStock' => $product['stock_status'] === 'in_stock',
            'stockQuantity' => intval($product['stock_quantity']),
            'badges' => [
                'new' => (bool)$product['badge_new'],
                'hot' => (bool)$product['badge_hot'],
                'sale' => (bool)$product['badge_sale'],
                'featured' => (bool)$product['badge_featured']
            ],
            'specifications' => $product['specifications'],
            'weight' => $product['weight'],
            'size' => $product['size']
        ];
    }, $products);
    
    echo json_encode([
        'success' => true,
        'count' => count($processed_products),
        'products' => $processed_products
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error fetching products: ' . $e->getMessage()
    ]);
}
?>