<?php
session_start();
require_once 'config/database.php';
require_once 'config/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $remember = isset($_POST['remember']);
    
    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Email and password are required";
        header('Location: login.php');
        exit();
    }
    
    $database = new Database();
    $db = $database->getConnection();
    
    $query = "SELECT * FROM users WHERE email = :email AND status = 'active'";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    
    if ($stmt->rowCount() == 1) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['logged_in'] = true;
            
            // Remember me functionality
            if ($remember) {
                setcookie('user_email', $email, time() + (86400 * 30), "/");
            }
            
            header('Location: dashboard.php');
        } else {
            $_SESSION['error'] = "Invalid email or password";
            header('Location: login.php');
        }
    } else {
        $_SESSION['error'] = "Invalid email or password";
        header('Location: login.php');
    }
} else {
    header('Location: login.php');
}
?>