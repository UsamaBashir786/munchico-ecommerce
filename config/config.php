<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Site configuration
define('SITE_NAME', 'MUNCHICO');
define('SITE_URL', 'http://localhost/munchico');

// Security
define('PASSWORD_MIN_LENGTH', 8);

// File upload
define('UPLOAD_DIR', 'uploads/');
define('MAX_FILE_SIZE', 5242880); // 5MB
?>