<?php
session_start();

// Destroy all session data
session_unset();
session_destroy();

// Delete remember me cookie
if (isset($_COOKIE['user_email'])) {
    setcookie('user_email', '', time() - 3600, "/");
}

header('Location: login.php');
exit();
?>