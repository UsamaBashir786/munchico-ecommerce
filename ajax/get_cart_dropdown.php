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

    // Get cart items with product details
    $stmt = $pdo->prepare("
        SELECT 
            c.id as cart_id,
            c.quantity,
            c.price,
            c.total_price,
            p.id as product_id,
            p.product_name,
            p.main_image
        FROM cart c
        JOIN products p ON c.product_id = p.id
        WHERE c.user_id = ?
        ORDER BY c.created_at DESC
        LIMIT 10
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fix image paths for frontend display
    foreach ($items as &$item) {
        if (!empty($item['main_image'])) {
            // Convert database path to frontend accessible path
            $filename = basename($item['main_image']);
            $item['main_image'] = '../rc-admin/uploads/products/' . $filename;
        } else {
            $item['main_image'] = '../assets/images/placeholder-product.jpg';
        }
    }

    // Get total count and amount
    $stmt = $pdo->prepare("
        SELECT SUM(quantity) as total_count, SUM(total_price) as total_amount 
        FROM cart 
        WHERE user_id = ?
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $totals = $stmt->fetch();

    echo json_encode([
        'success' => true,
        'items' => $items,
        'total_count' => $totals['total_count'] ?? 0,
        'total' => $totals['total_amount'] ?? 0
    ]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>