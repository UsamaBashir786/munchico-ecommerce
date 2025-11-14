// orders.js - Order Management JavaScript

document.addEventListener('DOMContentLoaded', function() {
    
    // Select All Checkbox
    const selectAll = document.getElementById('selectAll');
    const orderCheckboxes = document.querySelectorAll('.order-checkbox');
    
    if (selectAll) {
        selectAll.addEventListener('change', function() {
            orderCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    }
    
    // Search Orders
    const searchInput = document.getElementById('searchOrders');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('.data-table tbody tr');
            
            rows.forEach(row => {
                const orderId = row.querySelector('td:nth-child(2)')?.textContent.toLowerCase();
                const customerName = row.querySelector('.customer-name')?.textContent.toLowerCase();
                
                if (orderId?.includes(searchTerm) || customerName?.includes(searchTerm)) {
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
                const orderStatus = row.querySelector('.badge-status')?.textContent.toLowerCase();
                
                if (!status || orderStatus?.includes(status)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
    
    // Filter by Payment
    const paymentFilter = document.getElementById('filterPayment');
    if (paymentFilter) {
        paymentFilter.addEventListener('change', function() {
            const payment = this.value.toLowerCase();
            const rows = document.querySelectorAll('.data-table tbody tr');
            
            rows.forEach(row => {
                const paymentStatus = row.querySelector('.badge-payment')?.textContent.toLowerCase();
                
                if (!payment || paymentStatus?.includes(payment)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
    
    // Filter by Date
    const dateFilter = document.getElementById('filterDate');
    if (dateFilter) {
        dateFilter.addEventListener('change', function() {
            const selectedDate = this.value;
            const rows = document.querySelectorAll('.data-table tbody tr');
            
            rows.forEach(row => {
                const orderDate = row.querySelector('td:nth-last-child(2)')?.textContent;
                
                if (!selectedDate || orderDate?.includes(selectedDate)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
    
    console.log('Orders page initialized');
});

// View Order Function
function viewOrder(orderId) {
    console.log('Viewing order:', orderId);
    window.location.href = `view-order.php?id=${orderId}`;
}

// Update Order Status Function
function updateOrderStatus(orderId) {
    const statuses = [
        'Pending',
        'Processing',
        'Shipped',
        'Delivered',
        'Cancelled'
    ];
    
    let statusHtml = '<select id="statusSelect" style="padding: 8px; border-radius: 6px; border: 1px solid #e5e7eb;">';
    statuses.forEach(status => {
        statusHtml += `<option value="${status.toLowerCase()}">${status}</option>`;
    });
    statusHtml += '</select>';
    
    const result = confirm(`Update status for order ${orderId}?\n\n(In production, this would show a proper modal)`);
    
    if (result) {
        console.log('Updating order status:', orderId);
        alert('Order status updated successfully!');
        location.reload();
    }
}

// Print Invoice Function
document.querySelectorAll('.btn-print').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        const row = this.closest('tr');
        const orderId = row.querySelector('td:nth-child(2)').textContent;
        console.log('Printing invoice for:', orderId);
        window.open(`print-invoice.php?order=${orderId}`, '_blank');
    });
});