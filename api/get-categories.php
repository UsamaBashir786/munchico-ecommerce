<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once '../config/database.php';
require_once '../config/path-helper.php';

try {
    $database = new Database();
    $db = $database->getConnection();
    
    // Get active categories with product counts
    $query = "SELECT c.*, 
              (SELECT COUNT(*) FROM products p WHERE p.category_id = c.id AND p.is_active = 1) as product_count
              FROM categories c 
              WHERE c.is_active = 1 
              ORDER BY c.display_order ASC, c.category_name ASC";
    
    $stmt = $db->prepare($query);
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Helper function for category images
    function getCategoryImagePath($imagePath) {
        if (empty($imagePath)) {
            return 'assets/images/placeholder-category.jpg';
        }
        
        // If path starts with assets/, use as is (already correct)
        if (strpos($imagePath, 'assets/') === 0) {
            return 'rc-admin/' . $imagePath;
        }
        
        // Otherwise treat as relative path
        return 'rc-admin/' . $imagePath;
    }
    
    // Process categories
    $processed_categories = array_map(function($category) {
        return [
            'id' => intval($category['id']),
            'name' => $category['category_name'],
            'slug' => $category['category_slug'],
            'description' => $category['description'],
            'image' => getCategoryImagePath($category['category_image']),
            'color' => $category['color'],
            'icon' => $category['icon_class'],
            'is_featured' => (bool)$category['is_featured'],
            'product_count' => intval($category['product_count']),
            'parent_id' => $category['parent_category_id']
        ];
    }, $categories);
    
    echo json_encode([
        'success' => true,
        'count' => count($processed_categories),
        'categories' => $processed_categories
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error fetching categories: ' . $e->getMessage()
    ]);
}
?>