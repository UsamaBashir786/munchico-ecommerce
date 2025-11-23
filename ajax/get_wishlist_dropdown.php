<?php
session_start();
require_once '../config/database.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

try {
    $database = new Database();
    $pdo = $database->getConnection();

    // Get wishlist items with product details
    $stmt = $pdo->prepare("
        SELECT 
            w.id as wishlist_id,
            p.id as product_id,
            p.product_name,
            p.main_image,
            p.sale_price,
            p.regular_price
        FROM wishlist w
        JOIN products p ON w.product_id = p.id
        WHERE w.user_id = ?
        ORDER BY w.created_at DESC
        LIMIT 10
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fix image paths and add calculated price
    foreach ($items as &$item) {
        if (!empty($item['main_image'])) {
            // Convert database path to frontend accessible path
            $filename = basename($item['main_image']);
            $item['main_image'] = '../rc-admin/uploads/products/' . $filename;
        } else {
            $item['main_image'] = '../assets/images/placeholder-product.jpg';
        }
        
        // Add calculated price
        $item['price'] = $item['sale_price'] ?: $item['regular_price'];
    }

    // Get total count
    $stmt = $pdo->prepare("SELECT COUNT(*) as total_count FROM wishlist WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $count = $stmt->fetch();

    echo json_encode([
        'success' => true,
        'items' => $items,
        'total_count' => $count['total_count'] ?? 0
    ]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>