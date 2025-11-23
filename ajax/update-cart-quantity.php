<?php
session_start();
require_once '../config/database.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Please login to update cart']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cart_id = $_POST['cart_id'] ?? null;
    $quantity = $_POST['quantity'] ?? null;
    
    if (!$cart_id || !$quantity) {
        echo json_encode(['success' => false, 'error' => 'Missing required fields']);
        exit;
    }
    
    $database = new Database();
    $conn = $database->getConnection();
    
    if (!$conn) {
        echo json_encode(['success' => false, 'error' => 'Database connection failed']);
        exit;
    }
    
    try {
        // Verify the cart item belongs to the user
        $query = "SELECT user_id FROM cart WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$cart_id]);
        $cartItem = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$cartItem || $cartItem['user_id'] != $_SESSION['user_id']) {
            echo json_encode(['success' => false, 'error' => 'Invalid cart item']);
            exit;
        }
        
        // Update quantity
        $query = "UPDATE cart SET quantity = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?";
        $stmt = $conn->prepare($query);
        
        if ($stmt->execute([$quantity, $cart_id])) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to update quantity']);
        }
        
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        echo json_encode(['success' => false, 'error' => 'Database error']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
?>