<?php
session_start();
require_once '../config/database.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit;
}

try {
    $stmt = $pdo->prepare("
        SELECT SUM(quantity) as item_count, SUM(total_price) as subtotal 
        FROM cart 
        WHERE user_id = ?
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $result = $stmt->fetch();
    
    $subtotal = $result['subtotal'] ?? 0;
    $item_count = $result['item_count'] ?? 0;
    $tax = $subtotal * 0.05;
    $grand_total = $subtotal + $tax;
    
    echo json_encode([
        'subtotal' => floatval($subtotal),
        'tax' => $tax,
        'grand_total' => $grand_total,
        'item_count' => intval($item_count)
    ]);
    
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>