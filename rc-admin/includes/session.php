<?php
/**
 * Session Management for Munchico Admin Panel
 * IMPORTANT: This file MUST be included FIRST before any other includes
 */

// Set session ini settings BEFORE starting the session
if (session_status() === PHP_SESSION_NONE) {
    // Configure session settings before session_start()
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    ini_set('session.cookie_secure', 0);      // Set to 1 if using HTTPS
    ini_set('session.cookie_samesite', 'Lax');
    
    // Start session with additional options
    session_start([
        'cookie_lifetime' => 0,               // Session cookie (closes with browser)
        'cookie_path' => '/',
        'cookie_secure' => false,             // Set to true if using HTTPS
        'cookie_httponly' => true,
        'cookie_samesite' => 'Lax',
        'use_strict_mode' => true,
        'use_only_cookies' => true
    ]);
}

// Load config after session is started
require_once __DIR__ . '/../config/config.php';

// Regenerate session ID periodically for security
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    if (!isset($_SESSION['created'])) {
        $_SESSION['created'] = time();
    } else if (time() - $_SESSION['created'] > 1800) {
        // Regenerate session every 30 minutes
        session_regenerate_id(true);
        $_SESSION['created'] = time();
    }
}

?>