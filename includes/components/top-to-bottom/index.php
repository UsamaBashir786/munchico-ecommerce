<div class="scrollToTop" id="scrollToTop">
    <svg
        xmlns="http://www.w3.org/2000/svg"
        width="24"
        height="24"
        stroke="currentColor"
        fill="none"
        stroke-width="2"
        stroke-linecap="round"
        stroke-linejoin="round"
        viewBox="0 0 24 24"
    >
        <line x1="12" y1="19" x2="12" y2="5"></line>
        <polyline points="5 12 12 5 19 12"></polyline>
    </svg>
</div>

<style>
    .scrollToTop {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 50px;
        height: 50px;
        background: #8b4513;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(139, 69, 19, 0.3);
        z-index: 1000;
    }

    .scrollToTop.active {
        opacity: 1;
        visibility: visible;
    }

    .scrollToTop:hover {
        background: #6d3410;
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(139, 69, 19, 0.4);
    }
</style>
<script>
    // Scroll to Top Button
    const scrollToTopBtn = document.getElementById("scrollToTop");

    window.addEventListener("scroll", function () {
        if (window.pageYOffset > 300) {
            scrollToTopBtn.classList.add("active");
        } else {
            scrollToTopBtn.classList.remove("active");
        }
    });

    scrollToTopBtn.addEventListener("click", function () {
        window.scrollTo({
            top: 0,
            behavior: "smooth",
        });
    });
</script>
