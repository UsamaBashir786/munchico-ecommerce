<?php
// edit-product.php - Edit Product Page
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

$page_title = "Edit Product";
$current_page = "products";

// Database connection
require_once 'config/database.php';
$conn = getDB();

// Get product ID
$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($product_id <= 0) {
    header('Location: products.php');
    exit();
}

// Fetch product details
$sql = "SELECT p.*, c.category_name 
        FROM products p 
        LEFT JOIN categories c ON p.category_id = c.id 
        WHERE p.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
$stmt->close();

if (!$product) {
    $_SESSION['error'] = "Product not found!";
    header('Location: products.php');
    exit();
}

// Get all categories
$categories_sql = "SELECT id, category_name, parent_category_id FROM categories WHERE is_active = 1 ORDER BY category_name";
$categories_result = $conn->query($categories_sql);
$categories = $categories_result->fetch_all(MYSQLI_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_product'])) {
    
    // Get form data
    $product_name = trim($_POST['product_name']);
    $product_slug = trim($_POST['product_slug']);
    $category_id = (int)$_POST['category_id'];
    $short_description = trim($_POST['short_description']);
    $full_description = trim($_POST['full_description']);
    $specifications = trim($_POST['specifications']);
    $regular_price = floatval($_POST['regular_price']);
    $sale_price = !empty($_POST['sale_price']) ? floatval($_POST['sale_price']) : NULL;
    $discount_percentage = (int)$_POST['discount_percentage'];
    $stock_quantity = (int)$_POST['stock_quantity'];
    $stock_status = $_POST['stock_status'];
    $weight = !empty($_POST['weight']) ? floatval($_POST['weight']) : NULL;
    $size = trim($_POST['size']);
    $tax_class = $_POST['tax_class'];
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $badge_new = isset($_POST['badge_new']) ? 1 : 0;
    $badge_hot = isset($_POST['badge_hot']) ? 1 : 0;
    $badge_sale = isset($_POST['badge_sale']) ? 1 : 0;
    $badge_featured = isset($_POST['badge_featured']) ? 1 : 0;
    $badge_text = trim($_POST['badge_text']);
    $badge_color = trim($_POST['badge_color']);
    $enable_reviews = isset($_POST['enable_reviews']) ? 1 : 0;
    $meta_title = trim($_POST['meta_title']);
    $meta_description = trim($_POST['meta_description']);
    $meta_keywords = trim($_POST['meta_keywords']);
    
    // Validation
    $errors = [];
    
    if (empty($product_name)) {
        $errors[] = "Product name is required";
    }
    
    if (empty($product_slug)) {
        $errors[] = "Product slug is required";
    } else {
        // Check if slug exists for other products
        $slug_check = $conn->prepare("SELECT id FROM products WHERE product_slug = ? AND id != ?");
        $slug_check->bind_param("si", $product_slug, $product_id);
        $slug_check->execute();
        if ($slug_check->get_result()->num_rows > 0) {
            $errors[] = "Product slug already exists";
        }
        $slug_check->close();
    }
    
    if ($category_id <= 0) {
        $errors[] = "Please select a category";
    }
    
    if ($regular_price <= 0) {
        $errors[] = "Regular price must be greater than 0";
    }
    
    if (empty($errors)) {
        // Handle main image upload
        $main_image = $product['main_image'];
        if (isset($_FILES['main_image']) && $_FILES['main_image']['error'] == 0) {
            $upload_dir = 'uploads/products/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            $file_extension = strtolower(pathinfo($_FILES['main_image']['name'], PATHINFO_EXTENSION));
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
            
            if (in_array($file_extension, $allowed_extensions)) {
                $new_filename = 'prod_' . uniqid() . '.' . $file_extension;
                $upload_path = $upload_dir . $new_filename;
                
                if (move_uploaded_file($_FILES['main_image']['tmp_name'], $upload_path)) {
                    // Delete old image if exists
                    if (!empty($product['main_image']) && file_exists($product['main_image'])) {
                        unlink($product['main_image']);
                    }
                    $main_image = $upload_path;
                }
            }
        }
        
        // Handle gallery images upload
        $gallery_images = $product['gallery_images'];
        if (isset($_FILES['gallery_images']) && !empty($_FILES['gallery_images']['name'][0])) {
            $upload_dir = 'uploads/products/';
            $gallery_paths = [];
            
            foreach ($_FILES['gallery_images']['tmp_name'] as $key => $tmp_name) {
                if ($_FILES['gallery_images']['error'][$key] == 0) {
                    $file_extension = strtolower(pathinfo($_FILES['gallery_images']['name'][$key], PATHINFO_EXTENSION));
                    $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
                    
                    if (in_array($file_extension, $allowed_extensions)) {
                        $new_filename = 'gallery_' . uniqid() . '.' . $file_extension;
                        $upload_path = $upload_dir . $new_filename;
                        
                        if (move_uploaded_file($tmp_name, $upload_path)) {
                            $gallery_paths[] = $upload_path;
                        }
                    }
                }
            }
            
            if (!empty($gallery_paths)) {
                // Keep existing gallery images and add new ones
                $existing_gallery = !empty($product['gallery_images']) ? explode(',', $product['gallery_images']) : [];
                $all_gallery = array_merge($existing_gallery, $gallery_paths);
                $gallery_images = implode(',', $all_gallery);
            }
        }
        
        // Update product in database
        $update_sql = "UPDATE products SET 
            product_name = ?,
            product_slug = ?,
            category_id = ?,
            short_description = ?,
            full_description = ?,
            specifications = ?,
            main_image = ?,
            gallery_images = ?,
            regular_price = ?,
            sale_price = ?,
            discount_percentage = ?,
            tax_class = ?,
            stock_quantity = ?,
            stock_status = ?,
            badge_new = ?,
            badge_hot = ?,
            badge_sale = ?,
            badge_featured = ?,
            badge_text = ?,
            badge_color = ?,
            weight = ?,
            size = ?,
            enable_reviews = ?,
            meta_title = ?,
            meta_description = ?,
            meta_keywords = ?,
            is_active = ?,
            is_featured = ?,
            updated_at = NOW()
            WHERE id = ?";
        
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param(
            "ssisssssddisissiiissdsisssiii",
            $product_name,
            $product_slug,
            $category_id,
            $short_description,
            $full_description,
            $specifications,
            $main_image,
            $gallery_images,
            $regular_price,
            $sale_price,
            $discount_percentage,
            $tax_class,
            $stock_quantity,
            $stock_status,
            $badge_new,
            $badge_hot,
            $badge_sale,
            $badge_featured,
            $badge_text,
            $badge_color,
            $weight,
            $size,
            $enable_reviews,
            $meta_title,
            $meta_description,
            $meta_keywords,
            $is_active,
            $is_featured,
            $product_id
        );
        
        if ($stmt->execute()) {
            $_SESSION['success'] = "Product updated successfully!";
            header('Location: products.php');
            exit();
        } else {
            $errors[] = "Failed to update product: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Parse gallery images
$gallery_array = !empty($product['gallery_images']) ? explode(',', $product['gallery_images']) : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> | ADMIN PANEL</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/products.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .form-section {
            background: white;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .form-section h3 {
            margin: 0 0 20px 0;
            padding-bottom: 12px;
            border-bottom: 2px solid #f3f4f6;
            color: #1f2937;
            font-size: 18px;
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        
        .form-grid-full {
            grid-column: 1 / -1;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #374151;
            font-weight: 500;
            font-size: 14px;
        }
        
        .form-group label .required {
            color: #ef4444;
        }
        
        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }
        
        .image-preview {
            margin-top: 12px;
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }
        
        .image-preview-item {
            position: relative;
            width: 120px;
            height: 120px;
            border-radius: 8px;
            overflow: hidden;
            border: 2px solid #e5e7eb;
        }
        
        .image-preview-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .image-preview-item .remove-image {
            position: absolute;
            top: 4px;
            right: 4px;
            background: #ef4444;
            color: white;
            border: none;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
        }
        
        .checkbox-group input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }
        
        .checkbox-group label {
            margin: 0;
            cursor: pointer;
            font-weight: 400;
        }
        
        .action-buttons {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            padding: 24px;
            background: #f9fafb;
            border-radius: 12px;
            margin-top: 24px;
        }
        
        .alert {
            padding: 16px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border-left: 4px solid #ef4444;
        }
        
        .color-picker-group {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .color-picker-group input[type="color"] {
            width: 60px;
            height: 40px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            cursor: pointer;
        }
        
        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
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
                    <h1>Edit Product</h1>
                </div>
                <div class="header-right">
                    <button class="btn btn-secondary" onclick="window.location.href='products.php'">
                        <i class="fas fa-arrow-left"></i> Back to Products
                    </button>
                </div>
            </header>

            <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                <strong>Error:</strong>
                <ul style="margin: 8px 0 0 20px;">
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>

            <form method="POST" action="" enctype="multipart/form-data" id="productForm">
                <!-- Basic Information -->
                <div class="form-section">
                    <h3><i class="fas fa-info-circle"></i> Basic Information</h3>
                    <div class="form-grid">
                        <div class="form-group form-grid-full">
                            <label>Product Name <span class="required">*</span></label>
                            <input type="text" name="product_name" class="form-control" value="<?php echo htmlspecialchars($product['product_name']); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Product Slug <span class="required">*</span></label>
                            <input type="text" name="product_slug" class="form-control" value="<?php echo htmlspecialchars($product['product_slug']); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Category <span class="required">*</span></label>
                            <select name="category_id" class="form-control" required>
                                <option value="">Select Category</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?php echo $cat['id']; ?>" <?php echo $product['category_id'] == $cat['id'] ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($cat['category_name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="form-group form-grid-full">
                            <label>Short Description <span class="required">*</span></label>
                            <textarea name="short_description" class="form-control" rows="3" required><?php echo htmlspecialchars($product['short_description']); ?></textarea>
                        </div>
                        
                        <div class="form-group form-grid-full">
                            <label>Full Description <span class="required">*</span></label>
                            <textarea name="full_description" class="form-control" rows="6" required><?php echo htmlspecialchars($product['full_description']); ?></textarea>
                        </div>
                        
                        <div class="form-group form-grid-full">
                            <label>Specifications</label>
                            <textarea name="specifications" class="form-control" rows="4" placeholder="e.g., Weight: 500g&#10;Origin: Turkey&#10;Package: Premium"><?php echo htmlspecialchars($product['specifications']); ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- Pricing -->
                <div class="form-section">
                    <h3><i class="fas fa-dollar-sign"></i> Pricing & Tax</h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Regular Price ($) <span class="required">*</span></label>
                            <input type="number" name="regular_price" class="form-control" step="0.01" min="0" value="<?php echo $product['regular_price']; ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Sale Price ($)</label>
                            <input type="number" name="sale_price" class="form-control" step="0.01" min="0" value="<?php echo $product['sale_price']; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label>Discount Percentage (%)</label>
                            <input type="number" name="discount_percentage" class="form-control" min="0" max="100" value="<?php echo $product['discount_percentage']; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label>Tax Class</label>
                            <select name="tax_class" class="form-control">
                                <option value="standard" <?php echo $product['tax_class'] == 'standard' ? 'selected' : ''; ?>>Standard</option>
                                <option value="reduced" <?php echo $product['tax_class'] == 'reduced' ? 'selected' : ''; ?>>Reduced</option>
                                <option value="zero" <?php echo $product['tax_class'] == 'zero' ? 'selected' : ''; ?>>Zero</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Inventory -->
                <div class="form-section">
                    <h3><i class="fas fa-boxes"></i> Inventory</h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Stock Quantity <span class="required">*</span></label>
                            <input type="number" name="stock_quantity" class="form-control" min="0" value="<?php echo $product['stock_quantity']; ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Stock Status</label>
                            <select name="stock_status" class="form-control">
                                <option value="in_stock" <?php echo $product['stock_status'] == 'in_stock' ? 'selected' : ''; ?>>In Stock</option>
                                <option value="out_of_stock" <?php echo $product['stock_status'] == 'out_of_stock' ? 'selected' : ''; ?>>Out of Stock</option>
                                <option value="on_backorder" <?php echo $product['stock_status'] == 'on_backorder' ? 'selected' : ''; ?>>On Backorder</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>Weight (kg)</label>
                            <input type="number" name="weight" class="form-control" step="0.01" min="0" value="<?php echo $product['weight']; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label>Size Options</label>
                            <input type="text" name="size" class="form-control" placeholder="e.g., 250g, 500g, 1kg" value="<?php echo htmlspecialchars($product['size']); ?>">
                        </div>
                    </div>
                </div>

                <!-- Images -->
                <div class="form-section">
                    <h3><i class="fas fa-images"></i> Product Images</h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Main Image</label>
                            <input type="file" name="main_image" class="form-control" accept="image/*">
                            <?php if (!empty($product['main_image'])): ?>
                            <div class="image-preview">
                                <div class="image-preview-item">
                                    <img src="<?php echo htmlspecialchars($product['main_image']); ?>" alt="Main Image">
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="form-group">
                            <label>Gallery Images</label>
                            <input type="file" name="gallery_images[]" class="form-control" accept="image/*" multiple>
                            <?php if (!empty($gallery_array)): ?>
                            <div class="image-preview">
                                <?php foreach ($gallery_array as $gallery_img): ?>
                                <div class="image-preview-item">
                                    <img src="<?php echo htmlspecialchars(trim($gallery_img)); ?>" alt="Gallery Image">
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Badges & Features -->
                <div class="form-section">
                    <h3><i class="fas fa-tags"></i> Badges & Features</h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <div class="checkbox-group">
                                <input type="checkbox" name="badge_new" id="badge_new" value="1" <?php echo $product['badge_new'] ? 'checked' : ''; ?>>
                                <label for="badge_new">New Product</label>
                            </div>
                            <div class="checkbox-group">
                                <input type="checkbox" name="badge_hot" id="badge_hot" value="1" <?php echo $product['badge_hot'] ? 'checked' : ''; ?>>
                                <label for="badge_hot">Hot Product</label>
                            </div>
                            <div class="checkbox-group">
                                <input type="checkbox" name="badge_sale" id="badge_sale" value="1" <?php echo $product['badge_sale'] ? 'checked' : ''; ?>>
                                <label for="badge_sale">On Sale</label>
                            </div>
                            <div class="checkbox-group">
                                <input type="checkbox" name="badge_featured" id="badge_featured" value="1" <?php echo $product['badge_featured'] ? 'checked' : ''; ?>>
                                <label for="badge_featured">Featured Badge</label>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Custom Badge Text</label>
                            <input type="text" name="badge_text" class="form-control" placeholder="e.g., Limited Edition" value="<?php echo htmlspecialchars($product['badge_text']); ?>">
                            
                            <label style="margin-top: 12px;">Badge Color</label>
                            <div class="color-picker-group">
                                <input type="color" name="badge_color" value="<?php echo htmlspecialchars($product['badge_color']); ?>">
                                <input type="text" class="form-control" value="<?php echo htmlspecialchars($product['badge_color']); ?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SEO & Settings -->
                <div class="form-section">
                    <h3><i class="fas fa-search"></i> SEO & Settings</h3>
                    <div class="form-grid">
                        <div class="form-group form-grid-full">
                            <label>Meta Title</label>
                            <input type="text" name="meta_title" class="form-control" maxlength="200" value="<?php echo htmlspecialchars($product['meta_title']); ?>">
                        </div>
                        
                        <div class="form-group form-grid-full">
                            <label>Meta Description</label>
                            <textarea name="meta_description" class="form-control" rows="3" maxlength="500"><?php echo htmlspecialchars($product['meta_description']); ?></textarea>
                        </div>
                        
                        <div class="form-group form-grid-full">
                            <label>Meta Keywords</label>
                            <input type="text" name="meta_keywords" class="form-control" placeholder="Separate keywords with commas" value="<?php echo htmlspecialchars($product['meta_keywords']); ?>">
                        </div>
                        
                        <div class="form-group">
                            <div class="checkbox-group">
                                <input type="checkbox" name="is_active" id="is_active" value="1" <?php echo $product['is_active'] ? 'checked' : ''; ?>>
                                <label for="is_active">Product Active</label>
                            </div>
                            <div class="checkbox-group">
                                <input type="checkbox" name="is_featured" id="is_featured" value="1" <?php echo $product['is_featured'] ? 'checked' : ''; ?>>
                                <label for="is_featured">Featured Product</label>
                            </div>
                            <div class="checkbox-group">
                                <input type="checkbox" name="enable_reviews" id="enable_reviews" value="1" <?php echo $product['enable_reviews'] ? 'checked' : ''; ?>>
                                <label for="enable_reviews">Enable Reviews</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="action-buttons">
                    <button type="button" class="btn btn-secondary" onclick="window.location.href='products.php'">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="submit" name="update_product" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Product
                    </button>
                </div>
            </form>

            <?php include 'includes/footer.php'; ?>
        </div>
    </div>

    <script src="assets/js/script.js"></script>
    <script>
        // Auto-generate slug from product name
        document.querySelector('input[name="product_name"]').addEventListener('input', function(e) {
            const slug = e.target.value
                .toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/(^-|-$)/g, '');
            document.querySelector('input[name="product_slug"]').value = slug;
        });

        // Color picker sync
        document.querySelector('input[name="badge_color"]').addEventListener('input', function(e) {
            this.nextElementSibling.value = e.target.value;
        });

        // Image preview for main image
        document.querySelector('input[name="main_image"]').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const preview = e.target.parentElement.querySelector('.image-preview');
                    if (!preview) {
                        const newPreview = document.createElement('div');
                        newPreview.className = 'image-preview';
                        newPreview.innerHTML = `
                            <div class="image-preview-item">
                                <img src="${event.target.result}" alt="Preview">
                            </div>
                        `;
                        e.target.parentElement.appendChild(newPreview);
                    } else {
                        preview.querySelector('img').src = event.target.result;
                    }
                };
                reader.readAsDataURL(file);
            }
        });

        // Form validation
        document.getElementById('productForm').addEventListener('submit', function(e) {
            const regularPrice = parseFloat(document.querySelector('input[name="regular_price"]').value);
            const salePrice = parseFloat(document.querySelector('input[name="sale_price"]').value);
            
            if (salePrice && salePrice >= regularPrice) {
                e.preventDefault();
                alert('Sale price must be less than regular price!');
            }
        });
    </script>
</body>
</html>