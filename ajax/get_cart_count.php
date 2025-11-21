<?php
session_start();
require_once '../config/database.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['cart_count' => 0]);
    exit;
}

try {
    $database = new Database();
    $pdo = $database->getConnection();

    $stmt = $pdo->prepare("SELECT SUM(quantity) as total_count FROM cart WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $result = $stmt->fetch();
    
    echo json_encode([
        'cart_count' => (int)($result['total_count'] ?? 0)
    ]);
    
} catch (Exception $e) {
    echo json_encode(['cart_count' => 0]);
}
?>