<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

require_once 'config/database.php';

$database = new Database();
$db = $database->getConnection();

// Get user stats
$user_id = $_SESSION['user_id'];

// Total orders
$query = "SELECT COUNT(*) as total_orders FROM orders WHERE user_id = :user_id";
$stmt = $db->prepare($query);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$total_orders = $stmt->fetch(PDO::FETCH_ASSOC)['total_orders'];

// Pending orders
$query = "SELECT COUNT(*) as pending_orders FROM orders WHERE user_id = :user_id AND status IN ('pending', 'confirmed', 'preparing', 'out_for_delivery')";
$stmt = $db->prepare($query);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$pending_orders = $stmt->fetch(PDO::FETCH_ASSOC)['pending_orders'];

// Total spent
$query = "SELECT SUM(total_amount) as total_spent FROM orders WHERE user_id = :user_id AND payment_status = 'paid'";
$stmt = $db->prepare($query);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$total_spent = $stmt->fetch(PDO::FETCH_ASSOC)['total_spent'] ?? 0;

// Recent orders
$query = "SELECT * FROM orders WHERE user_id = :user_id ORDER BY created_at DESC LIMIT 5";
$stmt = $db->prepare($query);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$recent_orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - MUNCHICO</title>
    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-brand">MUNCHICO</div>
            <div class="nav-menu">
                <a href="dashboard.php" class="nav-link active">Dashboard</a>
                <a href="menu.php" class="nav-link">Menu</a>
                <a href="orders.php" class="nav-link">My Orders</a>
                <a href="profile.php" class="nav-link">Profile</a>
                <a href="logout.php" class="nav-link-logout">Logout</a>
            </div>
        </div>
    </nav>
    <div class="dashboard-container">
        <div class="welcome-section">
            <h1>Welcome back, <?php echo htmlspecialchars(explode(' ', $_SESSION['user_name'])[0]); ?>! 👋</h1>
            <p>Ready to order something delicious?</p>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">📦</div>
                <div class="stat-info">
                    <h3><?php echo $total_orders; ?></h3>
                    <p>Total Orders</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">⏳</div>
                <div class="stat-info">
                    <h3><?php echo $pending_orders; ?></h3>
                    <p>Active Orders</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">💰</div>
                <div class="stat-info">
                    <h3>Rs. <?php echo number_format($total_spent, 0); ?></h3>
                    <p>Total Spent</p>
                </div>
            </div>
        </div>

        <div class="recent-orders-section">
            <div class="section-header">
                <h2>Recent Orders</h2>
                <a href="orders.php" class="view-all">View All →</a>
            </div>
            
            <?php if (count($recent_orders) > 0): ?>
                <div class="orders-list">
                    <?php foreach ($recent_orders as $order): ?>
                        <div class="order-card">
                            <div class="order-header">
                                <div>
                                    <h3>Order #<?php echo $order['order_number']; ?></h3>
                                    <p class="order-date"><?php echo date('M d, Y', strtotime($order['created_at'])); ?></p>
                                </div>
                                <span class="status-badge status-<?php echo $order['status']; ?>">
                                    <?php echo ucfirst(str_replace('_', ' ', $order['status'])); ?>
                                </span>
                            </div>
                            <div class="order-amount">
                                <strong>Rs. <?php echo number_format($order['total_amount'], 0); ?></strong>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <p>No orders yet. Start ordering delicious food!</p>
                    <a href="index.php" class="btn-primary">Browse Menu</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Inter", -apple-system, sans-serif;
            background: #f5f5f5;
        }

        .navbar {
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 1rem 0;
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-brand {
            font-size: 1.5rem;
            font-weight: 800;
            color: #8b4513;
        }

        .nav-menu {
            display: flex;
            gap: 2rem;
        }

        .nav-link {
            color: #666;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        .nav-link:hover, .nav-link.active {
            color: #8b4513;
        }

        .nav-link-logout {
            color: #c00;
            text-decoration: none;
            font-weight: 600;
        }

        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 3rem 2rem;
        }

        .welcome-section {
            margin-bottom: 3rem;
        }

        .welcome-section h1 {
            font-size: 2.5rem;
            color: #1a1a1a;
            margin-bottom: 0.5rem;
        }

        .welcome-section p {
            color: #666;
            font-size: 1.1rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .stat-card {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 1.5rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .stat-icon {
            font-size: 3rem;
        }

        .stat-info h3 {
            font-size: 2rem;
            color: #1a1a1a;
            margin-bottom: 0.25rem;
        }

        .stat-info p {
            color: #666;
            font-size: 0.95rem;
        }

        .recent-orders-section {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .section-header h2 {
            font-size: 1.5rem;
            color: #1a1a1a;
        }

        .view-all {
            color: #8b4513;
            text-decoration: none;
            font-weight: 600;
        }

        .orders-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .order-card {
            border: 1px solid #e0e0e0;
            padding: 1.5rem;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .order-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .order-header h3 {
            color: #1a1a1a;
            font-size: 1.1rem;
        }

        .order-date {
            color: #999;
            font-size: 0.9rem;
            margin-top: 0.25rem;
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .status-pending { background: #fff3cd; color: #856404; }
        .status-confirmed { background: #cfe2ff; color: #084298; }
        .status-preparing { background: #e7d4ff; color: #6f42c1; }
        .status-out_for_delivery { background: #cff4fc; color: #055160; }
        .status-delivered { background: #d1e7dd; color: #0f5132; }
        .status-cancelled { background: #f8d7da; color: #842029; }

        .order-amount {
            color: #8b4513;
            font-size: 1.25rem;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #999;
        }

        .btn-primary {
            display: inline-block;
            margin-top: 1rem;
            padding: 0.75rem 2rem;
            background: #8b4513;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .nav-menu {
                gap: 1rem;
                font-size: 0.9rem;
            }
            
            .welcome-section h1 {
                font-size: 1.75rem;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</body>
</html>