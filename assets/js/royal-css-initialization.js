const observer = new IntersectionObserver((entries) => {
  entries.forEach((entry) => {
    if (entry.isIntersecting) {
      entry.target.classList.add("rc-animate");
    }
  });
});

document.querySelectorAll('[class*="rc-"]').forEach((el) => {
  observer.observe(el);
});
