// Filter Items Click Handler
document.addEventListener("DOMContentLoaded", function () {
  const filterItems = document.querySelectorAll(".filter-item");

  filterItems.forEach((item, index) => {
    item.addEventListener("click", function () {
      // Remove active class from all items
      filterItems.forEach((i) => i.classList.remove("active"));

      // Add active class to clicked item
      this.classList.add("active");

      // Get category name for filtering
      const categoryName = this.querySelector("span").textContent;
      console.log("Selected category:", categoryName);

      // Here you can add your filter logic
      // filterProducts(categoryName);
    });

    // Keyboard Navigation
    item.setAttribute("tabindex", "0");

    item.addEventListener("keydown", function (e) {
      if (e.key === "Enter" || e.key === " ") {
        e.preventDefault();
        this.click();
      }

      // Arrow key navigation
      if (e.key === "ArrowDown") {
        e.preventDefault();
        const nextItem = filterItems[index + 1];
        if (nextItem) nextItem.focus();
      }

      if (e.key === "ArrowUp") {
        e.preventDefault();
        const prevItem = filterItems[index - 1];
        if (prevItem) prevItem.focus();
      }
    });
  });
});
