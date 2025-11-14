<?php
/**
 * Authentication Functions for Munchico Admin Panel
 */

// Load database configuration (no session stuff here)
require_once __DIR__ . '/../config/database.php';

/**
 * Verify admin login credentials
 */
function verifyLogin($email, $password) {
    $db = getDB();
    
    // Escape inputs
    $email = escapeString($email);
    
    // Check login attempts
    if (isLoginLocked($email)) {
        return [
            'success' => false,
            'message' => 'Too many failed attempts. Please try again in 15 minutes.'
        ];
    }
    
    // Query admin user
    $sql = "SELECT * FROM admins WHERE email = ? AND status = 'active' LIMIT 1";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $admin = $result->fetch_assoc();
        
        // Verify password
        if (password_verify($password, $admin['password'])) {
            // Reset login attempts
            resetLoginAttempts($email);
            
            // Update last login
            updateLastLogin($admin['id']);
            
            // Set session
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['name'];
            $_SESSION['admin_email'] = $admin['email'];
            $_SESSION['admin_role'] = $admin['role'];
            $_SESSION['login_time'] = time();
            $_SESSION['last_activity'] = time();
            
            return [
                'success' => true,
                'message' => 'Login successful'
            ];
        }
    }
    
    // Failed login
    recordFailedLogin($email);
    
    return [
        'success' => false,
        'message' => 'Invalid email or password'
    ];
}

/**
 * Check if user is logged in
 */
function isLoggedIn() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

/**
 * Check session timeout
 */
function checkSessionTimeout() {
    if (isLoggedIn()) {
        $last_activity = $_SESSION['last_activity'] ?? 0;
        
        if ((time() - $last_activity) > SESSION_TIMEOUT) {
            logout();
            return false;
        }
        
        $_SESSION['last_activity'] = time();
    }
    return true;
}

/**
 * Logout admin
 */
function logout() {
    $_SESSION = array();
    
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time()-3600, '/');
    }
    
    session_destroy();
}

/**
 * Record failed login attempt
 */
function recordFailedLogin($email) {
    $db = getDB();
    $email = escapeString($email);
    $ip_address = $_SERVER['REMOTE_ADDR'];
    
    $sql = "INSERT INTO login_attempts (email, ip_address, attempt_time) VALUES (?, ?, NOW())";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("ss", $email, $ip_address);
    $stmt->execute();
}

/**
 * Check if login is locked
 */
function isLoginLocked($email) {
    $db = getDB();
    $email = escapeString($email);
    $lockout_time = date('Y-m-d H:i:s', time() - LOGIN_TIMEOUT);
    
    $sql = "SELECT COUNT(*) as attempts FROM login_attempts 
            WHERE email = ? AND attempt_time > ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("ss", $email, $lockout_time);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    return $row['attempts'] >= MAX_LOGIN_ATTEMPTS;
}

/**
 * Reset login attempts
 */
function resetLoginAttempts($email) {
    $db = getDB();
    $email = escapeString($email);
    
    $sql = "DELETE FROM login_attempts WHERE email = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
}

/**
 * Update last login time
 */
function updateLastLogin($admin_id) {
    $db = getDB();
    $ip_address = $_SERVER['REMOTE_ADDR'];
    
    $sql = "UPDATE admins SET last_login = NOW(), last_ip = ? WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("si", $ip_address, $admin_id);
    $stmt->execute();
}

/**
 * Require login (use in protected pages)
 */
function requireLogin() {
    if (!isLoggedIn() || !checkSessionTimeout()) {
        // Use ob_start() to prevent header errors
        if (!headers_sent()) {
            header('Location: login.php');
            exit;
        } else {
            // Fallback if headers already sent
            echo '<script>window.location.href="login.php";</script>';
            echo '<noscript><meta http-equiv="refresh" content="0;url=login.php"></noscript>';
            exit;
        }
    }
}

?>