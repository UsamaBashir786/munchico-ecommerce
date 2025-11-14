<?php
/**
 * Update Admin Credentials Script for Munchico Admin Panel
 * 
 * This script will update the admin email and password
 * Run this ONCE, then DELETE this file for security!
 * 
 * New Credentials:
 * Email: panel@munchico.com
 * Password: panel@123
 */

// Database configuration
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'munchico_db';

// New admin credentials
$new_email = 'panel@munchico.com';
$new_password = 'panel@123';
$admin_name = 'Administrator';

$success = false;
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Connect to database
        $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
        
        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }
        
        // Hash the new password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        
        // Check if admin with old email exists
        $old_email = 'admin@munchico.com';
        $check_sql = "SELECT id FROM admins WHERE email = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("s", $old_email);
        $check_stmt->execute();
        $result = $check_stmt->get_result();
        
        if ($result->num_rows > 0) {
            // Update existing admin
            $sql = "UPDATE admins SET email = ?, password = ?, name = ? WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $new_email, $hashed_password, $admin_name, $old_email);
        } else {
            // Insert new admin
            $sql = "INSERT INTO admins (name, email, password, role, status) VALUES (?, ?, ?, 'super_admin', 'active')";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $admin_name, $new_email, $hashed_password);
        }
        
        if ($stmt->execute()) {
            $success = true;
        } else {
            throw new Exception("Failed to update credentials: " . $stmt->error);
        }
        
        $conn->close();
        
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Admin Credentials - Munchico</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 600px;
        }

        .card {
            background: white;
            border-radius: 24px;
            padding: 48px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: slideUp 0.5s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            box-shadow: 0 8px 24px rgba(102, 126, 234, 0.4);
        }

        .icon i {
            font-size: 40px;
            color: white;
        }

        h1 {
            font-size: 28px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 8px;
        }

        .subtitle {
            font-size: 15px;
            color: #6b7280;
        }

        .warning-box {
            background: #fef3c7;
            border: 2px solid #fcd34d;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 24px;
        }

        .warning-box h3 {
            color: #92400e;
            font-size: 16px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .warning-box p {
            color: #92400e;
            font-size: 14px;
            line-height: 1.6;
        }

        .info-box {
            background: #eff6ff;
            border: 2px solid #bfdbfe;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 24px;
        }

        .info-box h3 {
            color: #1e40af;
            font-size: 16px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .credentials {
            background: #f9fafb;
            border-radius: 10px;
            padding: 16px;
            margin-top: 12px;
        }

        .credentials-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .credentials-item:last-child {
            border-bottom: none;
        }

        .credentials-label {
            font-size: 14px;
            color: #6b7280;
            font-weight: 600;
        }

        .credentials-value {
            font-size: 14px;
            color: #1f2937;
            font-family: 'Courier New', monospace;
            background: white;
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 600;
        }

        .success-box {
            background: #d1fae5;
            border: 2px solid #6ee7b7;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 24px;
            animation: scaleIn 0.5s ease;
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .success-box h3 {
            color: #065f46;
            font-size: 18px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .success-box p {
            color: #065f46;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 8px;
        }

        .error-box {
            background: #fee2e2;
            border: 2px solid #fecaca;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 24px;
        }

        .error-box p {
            color: #dc2626;
            font-size: 14px;
            line-height: 1.6;
        }

        .btn {
            width: 100%;
            padding: 16px;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(102, 126, 234, 0.4);
        }

        .btn-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(16, 185, 129, 0.4);
        }

        .btn-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            margin-top: 12px;
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(239, 68, 68, 0.4);
        }

        .footer {
            text-align: center;
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid #e5e7eb;
            font-size: 13px;
            color: #6b7280;
        }

        @media (max-width: 768px) {
            .card {
                padding: 32px 24px;
            }

            .credentials-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="header">
                <div class="icon">
                    <i class="fas fa-key"></i>
                </div>
                <h1>Update Admin Credentials</h1>
                <p class="subtitle">Munchico Admin Panel</p>
            </div>

            <?php if (!$success && !$error_message): ?>
            
            <div class="warning-box">
                <h3><i class="fas fa-exclamation-triangle"></i> Important Security Notice!</h3>
                <p>
                    This script will update your admin login credentials. 
                    <strong>Run this ONCE and DELETE this file immediately after use!</strong>
                </p>
            </div>

            <div class="info-box">
                <h3><i class="fas fa-info-circle"></i> New Credentials</h3>
                <div class="credentials">
                    <div class="credentials-item">
                        <span class="credentials-label">Email:</span>
                        <span class="credentials-value"><?php echo htmlspecialchars($new_email); ?></span>
                    </div>
                    <div class="credentials-item">
                        <span class="credentials-label">Password:</span>
                        <span class="credentials-value"><?php echo htmlspecialchars($new_password); ?></span>
                    </div>
                    <div class="credentials-item">
                        <span class="credentials-label">Role:</span>
                        <span class="credentials-value">Super Admin</span>
                    </div>
                </div>
            </div>

            <form method="POST">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-sync-alt"></i>
                    Update Credentials Now
                </button>
            </form>

            <?php endif; ?>

            <?php if ($success): ?>
            
            <div class="success-box">
                <h3><i class="fas fa-check-circle"></i> Success!</h3>
                <p>✓ Admin credentials have been updated successfully!</p>
                <p>✓ You can now login with the new credentials.</p>
            </div>

            <div class="credentials">
                <div class="credentials-item">
                    <span class="credentials-label">Email:</span>
                    <span class="credentials-value"><?php echo htmlspecialchars($new_email); ?></span>
                </div>
                <div class="credentials-item">
                    <span class="credentials-label">Password:</span>
                    <span class="credentials-value"><?php echo htmlspecialchars($new_password); ?></span>
                </div>
            </div>

            <a href="login.php" class="btn btn-success">
                <i class="fas fa-sign-in-alt"></i>
                Go to Login Page
            </a>

            <button onclick="confirmDelete()" class="btn btn-danger">
                <i class="fas fa-trash-alt"></i>
                I've Saved the Credentials - Help Me Delete This File
            </button>

            <?php endif; ?>

            <?php if ($error_message): ?>
            
            <div class="error-box">
                <p><strong>Error:</strong> <?php echo htmlspecialchars($error_message); ?></p>
            </div>

            <form method="POST">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-redo"></i>
                    Try Again
                </button>
            </form>

            <?php endif; ?>

            <div class="footer">
                <strong>⚠️ Security Warning:</strong> Delete this file after use!<br>
                File location: <code><?php echo __FILE__; ?></code>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete() {
            if (confirm('Have you saved the new credentials?\n\nEmail: <?php echo $new_email; ?>\nPassword: <?php echo $new_password; ?>')) {
                alert('Please manually delete this file from your server:\n\n<?php echo basename(__FILE__); ?>\n\nFor security reasons, PHP cannot delete itself while running.');
                
                // Show instructions
                const instructions = `
To delete this file:

1. Via FTP/File Manager:
   - Navigate to: rc-admin/
   - Delete file: <?php echo basename(__FILE__); ?>

2. Via Command Line:
   cd rc-admin/
   rm <?php echo basename(__FILE__); ?>

3. Via File Manager in cPanel/DirectAdmin:
   - Find and delete: <?php echo basename(__FILE__); ?>
                `;
                
                console.log(instructions);
                alert('Deletion instructions have been logged to the browser console (F12)');
            }
        }

        // Auto-hide success message after 10 seconds
        <?php if ($success): ?>
        setTimeout(() => {
            if (confirm('Credentials updated! Ready to go to login page?')) {
                window.location.href = 'login.php';
            }
        }, 3000);
        <?php endif; ?>
    </script>
</body>
</html>