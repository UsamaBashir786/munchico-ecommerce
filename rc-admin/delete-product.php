<?php
// delete-product.php - Enhanced Product Deletion Handler
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

// Database connection
require_once 'config/database.php';
$conn = getDB();

// Check if product ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error_message'] = "Product ID is required.";
    header('Location: products.php');
    exit();
}

$product_id = (int)$_GET['id'];

// Check if this is a confirmation request
$confirmed = isset($_GET['confirm']) && $_GET['confirm'] === 'true';

if (!$confirmed) {
    // Show confirmation page
    showConfirmationPage($product_id, $conn);
    exit();
}

// Process deletion
processDeletion($product_id, $conn);

function showConfirmationPage($product_id, $conn) {
    // Get product details for confirmation
    $sql = "SELECT p.*, c.category_name 
            FROM products p 
            LEFT JOIN categories c ON p.category_id = c.id 
            WHERE p.id = ? AND p.is_active = 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        $_SESSION['error_message'] = "Product not found.";
        header('Location: products.php');
        exit();
    }
    
    $product = $result->fetch_assoc();
    $stmt->close();
    
    // Display confirmation page
    displayConfirmationHTML($product);
}

function displayConfirmationHTML($product) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Confirm Deletion | ADMIN PANEL</title>
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <style>
            .confirmation-container {
                max-width: 600px;
                margin: 50px auto;
                padding: 30px;
                background: white;
                border-radius: 12px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                text-align: center;
            }
            .warning-icon {
                font-size: 64px;
                color: #ef4444;
                margin-bottom: 20px;
            }
            .product-info {
                background: #f8fafc;
                padding: 20px;
                border-radius: 8px;
                margin: 20px 0;
                text-align: left;
            }
            .btn-group {
                display: flex;
                gap: 12px;
                justify-content: center;
                margin-top: 30px;
            }
            .btn-danger {
                background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
                color: white;
                border: none;
                padding: 12px 24px;
                border-radius: 6px;
                cursor: pointer;
                font-size: 16px;
            }
            .btn-secondary {
                background: #6b7280;
                color: white;
                border: none;
                padding: 12px 24px;
                border-radius: 6px;
                cursor: pointer;
                font-size: 16px;
                text-decoration: none;
                display: inline-block;
            }
        </style>
    </head>
    <body>
        <div class="admin-wrapper">
            <?php include 'includes/sidebar.php'; ?>
            
            <div class="main-content">
                <header class="top-header">
                    <div class="header-left">
                        <button class="toggle-sidebar" id="toggleSidebar">
                            <i class="fas fa-bars"></i>
                        </button>
                        <h1>Confirm Deletion</h1>
                    </div>
                </header>

                <div class="confirmation-container">
                    <div class="warning-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <h2>Are you sure you want to delete this product?</h2>
                    <p style="color: #6b7280; margin-bottom: 20px;">
                        This action cannot be undone. The product will be removed from the system and will no longer be available for sale.
                    </p>
                    
                    <div class="product-info">
                        <h3><?php echo htmlspecialchars($product['product_name']); ?></h3>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 15px;">
                            <div><strong>SKU:</strong> <?php echo htmlspecialchars($product['product_slug']); ?></div>
                            <div><strong>Category:</strong> <?php echo htmlspecialchars($product['category_name']); ?></div>
                            <div><strong>Price:</strong> $<?php echo number_format($product['regular_price'], 2); ?></div>
                            <div><strong>Stock:</strong> <?php echo number_format($product['stock_quantity']); ?></div>
                        </div>
                    </div>
                    
                    <div class="btn-group">
                        <a href="products.php" class="btn-secondary">
                            <i class="fas fa-arrow-left"></i> Cancel
                        </a>
                        <a href="delete-product.php?id=<?php echo $product['id']; ?>&confirm=true" class="btn-danger">
                            <i class="fas fa-trash"></i> Yes, Delete Product
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <script src="assets/js/script.js"></script>
    </body>
    </html>
    <?php
}

function processDeletion($product_id, $conn) {
    try {
        // Start transaction
        $conn->begin_transaction();
        
        // Get product details before deletion
        $product_sql = "SELECT * FROM products WHERE id = ?";
        $product_stmt = $conn->prepare($product_sql);
        $product_stmt->bind_param("i", $product_id);
        $product_stmt->execute();
        $product_result = $product_stmt->get_result();
        
        if ($product_result->num_rows === 0) {
            $_SESSION['error_message'] = "Product not found.";
            header('Location: products.php');
            exit();
        }
        
        $product = $product_result->fetch_assoc();
        $product_name = $product['product_name'];
        $product_stmt->close();
        
        // Create backup in deleted_products table (if table exists)
        $backup_sql = "CREATE TABLE IF NOT EXISTS deleted_products LIKE products";
        $conn->query($backup_sql);
        
        $backup_sql = "INSERT INTO deleted_products SELECT *, NOW() as deleted_at FROM products WHERE id = ?";
        $backup_stmt = $conn->prepare($backup_sql);
        $backup_stmt->bind_param("i", $product_id);
        $backup_stmt->execute();
        $backup_stmt->close();
        
        // Soft delete the product
        $delete_sql = "UPDATE products SET is_active = 0, updated_at = NOW() WHERE id = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("i", $product_id);
        
        if ($delete_stmt->execute()) {
            // Commit transaction
            $conn->commit();
            
            $_SESSION['success_message'] = "Product '{$product_name}' has been deleted successfully.";
            
            // Log the deletion action
            $admin_id = $_SESSION['admin_id'];
            $action = "DELETED_PRODUCT";
            $details = "Deleted product: {$product_name} (ID: {$product_id})";
            
            $log_sql = "INSERT INTO admin_logs (admin_id, action, details, ip_address) VALUES (?, ?, ?, ?)";
            $log_stmt = $conn->prepare($log_sql);
            $log_stmt->bind_param("isss", $admin_id, $action, $details, $_SERVER['REMOTE_ADDR']);
            $log_stmt->execute();
            $log_stmt->close();
            
        } else {
            throw new Exception("Failed to delete product: " . $delete_stmt->error);
        }
        
        $delete_stmt->close();
        
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        $_SESSION['error_message'] = "Error deleting product: " . $e->getMessage();
    }
    
    // Redirect back to products page
    header('Location: products.php');
    exit();
}
?>