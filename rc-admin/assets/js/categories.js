// categories.js - Categories Management JavaScript

document.addEventListener('DOMContentLoaded', function() {
    
    // Search Categories
    const searchInput = document.getElementById('searchCategories');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const categoryCards = document.querySelectorAll('.category-card');
            
            categoryCards.forEach(card => {
                const name = card.querySelector('.category-name')?.textContent.toLowerCase();
                const description = card.querySelector('.category-description')?.textContent.toLowerCase();
                
                if (name?.includes(searchTerm) || description?.includes(searchTerm)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }
    
    // Filter by Status
    const statusFilter = document.getElementById('filterStatus');
    if (statusFilter) {
        statusFilter.addEventListener('change', function() {
            const status = this.value.toLowerCase();
            const categoryCards = document.querySelectorAll('.category-card');
            
            categoryCards.forEach(card => {
                const categoryStatus = card.querySelector('.category-status')?.textContent.toLowerCase();
                
                if (!status || categoryStatus?.includes(status)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }
    
    // Filter by Featured
    const featuredFilter = document.getElementById('filterFeatured');
    if (featuredFilter) {
        featuredFilter.addEventListener('change', function() {
            const filter = this.value;
            const categoryCards = document.querySelectorAll('.category-card');
            
            categoryCards.forEach(card => {
                const isFeatured = card.querySelector('.badge-featured') !== null;
                
                if (!filter || 
                    (filter === 'featured' && isFeatured) ||
                    (filter === 'non-featured' && !isFeatured)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }
    
    // Sort Categories
    const sortSelect = document.getElementById('sortBy');
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            const sortValue = this.value;
            const categoriesGrid = document.querySelector('.categories-grid');
            const categoryCards = Array.from(document.querySelectorAll('.category-card'));
            
            categoryCards.sort((a, b) => {
                const aName = a.querySelector('.category-name')?.textContent;
                const bName = b.querySelector('.category-name')?.textContent;
                const aProducts = parseInt(a.querySelector('.meta-item strong')?.textContent);
                const bProducts = parseInt(b.querySelector('.meta-item strong')?.textContent);
                
                switch(sortValue) {
                    case 'name-asc':
                        return aName.localeCompare(bName);
                    case 'name-desc':
                        return bName.localeCompare(aName);
                    case 'products-high':
                        return bProducts - aProducts;
                    case 'products-low':
                        return aProducts - bProducts;
                    case 'newest':
                        // Assuming cards are already in newest order
                        return 0;
                    case 'oldest':
                        // Reverse order
                        return categoryCards.indexOf(b) - categoryCards.indexOf(a);
                    default:
                        return 0;
                }
            });
            
            categoryCards.forEach(card => categoriesGrid.appendChild(card));
        });
    }
    
    // Select All Categories
    const categoryCheckboxes = document.querySelectorAll('.category-checkbox');
    categoryCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateSelectedCount();
        });
    });
    
    function updateSelectedCount() {
        const checkedCount = document.querySelectorAll('.category-checkbox:checked').length;
        if (checkedCount > 0) {
            console.log(`${checkedCount} category(ies) selected`);
            // Show bulk actions toolbar here if needed
        }
    }
    
    // Export Categories
    const exportBtn = document.querySelector('.btn-secondary');
    if (exportBtn && exportBtn.textContent.includes('Export')) {
        exportBtn.addEventListener('click', function() {
            console.log('Exporting categories...');
            alert('Export functionality will be implemented here\nFormats: CSV, Excel, PDF');
        });
    }
    
    console.log('Categories page initialized');
});

// View Category Details
function viewCategory(categoryId) {
    console.log('Viewing category:', categoryId);
    // Implement modal or redirect to details page
    alert(`View details for category ID: ${categoryId}\n\nThis would show full category information.`);
}

// Edit Category
function editCategory(categoryId) {
    console.log('Editing category:', categoryId);
    window.location.href = `edit-category.php?id=${categoryId}`;
}

// View Products in Category
function viewProducts(categoryId) {
    console.log('Viewing products in category:', categoryId);
    window.location.href = `products.php?category=${categoryId}`;
}

// Delete Category
function deleteCategory(categoryId) {
    const confirmed = confirm('Are you sure you want to delete this category?\n\nWarning: This will also affect associated products.\n\nThis action cannot be undone.');
    if (confirmed) {
        console.log('Deleting category:', categoryId);
        
        // Find and remove the category card with animation
        const categoryCard = document.querySelector(`[data-category-id="${categoryId}"]`);
        if (categoryCard) {
            categoryCard.style.transition = 'all 0.3s ease';
            categoryCard.style.opacity = '0';
            categoryCard.style.transform = 'scale(0.8)';
            
            setTimeout(() => {
                categoryCard.remove();
                alert('Category deleted successfully!');
            }, 300);
        }
    }
}

// Toggle Featured Status
function toggleFeatured(categoryId) {
    const categoryCard = document.querySelector(`[data-category-id="${categoryId}"]`);
    const featuredBadge = categoryCard.querySelector('.badge-featured');
    
    if (featuredBadge) {
        // Remove featured
        featuredBadge.remove();
        console.log('Category removed from featured');
        alert('Category removed from featured list');
    } else {
        // Add featured
        const badgeContainer = categoryCard.querySelector('.category-badges');
        const newBadge = document.createElement('span');
        newBadge.className = 'badge-featured';
        newBadge.innerHTML = '<i class="fas fa-star"></i> Featured';
        badgeContainer.insertBefore(newBadge, badgeContainer.firstChild);
        console.log('Category marked as featured');
        alert('Category added to featured list');
    }
}

// Toggle Active/Inactive Status
function toggleStatus(categoryId) {
    const categoryCard = document.querySelector(`[data-category-id="${categoryId}"]`);
    const statusBadge = categoryCard.querySelector('.category-status');
    
    if (statusBadge.classList.contains('badge-active')) {
        statusBadge.classList.remove('badge-active');
        statusBadge.classList.add('badge-inactive');
        statusBadge.textContent = 'Inactive';
        alert('Category deactivated');
    } else {
        statusBadge.classList.remove('badge-inactive');
        statusBadge.classList.add('badge-active');
        statusBadge.textContent = 'Active';
        alert('Category activated');
    }
}

// Bulk Actions
function performBulkAction(action) {
    const selectedCategories = document.querySelectorAll('.category-checkbox:checked');
    const categoryIds = Array.from(selectedCategories).map(cb => cb.value);
    
    if (categoryIds.length === 0) {
        alert('Please select at least one category');
        return;
    }
    
    switch(action) {
        case 'delete':
            if (confirm(`Delete ${categoryIds.length} selected category(ies)?\n\nThis action cannot be undone.`)) {
                console.log('Bulk delete:', categoryIds);
                selectedCategories.forEach(cb => {
                    const card = cb.closest('.category-card');
                    card.style.opacity = '0';
                    setTimeout(() => card.remove(), 300);
                });
                alert(`${categoryIds.length} category(ies) deleted`);
            }
            break;
        case 'activate':
            console.log('Bulk activate:', categoryIds);
            alert(`${categoryIds.length} category(ies) activated`);
            selectedCategories.forEach(cb => {
                const card = cb.closest('.category-card');
                const statusBadge = card.querySelector('.category-status');
                statusBadge.classList.remove('badge-inactive');
                statusBadge.classList.add('badge-active');
                statusBadge.textContent = 'Active';
            });
            break;
        case 'deactivate':
            console.log('Bulk deactivate:', categoryIds);
            alert(`${categoryIds.length} category(ies) deactivated`);
            selectedCategories.forEach(cb => {
                const card = cb.closest('.category-card');
                const statusBadge = card.querySelector('.category-status');
                statusBadge.classList.remove('badge-active');
                statusBadge.classList.add('badge-inactive');
                statusBadge.textContent = 'Inactive';
            });
            break;
        case 'feature':
            console.log('Bulk feature:', categoryIds);
            alert(`${categoryIds.length} category(ies) marked as featured`);
            break;
    }
}

// Category Statistics
function showCategoryStats(categoryId) {
    console.log('Showing stats for category:', categoryId);
    // Implement stats modal
    alert('Category statistics:\n\n- Total Products: 45\n- Active Products: 42\n- Total Sales: $12,450\n- Average Rating: 4.7\n- Last Updated: Today');
}