<?php
session_start();
require_once 'config/database.php';
require_once 'config/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get POST data with null coalescing operator
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $address = trim($_POST['address'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $postal_code = trim($_POST['postal_code'] ?? '');
    
    // Validation
    $errors = [];
    
    if (empty($first_name) || empty($last_name) || empty($email) || empty($phone) || empty($password)) {
        $errors[] = "Required fields (name, email, phone, password) must be filled";
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    
    if (strlen($password) < PASSWORD_MIN_LENGTH) {
        $errors[] = "Password must be at least 8 characters";
    }
    
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match";
    }
    
    // Check if email already exists
    if (empty($errors)) {
        try {
            $database = new Database();
            $db = $database->getConnection();
            
            $query = "SELECT id FROM users WHERE email = :email";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                $errors[] = "Email already registered";
            }
        } catch(PDOException $e) {
            $errors[] = "Database error: " . $e->getMessage();
        }
    }
    
    if (count($errors) > 0) {
        $_SESSION['error'] = implode('<br>', $errors);
        header('Location: register.php');
        exit();
    }
    
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    try {
        // Insert user with address fields
        $query = "INSERT INTO users (first_name, last_name, email, phone, password, address, city, postal_code, status) 
                  VALUES (:first_name, :last_name, :email, :phone, :password, :address, :city, :postal_code, 'active')";
        
        $stmt = $db->prepare($query);
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':postal_code', $postal_code);
        
        if ($stmt->execute()) {
            $_SESSION['success'] = "Registration successful! Please login.";
            header('Location: login.php');
            exit();
        } else {
            $_SESSION['error'] = "Registration failed. Please try again.";
            header('Location: register.php');
            exit();
        }
    } catch(PDOException $e) {
        $_SESSION['error'] = "Registration error: " . $e->getMessage();
        header('Location: register.php');
        exit();
    }
} else {
    header('Location: register.php');
    exit();
}
?>