<?php
// IMPORTANT: Include session.php FIRST
require_once 'includes/session.php';
require_once 'includes/auth.php';

// Require login to access this page
requireLogin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | <?php echo SITE_NAME; ?> Admin</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="admin-wrapper">
        <!-- Include Sidebar -->
        <?php include 'includes/sidebar.php'; ?>

        <!-- Main Content Area -->
        <div class="main-content">
            <!-- Header -->
            <header class="top-header">
                <div class="header-left">
                    <button class="toggle-sidebar" id="toggleSidebar">
                        <i class="fas fa-bars"></i>
                    </button>
                    <!-- <h1>Welcome to Admin Panel</h1> -->
                </div>
                <div class="header-right">
                    <div class="user-info">
                        <span><?php echo htmlspecialchars($_SESSION['admin_name']); ?>!</span>
                        <i class="fas fa-user-circle"></i>
                    </div>
                </div>
            </header>

            <!-- Stats Section -->
            <?php include 'includes/stats.php'; ?>

            <!-- Action Buttons Section -->
            <div class="action-section">
                <h2>Quick Actions</h2>
                <div class="action-buttons-grid">
                    <!-- Button 1: Add Products -->
                    <div class="action-card">
                        <div class="action-content">
                            <div class="action-left">
                                <h3>Add Products</h3>
                                <p>Create and manage new products in your inventory</p>
                            </div>
                            <div class="action-right">
                                <button class="btn btn-primary" onclick="window.location.href='add-product.php'">
                                    <i class="fas fa-plus"></i> Add Product
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Button 2: Manage Orders -->
                    <div class="action-card">
                        <div class="action-content">
                            <div class="action-left">
                                <h3>Manage Orders</h3>
                                <p>View and process customer orders</p>
                            </div>
                            <div class="action-right">
                                <button class="btn btn-success" onclick="window.location.href='orders.php'">
                                    <i class="fas fa-shopping-cart"></i> View Orders
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Button 3: Add Categories -->
                    <div class="action-card">
                        <div class="action-content">
                            <div class="action-left">
                                <h3>Add Categories</h3>
                                <p>Organize your products with categories</p>
                            </div>
                            <div class="action-right">
                                <button class="btn btn-info" onclick="window.location.href='categories.php'">
                                    <i class="fas fa-folder-plus"></i> Add Category
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Button 4: User Management -->
                    <div class="action-card">
                        <div class="action-content">
                            <div class="action-left">
                                <h3>User Management</h3>
                                <p>Manage customer accounts and permissions</p>
                            </div>
                            <div class="action-right">
                                <button class="btn btn-warning" onclick="window.location.href='users.php'">
                                    <i class="fas fa-users"></i> Manage Users
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Button 5: Reports -->
                    <div class="action-card">
                        <div class="action-content">
                            <div class="action-left">
                                <h3>Sales Reports</h3>
                                <p>Generate and view sales analytics</p>
                            </div>
                            <div class="action-right">
                                <button class="btn btn-purple" onclick="window.location.href='reports.php'">
                                    <i class="fas fa-chart-line"></i> View Reports
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Button 6: Settings -->
                    <div class="action-card">
                        <div class="action-content">
                            <div class="action-left">
                                <h3>System Settings</h3>
                                <p>Configure system preferences and options</p>
                            </div>
                            <div class="action-right">
                                <button class="btn btn-dark" onclick="window.location.href='settings.php'">
                                    <i class="fas fa-cog"></i> Settings
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include 'includes/components/preloader.php'; ?>
            <?php include 'includes/components/reloader.php'; ?>
            <!-- Include Footer -->
            <?php include 'includes/footer.php'; ?>
        </div>
    </div>

    <script src="assets/js/script.js"></script>
</body>
</html>