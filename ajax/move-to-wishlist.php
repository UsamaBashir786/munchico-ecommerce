<?php
session_start();
require_once '../config/database.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Please login to use wishlist']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $product_id = $input['product_id'] ?? null;
    
    if (!$product_id) {
        echo json_encode(['success' => false, 'error' => 'Missing product ID']);
        exit;
    }
    
    $database = new Database();
    $conn = $database->getConnection();
    
    if (!$conn) {
        echo json_encode(['success' => false, 'error' => 'Database connection failed']);
        exit;
    }
    
    try {
        // Check if product exists
        $query = "SELECT id FROM products WHERE id = ? AND is_active = 1";
        $stmt = $conn->prepare($query);
        $stmt->execute([$product_id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$product) {
            echo json_encode(['success' => false, 'error' => 'Product not found']);
            exit;
        }
        
        // Check if already in wishlist
        $query = "SELECT id FROM wishlist WHERE user_id = ? AND product_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$_SESSION['user_id'], $product_id]);
        $existing = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($existing) {
            echo json_encode(['success' => false, 'error' => 'Product already in wishlist']);
            exit;
        }
        
        // Add to wishlist
        $query = "INSERT INTO wishlist (user_id, product_id, created_at) VALUES (?, ?, CURRENT_TIMESTAMP)";
        $stmt = $conn->prepare($query);
        
        if ($stmt->execute([$_SESSION['user_id'], $product_id])) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to add to wishlist']);
        }
        
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        echo json_encode(['success' => false, 'error' => 'Database error']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
?>