<?php
session_start();
require_once '../config/database.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$wishlist_id = $input['wishlist_id'] ?? null;

if (!$wishlist_id) {
    echo json_encode(['success' => false, 'message' => 'Wishlist ID is required']);
    exit;
}

try {
    $database = new Database();
    $pdo = $database->getConnection();

    $stmt = $pdo->prepare("DELETE FROM wishlist WHERE id = ? AND user_id = ?");
    $stmt->execute([$wishlist_id, $_SESSION['user_id']]);

    echo json_encode(['success' => true, 'message' => 'Item removed from wishlist']);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>