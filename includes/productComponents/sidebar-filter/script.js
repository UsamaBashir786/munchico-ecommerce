// Sidebar Filter Component JavaScript
class SidebarFilter {
  constructor() {
    this.init();
  }

  init() {
    this.mobileFilterToggle = document.querySelector(".mobile-filter-toggle");
    this.sidebarOverlay = document.querySelector(".sidebar-overlay");
    this.sidebarFilter = document.querySelector(".sidebar-filter");
    this.closeSidebar = document.querySelector(".close-sidebar");

    this.bindEvents();
  }

  bindEvents() {
    // Mobile sidebar toggle
    if (this.mobileFilterToggle) {
      this.mobileFilterToggle.addEventListener("click", () =>
        this.openSidebar()
      );
    }

    // Close sidebar events
    if (this.closeSidebar) {
      this.closeSidebar.addEventListener("click", () =>
        this.closeSidebarFunc()
      );
    }

    if (this.sidebarOverlay) {
      this.sidebarOverlay.addEventListener("click", () =>
        this.closeSidebarFunc()
      );
    }

    // Filter button event
    const filterBtn = document.querySelector(".filter-btn");
    if (filterBtn) {
      filterBtn.addEventListener("click", () => this.applyFilters());
    }

    // Filter option events
    const filterOptions = document.querySelectorAll(
      '.filter-option input[type="checkbox"]'
    );
    filterOptions.forEach((option) => {
      option.addEventListener("change", () => this.handleFilterChange());
    });
  }

  openSidebar() {
    this.sidebarFilter.classList.add("active");
    this.sidebarOverlay.classList.add("active");
    document.body.style.overflow = "hidden";
  }

  closeSidebarFunc() {
    this.sidebarFilter.classList.remove("active");
    this.sidebarOverlay.classList.remove("active");
    document.body.style.overflow = "";
  }

  applyFilters() {
    const selectedFilters = this.getSelectedFilters();

    // Dispatch custom event for other components to listen to
    const filterEvent = new CustomEvent("filtersApplied", {
      detail: { filters: selectedFilters },
    });
    document.dispatchEvent(filterEvent);

    // Close sidebar on mobile after applying filters
    if (window.innerWidth <= 768) {
      this.closeSidebarFunc();
    }
  }

  getSelectedFilters() {
    const filters = {
      categories: [],
      priceRange: {
        min: document.querySelector('.price-input[placeholder="Min"]').value,
        max: document.querySelector('.price-input[placeholder="Max"]').value,
      },
      quality: [],
      rating: [],
    };

    // Get selected categories
    const categoryCheckboxes = document.querySelectorAll(
      'input[id^="cat-"]:checked'
    );
    categoryCheckboxes.forEach((checkbox) => {
      filters.categories.push(checkbox.id.replace("cat-", ""));
    });

    // Get quality filters
    if (document.getElementById("organic").checked) {
      filters.quality.push("organic");
    }
    if (document.getElementById("premium").checked) {
      filters.quality.push("premium");
    }

    // Get rating filters
    const ratingCheckboxes = document.querySelectorAll(
      'input[id^="rating-"]:checked'
    );
    ratingCheckboxes.forEach((checkbox) => {
      filters.rating.push(checkbox.id.replace("rating-", ""));
    });

    return filters;
  }

  handleFilterChange() {
    // Update filter counts or perform any immediate actions
    console.log("Filter changed");
  }
}

// Initialize when DOM is loaded
document.addEventListener("DOMContentLoaded", () => {
  new SidebarFilter();
});
