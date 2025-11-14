<?php
require_once 'includes/session.php';
require_once 'includes/auth.php';

$admin_name = isset($_SESSION['admin_name']) ? $_SESSION['admin_name'] : 'Admin';

// Perform logout
logout();

// Set flash message
session_start();
$_SESSION['logout_message'] = 'You have been successfully logged out.';
session_write_close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logging Out | <?php echo SITE_NAME; ?></title>
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

        .logout-card {
            background: white;
            border-radius: 24px;
            padding: 60px 50px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-width: 500px;
            text-align: center;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logout-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(16, 185, 129, 0.4);
        }

        .logout-icon i {
            font-size: 50px;
            color: white;
        }

        h1 {
            font-size: 32px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 16px;
        }

        .logout-message {
            font-size: 16px;
            color: #6b7280;
            margin-bottom: 12px;
        }

        .admin-name {
            font-size: 18px;
            color: #667eea;
            font-weight: 600;
            margin-bottom: 30px;
        }

        .redirect-info {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 16px;
            background: #f0fdf4;
            border-radius: 12px;
            margin-bottom: 30px;
        }

        .spinner {
            width: 16px;
            height: 16px;
            border: 2px solid #bbf7d0;
            border-top-color: #059669;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .redirect-info span {
            font-size: 14px;
            color: #166534;
            font-weight: 500;
        }

        .btn-login-now {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 16px 32px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            transition: all 0.3s ease;
        }

        .btn-login-now:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(102, 126, 234, 0.4);
        }
    </style>
</head>
<body>
    <div class="logout-card">
        <div class="logout-icon">
            <i class="fas fa-check"></i>
        </div>

        <h1>Successfully Logged Out</h1>
        
        <p class="logout-message">Thank you for using <?php echo SITE_NAME; ?> Admin Panel.</p>
        
        <p class="admin-name">Goodbye, <?php echo htmlspecialchars($admin_name); ?>! 👋</p>

        <div class="redirect-info">
            <div class="spinner"></div>
            <span>Redirecting in <strong id="countdown">3</strong> seconds...</span>
        </div>

        <a href="login.php" class="btn-login-now">
            <i class="fas fa-sign-in-alt"></i>
            Login Again
        </a>
    </div>

    <script>
        let countdown = 3;
        const countdownElement = document.getElementById('countdown');
        
        const timer = setInterval(() => {
            countdown--;
            countdownElement.textContent = countdown;
            
            if (countdown <= 0) {
                clearInterval(timer);
                window.location.href = 'login.php';
            }
        }, 1000);
    </script>
</body>
</html>