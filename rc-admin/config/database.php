<?php
/**
 * Database Configuration for Munchico Admin Panel
 * Make sure to update these credentials for your server
 */

// Database credentials
define('DB_HOST', 'localhost');
define('DB_USER', 'root');                    // Your database username
define('DB_PASS', '');                        // Your database password
define('DB_NAME', 'munchico_db');             // Your database name
define('DB_CHARSET', 'utf8mb4');

// Create database connection
class Database {
    private static $instance = null;
    private $connection;
    
    private function __construct() {
        try {
            $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            
            // Check connection
            if ($this->connection->connect_error) {
                throw new Exception("Connection failed: " . $this->connection->connect_error);
            }
            
            // Set charset
            $this->connection->set_charset(DB_CHARSET);
            
        } catch (Exception $e) {
            die("Database Error: " . $e->getMessage());
        }
    }
    
    // Singleton pattern
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->connection;
    }
    
    // Prevent cloning
    private function __clone() {}
    
    // Prevent unserializing
    public function __wakeup() {
        throw new Exception("Cannot unserialize singleton");
    }
}

// Get database connection
function getDB() {
    return Database::getInstance()->getConnection();
}

// Escape string for SQL
function escapeString($string) {
    $db = getDB();
    return $db->real_escape_string($string);
}

?>