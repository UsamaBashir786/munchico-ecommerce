<?php
// categories.php - Categories Management Page
session_start();

$page_title = "Categories";
$current_page = "categories";

// Database connection
require_once 'config/database.php';
$db = getDB();

// Handle file upload
function handleImageUpload() {
    if (isset($_FILES['category_image']) && $_FILES['category_image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'assets/images/categories/';
        
        // Create directory if it doesn't exist
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $fileName = uniqid() . '_' . basename($_FILES['category_image']['name']);
        $uploadFile = $uploadDir . $fileName;
        
        // Check if file is an image
        $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        
        if (in_array($imageFileType, $allowedTypes)) {
            // Check file size (max 5MB)
            if ($_FILES['category_image']['size'] > 5 * 1024 * 1024) {
                $_SESSION['error'] = "File size must be less than 5MB";
                return null;
            }
            
            if (move_uploaded_file($_FILES['category_image']['tmp_name'], $uploadFile)) {
                return $uploadFile;
            } else {
                $_SESSION['error'] = "Failed to upload image";
                return null;
            }
        } else {
            $_SESSION['error'] = "Only JPG, JPEG, PNG, GIF & WebP files are allowed";
            return null;
        }
    }
    return null;
}

// Handle CRUD operations
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'create':
                createCategory($db);
                break;
            case 'update':
                updateCategory($db);
                break;
            case 'delete':
                deleteCategory($db);
                break;
        }
    }
}

// CRUD Functions
function createCategory($db) {
    try {
        $slug = createSlug($_POST['category_name']);
        $parent_id = !empty($_POST['parent_category_id']) ? $_POST['parent_category_id'] : null;
        $show_homepage = isset($_POST['show_on_homepage']) ? 1 : 0;
        $is_featured = isset($_POST['is_featured']) ? 1 : 0;
        $is_active = isset($_POST['is_active']) ? 1 : 0;
        
        // Handle image upload
        $category_image = handleImageUpload();
        
        $stmt = $db->prepare("INSERT INTO categories (category_name, category_slug, parent_category_id, description, category_image, display_order, icon_class, color, show_on_homepage, is_featured, is_active, meta_title, meta_description, meta_keywords) 
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        $stmt->bind_param("ssississsiisss", 
            $_POST['category_name'],
            $slug,
            $parent_id,
            $_POST['description'],
            $category_image,
            $_POST['display_order'],
            $_POST['icon_class'],
            $_POST['color'],
            $show_homepage,
            $is_featured,
            $is_active,
            $_POST['meta_title'],
            $_POST['meta_description'],
            $_POST['meta_keywords']
        );
        
        if ($stmt->execute()) {
            $_SESSION['success'] = "Category created successfully!";
        } else {
            throw new Exception("Error creating category: " . $stmt->error);
        }
        
        $stmt->close();
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
    }
    header("Location: categories.php");
    exit;
}

function updateCategory($db) {
    try {
        $slug = createSlug($_POST['category_name']);
        $parent_id = !empty($_POST['parent_category_id']) ? $_POST['parent_category_id'] : null;
        $show_homepage = isset($_POST['show_on_homepage']) ? 1 : 0;
        $is_featured = isset($_POST['is_featured']) ? 1 : 0;
        $is_active = isset($_POST['is_active']) ? 1 : 0;
        
        // Handle image upload
        $category_image = handleImageUpload();
        
        // If no new image uploaded, keep the existing one
        if (!$category_image) {
            $category_image = $_POST['existing_image'] ?? null;
        }
        
        // If remove image is set, set category_image to null
        if (isset($_POST['remove_image']) && $_POST['remove_image'] == '1') {
            $category_image = null;
        }
        
        $stmt = $db->prepare("UPDATE categories SET 
                              category_name = ?, category_slug = ?, parent_category_id = ?, description = ?, 
                              category_image = ?, display_order = ?, icon_class = ?, color = ?, 
                              show_on_homepage = ?, is_featured = ?, is_active = ?, 
                              meta_title = ?, meta_description = ?, meta_keywords = ?, updated_at = CURRENT_TIMESTAMP 
                              WHERE id = ?");
        
        $stmt->bind_param("ssississsiisssi", 
            $_POST['category_name'],
            $slug,
            $parent_id,
            $_POST['description'],
            $category_image,
            $_POST['display_order'],
            $_POST['icon_class'],
            $_POST['color'],
            $show_homepage,
            $is_featured,
            $is_active,
            $_POST['meta_title'],
            $_POST['meta_description'],
            $_POST['meta_keywords'],
            $_POST['category_id']
        );
        
        if ($stmt->execute()) {
            $_SESSION['success'] = "Category updated successfully!";
        } else {
            throw new Exception("Error updating category: " . $stmt->error);
        }
        
        $stmt->close();
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
    }
    header("Location: categories.php");
    exit;
}

function deleteCategory($db) {
    try {
        // Check if category has subcategories
        $check_stmt = $db->prepare("SELECT COUNT(*) as child_count FROM categories WHERE parent_category_id = ?");
        $check_stmt->bind_param("i", $_POST['category_id']);
        $check_stmt->execute();
        $result = $check_stmt->get_result();
        $row = $result->fetch_assoc();
        $has_children = $row['child_count'] ?? 0;
        $check_stmt->close();
        
        if ($has_children > 0) {
            $_SESSION['error'] = "Cannot delete category. It has subcategories. Please delete subcategories first.";
        } else {
            $stmt = $db->prepare("DELETE FROM categories WHERE id = ?");
            $stmt->bind_param("i", $_POST['category_id']);
            
            if ($stmt->execute()) {
                $_SESSION['success'] = "Category deleted successfully!";
            } else {
                throw new Exception("Error deleting category: " . $stmt->error);
            }
            
            $stmt->close();
        }
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
    }
    header("Location: categories.php");
    exit;
}

function createSlug($text) {
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text);
    $text = strtolower($text);
    
    if (empty($text)) {
        return 'n-a';
    }
    
    return $text;
}

// Get all categories
function getCategories($db, $parent_id = null) {
    $sql = "SELECT c1.*, c2.category_name as parent_name 
            FROM categories c1 
            LEFT JOIN categories c2 ON c1.parent_category_id = c2.id";
    
    if ($parent_id === null) {
        $sql .= " WHERE c1.parent_category_id IS NULL";
    } else {
        $sql .= " WHERE c1.parent_category_id = ?";
    }
    
    $sql .= " ORDER BY c1.display_order ASC, c1.category_name ASC";
    
    $stmt = $db->prepare($sql);
    
    if ($parent_id !== null) {
        $stmt->bind_param("i", $parent_id);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    $categories = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    
    return $categories;
}

// Get category by ID
function getCategory($db, $id) {
    $stmt = $db->prepare("SELECT * FROM categories WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $category = $result->fetch_assoc();
    $stmt->close();
    
    return $category;
}

// Get all parent categories for dropdown
function getParentCategories($db, $exclude_id = null) {
    $sql = "SELECT * FROM categories WHERE parent_category_id IS NULL";
    
    if ($exclude_id) {
        $sql .= " AND id != ?";
    }
    
    $sql .= " ORDER BY display_order ASC, category_name ASC";
    
    $stmt = $db->prepare($sql);
    
    if ($exclude_id) {
        $stmt->bind_param("i", $exclude_id);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    $categories = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    
    return $categories;
}

// Get statistics
function getCategoryStats($db) {
    $stats = [];
    
    // Total categories
    $result = $db->query("SELECT COUNT(*) as total FROM categories");
    $row = $result->fetch_assoc();
    $stats['total_categories'] = $row['total'];
    
    // Main categories
    $result = $db->query("SELECT COUNT(*) as total FROM categories WHERE parent_category_id IS NULL");
    $row = $result->fetch_assoc();
    $stats['main_categories'] = $row['total'];
    
    // Subcategories
    $result = $db->query("SELECT COUNT(*) as total FROM categories WHERE parent_category_id IS NOT NULL");
    $row = $result->fetch_assoc();
    $stats['subcategories'] = $row['total'];
    
    // Featured categories
    $result = $db->query("SELECT COUNT(*) as total FROM categories WHERE is_featured = 1");
    $row = $result->fetch_assoc();
    $stats['featured'] = $row['total'];
    
    return $stats;
}

// Helper function to safely escape and display text
function safeText($text) {
    return htmlspecialchars($text ?? '', ENT_QUOTES, 'UTF-8');
}

// Get data
$categories = getCategories($db);
$parent_categories = getParentCategories($db);
$stats = getCategoryStats($db);

// Check if editing
$editing = false;
$edit_category = null;
if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
    $edit_category = getCategory($db, $_GET['edit']);
    if ($edit_category) {
        $editing = true;
        $parent_categories = getParentCategories($db, $edit_category['id']);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> | ADMIN PANEL</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/categories.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
                /* Categories Management Styles */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 1rem;
            border: 1px solid #e5e7eb;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }

        .stat-details {
            flex: 1;
        }

        .stat-label {
            color: #6b7280;
            font-size: 0.875rem;
            margin-bottom: 0.25rem;
        }

        .stat-value {
            font-size: 1.875rem;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 0.25rem;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal.show {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 12px;
            width: 90%;
            max-width: 800px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-header h2 {
            margin: 0;
            flex: 1;
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #6b7280;
        }

        .close-modal:hover {
            color: #374151;
        }

        /* Form Styles */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            padding: 2rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-group label {
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: #374151;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 0.875rem;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-switches {
            display: flex;
            gap: 2rem;
            padding: 0 2rem;
            margin-bottom: 1.5rem;
        }

        .switch {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
        }

        .switch input[type="checkbox"] {
            display: none;
        }

        .slider {
            width: 50px;
            height: 24px;
            background: #d1d5db;
            border-radius: 24px;
            position: relative;
            transition: background 0.3s;
        }

        .slider:before {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            background: white;
            border-radius: 50%;
            top: 2px;
            left: 2px;
            transition: transform 0.3s;
        }

        input[type="checkbox"]:checked + .slider {
            background: #10b981;
        }

        input[type="checkbox"]:checked + .slider:before {
            transform: translateX(26px);
        }

        .form-actions {
            padding: 1.5rem 2rem;
            border-top: 1px solid #e5e7eb;
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
        }

        /* Table Styles */
        .table-container {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th {
            background: #f9fafb;
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: #374151;
            border-bottom: 1px solid #e5e7eb;
        }

        .data-table td {
            padding: 1rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .data-table tr:hover {
            background: #f9fafb;
        }

        /* Category Info */
        .category-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .category-info.subcategory {
            margin-left: 1.5rem;
        }

        /* Status Badges */
        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .status-active {
            background: #d1fae5;
            color: #065f46;
        }

        .status-inactive {
            background: #fee2e2;
            color: #991b1b;
        }

        .status-featured {
            background: #fef3c7;
            color: #92400e;
        }

        .status-normal {
            background: #f3f4f6;
            color: #374151;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .btn-action {
            padding: 0.5rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-edit {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .btn-edit:hover {
            background: #bfdbfe;
        }

        .btn-delete {
            background: #fee2e2;
            color: #dc2626;
        }

        .btn-delete:hover {
            background: #fecaca;
        }

        /* Image Upload Styles */
        .image-preview {
            margin-top: 0.5rem;
            max-width: 200px;
        }
        
        .image-preview img {
            max-width: 100%;
            height: auto;
            border-radius: 6px;
            border: 1px solid #d1d5db;
        }
        
        .current-image {
            margin-top: 0.5rem;
        }
        
        .current-image img {
            max-width: 200px;
            height: auto;
            border-radius: 6px;
            border: 1px solid #d1d5db;
        }
        
        .remove-image {
            display: inline-block;
            margin-top: 0.5rem;
            color: #dc2626;
            cursor: pointer;
            font-size: 0.875rem;
        }
        
        .remove-image:hover {
            text-decoration: underline;
        }

        .file-input-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
            width: 100%;
        }
        
        .file-input-wrapper input[type=file] {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }
        
        .file-input-button {
            display: inline-block;
            padding: 0.75rem 1rem;
            background: #f3f4f6;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            color: #374151;
            cursor: pointer;
            text-align: center;
            width: 100%;
        }
        
        .file-input-button:hover {
            background: #e5e7eb;
        }
        
        .file-name {
            margin-top: 0.5rem;
            font-size: 0.875rem;
            color: #6b7280;
        }

        /* No Image Text */
        .no-image {
            color: #6b7280;
            font-style: italic;
            font-size: 0.875rem;
        }

        /* Textarea Styles */
textarea {
    font-family: inherit;
    font-size: 0.875rem;
    line-height: 1.5;
    padding: 0.75rem;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    background-color: white;
    resize: vertical;
    min-height: 80px;
    transition: all 0.2s ease-in-out;
    width: 100%;
    box-sizing: border-box;
}

textarea:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

textarea:hover {
    border-color: #9ca3af;
}

textarea:disabled {
    background-color: #f9fafb;
    color: #6b7280;
    cursor: not-allowed;
    border-color: #e5e7eb;
}

/* Textarea with error state */
textarea.error {
    border-color: #ef4444;
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
}

/* Textarea with success state */
textarea.success {
    border-color: #10b981;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
}

/* Textarea with warning state */
textarea.warning {
    border-color: #f59e0b;
    box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
}

/* Different sizes */
textarea.small {
    padding: 0.5rem;
    font-size: 0.75rem;
    min-height: 60px;
}

textarea.large {
    padding: 1rem;
    font-size: 1rem;
    min-height: 120px;
}

/* Full width textarea */
.custom-width{
    width: 92%;
    margin: auto;
}

/* Textarea with label */
.form-group textarea {
    margin-top: 0.25rem;
}

/* Placeholder styling */
textarea::placeholder {
    color: #9ca3af;
    opacity: 1;
}

/* Readonly textarea */
textarea[readonly] {
    background-color: #f8f9fa;
    border-color: #e9ecef;
    cursor: default;
}

/* Textarea in dark mode (if needed) */
@media (prefers-color-scheme: dark) {
    textarea {
        background-color: #374151;
        border-color: #4b5563;
        color: #f9fafb;
    }
    
    textarea::placeholder {
        color: #9ca3af;
    }
    
    textarea:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
    }
}

/* Responsive textarea */
@media (max-width: 768px) {
    textarea {
        font-size: 16px; /* Prevents zoom on iOS */
    }
}

        /* Responsive */
        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
                padding: 1rem;
            }
            
            .form-switches {
                flex-direction: column;
                gap: 1rem;
                padding: 0 1rem;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    

        <div class="admin-wrapper">
        <?php include 'includes/sidebar.php'; ?>

        <div class="main-content">
            <header class="top-header">
                <div class="header-left">
                    <button class="toggle-sidebar" id="toggleSidebar">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1>Categories Management</h1>
                </div>
                <div class="header-right">
                    <button class="btn btn-secondary" onclick="exportCategories()">
                        <i class="fas fa-file-export"></i> Export
                    </button>
                    <button class="btn btn-primary" onclick="showCategoryForm()">
                        <i class="fas fa-plus"></i> Add New Category
                    </button>
                </div>
            </header>

            <!-- Flash Messages -->
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-error">
                    <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <i class="fas fa-folder"></i>
                    </div>
                    <div class="stat-details">
                        <p class="stat-label">Total Categories</p>
                        <h3 class="stat-value"><?php echo $stats['total_categories']; ?></h3>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                        <i class="fas fa-sitemap"></i>
                    </div>
                    <div class="stat-details">
                        <p class="stat-label">Main Categories</p>
                        <h3 class="stat-value"><?php echo $stats['main_categories']; ?></h3>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                        <i class="fas fa-folder-tree"></i>
                    </div>
                    <div class="stat-details">
                        <p class="stat-label">Subcategories</p>
                        <h3 class="stat-value"><?php echo $stats['subcategories']; ?></h3>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #ec4899 0%, #db2777 100%);">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="stat-details">
                        <p class="stat-label">Featured</p>
                        <h3 class="stat-value"><?php echo $stats['featured']; ?></h3>
                    </div>
                </div>
            </div>

            <!-- Category Form Modal -->
            <div id="categoryModal" class="modal <?php echo $editing ? 'show' : ''; ?>">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2><?php echo $editing ? 'Edit Category' : 'Add New Category'; ?></h2>
                        <button class="close-modal" onclick="hideCategoryForm()">&times;</button>
                    </div>
                    <form method="POST" id="categoryForm" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="<?php echo $editing ? 'update' : 'create'; ?>">
                        <?php if ($editing): ?>
                            <input type="hidden" name="category_id" value="<?php echo $edit_category['id']; ?>">
                            <input type="hidden" name="existing_image" id="existingImage" value="<?php echo safeText($edit_category['category_image']); ?>">
                        <?php endif; ?>
                        
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="category_name">Category Name *</label>
                                <input type="text" id="category_name" name="category_name" 
                                       value="<?php echo $editing ? safeText($edit_category['category_name']) : ''; ?>" 
                                       required>
                            </div>
                            
                            <div class="form-group">
                                <label for="parent_category_id">Parent Category</label>
                                <select id="parent_category_id" name="parent_category_id">
                                    <option value="">No Parent (Main Category)</option>
                                    <?php foreach($parent_categories as $parent): ?>
                                        <option value="<?php echo $parent['id']; ?>"
                                            <?php echo ($editing && $edit_category['parent_category_id'] == $parent['id']) ? 'selected' : ''; ?>>
                                            <?php echo safeText($parent['category_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="display_order">Display Order</label>
                                <input type="number" id="display_order" name="display_order" 
                                       value="<?php echo $editing ? $edit_category['display_order'] : '0'; ?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="icon_class">Icon Class</label>
                                <input type="text" id="icon_class" name="icon_class" 
                                       value="<?php echo $editing ? safeText($edit_category['icon_class']) : ''; ?>" 
                                       placeholder="fas fa-folder">
                            </div>
                            
                            <div class="form-group">
                                <label for="color">Color</label>
                                <input type="color" id="color" name="color" 
                                       value="<?php echo $editing ? $edit_category['color'] : '#10b981'; ?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="category_image">Category Image</label>
                                <div class="file-input-wrapper">
                                    <div class="file-input-button">
                                        <i class="fas fa-cloud-upload-alt"></i> Choose Image
                                    </div>
                                    <input type="file" id="category_image" name="category_image" accept="image/*" onchange="previewImage(this)">
                                </div>
                                <div class="file-name" id="fileName"></div>
                                
                                <!-- Image Preview -->
                                <div class="image-preview" id="imagePreview" style="display: none;">
                                    <img id="preview" src="" alt="Image Preview">
                                </div>
                                
                                <!-- Current Image (for edit mode) -->
                                <?php if ($editing && !empty($edit_category['category_image'])): ?>
                                    <div class="current-image">
                                        <p><small>Current Image:</small></p>
                                        <img src="<?php echo safeText($edit_category['category_image']); ?>" alt="Current Category Image">
                                        <div class="remove-image" onclick="removeCurrentImage()">
                                            <i class="fas fa-times"></i> Remove Current Image
                                        </div>
                                        <input type="hidden" name="remove_image" id="removeImage" value="0">
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="form-group custom-width">
                            <label for="description">Description</label>
                            <textarea id="description" name="description" rows="3"><?php echo $editing ? safeText($edit_category['description']) : ''; ?></textarea>
                        </div>
                        
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="meta_title">Meta Title</label>
                                <input type="text" id="meta_title" name="meta_title" 
                                       value="<?php echo $editing ? safeText($edit_category['meta_title']) : ''; ?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="meta_keywords">Meta Keywords</label>
                                <input type="text" id="meta_keywords" name="meta_keywords" 
                                       value="<?php echo $editing ? safeText($edit_category['meta_keywords']) : ''; ?>">
                            </div>
                        </div>
                        
                        <div class="form-group custom-width">
                            <label for="meta_description">Meta Description</label>
                            <textarea id="meta_description" name="meta_description" rows="2"><?php echo $editing ? safeText($edit_category['meta_description']) : ''; ?></textarea>
                        </div>
                        <br><br>
                        <div class="form-switches">
                            <label class="switch">
                                <input type="checkbox" name="show_on_homepage" value="1" 
                                    <?php echo ($editing && $edit_category['show_on_homepage']) ? 'checked' : ''; ?>>
                                <span class="slider"></span>
                                Show on Homepage
                            </label>
                            
                            <label class="switch">
                                <input type="checkbox" name="is_featured" value="1"
                                    <?php echo ($editing && $edit_category['is_featured']) ? 'checked' : ''; ?>>
                                <span class="slider"></span>
                                Featured Category
                            </label>
                            
                            <label class="switch">
                                <input type="checkbox" name="is_active" value="1"
                                    <?php echo ($editing && $edit_category['is_active']) ? 'checked' : ''; ?>>
                                <span class="slider"></span>
                                Active
                            </label>
                        </div>
                        
                        <div class="form-actions">
                            <button type="button" class="btn btn-secondary" onclick="hideCategoryForm()">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                                <?php echo $editing ? 'Update Category' : 'Create Category'; ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Categories Table -->
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="selectAll"></th>
                            <th>Category Name</th>
                            <th>Slug</th>
                            <th>Parent</th>
                            <th>Display Order</th>
                            <th>Status</th>
                            <th>Featured</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($categories as $category): ?>
                            <?php 
                            $subcategories = getCategories($db, $category['id']);
                            ?>
                            <tr>
                                <td><input type="checkbox" class="row-checkbox" value="<?php echo $category['id']; ?>"></td>
                                <td>
                                    <div class="category-info">
                                        <span><?php echo safeText($category['category_name']); ?></span>
                                    </div>
                                </td>
                                <td><?php echo $category['category_slug']; ?></td>
                                <td><?php echo $category['parent_name'] ?? '-'; ?></td>
                                <td><?php echo $category['display_order']; ?></td>
                                <td>
                                    <span class="status-badge status-<?php echo $category['is_active'] ? 'active' : 'inactive'; ?>">
                                        <?php echo $category['is_active'] ? 'Active' : 'Inactive'; ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="status-badge status-<?php echo $category['is_featured'] ? 'featured' : 'normal'; ?>">
                                        <?php echo $category['is_featured'] ? 'Featured' : 'Normal'; ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if (!empty($category['category_image'])): ?>
                                        <a href="<?php echo safeText($category['category_image']); ?>" target="_blank" title="View Image">
                                            <img src="<?php echo safeText($category['category_image']); ?>" alt="Category Image" style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px;">
                                        </a>
                                    <?php else: ?>
                                        <span class="no-image">No Image</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-action btn-edit" 
                                                onclick="editCategory(<?php echo $category['id']; ?>)" 
                                                title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn-action btn-delete" 
                                                onclick="deleteCategory(<?php echo $category['id']; ?>)" 
                                                title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- Subcategories -->
                            <?php foreach($subcategories as $subcategory): ?>
                                <tr>
                                    <td><input type="checkbox" class="row-checkbox" value="<?php echo $subcategory['id']; ?>"></td>
                                    <td>
                                        <div class="category-info subcategory">
                                            <i class="fas fa-level-down-alt"></i>
                                            <span><?php echo safeText($subcategory['category_name']); ?></span>
                                        </div>
                                    </td>
                                    <td><?php echo $subcategory['category_slug']; ?></td>
                                    <td><?php echo safeText($category['category_name']); ?></td>
                                    <td><?php echo $subcategory['display_order']; ?></td>
                                    <td>
                                        <span class="status-badge status-<?php echo $subcategory['is_active'] ? 'active' : 'inactive'; ?>">
                                            <?php echo $subcategory['is_active'] ? 'Active' : 'Inactive'; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="status-badge status-<?php echo $subcategory['is_featured'] ? 'featured' : 'normal'; ?>">
                                            <?php echo $subcategory['is_featured'] ? 'Featured' : 'Normal'; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if (!empty($subcategory['category_image'])): ?>
                                            <a href="<?php echo safeText($subcategory['category_image']); ?>" target="_blank" title="View Image">
                                                <img src="<?php echo safeText($subcategory['category_image']); ?>" alt="Category Image" style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px;">
                                            </a>
                                        <?php else: ?>
                                            <span class="no-image">No Image</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-action btn-edit" 
                                                    onclick="editCategory(<?php echo $subcategory['id']; ?>)" 
                                                    title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn-action btn-delete" 
                                                    onclick="deleteCategory(<?php echo $subcategory['id']; ?>)" 
                                                    title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <?php include 'includes/footer.php'; ?>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Confirm Deletion</h2>
                <button class="close-modal" onclick="hideDeleteModal()">&times;</button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this category? This action cannot be undone.</p>
            </div>
            <div class="modal-actions">
                <form method="POST" id="deleteForm">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="category_id" id="deleteCategoryId">
                    <button type="button" class="btn btn-secondary" onclick="hideDeleteModal()">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete Category</button>
                </form>
            </div>
        </div>
    </div>


    <script src="assets/js/script.js"></script>
    <script>
        // Categories Management JavaScript

// Modal Functions
function showCategoryForm() {
    document.getElementById('categoryModal').classList.add('show');
    document.getElementById('categoryForm').reset();
    document.querySelector('input[name="action"]').value = 'create';
    document.querySelector('.modal-header h2').textContent = 'Add New Category';
    
    // Reset image preview
    document.getElementById('imagePreview').style.display = 'none';
    document.getElementById('fileName').textContent = '';
    
    // Show current image section if it was hidden
    const currentImage = document.querySelector('.current-image');
    if (currentImage) {
        currentImage.style.display = 'block';
    }
}

function hideCategoryForm() {
    document.getElementById('categoryModal').classList.remove('show');
    window.history.replaceState({}, document.title, window.location.pathname);
}

function editCategory(categoryId) {
    window.location.href = `categories.php?edit=${categoryId}`;
}

function deleteCategory(categoryId) {
    document.getElementById('deleteCategoryId').value = categoryId;
    document.getElementById('deleteModal').classList.add('show');
}

function hideDeleteModal() {
    document.getElementById('deleteModal').classList.remove('show');
}

// Image Upload Functions
function previewImage(input) {
    const preview = document.getElementById('preview');
    const imagePreview = document.getElementById('imagePreview');
    const fileName = document.getElementById('fileName');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            imagePreview.style.display = 'block';
        }
        
        reader.readAsDataURL(input.files[0]);
        fileName.textContent = input.files[0].name;
        
        // Validate file size (max 5MB)
        const fileSize = input.files[0].size / 1024 / 1024; // in MB
        if (fileSize > 5) {
            alert('File size must be less than 5MB');
            input.value = '';
            imagePreview.style.display = 'none';
            fileName.textContent = '';
            return;
        }
        
        // Validate file type
        const fileType = input.files[0].type;
        const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
        if (!validTypes.includes(fileType)) {
            alert('Please select a valid image file (JPEG, PNG, GIF, WebP)');
            input.value = '';
            imagePreview.style.display = 'none';
            fileName.textContent = '';
            return;
        }
    } else {
        imagePreview.style.display = 'none';
        fileName.textContent = '';
    }
}

function removeCurrentImage() {
    if (confirm('Are you sure you want to remove the current image?')) {
        document.getElementById('existingImage').value = '';
        const currentImageDiv = document.querySelector('.current-image');
        if (currentImageDiv) {
            currentImageDiv.style.display = 'none';
        }
        
        // Also clear any file input
        const fileInput = document.getElementById('category_image');
        if (fileInput) {
            fileInput.value = '';
        }
        
        // Hide preview
        document.getElementById('imagePreview').style.display = 'none';
        document.getElementById('fileName').textContent = '';
    }
}

// Export Functionality
function exportCategories() {
    const table = document.querySelector('.data-table');
    let csv = [];
    const rows = table.querySelectorAll('tr');
    
    for (let i = 0; i < rows.length; i++) {
        let row = [], cols = rows[i].querySelectorAll('td, th');
        
        for (let j = 0; j < cols.length; j++) {
            // Skip action columns and image columns
            if (j < cols.length - 2) { // -2 to skip image and actions columns
                let text = cols[j].innerText.replace(/,/g, '');
                row.push(text);
            }
        }
        
        csv.push(row.join(","));
    }
    
    // Download CSV file
    const csvFile = new Blob([csv.join("\n")], { type: "text/csv" });
    const downloadLink = document.createElement("a");
    downloadLink.download = "categories_export_" + new Date().toISOString().split('T')[0] + ".csv";
    downloadLink.href = window.URL.createObjectURL(csvFile);
    downloadLink.style.display = "none";
    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
}

// Bulk Operations
function bulkDeleteCategories() {
    const selectedIds = getSelectedCategoryIds();
    if (selectedIds.length === 0) {
        alert('Please select at least one category to delete.');
        return;
    }
    
    if (confirm(`Are you sure you want to delete ${selectedIds.length} selected categories?`)) {
        // Implement bulk delete logic here
        console.log('Bulk delete categories:', selectedIds);
        // You would typically make an AJAX call here
        alert(`Bulk delete functionality for ${selectedIds.length} categories would be implemented here.`);
    }
}

function bulkUpdateStatus(status) {
    const selectedIds = getSelectedCategoryIds();
    if (selectedIds.length === 0) {
        alert('Please select at least one category to update.');
        return;
    }
    
    if (confirm(`Are you sure you want to update ${selectedIds.length} selected categories to ${status}?`)) {
        // Implement bulk status update logic here
        console.log(`Bulk update categories to ${status}:`, selectedIds);
        // You would typically make an AJAX call here
        alert(`Bulk status update functionality for ${selectedIds.length} categories would be implemented here.`);
    }
}

function getSelectedCategoryIds() {
    const checkboxes = document.querySelectorAll('.row-checkbox:checked');
    const selectedIds = [];
    checkboxes.forEach(checkbox => {
        if (checkbox.value) {
            selectedIds.push(checkbox.value);
        }
    });
    return selectedIds;
}

// Form Validation
function validateCategoryForm() {
    const categoryName = document.getElementById('category_name');
    const displayOrder = document.getElementById('display_order');
    
    if (!categoryName.value.trim()) {
        alert('Category name is required.');
        categoryName.focus();
        return false;
    }
    
    if (displayOrder.value < 0) {
        alert('Display order must be a positive number.');
        displayOrder.focus();
        return false;
    }
    
    return true;
}

// Search and Filter Functions
function searchCategories() {
    const searchTerm = document.getElementById('searchCategories').value.toLowerCase();
    const rows = document.querySelectorAll('.data-table tbody tr');
    
    rows.forEach(row => {
        const categoryName = row.cells[1].textContent.toLowerCase();
        const categorySlug = row.cells[2].textContent.toLowerCase();
        const shouldShow = categoryName.includes(searchTerm) || categorySlug.includes(searchTerm);
        row.style.display = shouldShow ? '' : 'none';
    });
}

function filterByCategory() {
    const filterValue = document.getElementById('filterCategory').value;
    const rows = document.querySelectorAll('.data-table tbody tr');
    
    rows.forEach(row => {
        if (!filterValue) {
            row.style.display = '';
            return;
        }
        
        const parentCategory = row.cells[3].textContent.toLowerCase();
        const shouldShow = parentCategory === filterValue.toLowerCase() || 
                          (filterValue === 'main' && parentCategory === '-') ||
                          (filterValue === 'subcategory' && parentCategory !== '-');
        row.style.display = shouldShow ? '' : 'none';
    });
}

function filterByStatus() {
    const filterValue = document.getElementById('filterStatus').value;
    const rows = document.querySelectorAll('.data-table tbody tr');
    
    rows.forEach(row => {
        if (!filterValue) {
            row.style.display = '';
            return;
        }
        
        const statusBadge = row.cells[5].querySelector('.status-badge');
        const status = statusBadge ? statusBadge.textContent.toLowerCase() : '';
        const shouldShow = status.includes(filterValue.toLowerCase());
        row.style.display = shouldShow ? '' : 'none';
    });
}

// Sort Functionality
function sortCategories(sortBy) {
    const table = document.querySelector('.data-table');
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    
    rows.sort((a, b) => {
        let aValue, bValue;
        
        switch (sortBy) {
            case 'name-asc':
                aValue = a.cells[1].textContent.toLowerCase();
                bValue = b.cells[1].textContent.toLowerCase();
                return aValue.localeCompare(bValue);
                
            case 'name-desc':
                aValue = a.cells[1].textContent.toLowerCase();
                bValue = b.cells[1].textContent.toLowerCase();
                return bValue.localeCompare(aValue);
                
            case 'order-asc':
                aValue = parseInt(a.cells[4].textContent) || 0;
                bValue = parseInt(b.cells[4].textContent) || 0;
                return aValue - bValue;
                
            case 'order-desc':
                aValue = parseInt(a.cells[4].textContent) || 0;
                bValue = parseInt(b.cells[4].textContent) || 0;
                return bValue - aValue;
                
            case 'newest':
                // Assuming you have a created_at column
                aValue = a.getAttribute('data-created') || '';
                bValue = b.getAttribute('data-created') || '';
                return new Date(bValue) - new Date(aValue);
                
            case 'oldest':
                aValue = a.getAttribute('data-created') || '';
                bValue = b.getAttribute('data-created') || '';
                return new Date(aValue) - new Date(bValue);
                
            default:
                return 0;
        }
    });
    
    // Remove existing rows
    rows.forEach(row => tbody.removeChild(row));
    
    // Add sorted rows
    rows.forEach(row => tbody.appendChild(row));
}

// Auto-generate slug from category name
function generateSlug() {
    const categoryNameInput = document.getElementById('category_name');
    const slugInput = document.getElementById('category_slug'); // if you add a slug field
    
    if (categoryNameInput && !document.querySelector('input[name="category_id"]')) {
        categoryNameInput.addEventListener('blur', function() {
            if (this.value && !document.querySelector('input[name="category_id"]')) {
                const slug = this.value
                    .toLowerCase()
                    .trim()
                    .replace(/[^\w\s-]/g, '')
                    .replace(/[\s_-]+/g, '-')
                    .replace(/^-+|-+$/g, '');
                
                // If you have a separate slug field, set it
                if (slugInput) {
                    slugInput.value = slug;
                }
                
                console.log('Generated slug:', slug);
            }
        });
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Select All functionality
    const selectAll = document.getElementById('selectAll');
    const rowCheckboxes = document.querySelectorAll('.row-checkbox');
    
    if (selectAll) {
        selectAll.addEventListener('change', function() {
            rowCheckboxes.forEach(checkbox => {
                checkbox.checked = selectAll.checked;
            });
        });
    }
    
    // Close modal when clicking outside
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.classList.remove('show');
                if (modal.id === 'categoryModal') {
                    window.history.replaceState({}, document.title, window.location.pathname);
                }
            }
        });
    });
    
    // Initialize slug generation
    generateSlug();
    
    // Add form validation
    const categoryForm = document.getElementById('categoryForm');
    if (categoryForm) {
        categoryForm.addEventListener('submit', function(e) {
            if (!validateCategoryForm()) {
                e.preventDefault();
            }
        });
    }
    
    // Initialize search and filter events
    const searchInput = document.getElementById('searchCategories');
    if (searchInput) {
        searchInput.addEventListener('input', searchCategories);
    }
    
    const categoryFilter = document.getElementById('filterCategory');
    if (categoryFilter) {
        categoryFilter.addEventListener('change', filterByCategory);
    }
    
    const statusFilter = document.getElementById('filterStatus');
    if (statusFilter) {
        statusFilter.addEventListener('change', filterByStatus);
    }
    
    // Drag and drop for image upload
    const fileInput = document.getElementById('category_image');
    if (fileInput) {
        const fileInputWrapper = fileInput.closest('.file-input-wrapper');
        
        fileInputWrapper.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.style.background = '#e5e7eb';
        });
        
        fileInputWrapper.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.style.background = '#f3f4f6';
        });
        
        fileInputWrapper.addEventListener('drop', function(e) {
            e.preventDefault();
            this.style.background = '#f3f4f6';
            
            if (e.dataTransfer.files.length) {
                fileInput.files = e.dataTransfer.files;
                previewImage(fileInput);
            }
        });
    }
});

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Escape key to close modals
    if (e.key === 'Escape') {
        const openModals = document.querySelectorAll('.modal.show');
        openModals.forEach(modal => {
            modal.classList.remove('show');
            if (modal.id === 'categoryModal') {
                window.history.replaceState({}, document.title, window.location.pathname);
            }
        });
    }
    
    // Ctrl+N to add new category
    if (e.ctrlKey && e.key === 'n') {
        e.preventDefault();
        showCategoryForm();
    }
    
    // Ctrl+F to focus search
    if (e.ctrlKey && e.key === 'f') {
        e.preventDefault();
        const searchInput = document.getElementById('searchCategories');
        if (searchInput) {
            searchInput.focus();
        }
    }
    
    // Delete key for bulk delete when items are selected
    if (e.key === 'Delete') {
        const selectedIds = getSelectedCategoryIds();
        if (selectedIds.length > 0) {
            e.preventDefault();
            bulkDeleteCategories();
        }
    }
});

// Utility Functions
function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

function showNotification(message, type = 'success') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <span class="notification-message">${message}</span>
            <button class="notification-close" onclick="this.parentElement.parentElement.remove()">&times;</button>
        </div>
    `;
    
    // Add styles if not already added
    if (!document.querySelector('#notification-styles')) {
        const styles = document.createElement('style');
        styles.id = 'notification-styles';
        styles.textContent = `
            .notification {
                position: fixed;
                top: 20px;
                right: 20px;
                background: white;
                border-radius: 8px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                z-index: 10000;
                max-width: 400px;
                animation: slideIn 0.3s ease-out;
            }
            .notification-success { border-left: 4px solid #10b981; }
            .notification-error { border-left: 4px solid #ef4444; }
            .notification-warning { border-left: 4px solid #f59e0b; }
            .notification-content {
                padding: 1rem;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }
            .notification-close {
                background: none;
                border: none;
                font-size: 1.2rem;
                cursor: pointer;
                margin-left: 1rem;
            }
            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
        `;
        document.head.appendChild(styles);
    }
    
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentElement) {
            notification.remove();
        }
    }, 5000);
}

// Export all functions for global access
window.showCategoryForm = showCategoryForm;
window.hideCategoryForm = hideCategoryForm;
window.editCategory = editCategory;
window.deleteCategory = deleteCategory;
window.hideDeleteModal = hideDeleteModal;
window.previewImage = previewImage;
window.removeCurrentImage = removeCurrentImage;
window.exportCategories = exportCategories;
window.bulkDeleteCategories = bulkDeleteCategories;
window.bulkUpdateStatus = bulkUpdateStatus;
window.searchCategories = searchCategories;
window.filterByCategory = filterByCategory;
window.filterByStatus = filterByStatus;
window.sortCategories = sortCategories;
window.showNotification = showNotification;
    </script>
</body>
</html>