// settings.js - Settings Page JavaScript

document.addEventListener('DOMContentLoaded', function() {
    
    // Tab Navigation
    const navBtns = document.querySelectorAll('.setting-nav-btn');
    const tabs = document.querySelectorAll('.setting-tab');
    
    navBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const targetTab = this.dataset.tab;
            
            // Remove active class from all buttons and tabs
            navBtns.forEach(b => b.classList.remove('active'));
            tabs.forEach(t => t.classList.remove('active'));
            
            // Add active class to clicked button and corresponding tab
            this.classList.add('active');
            document.getElementById(targetTab).classList.add('active');
            
            // Save current tab to localStorage
            localStorage.setItem('activeSettingsTab', targetTab);
        });
    });
    
    // Restore last active tab
    const lastActiveTab = localStorage.getItem('activeSettingsTab');
    if (lastActiveTab) {
        const targetBtn = document.querySelector(`[data-tab="${lastActiveTab}"]`);
        if (targetBtn) {
            targetBtn.click();
        }
    }
    
    // File Upload Preview
    const fileInputs = document.querySelectorAll('input[type="file"]');
    fileInputs.forEach(input => {
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const preview = this.nextElementSibling;
                
                // Check file size
                if (file.size > 2 * 1024 * 1024) {
                    alert('File size should not exceed 2MB');
                    this.value = '';
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = function(event) {
                    preview.innerHTML = `<img src="${event.target.result}" style="max-width: 200px; border-radius: 8px;">`;
                };
                reader.readAsDataURL(file);
            }
        });
    });
    
    // Toggle Payment Methods
    const toggles = document.querySelectorAll('.toggle-switch input');
    toggles.forEach(toggle => {
        toggle.addEventListener('change', function() {
            const card = this.closest('.payment-method-card');
            const details = card.querySelector('.payment-details');
            
            if (this.checked) {
                details.style.display = 'grid';
                details.style.opacity = '0';
                setTimeout(() => {
                    details.style.transition = 'opacity 0.3s';
                    details.style.opacity = '1';
                }, 10);
            } else {
                details.style.opacity = '0';
                setTimeout(() => {
                    details.style.display = 'none';
                }, 300);
            }
        });
        
        // Initialize state
        const card = toggle.closest('.payment-method-card');
        const details = card.querySelector('.payment-details');
        if (!toggle.checked) {
            details.style.display = 'none';
        }
    });
    
    // Add Shipping Zone
    const addZoneBtn = document.querySelector('.btn-secondary.btn-sm');
    if (addZoneBtn) {
        addZoneBtn.addEventListener('click', function() {
            const zoneName = prompt('Enter zone name:');
            if (zoneName) {
                const zoneList = document.querySelector('.zone-list');
                const newZone = document.createElement('div');
                newZone.className = 'zone-item';
                newZone.innerHTML = `
                    <input type="text" value="${zoneName}" readonly>
                    <input type="number" value="0" placeholder="Rate">
                    <button class="btn-remove"><i class="fas fa-times"></i></button>
                `;
                zoneList.appendChild(newZone);
                
                // Add remove functionality
                newZone.querySelector('.btn-remove').addEventListener('click', function() {
                    if (confirm('Remove this zone?')) {
                        newZone.remove();
                    }
                });
            }
        });
    }
    
    // Remove Shipping Zone
    document.querySelectorAll('.btn-remove').forEach(btn => {
        btn.addEventListener('click', function() {
            if (confirm('Remove this zone?')) {
                this.closest('.zone-item').remove();
            }
        });
    });
    
    // Send Test Email
    const testEmailBtn = document.querySelector('.btn-secondary');
    if (testEmailBtn && testEmailBtn.textContent.includes('Test Email')) {
        testEmailBtn.addEventListener('click', function() {
            const email = prompt('Enter email address to send test email:');
            if (email) {
                this.disabled = true;
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
                
                // Simulate sending
                setTimeout(() => {
                    this.disabled = false;
                    this.innerHTML = '<i class="fas fa-paper-plane"></i> Send Test Email';
                    alert(`Test email sent to ${email}`);
                }, 2000);
            }
        });
    }
    
    // Save All Settings
    const saveAllBtn = document.getElementById('saveAllSettings');
    if (saveAllBtn) {
        saveAllBtn.addEventListener('click', function() {
            this.disabled = true;
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
            
            // Collect all form data
            const formData = {};
            
            // General Settings
            formData.site_name = document.getElementById('site_name')?.value;
            formData.site_tagline = document.getElementById('site_tagline')?.value;
            formData.timezone = document.getElementById('timezone')?.value;
            formData.currency = document.getElementById('currency')?.value;
            
            console.log('Saving settings:', formData);
            
            // Simulate save
            setTimeout(() => {
                this.disabled = false;
                this.innerHTML = '<i class="fas fa-save"></i> Save All Changes';
                
                // Show success message
                showNotification('Settings saved successfully!', 'success');
            }, 1500);
        });
    }
    
    // Character counter for meta fields
    const metaFields = ['meta_title', 'meta_description', 'meta_keywords'];
    metaFields.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (field) {
            const maxLength = fieldId === 'meta_title' ? 60 : (fieldId === 'meta_description' ? 160 : 200);
            
            // Create counter
            const counter = document.createElement('small');
            counter.style.cssText = 'display: block; margin-top: 4px; color: #6b7280;';
            field.parentNode.appendChild(counter);
            
            function updateCounter() {
                const length = field.value.length;
                counter.textContent = `${length} / ${maxLength} characters`;
                
                if (length > maxLength) {
                    counter.style.color = '#ef4444';
                } else if (length > maxLength * 0.9) {
                    counter.style.color = '#f59e0b';
                } else {
                    counter.style.color = '#10b981';
                }
            }
            
            field.addEventListener('input', updateCounter);
            updateCounter();
        }
    });
    
    // Auto-save functionality
    let saveTimeout;
    const allInputs = document.querySelectorAll('input, select, textarea');
    
    allInputs.forEach(input => {
        input.addEventListener('input', function() {
            clearTimeout(saveTimeout);
            saveTimeout = setTimeout(() => {
                console.log('Auto-saving draft...');
                // Save to localStorage or server
            }, 2000);
        });
    });
    
    // Maintenance mode warning
    const maintenanceCheckbox = document.querySelector('input[name="maintenance_mode"]');
    if (maintenanceCheckbox) {
        maintenanceCheckbox.addEventListener('change', function() {
            if (this.checked) {
                const confirm = window.confirm('Warning: Enabling maintenance mode will make the site inaccessible to customers. Continue?');
                if (!confirm) {
                    this.checked = false;
                }
            }
        });
    }
    
    console.log('Settings page initialized');
});

// Show notification function
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 16px 24px;
        background: ${type === 'success' ? '#10b981' : '#ef4444'};
        color: white;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        z-index: 10000;
        animation: slideIn 0.3s ease;
    `;
    notification.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
        ${message}
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Add animation styles
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(400px);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);