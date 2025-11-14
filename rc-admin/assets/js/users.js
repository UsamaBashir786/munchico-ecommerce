// users.js - User Management JavaScript

document.addEventListener('DOMContentLoaded', function() {
    
    // Select All Checkbox
    const selectAll = document.getElementById('selectAll');
    const userCheckboxes = document.querySelectorAll('.user-checkbox');
    
    if (selectAll) {
        selectAll.addEventListener('change', function() {
            userCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateBulkActions();
        });
    }
    
    userCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateSelectAll();
            updateBulkActions();
        });
    });
    
    function updateSelectAll() {
        const checkedCount = document.querySelectorAll('.user-checkbox:checked').length;
        selectAll.checked = checkedCount === userCheckboxes.length && checkedCount > 0;
        selectAll.indeterminate = checkedCount > 0 && checkedCount < userCheckboxes.length;
    }
    
    function updateBulkActions() {
        const checkedCount = document.querySelectorAll('.user-checkbox:checked').length;
        console.log(`${checkedCount} user(s) selected`);
        // Add bulk action buttons here if needed
    }
    
    // Search Users
    const searchInput = document.getElementById('searchUsers');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('.data-table tbody tr');
            
            rows.forEach(row => {
                const name = row.querySelector('.user-name')?.textContent.toLowerCase();
                const email = row.querySelector('td:nth-child(3)')?.textContent.toLowerCase();
                
                if (name?.includes(searchTerm) || email?.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
    
    // Filter by Role
    const roleFilter = document.getElementById('filterRole');
    if (roleFilter) {
        roleFilter.addEventListener('change', function() {
            const role = this.value.toLowerCase();
            const rows = document.querySelectorAll('.data-table tbody tr');
            
            rows.forEach(row => {
                const userRole = row.querySelector('.badge-role')?.textContent.toLowerCase();
                
                if (!role || userRole?.includes(role)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
    
    // Filter by Status
    const statusFilter = document.getElementById('filterStatus');
    if (statusFilter) {
        statusFilter.addEventListener('change', function() {
            const status = this.value.toLowerCase();
            const rows = document.querySelectorAll('.data-table tbody tr');
            
            rows.forEach(row => {
                const userStatus = row.querySelector('.badge-active, .badge-inactive')?.textContent.toLowerCase();
                
                if (!status || userStatus?.includes(status)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
    
    // Export Users
    const exportBtn = document.getElementById('exportUsers');
    if (exportBtn) {
        exportBtn.addEventListener('click', function() {
            console.log('Exporting users...');
            alert('Export functionality will be implemented here');
        });
    }
    
    // View User Details
    document.querySelectorAll('.btn-view').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const row = this.closest('tr');
            const userId = row.querySelector('.user-checkbox').value;
            const userName = row.querySelector('.user-name').textContent;
            console.log(`Viewing user: ${userName} (ID: ${userId})`);
            alert(`View details for: ${userName}`);
        });
    });
    
    // Edit User
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const row = this.closest('tr');
            const userId = row.querySelector('.user-checkbox').value;
            const userName = row.querySelector('.user-name').textContent;
            console.log(`Editing user: ${userName} (ID: ${userId})`);
            window.location.href = `edit-user.php?id=${userId}`;
        });
    });
    
    // Delete User
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const row = this.closest('tr');
            const userId = row.querySelector('.user-checkbox').value;
            const userName = row.querySelector('.user-name').textContent;
            
            if (confirm(`Are you sure you want to delete ${userName}?`)) {
                console.log(`Deleting user: ${userName} (ID: ${userId})`);
                // Implement delete functionality
                row.style.transition = 'opacity 0.3s';
                row.style.opacity = '0';
                setTimeout(() => {
                    row.remove();
                    alert(`User ${userName} has been deleted`);
                }, 300);
            }
        });
    });
    
    console.log('Users page initialized');
});