// assets/js/add-product.js - Add Product Page JavaScript

document.addEventListener('DOMContentLoaded', function() {
    
    // Main Image Preview
    const mainImageInput = document.getElementById('main_image');
    const mainImagePreview = document.getElementById('mainImagePreview');
    
    if (mainImageInput && mainImagePreview) {
        mainImageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    mainImagePreview.innerHTML = `<img src="${event.target.result}" alt="Main Product Image">`;
                    mainImagePreview.classList.add('has-image');
                };
                reader.readAsDataURL(file);
            }
        });
    }
    
    // Gallery Images Preview
    const galleryInput = document.getElementById('gallery_images');
    const galleryGrid = document.getElementById('galleryGrid');
    
    if (galleryInput && galleryGrid) {
        galleryInput.addEventListener('change', function(e) {
            galleryGrid.innerHTML = '';
            const files = Array.from(e.target.files);
            
            files.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const galleryItem = document.createElement('div');
                    galleryItem.className = 'gallery-item';
                    galleryItem.innerHTML = `
                        <img src="${event.target.result}" alt="Gallery Image ${index + 1}">
                        <button type="button" class="remove-image" data-index="${index}">
                            <i class="fas fa-times"></i>
                        </button>
                    `;
                    galleryGrid.appendChild(galleryItem);
                };
                reader.readAsDataURL(file);
            });
        });
        
        // Remove gallery image
        galleryGrid.addEventListener('click', function(e) {
            if (e.target.closest('.remove-image')) {
                const button = e.target.closest('.remove-image');
                const index = parseInt(button.dataset.index);
                const galleryItem = button.closest('.gallery-item');
                
                // Remove from DOM
                galleryItem.remove();
                
                // Update file input
                const dt = new DataTransfer();
                const files = Array.from(galleryInput.files);
                files.forEach((file, i) => {
                    if (i !== index) {
                        dt.items.add(file);
                    }
                });
                galleryInput.files = dt.files;
            }
        });
    }
    
    // Calculate discount percentage automatically
    const regularPriceInput = document.getElementById('regular_price');
    const salePriceInput = document.getElementById('sale_price');
    const discountPercentageInput = document.getElementById('discount_percentage');
    
    function calculateDiscount() {
        const regularPrice = parseFloat(regularPriceInput.value) || 0;
        const salePrice = parseFloat(salePriceInput.value) || 0;
        
        if (regularPrice > 0 && salePrice > 0 && salePrice < regularPrice) {
            const discount = ((regularPrice - salePrice) / regularPrice) * 100;
            discountPercentageInput.value = Math.round(discount);
        } else {
            discountPercentageInput.value = '';
        }
    }
    
    if (regularPriceInput && salePriceInput && discountPercentageInput) {
        regularPriceInput.addEventListener('input', calculateDiscount);
        salePriceInput.addEventListener('input', calculateDiscount);
        
        // Calculate sale price from discount percentage
        discountPercentageInput.addEventListener('input', function() {
            const regularPrice = parseFloat(regularPriceInput.value) || 0;
            const discountPercent = parseFloat(this.value) || 0;
            
            if (regularPrice > 0 && discountPercent > 0 && discountPercent <= 100) {
                const salePrice = regularPrice - (regularPrice * discountPercent / 100);
                salePriceInput.value = salePrice.toFixed(2);
            }
        });
    }
    
    // Form validation before submit
    const addProductForm = document.getElementById('addProductForm');
    if (addProductForm) {
        addProductForm.addEventListener('submit', function(e) {
            let isValid = true;
            const errors = [];
            
            // Check required fields
            const productName = document.getElementById('product_name').value.trim();
            const regularPrice = parseFloat(document.getElementById('regular_price').value);
            const stockQuantity = parseInt(document.getElementById('stock_quantity').value);
            
            if (!productName) {
                errors.push('Product name is required');
                isValid = false;
            }
            
            if (!regularPrice || regularPrice <= 0) {
                errors.push('Valid regular price is required');
                isValid = false;
            }
            
            if (isNaN(stockQuantity) || stockQuantity < 0) {
                errors.push('Valid stock quantity is required');
                isValid = false;
            }
            
            // Check if main image is uploaded
            if (!mainImageInput.files.length) {
                errors.push('Main product image is required');
                isValid = false;
            }
            
            if (!isValid) {
                e.preventDefault();
                alert('Please fix the following errors:\n\n' + errors.join('\n'));
                return false;
            }
            
            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving Product...';
        });
    }
    
    // Badge preview
    const badgeCheckboxes = document.querySelectorAll('input[name^="badge_"]');
    const badgeTextInput = document.getElementById('badge_text');
    const badgeColorInput = document.getElementById('badge_color');
    
    function createBadgePreview() {
        let previewContainer = document.getElementById('badge-preview-container');
        
        if (!previewContainer) {
            previewContainer = document.createElement('div');
            previewContainer.id = 'badge-preview-container';
            previewContainer.style.cssText = 'margin-top: 15px; display: flex; gap: 10px; flex-wrap: wrap;';
            const badgeSection = document.querySelector('.form-section:has([name^="badge_"])');
            if (badgeSection) {
                badgeSection.querySelector('.form-grid').appendChild(previewContainer);
            }
        }
        
        previewContainer.innerHTML = '<strong style="width: 100%; color: #6b7280; font-size: 13px;">Badge Preview:</strong>';
        
        badgeCheckboxes.forEach(checkbox => {
            if (checkbox.checked) {
                const badgeSpan = checkbox.parentElement.querySelector('.badge').cloneNode(true);
                previewContainer.appendChild(badgeSpan);
            }
        });
        
        if (badgeTextInput.value) {
            const customBadge = document.createElement('span');
            customBadge.className = 'badge';
            customBadge.textContent = badgeTextInput.value;
            customBadge.style.backgroundColor = badgeColorInput.value;
            customBadge.style.color = '#ffffff';
            previewContainer.appendChild(customBadge);
        }
    }
    
    badgeCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', createBadgePreview);
    });
    
    if (badgeTextInput) {
        badgeTextInput.addEventListener('input', createBadgePreview);
    }
    
    if (badgeColorInput) {
        badgeColorInput.addEventListener('change', createBadgePreview);
    }
    
    // Auto-save to localStorage (draft)
    let autoSaveTimer;
    const formInputs = addProductForm.querySelectorAll('input, select, textarea');
    
    formInputs.forEach(input => {
        input.addEventListener('input', function() {
            clearTimeout(autoSaveTimer);
            autoSaveTimer = setTimeout(saveFormDraft, 2000);
        });
    });
    
    function saveFormDraft() {
        const formData = {};
        const inputs = addProductForm.querySelectorAll('input:not([type="file"]), select, textarea');
        
        inputs.forEach(input => {
            if (input.type === 'checkbox') {
                formData[input.name] = input.checked;
            } else {
                formData[input.name] = input.value;
            }
        });
        
        console.log('Draft saved:', new Date().toLocaleTimeString());
        // In production, save to localStorage or send to server
        // localStorage.setItem('product_draft', JSON.stringify(formData));
    }
    
    console.log('Add Product page initialized');
});