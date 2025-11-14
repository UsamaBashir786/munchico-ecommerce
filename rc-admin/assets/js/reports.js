// reports.js - Reports & Analytics JavaScript

document.addEventListener('DOMContentLoaded', function() {
    
    // Sales Chart
    const salesCtx = document.getElementById('salesChart');
    if (salesCtx) {
        const salesChart = new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Sales',
                    data: [1200, 1900, 1500, 2100, 1800, 2400, 2200],
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + value;
                            }
                        }
                    }
                }
            }
        });
        
        // Chart Period Buttons
        const chartBtns = document.querySelectorAll('.chart-btn');
        chartBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                chartBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                
                const period = this.dataset.period;
                console.log('Changing chart period to:', period);
                
                // Update chart data based on period
                if (period === 'week') {
                    salesChart.data.labels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
                    salesChart.data.datasets[0].data = [1200, 1900, 1500, 2100, 1800, 2400, 2200];
                } else if (period === 'month') {
                    salesChart.data.labels = ['Week 1', 'Week 2', 'Week 3', 'Week 4'];
                    salesChart.data.datasets[0].data = [8500, 9200, 8800, 10200];
                } else if (period === 'year') {
                    salesChart.data.labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                    salesChart.data.datasets[0].data = [32000, 35000, 38000, 36000, 40000, 42000, 45000, 43000, 46000, 48000, 47000, 50000];
                }
                
                salesChart.update();
            });
        });
    }
    
    // Orders Chart (Doughnut)
    const ordersCtx = document.getElementById('ordersChart');
    if (ordersCtx) {
        new Chart(ordersCtx, {
            type: 'doughnut',
            data: {
                labels: ['Delivered', 'Shipped', 'Processing', 'Pending', 'Cancelled'],
                datasets: [{
                    data: [215, 15, 12, 18, 5],
                    backgroundColor: [
                        '#10b981',
                        '#3b82f6',
                        '#f59e0b',
                        '#8b5cf6',
                        '#ef4444'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            usePointStyle: true,
                            font: {
                                size: 12
                            }
                        }
                    }
                }
            }
        });
    }
    
    // Date Range Filter
    const dateRange = document.getElementById('dateRange');
    if (dateRange) {
        dateRange.addEventListener('change', function() {
            const range = this.value;
            console.log('Date range changed to:', range);
            
            if (range === 'custom') {
                // Show custom date picker modal
                alert('Custom date range picker would appear here');
            } else {
                // Update all charts and stats
                console.log(`Loading data for last ${range} days`);
            }
        });
    }
    
    // Export Report
    const exportBtn = document.querySelector('.btn-primary');
    if (exportBtn) {
        exportBtn.addEventListener('click', function() {
            console.log('Exporting report...');
            alert('Report export functionality will be implemented here\nFormats: PDF, Excel, CSV');
        });
    }
    
    // Animate progress bars on scroll
    const observerOptions = {
        threshold: 0.5
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const progressBar = entry.target.querySelector('.progress-fill');
                if (progressBar) {
                    const width = progressBar.style.width;
                    progressBar.style.width = '0%';
                    setTimeout(() => {
                        progressBar.style.width = width;
                    }, 100);
                }
            }
        });
    }, observerOptions);
    
    document.querySelectorAll('.category-bar-item').forEach(item => {
        observer.observe(item);
    });
    
    // Real-time activity updates (simulated)
    setInterval(() => {
        const activityTime = document.querySelectorAll('.activity-time');
        activityTime.forEach((time, index) => {
            // Update time every minute (in production, fetch from server)
            console.log('Activity time update');
        });
    }, 60000); // Update every minute
    
    console.log('Reports page initialized');
});