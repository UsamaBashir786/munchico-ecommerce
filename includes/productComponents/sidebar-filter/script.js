// Sidebar Filter Component
class SidebarFilter {
  constructor() {
    this.init();
  }

  init() {
    this.bindEvents();
  }

  bindEvents() {
    // Mobile toggle
    const toggleBtn = document.querySelector('.mobile-filter-toggle');
    if (toggleBtn) {
      toggleBtn.addEventListener('click', () => this.openSidebar());
    }

    // Close button
    const closeBtn = document.querySelector('.close-sidebar');
    if (closeBtn) {
      closeBtn.addEventListener('click', () => this.closeSidebar());
    }

    // Overlay click
    const overlay = document.querySelector('.sidebar-overlay');
    if (overlay) {
      overlay.addEventListener('click', () => this.closeSidebar());
    }

    // "All Products" checkbox handler
    const allCheckbox = document.getElementById('cat-all');
    if (allCheckbox) {
      allCheckbox.addEventListener('change', (e) => {
        if (e.target.checked) {
          document.querySelectorAll('#categories-filter input[type="checkbox"]:not(#cat-all)').forEach(cb => {
            cb.checked = false;
          });
        }
      });
    }

    // Category checkboxes
    document.addEventListener('change', (e) => {
      if (e.target.matches('#categories-filter input[type="checkbox"]:not(#cat-all)')) {
        if (e.target.checked) {
          const allCheckbox = document.getElementById('cat-all');
          if (allCheckbox) allCheckbox.checked = false;
        }
      }
    });
  }

  openSidebar() {
    const sidebar = document.querySelector('.sidebar-filter');
    const overlay = document.querySelector('.sidebar-overlay');
    
    if (sidebar) sidebar.classList.add('active');
    if (overlay) overlay.classList.add('active');
    
    document.body.style.overflow = 'hidden';
  }

  closeSidebar() {
    const sidebar = document.querySelector('.sidebar-filter');
    const overlay = document.querySelector('.sidebar-overlay');
    
    if (sidebar) sidebar.classList.remove('active');
    if (overlay) overlay.classList.remove('active');
    
    document.body.style.overflow = '';
  }
}

// Initialize
document.addEventListener('DOMContentLoaded', () => {
  new SidebarFilter();
});