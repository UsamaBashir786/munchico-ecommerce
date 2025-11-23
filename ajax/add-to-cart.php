<?php
session_start();
require_once '../config/database.php';

header('Content-Type: application/json');

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);
$product_id = $input['product_id'] ?? null;
$quantity = $input['quantity'] ?? 1;

if (!$product_id) {
    echo json_encode(['success' => false, 'message' => 'Product ID is required']);
    exit;
}

try {
    // Check if user is logged in
    $user_id = $_SESSION['user_id'] ?? null;
    
    if ($user_id) {
        // User is logged in - use database cart
        $this->handleDatabaseCart($user_id, $product_id, $quantity, $pdo);
    } else {
        // User is not logged in - use session cart
        $this->handleSessionCart($product_id, $quantity);
    }
    
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error']);
}

function handleDatabaseCart($user_id, $product_id, $quantity, $pdo) {
    // Check if product exists and is in stock
    $product_stmt = $pdo->prepare("SELECT * FROM products WHERE id = ? AND is_active = 1");
    $product_stmt->execute([$product_id]);
    $product = $product_stmt->fetch();
    
    if (!$product) {
        echo json_encode(['success' => false, 'message' => 'Product not found']);
        return;
    }
    
    if ($product['stock_quantity'] < $quantity) {
        echo json_encode(['success' => false, 'message' => 'Not enough stock available']);
        return;
    }
    
    // Check if product already in cart
    $cart_stmt = $pdo->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
    $cart_stmt->execute([$user_id, $product_id]);
    $existing_item = $cart_stmt->fetch();
    
    if ($existing_item) {
        // Update quantity
        $new_quantity = $existing_item['quantity'] + $quantity;
        $update_stmt = $pdo->prepare("UPDATE cart SET quantity = ?, total_price = ? * ? WHERE user_id = ? AND product_id = ?");
        $update_stmt->execute([$new_quantity, $product['sale_price'] ?: $product['regular_price'], $new_quantity, $user_id, $product_id]);
    } else {
        // Add new item
        $price = $product['sale_price'] ?: $product['regular_price'];
        $insert_stmt = $pdo->prepare("INSERT INTO cart (user_id, product_id, quantity, price, total_price) VALUES (?, ?, ?, ?, ?)");
        $insert_stmt->execute([$user_id, $product_id, $quantity, $price, $price * $quantity]);
    }
    
    // Get updated cart count
    $count_stmt = $pdo->prepare("SELECT COUNT(*) as count FROM cart WHERE user_id = ?");
    $count_stmt->execute([$user_id]);
    $cart_count = $count_stmt->fetch()['count'];
    
    echo json_encode(['success' => true, 'cart_count' => $cart_count]);
}

function handleSessionCart($product_id, $quantity) {
    // Initialize cart in session if not exists
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    // Check if product already in cart
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = $quantity;
    }
    
    $cart_count = array_sum($_SESSION['cart']);
    
    echo json_encode(['success' => true, 'cart_count' => $cart_count]);
}
?>