<?php
// includes/stats.php - Statistics Cards
// You can fetch these values from database
$total_products = 1250;
$total_orders = 342;
$total_users = 890;
$total_revenue = 45680;
?>

<section class="stats-section">
    <div class="stats-grid">
        <!-- Stat Card 1: Total Products -->
        <div class="stat-card stat-blue">
            <div class="stat-icon">
                <i class="fas fa-box"></i>
            </div>
            <div class="stat-details">
                <h3><?php echo number_format($total_products); ?></h3>
                <p>Total Products</p>
            </div>
            <div class="stat-trend">
                <span class="trend-up">
                    <i class="fas fa-arrow-up"></i> 12%
                </span>
            </div>
        </div>

        <!-- Stat Card 2: Total Orders -->
        <div class="stat-card stat-green">
            <div class="stat-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-details">
                <h3><?php echo number_format($total_orders); ?></h3>
                <p>Total Orders</p>
            </div>
            <div class="stat-trend">
                <span class="trend-up">
                    <i class="fas fa-arrow-up"></i> 8%
                </span>
            </div>
        </div>

        <!-- Stat Card 3: Total Users -->
        <div class="stat-card stat-orange">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-details">
                <h3><?php echo number_format($total_users); ?></h3>
                <p>Total Users</p>
            </div>
            <div class="stat-trend">
                <span class="trend-up">
                    <i class="fas fa-arrow-up"></i> 5%
                </span>
            </div>
        </div>

        <!-- Stat Card 4: Total Revenue -->
        <div class="stat-card stat-purple">
            <div class="stat-icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="stat-details">
                <h3>$<?php echo number_format($total_revenue); ?></h3>
                <p>Total Revenue</p>
            </div>
            <div class="stat-trend">
                <span class="trend-up">
                    <i class="fas fa-arrow-up"></i> 15%
                </span>
            </div>
        </div>
    </div>
</section>