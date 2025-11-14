<?php
// settings.php - Settings Page
session_start();

$page_title = "Settings";
$current_page = "settings";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> | ADMIN PANEL</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/settings.css">
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
                    <h1>Settings</h1>
                </div>
                <div class="header-right">
                    <button class="btn btn-primary" id="saveAllSettings">
                        <i class="fas fa-save"></i> Save All Changes
                    </button>
                </div>
            </header>

            <div class="settings-container">
                <!-- Settings Navigation -->
                <div class="settings-nav">
                    <button class="setting-nav-btn active" data-tab="general">
                        <i class="fas fa-cog"></i> General
                    </button>
                    <button class="setting-nav-btn" data-tab="store">
                        <i class="fas fa-store"></i> Store Info
                    </button>
                    <button class="setting-nav-btn" data-tab="payment">
                        <i class="fas fa-credit-card"></i> Payment
                    </button>
                    <button class="setting-nav-btn" data-tab="shipping">
                        <i class="fas fa-truck"></i> Shipping
                    </button>
                    <button class="setting-nav-btn" data-tab="email">
                        <i class="fas fa-envelope"></i> Email
                    </button>
                    <button class="setting-nav-btn" data-tab="notifications">
                        <i class="fas fa-bell"></i> Notifications
                    </button>
                    <button class="setting-nav-btn" data-tab="security">
                        <i class="fas fa-shield-alt"></i> Security
                    </button>
                    <button class="setting-nav-btn" data-tab="seo">
                        <i class="fas fa-search"></i> SEO
                    </button>
                </div>

                <!-- Settings Content -->
                <div class="settings-content">
                    
                    <!-- General Settings -->
                    <div class="setting-tab active" id="general">
                        <h2 class="setting-title">General Settings</h2>
                        
                        <div class="form-section">
                            <div class="form-group">
                                <label for="site_name">Site Name</label>
                                <input type="text" id="site_name" value="Dry Fruits Store" placeholder="Enter site name">
                            </div>
                            
                            <div class="form-group">
                                <label for="site_tagline">Site Tagline</label>
                                <input type="text" id="site_tagline" value="Premium Quality Dry Fruits & Nuts" placeholder="Enter tagline">
                            </div>
                            
                            <div class="form-group">
                                <label for="timezone">Timezone</label>
                                <select id="timezone">
                                    <option value="UTC">UTC</option>
                                    <option value="Asia/Karachi" selected>Asia/Karachi (PKT)</option>
                                    <option value="America/New_York">America/New York (EST)</option>
                                    <option value="Europe/London">Europe/London (GMT)</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="date_format">Date Format</label>
                                <select id="date_format">
                                    <option value="m/d/Y">MM/DD/YYYY</option>
                                    <option value="d/m/Y" selected>DD/MM/YYYY</option>
                                    <option value="Y-m-d">YYYY-MM-DD</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="currency">Currency</label>
                                <select id="currency">
                                    <option value="USD" selected>USD - US Dollar</option>
                                    <option value="PKR">PKR - Pakistani Rupee</option>
                                    <option value="EUR">EUR - Euro</option>
                                    <option value="GBP">GBP - British Pound</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" name="maintenance_mode">
                                    Enable Maintenance Mode
                                </label>
                                <small>When enabled, only administrators can access the site</small>
                            </div>
                        </div>
                    </div>

                    <!-- Store Info Settings -->
                    <div class="setting-tab" id="store">
                        <h2 class="setting-title">Store Information</h2>
                        
                        <div class="form-section">
                            <div class="form-group">
                                <label for="store_name">Store Name</label>
                                <input type="text" id="store_name" value="Dry Fruits Store">
                            </div>
                            
                            <div class="form-group">
                                <label for="store_email">Store Email</label>
                                <input type="email" id="store_email" value="info@dryfruits.com">
                            </div>
                            
                            <div class="form-group">
                                <label for="store_phone">Store Phone</label>
                                <input type="tel" id="store_phone" value="+92 300 1234567">
                            </div>
                            
                            <div class="form-group">
                                <label for="store_address">Store Address</label>
                                <textarea id="store_address" rows="3">123 Market Street, Muzaffargarh, Punjab, Pakistan</textarea>
                            </div>
                            
                            <div class="form-group">
                                <label for="store_logo">Store Logo</label>
                                <div class="file-upload">
                                    <input type="file" id="store_logo" accept="image/*">
                                    <div class="file-preview">
                                        <i class="fas fa-image"></i>
                                        <p>Upload Logo (Max 2MB)</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="store_favicon">Store Favicon</label>
                                <div class="file-upload">
                                    <input type="file" id="store_favicon" accept="image/x-icon,image/png">
                                    <div class="file-preview">
                                        <i class="fas fa-image"></i>
                                        <p>Upload Favicon (32x32 or 64x64)</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Settings -->
                    <div class="setting-tab" id="payment">
                        <h2 class="setting-title">Payment Settings</h2>
                        
                        <div class="payment-methods">
                            <div class="payment-method-card">
                                <div class="payment-header">
                                    <div class="payment-info">
                                        <i class="fas fa-credit-card"></i>
                                        <h3>Credit/Debit Card</h3>
                                    </div>
                                    <label class="toggle-switch">
                                        <input type="checkbox" checked>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </div>
                                <div class="payment-details">
                                    <div class="form-group">
                                        <label>API Key</label>
                                        <input type="text" placeholder="Enter API key">
                                    </div>
                                    <div class="form-group">
                                        <label>Secret Key</label>
                                        <input type="password" placeholder="Enter secret key">
                                    </div>
                                </div>
                            </div>

                            <div class="payment-method-card">
                                <div class="payment-header">
                                    <div class="payment-info">
                                        <i class="fab fa-paypal"></i>
                                        <h3>PayPal</h3>
                                    </div>
                                    <label class="toggle-switch">
                                        <input type="checkbox" checked>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </div>
                                <div class="payment-details">
                                    <div class="form-group">
                                        <label>Client ID</label>
                                        <input type="text" placeholder="Enter client ID">
                                    </div>
                                    <div class="form-group">
                                        <label>Secret</label>
                                        <input type="password" placeholder="Enter secret">
                                    </div>
                                </div>
                            </div>

                            <div class="payment-method-card">
                                <div class="payment-header">
                                    <div class="payment-info">
                                        <i class="fas fa-money-bill-wave"></i>
                                        <h3>Cash on Delivery</h3>
                                    </div>
                                    <label class="toggle-switch">
                                        <input type="checkbox" checked>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </div>
                                <div class="payment-details">
                                    <div class="form-group">
                                        <label>Extra Charges</label>
                                        <input type="number" placeholder="0.00" value="50">
                                        <small>Additional charges for COD orders</small>
                                    </div>
                                </div>
                            </div>

                            <div class="payment-method-card">
                                <div class="payment-header">
                                    <div class="payment-info">
                                        <i class="fas fa-university"></i>
                                        <h3>Bank Transfer</h3>
                                    </div>
                                    <label class="toggle-switch">
                                        <input type="checkbox">
                                        <span class="toggle-slider"></span>
                                    </label>
                                </div>
                                <div class="payment-details">
                                    <div class="form-group">
                                        <label>Bank Account Details</label>
                                        <textarea rows="4" placeholder="Enter bank account information"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Settings -->
                    <div class="setting-tab" id="shipping">
                        <h2 class="setting-title">Shipping Settings</h2>
                        
                        <div class="form-section">
                            <div class="form-group">
                                <label for="free_shipping_threshold">Free Shipping Threshold</label>
                                <input type="number" id="free_shipping_threshold" value="1000" placeholder="0.00">
                                <small>Orders above this amount qualify for free shipping</small>
                            </div>
                            
                            <div class="form-group">
                                <label for="flat_shipping_rate">Flat Shipping Rate</label>
                                <input type="number" id="flat_shipping_rate" value="150" placeholder="0.00">
                            </div>
                            
                            <div class="form-group">
                                <label for="shipping_zones">Shipping Zones</label>
                                <div class="zone-list">
                                    <div class="zone-item">
                                        <input type="text" value="Muzaffargarh" readonly>
                                        <input type="number" value="0" placeholder="Rate">
                                        <button class="btn-remove"><i class="fas fa-times"></i></button>
                                    </div>
                                    <div class="zone-item">
                                        <input type="text" value="Punjab" readonly>
                                        <input type="number" value="150" placeholder="Rate">
                                        <button class="btn-remove"><i class="fas fa-times"></i></button>
                                    </div>
                                    <div class="zone-item">
                                        <input type="text" value="Other Cities" readonly>
                                        <input type="number" value="250" placeholder="Rate">
                                        <button class="btn-remove"><i class="fas fa-times"></i></button>
                                    </div>
                                </div>
                                <button class="btn btn-secondary btn-sm"><i class="fas fa-plus"></i> Add Zone</button>
                            </div>
                            
                            <div class="form-group">
                                <label for="processing_time">Order Processing Time</label>
                                <select id="processing_time">
                                    <option value="1">1-2 Business Days</option>
                                    <option value="2" selected>2-3 Business Days</option>
                                    <option value="3">3-5 Business Days</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Email Settings -->
                    <div class="setting-tab" id="email">
                        <h2 class="setting-title">Email Settings</h2>
                        
                        <div class="form-section">
                            <div class="form-group">
                                <label for="smtp_host">SMTP Host</label>
                                <input type="text" id="smtp_host" placeholder="smtp.example.com">
                            </div>
                            
                            <div class="form-group">
                                <label for="smtp_port">SMTP Port</label>
                                <input type="number" id="smtp_port" value="587" placeholder="587">
                            </div>
                            
                            <div class="form-group">
                                <label for="smtp_username">SMTP Username</label>
                                <input type="text" id="smtp_username" placeholder="your-email@example.com">
                            </div>
                            
                            <div class="form-group">
                                <label for="smtp_password">SMTP Password</label>
                                <input type="password" id="smtp_password" placeholder="••••••••">
                            </div>
                            
                            <div class="form-group">
                                <label for="from_email">From Email</label>
                                <input type="email" id="from_email" value="noreply@dryfruits.com">
                            </div>
                            
                            <div class="form-group">
                                <label for="from_name">From Name</label>
                                <input type="text" id="from_name" value="Dry Fruits Store">
                            </div>
                            
                            <div class="form-group">
                                <button class="btn btn-secondary">
                                    <i class="fas fa-paper-plane"></i> Send Test Email
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Notification Settings -->
                    <div class="setting-tab" id="notifications">
                        <h2 class="setting-title">Notification Settings</h2>
                        
                        <div class="notification-groups">
                            <div class="notification-group">
                                <h3>Order Notifications</h3>
                                <div class="notification-items">
                                    <label class="checkbox-label">
                                        <input type="checkbox" checked>
                                        New order received
                                    </label>
                                    <label class="checkbox-label">
                                        <input type="checkbox" checked>
                                        Order status changed
                                    </label>
                                    <label class="checkbox-label">
                                        <input type="checkbox">
                                        Order cancelled
                                    </label>
                                </div>
                            </div>
                            
                            <div class="notification-group">
                                <h3>Product Notifications</h3>
                                <div class="notification-items">
                                    <label class="checkbox-label">
                                        <input type="checkbox" checked>
                                        Low stock alert
                                    </label>
                                    <label class="checkbox-label">
                                        <input type="checkbox">
                                        Out of stock alert
                                    </label>
                                    <label class="checkbox-label">
                                        <input type="checkbox" checked>
                                        New product added
                                    </label>
                                </div>
                            </div>
                            
                            <div class="notification-group">
                                <h3>Customer Notifications</h3>
                                <div class="notification-items">
                                    <label class="checkbox-label">
                                        <input type="checkbox" checked>
                                        New customer registration
                                    </label>
                                    <label class="checkbox-label">
                                        <input type="checkbox" checked>
                                        New review submitted
                                    </label>
                                    <label class="checkbox-label">
                                        <input type="checkbox">
                                        Customer message
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Security Settings -->
                    <div class="setting-tab" id="security">
                        <h2 class="setting-title">Security Settings</h2>
                        
                        <div class="form-section">
                            <div class="form-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" checked>
                                    Enable Two-Factor Authentication (2FA)
                                </label>
                            </div>
                            
                            <div class="form-group">
                                <label for="session_timeout">Session Timeout (minutes)</label>
                                <input type="number" id="session_timeout" value="30" min="5" max="1440">
                            </div>
                            
                            <div class="form-group">
                                <label for="password_strength">Minimum Password Strength</label>
                                <select id="password_strength">
                                    <option value="weak">Weak (6+ characters)</option>
                                    <option value="medium" selected>Medium (8+ characters, mixed case)</option>
                                    <option value="strong">Strong (10+ characters, special chars)</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" checked>
                                    Enable Login Attempt Limiting
                                </label>
                                <small>Block IP after 5 failed login attempts</small>
                            </div>
                            
                            <div class="form-group">
                                <label class="checkbox-label">
                                    <input type="checkbox">
                                    Enable SSL/HTTPS Redirect
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- SEO Settings -->
                    <div class="setting-tab" id="seo">
                        <h2 class="setting-title">SEO Settings</h2>
                        
                        <div class="form-section">
                            <div class="form-group">
                                <label for="meta_title">Site Meta Title</label>
                                <input type="text" id="meta_title" value="Premium Dry Fruits & Nuts | Best Quality">
                                <small>60 characters recommended</small>
                            </div>
                            
                            <div class="form-group">
                                <label for="meta_description">Site Meta Description</label>
                                <textarea id="meta_description" rows="3">Shop premium quality dry fruits, nuts, seeds and organic products at the best prices. Fast delivery across Pakistan.</textarea>
                                <small>160 characters recommended</small>
                            </div>
                            
                            <div class="form-group">
                                <label for="meta_keywords">Meta Keywords</label>
                                <input type="text" id="meta_keywords" value="dry fruits, nuts, almonds, cashews, dates, organic">
                                <small>Comma separated keywords</small>
                            </div>
                            
                            <div class="form-group">
                                <label for="google_analytics">Google Analytics ID</label>
                                <input type="text" id="google_analytics" placeholder="G-XXXXXXXXXX">
                            </div>
                            
                            <div class="form-group">
                                <label for="google_search_console">Google Search Console Verification</label>
                                <input type="text" id="google_search_console" placeholder="Verification code">
                            </div>
                            
                            <div class="form-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" checked>
                                    Generate XML Sitemap Automatically
                                </label>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <?php include 'includes/footer.php'; ?>
        </div>
    </div>

    <script src="assets/js/script.js"></script>
    <script src="assets/js/settings.js"></script>
</body>
</html>