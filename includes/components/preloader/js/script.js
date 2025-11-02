/* Auto-remove overlay simulation */
document.addEventListener("DOMContentLoaded", () => {
  setTimeout(() => {
    const overlay = document.querySelector(".skeleton-overlay");
    overlay?.classList.add("fade-out");
    setTimeout(() => overlay?.remove(), 600);
  }, 2500);
});