<?php
/**
 * ============================================
 * ADD PRODUCT - COMPLETE PAGE
 * Backend + Frontend in One File
 * ============================================
 */

session_start();

// Include database configuration
require_once 'config/database.php';

// Get database connection
$conn = getDB();

// ============================================
// BACKEND LOGIC - TOP OF FILE
// ============================================

// Security check
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Initialize variables
$success_message = '';
$error_message = '';
$page_title = "Add Product";
$current_page = "products";

// Fetch categories from database
function getCategories($conn) {
    $sql = "SELECT id, category_name FROM categories WHERE is_active = 1 ORDER BY display_order ASC";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_product'])) {
    
    // Sanitize inputs
    $product_name = trim(escapeString($_POST['product_name']));
    $product_slug = trim(escapeString($_POST['product_slug']));
    $category_id = intval($_POST['category']);
    $short_description = trim(escapeString($_POST['short_description']));
    $full_description = trim(escapeString($_POST['full_description']));
    $specifications = trim(escapeString($_POST['specifications']));
    
    // Pricing
    $regular_price = floatval($_POST['regular_price']);
    $sale_price = !empty($_POST['sale_price']) ? floatval($_POST['sale_price']) : NULL;
    $discount_percentage = intval($_POST['discount_percentage']);
    $tax_class = escapeString($_POST['tax_class']);
    
    // Stock
    $stock_quantity = intval($_POST['stock_quantity']);
    
    // Badges
    $badge_new = isset($_POST['badge_new']) ? 1 : 0;
    $badge_hot = isset($_POST['badge_hot']) ? 1 : 0;
    $badge_sale = isset($_POST['badge_sale']) ? 1 : 0;
    $badge_featured = isset($_POST['badge_featured']) ? 1 : 0;
    $badge_text = trim(escapeString($_POST['badge_text']));
    $badge_color = trim(escapeString($_POST['badge_color']));
    
    // Attributes
    $weight = !empty($_POST['weight']) ? floatval($_POST['weight']) : NULL;
    $size = trim(escapeString($_POST['size']));
    
    // Rating
    $rating = floatval($_POST['rating']);
    $review_count = intval($_POST['review_count']);
    $enable_reviews = isset($_POST['enable_reviews']) ? 1 : 0;
    
    // Validation
    if (empty($product_name) || $category_id == 0 || $regular_price <= 0) {
        $error_message = "Please fill all required fields!";
    } else {
        // Check if slug exists
        $check_slug = "SELECT id FROM products WHERE product_slug = '$product_slug'";
        $result = $conn->query($check_slug);
        
        if ($result->num_rows > 0) {
            $error_message = "Product slug already exists!";
        } else {
            // Handle main image upload
            $main_image = NULL;
            if (isset($_FILES['main_image']) && $_FILES['main_image']['error'] === UPLOAD_ERR_OK) {
                $upload_dir = 'uploads/products/';
                
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }
                
                $file_extension = strtolower(pathinfo($_FILES['main_image']['name'], PATHINFO_EXTENSION));
                $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                
                if (in_array($file_extension, $allowed)) {
                    if ($_FILES['main_image']['size'] <= 5 * 1024 * 1024) {
                        $new_filename = uniqid('prod_') . '.' . $file_extension;
                        $upload_path = $upload_dir . $new_filename;
                        
                        if (move_uploaded_file($_FILES['main_image']['tmp_name'], $upload_path)) {
                            $main_image = $upload_path;
                        } else {
                            $error_message = "Failed to upload main image!";
                        }
                    } else {
                        $error_message = "Main image must be less than 5MB!";
                    }
                } else {
                    $error_message = "Invalid image format!";
                }
            } else {
                $error_message = "Main image is required!";
            }
            
            // Handle gallery images
            $gallery_images = array();
            if (isset($_FILES['gallery_images']) && !empty($_FILES['gallery_images']['name'][0])) {
                $upload_dir = 'uploads/products/';
                
                foreach ($_FILES['gallery_images']['tmp_name'] as $key => $tmp_name) {
                    if ($_FILES['gallery_images']['error'][$key] === UPLOAD_ERR_OK) {
                        $file_extension = strtolower(pathinfo($_FILES['gallery_images']['name'][$key], PATHINFO_EXTENSION));
                        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                        
                        if (in_array($file_extension, $allowed)) {
                            $new_filename = uniqid('gallery_') . '.' . $file_extension;
                            $upload_path = $upload_dir . $new_filename;
                            
                            if (move_uploaded_file($tmp_name, $upload_path)) {
                                $gallery_images[] = $upload_path;
                            }
                        }
                    }
                }
            }
            $gallery_images_str = !empty($gallery_images) ? implode(',', $gallery_images) : NULL;
            
            // Insert product if no errors
            if (empty($error_message) && $main_image) {
                $sale_value = $sale_price !== NULL ? $sale_price : 'NULL';
                $weight_value = $weight !== NULL ? $weight : 'NULL';
                $gallery_value = $gallery_images_str !== NULL ? "'$gallery_images_str'" : 'NULL';
                
                $sql = "INSERT INTO products (
                    product_name, product_slug, category_id, short_description, full_description, specifications,
                    main_image, gallery_images, regular_price, sale_price, discount_percentage, tax_class,
                    stock_quantity, badge_new, badge_hot, badge_sale, badge_featured, badge_text, badge_color,
                    weight, size, rating, review_count, enable_reviews
                ) VALUES (
                    '$product_name', '$product_slug', $category_id, '$short_description', '$full_description', '$specifications',
                    '$main_image', $gallery_value, $regular_price, $sale_value, $discount_percentage, '$tax_class',
                    $stock_quantity, $badge_new, $badge_hot, $badge_sale, $badge_featured, '$badge_text', '$badge_color',
                    $weight_value, '$size', $rating, $review_count, $enable_reviews
                )";
                
                if ($conn->query($sql)) {
                    $success_message = "Product added successfully!";
                    // Optionally redirect
                    // header('Location: products.php?success=1');
                    // exit();
                } else {
                    $error_message = "Error: " . $conn->error;
                }
            }
        }
    }
}

// Fetch categories
$categories = getCategories($conn);

// ============================================
// FRONTEND HTML - BOTTOM OF FILE
// ============================================
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?> | ADMIN PANEL</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/add-product.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .alert { padding: 15px 20px; border-radius: 8px; margin-bottom: 20px; font-weight: 500; animation: slideDown 0.3s ease; }
        .alert-success { background: #d1fae5; color: #065f46; border-left: 4px solid #10b981; }
        .alert-error { background: #fee2e2; color: #991b1b; border-left: 4px solid #ef4444; }
        .alert i { margin-right: 10px; }
        @keyframes slideDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body>
    <div class="admin-wrapper">
        <?php include 'includes/sidebar.php'; ?>

        <div class="main-content">
            <header class="top-header">
                <div class="header-left">
                    <button class="toggle-sidebar" id="toggleSidebar" aria-label="Toggle Sidebar">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1>Add New Product</h1>
                </div>
                <div class="header-right">
                    <a href="products.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Products
                    </a>
                </div>
            </header>

            <div class="form-container">
                
                <?php if (!empty($success_message)): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <?php echo htmlspecialchars($success_message); ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($error_message)): ?>
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <?php echo htmlspecialchars($error_message); ?>
                    </div>
                <?php endif; ?>

                <form action="" method="POST" enctype="multipart/form-data" id="addProductForm">
                    <input type="hidden" name="product_slug" id="product_slug" value="">
                    
                    <!-- Basic Information -->
                    <div class="form-section">
                        <div class="section-header">
                            <h2><i class="fas fa-info-circle"></i> Basic Information</h2>
                        </div>
                        <div class="form-grid">
                            <div class="form-group full-width">
                                <label for="product_name">Product Name <span class="required">*</span></label>
                                <input type="text" id="product_name" name="product_name" placeholder="Enter product name" required>
                            </div>

                            <div class="form-group">
                                <label for="category">Category <span class="required">*</span></label>
                                <select id="category" name="category" required>
                                    <option value="">Select Category</option>
                                    <?php foreach($categories as $cat): ?>
                                        <option value="<?php echo htmlspecialchars($cat['id']); ?>">
                                            <?php echo htmlspecialchars($cat['category_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="stock_quantity">Stock Quantity <span class="required">*</span></label>
                                <input type="number" id="stock_quantity" name="stock_quantity" min="0" placeholder="0" required>
                            </div>
                        </div>
                    </div>

                    <!-- Product Images -->
                    <div class="form-section">
                        <div class="section-header">
                            <h2><i class="fas fa-images"></i> Product Images</h2>
                        </div>
                        <div class="form-grid">
                            <div class="form-group full-width">
                                <label for="main_image">Main Product Image <span class="required">*</span></label>
                                <div class="image-upload-container">
                                    <input type="file" id="main_image" name="main_image" accept="image/*" required>
                                    <div class="image-preview" id="mainImagePreview">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                        <p>Click to upload main image</p>
                                        <small>Recommended: 800x800px, Max 5MB</small>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group full-width">
                                <label for="gallery_images">Gallery Images (Multiple)</label>
                                <div class="image-upload-container">
                                    <input type="file" id="gallery_images" name="gallery_images[]" accept="image/*" multiple>
                                    <div class="image-preview" id="galleryPreview">
                                        <i class="fas fa-images"></i>
                                        <p>Click to upload gallery images</p>
                                        <small>You can select multiple images</small>
                                    </div>
                                </div>
                                <div class="gallery-preview-grid" id="galleryGrid"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Pricing Information -->
                    <div class="form-section">
                        <div class="section-header">
                            <h2><i class="fas fa-dollar-sign"></i> Pricing Information</h2>
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="regular_price">Regular Price <span class="required">*</span></label>
                                <div class="input-with-icon">
                                    <span class="input-icon">$</span>
                                    <input type="number" id="regular_price" name="regular_price" step="0.01" min="0" placeholder="0.00" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="sale_price">Sale Price (Discounted)</label>
                                <div class="input-with-icon">
                                    <span class="input-icon">$</span>
                                    <input type="number" id="sale_price" name="sale_price" step="0.01" min="0" placeholder="0.00">
                                </div>
                                <small>Leave empty if no discount</small>
                            </div>

                            <div class="form-group">
                                <label for="discount_percentage">Discount Percentage</label>
                                <div class="input-with-icon">
                                    <input type="number" id="discount_percentage" name="discount_percentage" min="0" max="100" value="0" placeholder="0">
                                    <span class="input-icon-right">%</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="tax_class">Tax Class</label>
                                <select id="tax_class" name="tax_class">
                                    <option value="standard">Standard</option>
                                    <option value="reduced">Reduced Rate</option>
                                    <option value="zero">Zero Rate</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Product Description -->
                    <div class="form-section">
                        <div class="section-header">
                            <h2><i class="fas fa-align-left"></i> Product Description</h2>
                        </div>
                        <div class="form-grid">
                            <div class="form-group full-width">
                                <label for="short_description">Short Description <span class="required">*</span></label>
                                <textarea id="short_description" name="short_description" rows="3" placeholder="Brief product description (150-200 characters)" required></textarea>
                                <small>This will appear in product listings</small>
                            </div>

                            <div class="form-group full-width">
                                <label for="full_description">Full Description <span class="required">*</span></label>
                                <textarea id="full_description" name="full_description" rows="8" placeholder="Detailed product description..." required></textarea>
                                <small>Complete product details, features, and benefits</small>
                            </div>

                            <div class="form-group full-width">
                                <label for="specifications">Product Specifications</label>
                                <textarea id="specifications" name="specifications" rows="5" placeholder="Weight: 500g&#10;Origin: Turkey&#10;Packaging: Resealable bag"></textarea>
                                <small>Enter each specification on a new line</small>
                            </div>
                        </div>
                    </div>

                    <!-- Product Badges & Labels -->
                    <div class="form-section">
                        <div class="section-header">
                            <h2><i class="fas fa-tags"></i> Product Badges & Labels</h2>
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label>Product Badges</label>
                                <div class="checkbox-group">
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="badge_new" value="1">
                                        <span class="badge badge-new">NEW</span> Mark as New Product
                                    </label>
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="badge_hot" value="1">
                                        <span class="badge badge-hot">HOT</span> Mark as Hot/Trending
                                    </label>
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="badge_sale" value="1">
                                        <span class="badge badge-sale">SALE</span> Mark as On Sale
                                    </label>
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="badge_featured" value="1">
                                        <span class="badge badge-featured">FEATURED</span> Featured Product
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="badge_text">Custom Badge Text</label>
                                <input type="text" id="badge_text" name="badge_text" placeholder="e.g., Best Seller, Limited Edition">
                                <small>Custom badge text (optional)</small>
                            </div>

                            <div class="form-group">
                                <label for="badge_color">Badge Background Color</label>
                                <input type="color" id="badge_color" name="badge_color" value="#ff6b6b">
                            </div>
                        </div>
                    </div>

                    <!-- Product Attributes -->
                    <div class="form-section">
                        <div class="section-header">
                            <h2><i class="fas fa-sliders-h"></i> Product Attributes</h2>
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="weight">Weight</label>
                                <div class="input-with-icon">
                                    <input type="number" id="weight" name="weight" step="0.01" min="0" placeholder="0">
                                    <span class="input-icon-right">kg</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="size">Available Sizes</label>
                                <input type="text" id="size" name="size" placeholder="e.g., 250g, 500g, 1kg">
                            </div>
                        </div>
                    </div>

                    <!-- Rating & Reviews -->
                    <div class="form-section">
                        <div class="section-header">
                            <h2><i class="fas fa-star"></i> Rating & Reviews</h2>
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="rating">Initial Rating</label>
                                <select id="rating" name="rating">
                                    <option value="5">★★★★★ (5 Stars)</option>
                                    <option value="4.5">★★★★☆ (4.5 Stars)</option>
                                    <option value="4" selected>★★★★☆ (4 Stars)</option>
                                    <option value="3.5">★★★☆☆ (3.5 Stars)</option>
                                    <option value="3">★★★☆☆ (3 Stars)</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="review_count">Number of Reviews</label>
                                <input type="number" id="review_count" name="review_count" min="0" value="0" placeholder="0">
                            </div>

                            <div class="form-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" name="enable_reviews" value="1" checked>
                                    Enable customer reviews
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <button type="submit" name="submit_product" class="btn btn-primary btn-lg">
                            <i class="fas fa-save"></i> Save Product
                        </button>
                        <button type="button" class="btn btn-secondary btn-lg" onclick="window.location.href='products.php'">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                        <button type="reset" class="btn btn-warning btn-lg">
                            <i class="fas fa-undo"></i> Reset Form
                        </button>
                    </div>
                </form>
            </div>

            <?php include 'includes/footer.php'; ?>
        </div>
    </div>

    <script src="assets/js/script.js"></script>
    <script>
        // Auto-generate slug
        document.getElementById('product_name').addEventListener('input', function(e) {
            const slug = e.target.value.toLowerCase().trim()
                .replace(/[^\w\s-]/g, '').replace(/[\s_-]+/g, '-').replace(/^-+|-+$/g, '');
            document.getElementById('product_slug').value = slug;
        });

        // Main image preview
        document.getElementById('main_image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('mainImagePreview');
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `<img src="${e.target.result}" style="max-width: 100%; max-height: 300px; border-radius: 8px;">`;
                };
                reader.readAsDataURL(file);
            }
        });

        // Gallery images preview
        document.getElementById('gallery_images').addEventListener('change', function(e) {
            const files = e.target.files;
            const grid = document.getElementById('galleryGrid');
            grid.innerHTML = '';
            
            Array.from(files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.cssText = 'width: 150px; height: 150px; object-fit: cover; border-radius: 8px; margin: 5px;';
                    grid.appendChild(img);
                };
                reader.readAsDataURL(file);
            });
        });

        // Toggle sidebar
        document.getElementById('toggleSidebar')?.addEventListener('click', function() {
            document.querySelector('.admin-wrapper').classList.toggle('sidebar-collapsed');
        });
    </script>
</body>
</html>
<?php mysqli_close($conn); ?>