<?php
session_start();
require_once '../config/database.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$cart_id = $input['cart_id'] ?? null;
$quantity = $input['quantity'] ?? null;

if (!$cart_id || !$quantity) {
    echo json_encode(['error' => 'Invalid parameters']);
    exit;
}

try {
    // Create database connection
    $database = new Database();
    $pdo = $database->getConnection();

    // Get current price
    $stmt = $pdo->prepare("SELECT price FROM cart WHERE id = ? AND user_id = ?");
    $stmt->execute([$cart_id, $_SESSION['user_id']]);
    $cart_item = $stmt->fetch();
    
    if (!$cart_item) {
        throw new Exception('Cart item not found');
    }
    
    $new_total = $cart_item['price'] * $quantity;
    
    // Update cart
    $stmt = $pdo->prepare("UPDATE cart SET quantity = ?, total_price = ? WHERE id = ? AND user_id = ?");
    $stmt->execute([$quantity, $new_total, $cart_id, $_SESSION['user_id']]);
    
    echo json_encode([
        'success' => true,
        'new_total' => $new_total
    ]);
    
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>