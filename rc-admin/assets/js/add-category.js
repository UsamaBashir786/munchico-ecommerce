// assets/js/add-category.js - Add Category Page JavaScript

document.addEventListener('DOMContentLoaded', function() {
    
    // Auto-generate slug from category name
    const categoryNameInput = document.getElementById('category_name');
    const categorySlugInput = document.getElementById('category_slug');
    
    if (categoryNameInput && categorySlugInput) {
        categoryNameInput.addEventListener('input', function() {
            const slug = this.value
                .toLowerCase()
                .trim()
                .replace(/[^\w\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
            categorySlugInput.value = slug;
        });
    }
    
    // Category Image Preview
    const categoryImageInput = document.getElementById('category_image');
    const categoryImagePreview = document.getElementById('categoryImagePreview');
    
    if (categoryImageInput && categoryImagePreview) {
        categoryImageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Check file size (max 3MB)
                if (file.size > 3 * 1024 * 1024) {
                    alert('File size should not exceed 3MB');
                    this.value = '';
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = function(event) {
                    categoryImagePreview.innerHTML = `<img src="${event.target.result}" alt="Category Image">`;
                    categoryImagePreview.classList.add('has-image');
                };
                reader.readAsDataURL(file);
            }
        });
    }
    
    // Auto-fill meta title from category name
    const metaTitleInput = document.getElementById('meta_title');
    if (categoryNameInput && metaTitleInput) {
        categoryNameInput.addEventListener('blur', function() {
            if (!metaTitleInput.value) {
                metaTitleInput.value = this.value;
            }
        });
    }
    
    // Character counter for meta description
    const metaDescInput = document.getElementById('meta_description');
    if (metaDescInput) {
        const counterDiv = document.createElement('div');
        counterDiv.className = 'char-counter';
        metaDescInput.parentNode.appendChild(counterDiv);
        
        metaDescInput.addEventListener('input', function() {
            const length = this.value.length;
            counterDiv.textContent = `${length} / 160 characters`;
            if (length > 160) {
                counterDiv.style.color = '#ef4444';
            } else if (length > 140) {
                counterDiv.style.color = '#f59e0b';
            } else {
                counterDiv.style.color = '#10b981';
            }
        });
    }
    
    // Icon class preview
    const iconClassInput = document.getElementById('icon_class');
    const colorInput = document.getElementById('color');
    
    if (iconClassInput) {
        // Create preview container
        const previewContainer = document.createElement('div');
        previewContainer.className = 'icon-preview-container';
        previewContainer.innerHTML = `
            <div class="icon-preview" id="iconPreview">
                <i class="fas fa-folder"></i>
            </div>
            <div class="icon-preview-text">Icon Preview</div>
        `;
        iconClassInput.parentNode.appendChild(previewContainer);
        
        const iconPreview = document.getElementById('iconPreview');
        
        // Update icon preview
        function updateIconPreview() {
            const iconClass = iconClassInput.value || 'fas fa-folder';
            const color = colorInput.value || '#10b981';
            
            iconPreview.innerHTML = `<i class="${iconClass}"></i>`;
            iconPreview.style.color = color;
        }
        
        iconClassInput.addEventListener('input', updateIconPreview);
        if (colorInput) {
            colorInput.addEventListener('change', updateIconPreview);
        }
    }
    
    // Form validation before submit
    const addCategoryForm = document.getElementById('addCategoryForm');
    if (addCategoryForm) {
        addCategoryForm.addEventListener('submit', function(e) {
            let isValid = true;
            const errors = [];
            
            // Check required fields
            const categoryName = document.getElementById('category_name').value.trim();
            const categorySlug = document.getElementById('category_slug').value.trim();
            
            if (!categoryName) {
                errors.push('Category name is required');
                isValid = false;
            }
            
            if (!categorySlug) {
                errors.push('Category slug is required');
                isValid = false;
            }
            
            // Validate slug format
            const slugPattern = /^[a-z0-9]+(?:-[a-z0-9]+)*$/;
            if (categorySlug && !slugPattern.test(categorySlug)) {
                errors.push('Slug must contain only lowercase letters, numbers, and hyphens');
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
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving Category...';
        });
    }
    
    // Slug validation on input
    if (categorySlugInput) {
        categorySlugInput.addEventListener('blur', function() {
            const slug = this.value.trim();
            const slugPattern = /^[a-z0-9]+(?:-[a-z0-9]+)*$/;
            
            if (slug && !slugPattern.test(slug)) {
                this.style.borderColor = '#ef4444';
                
                // Show error message
                let errorMsg = this.nextElementSibling;
                if (!errorMsg || !errorMsg.classList.contains('slug-error')) {
                    errorMsg = document.createElement('small');
                    errorMsg.className = 'slug-error';
                    errorMsg.style.color = '#ef4444';
                    errorMsg.textContent = 'Invalid slug format. Use only lowercase letters, numbers, and hyphens.';
                    this.parentNode.insertBefore(errorMsg, this.nextSibling.nextSibling);
                }
            } else {
                this.style.borderColor = '#e5e7eb';
                const errorMsg = this.parentNode.querySelector('.slug-error');
                if (errorMsg) {
                    errorMsg.remove();
                }
            }
        });
    }
    
    // Parent category warning
    const parentCategorySelect = document.getElementById('parent_category');
    if (parentCategorySelect) {
        parentCategorySelect.addEventListener('change', function() {
            const warningDiv = document.getElementById('parent-warning');
            
            if (this.value) {
                if (!warningDiv) {
                    const warning = document.createElement('div');
                    warning.id = 'parent-warning';
                    warning.style.cssText = 'margin-top: 10px; padding: 10px; background: #fef3c7; border-left: 4px solid #f59e0b; border-radius: 6px; font-size: 13px; color: #92400e;';
                    warning.innerHTML = '<i class="fas fa-info-circle"></i> This will be created as a subcategory';
                    this.parentNode.appendChild(warning);
                }
            } else {
                if (warningDiv) {
                    warningDiv.remove();
                }
            }
        });
    }
    
    // Show/Hide homepage preview based on checkbox
    const showOnHomepageCheckbox = document.querySelector('input[name="show_on_homepage"]');
    const isFeaturedCheckbox = document.querySelector('input[name="is_featured"]');
    
    if (showOnHomepageCheckbox && isFeaturedCheckbox) {
        function updatePreviewMessage() {
            let messageDiv = document.getElementById('display-preview-message');
            
            if (!messageDiv) {
                messageDiv = document.createElement('div');
                messageDiv.id = 'display-preview-message';
                messageDiv.style.cssText = 'margin-top: 15px; padding: 12px; background: #f0f9ff; border-left: 4px solid #3b82f6; border-radius: 6px; font-size: 13px; color: #1e40af; grid-column: 1 / -1;';
                const displaySection = document.querySelector('.form-section:has([name="show_on_homepage"])');
                if (displaySection) {
                    displaySection.querySelector('.form-grid').appendChild(messageDiv);
                }
            }
            
            const messages = [];
            if (showOnHomepageCheckbox.checked) {
                messages.push('✓ Will appear on homepage');
            }
            if (isFeaturedCheckbox.checked) {
                messages.push('✓ Will be marked as featured');
            }
            
            if (messages.length > 0) {
                messageDiv.innerHTML = '<i class="fas fa-eye"></i> ' + messages.join(' | ');
                messageDiv.style.display = 'block';
            } else {
                messageDiv.style.display = 'none';
            }
        }
        
        showOnHomepageCheckbox.addEventListener('change', updatePreviewMessage);
        isFeaturedCheckbox.addEventListener('change', updatePreviewMessage);
        updatePreviewMessage();
    }
    
    // Auto-save draft functionality
    let autoSaveTimer;
    const formInputs = addCategoryForm.querySelectorAll('input:not([type="file"]), select, textarea');
    
    formInputs.forEach(input => {
        input.addEventListener('input', function() {
            clearTimeout(autoSaveTimer);
            autoSaveTimer = setTimeout(saveFormDraft, 2000);
        });
    });
    
    function saveFormDraft() {
        const formData = {};
        const inputs = addCategoryForm.querySelectorAll('input:not([type="file"]), select, textarea');
        
        inputs.forEach(input => {
            if (input.type === 'checkbox') {
                formData[input.name] = input.checked;
            } else {
                formData[input.name] = input.value;
            }
        });
        
        console.log('Draft saved:', new Date().toLocaleTimeString());
        // In production, save to localStorage or send to server
        // localStorage.setItem('category_draft', JSON.stringify(formData));
    }
    
    console.log('Add Category page initialized');
});