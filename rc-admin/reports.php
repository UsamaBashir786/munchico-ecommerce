<?php
// reports.php - Reports & Analytics Page
session_start();

$page_title = "Reports";
$current_page = "reports";

$stats = [
    'total_revenue' => '$45,890',
    'total_orders' => 245,
    'avg_order_value' => '$187.31',
    'top_product' => 'Organic Almonds'
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> | ADMIN PANEL</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/reports.css">
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
                    <h1>Reports & Analytics</h1>
                </div>
                <div class="header-right">
                    <select id="dateRange" class="date-range-select">
                        <option value="7">Last 7 Days</option>
                        <option value="30" selected>Last 30 Days</option>
                        <option value="90">Last 90 Days</option>
                        <option value="365">Last Year</option>
                        <option value="custom">Custom Range</option>
                    </select>
                    <button class="btn btn-primary">
                        <i class="fas fa-download"></i> Export Report
                    </button>
                </div>
            </header>

            <!-- Key Metrics -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon" style="background: #10b981;">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="stat-details">
                        <p class="stat-label">Total Revenue</p>
                        <h3 class="stat-value"><?php echo $stats['total_revenue']; ?></h3>
                        <span class="stat-change positive"><i class="fas fa-arrow-up"></i> 18.2% vs last month</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: #3b82f6;">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <div class="stat-details">
                        <p class="stat-label">Total Orders</p>
                        <h3 class="stat-value"><?php echo $stats['total_orders']; ?></h3>
                        <span class="stat-change positive"><i class="fas fa-arrow-up"></i> 12.5% vs last month</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: #f59e0b;">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="stat-details">
                        <p class="stat-label">Avg. Order Value</p>
                        <h3 class="stat-value"><?php echo $stats['avg_order_value']; ?></h3>
                        <span class="stat-change positive"><i class="fas fa-arrow-up"></i> 5.1% vs last month</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: #8b5cf6;">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="stat-details">
                        <p class="stat-label">Top Product</p>
                        <h3 class="stat-value" style="font-size: 20px;"><?php echo $stats['top_product']; ?></h3>
                        <span class="stat-change">156 units sold</span>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="charts-row">
                <!-- Sales Chart -->
                <div class="chart-card">
                    <div class="chart-header">
                        <h3><i class="fas fa-chart-area"></i> Sales Overview</h3>
                        <div class="chart-actions">
                            <button class="chart-btn active" data-period="week">Week</button>
                            <button class="chart-btn" data-period="month">Month</button>
                            <button class="chart-btn" data-period="year">Year</button>
                        </div>
                    </div>
                    <div class="chart-body">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>

                <!-- Orders Chart -->
                <div class="chart-card">
                    <div class="chart-header">
                        <h3><i class="fas fa-shopping-cart"></i> Order Status Distribution</h3>
                    </div>
                    <div class="chart-body">
                        <canvas id="ordersChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Reports Grid -->
            <div class="reports-grid">
                <!-- Top Products -->
                <div class="report-card">
                    <div class="report-header">
                        <h3><i class="fas fa-trophy"></i> Top Selling Products</h3>
                        <a href="#" class="view-all">View All <i class="fas fa-arrow-right"></i></a>
                    </div>
                    <div class="report-body">
                        <table class="mini-table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Sales</th>
                                    <th>Revenue</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Organic Almonds</td>
                                    <td>156</td>
                                    <td>$1,872</td>
                                </tr>
                                <tr>
                                    <td>Dried Apricots</td>
                                    <td>134</td>
                                    <td>$1,608</td>
                                </tr>
                                <tr>
                                    <td>Cashew Nuts</td>
                                    <td>98</td>
                                    <td>$1,470</td>
                                </tr>
                                <tr>
                                    <td>Walnuts Premium</td>
                                    <td>87</td>
                                    <td>$1,305</td>
                                </tr>
                                <tr>
                                    <td>Dates Medjool</td>
                                    <td>76</td>
                                    <td>$1,140</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Top Customers -->
                <div class="report-card">
                    <div class="report-header">
                        <h3><i class="fas fa-users"></i> Top Customers</h3>
                        <a href="#" class="view-all">View All <i class="fas fa-arrow-right"></i></a>
                    </div>
                    <div class="report-body">
                        <table class="mini-table">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Orders</th>
                                    <th>Spent</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>John Doe</td>
                                    <td>45</td>
                                    <td>$2,340</td>
                                </tr>
                                <tr>
                                    <td>Sarah Smith</td>
                                    <td>32</td>
                                    <td>$1,920</td>
                                </tr>
                                <tr>
                                    <td>Mike Johnson</td>
                                    <td>28</td>
                                    <td>$1,680</td>
                                </tr>
                                <tr>
                                    <td>Emily Brown</td>
                                    <td>24</td>
                                    <td>$1,440</td>
                                </tr>
                                <tr>
                                    <td>David Wilson</td>
                                    <td>19</td>
                                    <td>$1,140</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="report-card">
                    <div class="report-header">
                        <h3><i class="fas fa-clock"></i> Recent Activity</h3>
                    </div>
                    <div class="report-body">
                        <div class="activity-list">
                            <div class="activity-item">
                                <div class="activity-icon" style="background: #10b981;">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <div class="activity-content">
                                    <p class="activity-text">New order <strong>#ORD-2025-245</strong> placed</p>
                                    <span class="activity-time">2 minutes ago</span>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon" style="background: #3b82f6;">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="activity-content">
                                    <p class="activity-text">New customer <strong>Jane Cooper</strong> registered</p>
                                    <span class="activity-time">15 minutes ago</span>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon" style="background: #f59e0b;">
                                    <i class="fas fa-box"></i>
                                </div>
                                <div class="activity-content">
                                    <p class="activity-text">Product <strong>Organic Almonds</strong> low in stock</p>
                                    <span class="activity-time">1 hour ago</span>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon" style="background: #8b5cf6;">
                                    <i class="fas fa-star"></i>
                                </div>
                                <div class="activity-content">
                                    <p class="activity-text">New review for <strong>Cashew Nuts</strong> (5 stars)</p>
                                    <span class="activity-time">3 hours ago</span>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon" style="background: #10b981;">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="activity-content">
                                    <p class="activity-text">Order <strong>#ORD-2025-240</strong> delivered</p>
                                    <span class="activity-time">5 hours ago</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Category Performance -->
                <div class="report-card">
                    <div class="report-header">
                        <h3><i class="fas fa-layer-group"></i> Category Performance</h3>
                    </div>
                    <div class="report-body">
                        <div class="category-bars">
                            <div class="category-bar-item">
                                <div class="category-info">
                                    <span class="category-name">Dried Fruits</span>
                                    <span class="category-value">$12,450</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: 85%; background: #10b981;"></div>
                                </div>
                                <span class="category-percent">85%</span>
                            </div>
                            <div class="category-bar-item">
                                <div class="category-info">
                                    <span class="category-name">Nuts</span>
                                    <span class="category-value">$10,230</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: 70%; background: #3b82f6;"></div>
                                </div>
                                <span class="category-percent">70%</span>
                            </div>
                            <div class="category-bar-item">
                                <div class="category-info">
                                    <span class="category-name">Seeds</span>
                                    <span class="category-value">$8,100</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: 55%; background: #f59e0b;"></div>
                                </div>
                                <span class="category-percent">55%</span>
                            </div>
                            <div class="category-bar-item">
                                <div class="category-info">
                                    <span class="category-name">Organic Products</span>
                                    <span class="category-value">$6,890</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: 47%; background: #8b5cf6;"></div>
                                </div>
                                <span class="category-percent">47%</span>
                            </div>
                            <div class="category-bar-item">
                                <div class="category-info">
                                    <span class="category-name">Snacks</span>
                                    <span class="category-value">$4,220</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: 29%; background: #ef4444;"></div>
                                </div>
                                <span class="category-percent">29%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php include 'includes/footer.php'; ?>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script src="assets/js/script.js"></script>
    <script src="assets/js/reports.js"></script>
</body>
</html>