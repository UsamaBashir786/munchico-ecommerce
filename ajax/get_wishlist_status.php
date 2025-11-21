<?php
session_start();
require_once '../config/database.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode([]);
    exit;
}

$product_ids = $_GET['product_ids'] ?? '';
$product_ids_array = array_filter(explode(',', $product_ids));

if (empty($product_ids_array)) {
    echo json_encode([]);
    exit;
}

try {
    $database = new Database();
    $pdo = $database->getConnection();

    // Create placeholders for IN clause
    $placeholders = str_repeat('?,', count($product_ids_array) - 1) . '?';
    
    $stmt = $pdo->prepare("SELECT product_id FROM wishlist WHERE user_id = ? AND product_id IN ($placeholders)");
    $params = array_merge([$_SESSION['user_id']], $product_ids_array);
    $stmt->execute($params);
    $wishlist_items = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo json_encode($wishlist_items);
    
} catch (Exception $e) {
    echo json_encode([]);
}
?>