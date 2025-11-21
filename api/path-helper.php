<?php
class PathHelper {
    // Base URL for the website
    private static $baseUrl = '';
    
    public static function setBaseUrl($url) {
        self::$baseUrl = rtrim($url, '/');
    }
    
    public static function getProductImageUrl($imagePath) {
        if (empty($imagePath)) {
            return self::$baseUrl . '/assets/images/placeholder-product.jpg';
        }
        
        // Remove any leading slashes
        $imagePath = ltrim($imagePath, '/');
        
        // If path already contains rc-admin, use as is
        if (strpos($imagePath, 'rc-admin/') === 0) {
            return self::$baseUrl . '/' . $imagePath;
        }
        
        // If path starts with uploads/
        if (strpos($imagePath, 'uploads/') === 0) {
            return self::$baseUrl . '/rc-admin/' . $imagePath;
        }
        
        // Default: assume it's in rc-admin/uploads/products/
        return self::$baseUrl . '/rc-admin/uploads/products/' . basename($imagePath);
    }
    
    public static function getCategoryImageUrl($imagePath) {
        if (empty($imagePath)) {
            return self::$baseUrl . '/assets/images/placeholder-category.jpg';
        }
        
        // Remove any leading slashes
        $imagePath = ltrim($imagePath, '/');
        
        // If path already contains rc-admin or assets
        if (strpos($imagePath, 'rc-admin/') === 0 || strpos($imagePath, 'assets/') === 0) {
            return self::$baseUrl . '/' . $imagePath;
        }
        
        // Default: assume it's in rc-admin/
        return self::$baseUrl . '/rc-admin/' . $imagePath;
    }
}

// Auto-detect base URL
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$baseUrl = $protocol . '://' . $host;
PathHelper::setBaseUrl($baseUrl);
?>