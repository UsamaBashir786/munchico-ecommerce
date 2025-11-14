// products.js - Products Management JavaScript

document.addEventListener('DOMContentLoaded', function() {
    
    // Search Products
    const searchInput = document.getElementById('searchProducts');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const productCards = document.querySelectorAll('.product-card');
            
            productCards.forEach(card => {
                const name = card.querySelector('.product-name')?.textContent.toLowerCase();
                const sku = card.querySelector('.product-sku')?.textContent.toLowerCase();
                
                if (name?.includes(searchTerm) || sku?.includes(searchTerm)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }
    
    // Filter by Category
    const categoryFilter = document.getElementById('filterCategory');
    if (categoryFilter) {
        categoryFilter.addEventListener('change', function() {
            const category = this.value.toLowerCase();
            const productCards = document.querySelectorAll('.product-card');
            
            productCards.forEach(card => {
                const productCategory = card.querySelector('.product-category')?.textContent.toLowerCase();
                
                if (!category || productCategory?.includes(category)) {
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
            const productCards = document.querySelectorAll('.product-card');
            
            productCards.forEach(card => {
                const productStatus = card.querySelector('.product-status')?.textContent.toLowerCase();
                
                if (!status || productStatus?.includes(status)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }
    
    // Sort Products
    const sortSelect = document.getElementById('sortBy');
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            const sortValue = this.value;
            const productsGrid = document.querySelector('.products-grid');
            const productCards = Array.from(document.querySelectorAll('.product-card'));
            
            productCards.sort((a, b) => {
                const aName = a.querySelector('.product-name')?.textContent;
                const bName = b.querySelector('.product-name')?.textContent;
                const aPrice = parseFloat(a.querySelector('.product-price')?.textContent.replace('$', ''));
                const bPrice = parseFloat(b.querySelector('.product-price')?.textContent.replace('$', ''));
                const aStock = parseInt(a.querySelector('.meta-item strong')?.textContent);
                const bStock = parseInt(b.querySelector('.meta-item strong')?.textContent);
                
                switch(sortValue) {
                    case 'name-asc':
                        return aName.localeCompare(bName);
                    case 'name-desc':
                        return bName.localeCompare(aName);
                    case 'price-low':
                        return aPrice - bPrice;
                    case 'price-high':
                        return bPrice - aPrice;
                    case 'stock-low':
                        return aStock - bStock;
                    default:
                        return 0;
                }
            });
            
            productCards.forEach(card => productsGrid.appendChild(card));
        });
    }
    
    // Select All Products
    const selectAllCheckbox = document.createElement('input');
    selectAllCheckbox.type = 'checkbox';
    selectAllCheckbox.id = 'selectAllProducts';
    
    const productCheckboxes = document.querySelectorAll('.product-checkbox');
    productCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateSelectedCount();
        });
    });
    
    function updateSelectedCount() {
        const checkedCount = document.querySelectorAll('.product-checkbox:checked').length;
        if (checkedCount > 0) {
            console.log(`${checkedCount} product(s) selected`);
            // Show bulk actions toolbar here if needed
        }
    }
    
    // Export Products
    const exportBtn = document.querySelector('.btn-secondary');
    if (exportBtn && exportBtn.textContent.includes('Export')) {
        exportBtn.addEventListener('click', function() {
            console.log('Exporting products...');
            alert('Export functionality will be implemented here\nFormats: CSV, Excel, PDF');
        });
    }
    
    console.log('Products page initialized');
});

// Quick View Product
function quickView(productId) {
    console.log('Quick view product:', productId);
    // Implement modal with product details
    alert(`Quick view for product ID: ${productId}\n\nThis would open a modal with product details.`);
}

// Edit Product
function editProduct(productId) {
    console.log('Editing product:', productId);
    window.location.href = `edit-product.php?id=${productId}`;
}

// Duplicate Product
function duplicateProduct(productId) {
    const confirmed = confirm('Do you want to create a duplicate of this product?');
    if (confirmed) {
        console.log('Duplicating product:', productId);
        // Implement duplication logic
        alert('Product duplicated successfully!');
        // Reload page or add new card
        location.reload();
    }
}

// Delete Product
function deleteProduct(productId) {
    const confirmed = confirm('Are you sure you want to delete this product?\n\nThis action cannot be undone.');
    if (confirmed) {
        console.log('Deleting product:', productId);
        
        // Find and remove the product card with animation
        const productCard = document.querySelector(`[data-product-id="${productId}"]`);
        if (productCard) {
            productCard.style.transition = 'all 0.3s ease';
            productCard.style.opacity = '0';
            productCard.style.transform = 'scale(0.8)';
            
            setTimeout(() => {
                productCard.remove();
                alert('Product deleted successfully!');
            }, 300);
        }
    }
}

// Bulk Actions
function performBulkAction(action) {
    const selectedProducts = document.querySelectorAll('.product-checkbox:checked');
    const productIds = Array.from(selectedProducts).map(cb => cb.value);
    
    if (productIds.length === 0) {
        alert('Please select at least one product');
        return;
    }
    
    switch(action) {
        case 'delete':
            if (confirm(`Delete ${productIds.length} selected product(s)?`)) {
                console.log('Bulk delete:', productIds);
                selectedProducts.forEach(cb => {
                    const card = cb.closest('.product-card');
                    card.style.opacity = '0';
                    setTimeout(() => card.remove(), 300);
                });
            }
            break;
        case 'activate':
            console.log('Bulk activate:', productIds);
            alert(`${productIds.length} product(s) activated`);
            break;
        case 'deactivate':
            console.log('Bulk deactivate:', productIds);
            alert(`${productIds.length} product(s) deactivated`);
            break;
    }
}

// Image upload preview (for add/edit product pages)
function previewProductImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('imagePreview');
            if (preview) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Stock Alert
document.addEventListener('DOMContentLoaded', function() {
    const lowStockProducts = document.querySelectorAll('.badge-low-stock, .badge-out-of-stock');
    if (lowStockProducts.length > 0) {
        console.log(`Alert: ${lowStockProducts.length} product(s) need restocking`);
    }
});