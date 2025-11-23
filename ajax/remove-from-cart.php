<?php
session_start();
require_once '../config/database.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Please login to modify cart']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $cart_id = $input['cart_id'] ?? null;
    
    if (!$cart_id) {
        echo json_encode(['success' => false, 'error' => 'Missing cart ID']);
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
        
        // Remove from cart
        $query = "DELETE FROM cart WHERE id = ?";
        $stmt = $conn->prepare($query);
        
        if ($stmt->execute([$cart_id])) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to remove item']);
        }
        
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        echo json_encode(['success' => false, 'error' => 'Database error']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
?>