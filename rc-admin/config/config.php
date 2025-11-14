<?php
/**
 * General Configuration for Munchico Admin Panel
 * IMPORTANT: This file should NOT start sessions or set session ini
 */

// Site settings
define('SITE_NAME', 'Munchico');
define('SITE_URL', 'http://localhost/munchico');
define('ADMIN_URL', SITE_URL . '/rc-admin');

// Security settings
define('SESSION_TIMEOUT', 3600);              // 1 hour in seconds
define('MAX_LOGIN_ATTEMPTS', 5);              // Max failed login attempts
define('LOGIN_TIMEOUT', 900);                 // 15 minutes lockout after max attempts

// Password settings
define('MIN_PASSWORD_LENGTH', 8);

// Timezone
date_default_timezone_set('Asia/Karachi');

// Error reporting (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// NOTE: Session ini settings are now in includes/session.php
// They must be set BEFORE session_start() is called

?>