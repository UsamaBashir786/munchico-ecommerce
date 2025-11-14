<?php
// orders.php - Order Management Page
session_start();

$page_title = "Orders";
$current_page = "orders";

// Example order data
$orders = [
    ['id' => 'ORD-2025-001', 'customer' => 'John Doe', 'email' => 'john@example.com', 'items' => 3, 'total' => '$234.50', 'status' => 'Delivered', 'payment' => 'Paid', 'date' => '2025-11-08', 'method' => 'Credit Card'],
    ['id' => 'ORD-2025-002', 'customer' => 'Sarah Smith', 'email' => 'sarah@example.com', 'items' => 5, 'total' => '$567.00', 'status' => 'Shipped', 'payment' => 'Paid', 'date' => '2025-11-09', 'method' => 'PayPal'],
    ['id' => 'ORD-2025-003', 'customer' => 'Mike Johnson', 'email' => 'mike@example.com', 'items' => 2, 'total' => '$123.75', 'status' => 'Processing', 'payment' => 'Pending', 'date' => '2025-11-10', 'method' => 'COD'],
    ['id' => 'ORD-2025-004', 'customer' => 'Emily Brown', 'email' => 'emily@example.com', 'items' => 7, 'total' => '$890.25', 'status' => 'Pending', 'payment' => 'Paid', 'date' => '2025-11-10', 'method' => 'Credit Card'],
    ['id' => 'ORD-2025-005', 'customer' => 'David Wilson', 'email' => 'david@example.com', 'items' => 4, 'total' => '$456.80', 'status' => 'Cancelled', 'payment' => 'Refunded', 'date' => '2025-11-07', 'method' => 'Debit Card']
];

$stats = [
    'total_orders' => 245,
    'pending' => 18,
    'processing' => 12,
    'completed' => 215,
    'total_revenue' => '$45,890',
    'today_orders' => 8
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> | ADMIN PANEL</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/orders.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                    <h1>Order Management</h1>
                </div>
                <div class="header-right">
                    <button class="btn btn-secondary">
                        <i class="fas fa-file-export"></i> Export Orders
                    </button>
                </div>
            </header>

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon" style="background: #3b82f6;">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="stat-details">
                        <p class="stat-label">Total Orders</p>
                        <h3 class="stat-value"><?php echo $stats['total_orders']; ?></h3>
                        <span class="stat-change positive">+12% from last month</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: #f59e0b;">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-details">
                        <p class="stat-label">Pending Orders</p>
                        <h3 class="stat-value"><?php echo $stats['pending']; ?></h3>
                        <span class="stat-change">Needs attention</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: #10b981;">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-details">
                        <p class="stat-label">Completed</p>
                        <h3 class="stat-value"><?php echo $stats['completed']; ?></h3>
                        <span class="stat-change positive">87.8% completion rate</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: #8b5cf6;">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="stat-details">
                        <p class="stat-label">Total Revenue</p>
                        <h3 class="stat-value"><?php echo $stats['total_revenue']; ?></h3>
                        <span class="stat-change positive">+18% from last month</span>
                    </div>
                </div>
            </div>

            <!-- Filters and Search -->
            <div class="content-section">
                <div class="filters-bar">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" id="searchOrders" placeholder="Search by order ID, customer name...">
                    </div>
                    <div class="filters">
                        <select id="filterStatus">
                            <option value="">All Status</option>
                            <option value="pending">Pending</option>
                            <option value="processing">Processing</option>
                            <option value="shipped">Shipped</option>
                            <option value="delivered">Delivered</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                        <select id="filterPayment">
                            <option value="">All Payments</option>
                            <option value="paid">Paid</option>
                            <option value="pending">Pending</option>
                            <option value="refunded">Refunded</option>
                        </select>
                        <input type="date" id="filterDate" class="date-filter">
                    </div>
                </div>

                <!-- Orders Table -->
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="selectAll"></th>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Items</th>
                                <th>Total</th>
                                <th>Payment Method</th>
                                <th>Payment Status</th>
                                <th>Order Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($orders as $order): ?>
                            <tr>
                                <td><input type="checkbox" class="order-checkbox" value="<?php echo $order['id']; ?>"></td>
                                <td><strong><?php echo $order['id']; ?></strong></td>
                                <td>
                                    <div class="customer-info">
                                        <span class="customer-name"><?php echo $order['customer']; ?></span>
                                        <span class="customer-email"><?php echo $order['email']; ?></span>
                                    </div>
                                </td>
                                <td><?php echo $order['items']; ?> items</td>
                                <td><strong><?php echo $order['total']; ?></strong></td>
                                <td>
                                    <span class="payment-method">
                                        <i class="fas fa-<?php 
                                            echo $order['method'] == 'Credit Card' ? 'credit-card' : 
                                                 ($order['method'] == 'PayPal' ? 'paypal' : 
                                                 ($order['method'] == 'COD' ? 'money-bill-wave' : 'credit-card')); 
                                        ?>"></i>
                                        <?php echo $order['method']; ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-payment badge-<?php echo strtolower($order['payment']); ?>">
                                        <?php echo $order['payment']; ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-status badge-<?php echo strtolower($order['status']); ?>">
                                        <?php echo $order['status']; ?>
                                    </span>
                                </td>
                                <td><?php echo date('M d, Y', strtotime($order['date'])); ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-action btn-view" title="View Details" onclick="viewOrder('<?php echo $order['id']; ?>')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn-action btn-edit" title="Update Status" onclick="updateOrderStatus('<?php echo $order['id']; ?>')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn-action btn-print" title="Print Invoice">
                                            <i class="fas fa-print"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="pagination">
                    <button class="btn btn-secondary btn-sm" disabled>
                        <i class="fas fa-chevron-left"></i> Previous
                    </button>
                    <div class="pagination-info">
                        Showing 1-5 of <?php echo $stats['total_orders']; ?> orders
                    </div>
                    <button class="btn btn-secondary btn-sm">
                        Next <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>

            <?php include 'includes/footer.php'; ?>
        </div>
    </div>

    <script src="assets/js/script.js"></script>
    <script src="assets/js/orders.js"></script>
</body>
</html>