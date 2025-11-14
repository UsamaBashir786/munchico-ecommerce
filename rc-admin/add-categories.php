<?php
// add-category.php - Add Category Page
session_start();

// Page variables
$page_title = "Add Category";
$current_page = "categories";

// Fetch parent categories (example data)
$parent_categories = [
    ['id' => 1, 'name' => 'Dried Fruits'],
    ['id' => 2, 'name' => 'Nuts'],
    ['id' => 3, 'name' => 'Seeds'],
    ['id' => 4, 'name' => 'Organic Products'],
    ['id' => 5, 'name' => 'Snacks']
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> | ADMIN PANEL</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/add-category.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="admin-wrapper">
        <!-- Include Sidebar -->
        <?php include 'includes/sidebar.php'; ?>

        <!-- Main Content Area -->
        <div class="main-content">
            <!-- Header -->
            <header class="top-header">
                <div class="header-left">
                    <button class="toggle-sidebar" id="toggleSidebar">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1>Add New Category</h1>
                </div>
                <div class="header-right">
                    <a href="categories.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Categories
                    </a>
                </div>
            </header>

            <!-- Category Form Section -->
            <div class="form-container">
                <form action="process-category.php" method="POST" enctype="multipart/form-data" id="addCategoryForm">
                    
                    <!-- Basic Information -->
                    <div class="form-section">
                        <div class="section-header">
                            <h2><i class="fas fa-info-circle"></i> Basic Information</h2>
                        </div>
                        <div class="form-grid">
                            <div class="form-group full-width">
                                <label for="category_name">Category Name <span class="required">*</span></label>
                                <input type="text" id="category_name" name="category_name" placeholder="Enter category name" required>
                            </div>

                            <div class="form-group full-width">
                                <label for="category_slug">Category Slug <span class="required">*</span></label>
                                <input type="text" id="category_slug" name="category_slug" placeholder="category-slug-url" required>
                                <small>URL-friendly version of the category name</small>
                            </div>

                            <div class="form-group full-width">
                                <label for="parent_category">Parent Category</label>
                                <select id="parent_category" name="parent_category">
                                    <option value="">None (Main Category)</option>
                                    <?php foreach($parent_categories as $parent): ?>
                                        <option value="<?php echo $parent['id']; ?>"><?php echo $parent['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <small>Select a parent category to create a subcategory</small>
                            </div>

                            <div class="form-group full-width">
                                <label for="description">Category Description</label>
                                <textarea id="description" name="description" rows="4" placeholder="Brief description of this category..."></textarea>
                                <small>Optional description to help users understand the category</small>
                            </div>
                        </div>
                    </div>

                    <!-- Category Image -->
                    <div class="form-section">
                        <div class="section-header">
                            <h2><i class="fas fa-image"></i> Category Image</h2>
                        </div>
                        <div class="form-grid">
                            <div class="form-group full-width">
                                <label for="category_image">Category Image</label>
                                <div class="image-upload-container">
                                    <input type="file" id="category_image" name="category_image" accept="image/*">
                                    <div class="image-preview" id="categoryImagePreview">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                        <p>Click to upload category image</p>
                                        <small>Recommended: 600x400px, Max 3MB</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Display Settings -->
                    <div class="form-section">
                        <div class="section-header">
                            <h2><i class="fas fa-eye"></i> Display Settings</h2>
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="display_order">Display Order</label>
                                <input type="number" id="display_order" name="display_order" min="0" value="0" placeholder="0">
                                <small>Lower numbers appear first</small>
                            </div>

                            <div class="form-group">
                                <label for="icon_class">Icon Class (Font Awesome)</label>
                                <input type="text" id="icon_class" name="icon_class" placeholder="fas fa-leaf">
                                <small>E.g., fas fa-leaf, fas fa-apple-alt</small>
                            </div>

                            <div class="form-group">
                                <label for="color">Category Color</label>
                                <input type="color" id="color" name="color" value="#10b981">
                                <small>Used for category badge/tag</small>
                            </div>

                            <div class="form-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" name="show_on_homepage" value="1" checked>
                                    Show on Homepage
                                </label>
                            </div>

                            <div class="form-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" name="is_featured" value="1">
                                    Featured Category
                                </label>
                            </div>

                            <div class="form-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" name="is_active" value="1" checked>
                                    Active (Visible to Users)
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- SEO Settings -->
                    <div class="form-section">
                        <div class="section-header">
                            <h2><i class="fas fa-search"></i> SEO Settings</h2>
                        </div>
                        <div class="form-grid">
                            <div class="form-group full-width">
                                <label for="meta_title">Meta Title</label>
                                <input type="text" id="meta_title" name="meta_title" placeholder="SEO optimized title">
                                <small>Recommended: 50-60 characters</small>
                            </div>

                            <div class="form-group full-width">
                                <label for="meta_description">Meta Description</label>
                                <textarea id="meta_description" name="meta_description" rows="3" placeholder="SEO meta description"></textarea>
                                <small>Recommended: 150-160 characters</small>
                            </div>

                            <div class="form-group full-width">
                                <label for="meta_keywords">Meta Keywords</label>
                                <input type="text" id="meta_keywords" name="meta_keywords" placeholder="keyword1, keyword2, keyword3">
                                <small>Separate keywords with commas</small>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save"></i> Save Category
                        </button>
                        <button type="button" class="btn btn-secondary btn-lg" onclick="window.location.href='categories.php'">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                        <button type="reset" class="btn btn-warning btn-lg">
                            <i class="fas fa-undo"></i> Reset Form
                        </button>
                    </div>
                </form>
            </div>

            <!-- Include Footer -->
            <?php include 'includes/footer.php'; ?>
        </div>
    </div>

    <script src="assets/js/script.js"></script>
    <script src="assets/js/add-category.js"></script>
</body>
</html>