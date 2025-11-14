<?php
// includes/sidebar.php - Sidebar Navigation

// Set default if not defined
if (!isset($current_page)) {
    $current_page = '';
}
?>
<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="logo" onclick="window.location.href='index.php'">
            <i class="fas fa-shield-alt"></i>
            <span>ADMIN PANEL</span>
        </div>
    </div>

    <nav class="sidebar-nav">
        <ul class="nav-list">
            <li class="nav-item <?php echo ($current_page == 'dashboard') ? 'active' : ''; ?>">
                <a href="index.php">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item <?php echo ($current_page == 'products') ? 'active' : ''; ?>">
                <a href="products.php">
                    <i class="fas fa-box"></i>
                    <span>Products</span>
                </a>
            </li>
            <li class="nav-item <?php echo ($current_page == 'orders') ? 'active' : ''; ?>">
                <a href="orders.php">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Orders</span>
                </a>
            </li>
            <li class="nav-item <?php echo ($current_page == 'categories') ? 'active' : ''; ?>">
                <a href="categories.php">
                    <i class="fas fa-folder"></i>
                    <span>Categories</span>
                </a>
            </li>
            <li class="nav-item <?php echo ($current_page == 'users') ? 'active' : ''; ?>">
                <a href="users.php">
                    <i class="fas fa-users"></i>
                    <span>Users</span>
                </a>
            </li>
            <li class="nav-item <?php echo ($current_page == 'reports') ? 'active' : ''; ?>">
                <a href="reports.php">
                    <i class="fas fa-chart-bar"></i>
                    <span>Reports</span>
                </a>
            </li>
            <li class="nav-item <?php echo ($current_page == 'settings') ? 'active' : ''; ?>">
                <a href="settings.php">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>
            </li>
        </ul>
    </nav>

    <div class="sidebar-footer">
        <a href="logout.php" class="logout-btn">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </div>
</aside>