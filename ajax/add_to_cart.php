<?php
session_start();
require_once '../config/database.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Please login to add items to cart']);
    exit;
}

// Get input data
$input = json_decode(file_get_contents('php://input'), true);
$product_id = $input['product_id'] ?? null;
$quantity = $input['quantity'] ?? 1;

if (!$product_id) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Product ID is required']);
    exit;
}

try {
    $database = new Database();
    $pdo = $database->getConnection();

    // Get product details
    $stmt = $pdo->prepare("SELECT product_name, sale_price, regular_price, main_image FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch();
    
    if (!$product) {
        throw new Exception('Product not found');
    }
    
    $price = $product['sale_price'] ?: $product['regular_price'];
    $total_price = $price * $quantity;
    
    // Check if product already in cart
    $stmt = $pdo->prepare("SELECT id, quantity FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt->execute([$_SESSION['user_id'], $product_id]);
    $existing_item = $stmt->fetch();
    
    if ($existing_item) {
        // Update quantity
        $new_quantity = $existing_item['quantity'] + $quantity;
        $new_total = $price * $new_quantity;
        
        $stmt = $pdo->prepare("UPDATE cart SET quantity = ?, total_price = ? WHERE id = ?");
        $stmt->execute([$new_quantity, $new_total, $existing_item['id']]);
    } else {
        // Insert new item
        $stmt = $pdo->prepare("INSERT INTO cart (user_id, product_id, quantity, price, total_price) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$_SESSION['user_id'], $product_id, $quantity, $price, $total_price]);
    }
    
    // Get updated cart count
    $stmt = $pdo->prepare("SELECT SUM(quantity) as total_count FROM cart WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $cart_count = $stmt->fetch()['total_count'] ?? 0;
    
    echo json_encode([
        'success' => true,
        'message' => 'Product added to cart',
        'cart_count' => (int)$cart_count
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>