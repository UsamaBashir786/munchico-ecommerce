<!-- ==========================================
     STRUCTURE 1: HORIZONTAL CARD LAYOUT
     ========================================== -->
<section class="section-title rc-zoom-in-up">
  <h2 class="title">🌿 Feature</h2>
  <p class="subtitle">Crafted with care, inspired by nature.</p>
</section>
<style>
    .section-title {
    /* text-align: center; */
    max-width: 700px;
    /* margin: var(--space-3xl) auto var(--space-2xl); */
    padding: 0 var(--container-padding);
    }

    .section-title .title {
    font-family: var(--font-primary);
    font-size: var(--font-size-3xl);
    color: var(--primary-dark);
    letter-spacing: 0.5px;
    margin-bottom: var(--space-sm);
    position: relative;
    display: inline-block;
    }

    .section-title .title::after {
    content: "";
    display: block;
    width: 60px;
    height: 3px;
    background-color: var(--accent-color);
    border-radius: var(--radius-full);
    margin: var(--space-sm) auto 0;
    box-shadow: var(--shadow-sm);
    }

    .section-title .subtitle {
    font-family: var(--font-secondary);
    font-size: var(--font-size-base);
    color: var(--gray-600);
    margin-top: var(--space-xs);
    }
</style>
<section class="features-horizontal">
    <div class="container">
        <div class="features-wrapper-h">
            <div class="feature-card rc-zoom-in-up">
                <div class="feature-card-inner">
                    <div class="feature-icon-box">
                        <svg
                            width="48"
                            height="48"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.5"
                        >
                            <rect x="1" y="3" width="15" height="13"></rect>
                            <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                            <circle cx="5.5" cy="18.5" r="2.5"></circle>
                            <circle cx="18.5" cy="18.5" r="2.5"></circle>
                        </svg>
                    </div>
                    <div class="feature-details">
                        <h3>Fast Shipping</h3>
                        <p>Shipped In 1-3 Days</p>
                    </div>
                </div>
            </div>

            <div class="feature-card rc-zoom-in-up">
                <div class="feature-card-inner">
                    <div class="feature-icon-box">
                        <svg
                            width="48"
                            height="48"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.5"
                        >
                            <line x1="12" y1="1" x2="12" y2="23"></line>
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                        </svg>
                    </div>
                    <div class="feature-details">
                        <h3>Free Returns</h3>
                        <p>Free 7 Days Return</p>
                    </div>
                </div>
            </div>

            <div class="feature-card rc-zoom-in-up">
                <div class="feature-card-inner">
                    <div class="feature-icon-box">
                        <svg
                            width="48"
                            height="48"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.5"
                        >
                            <path d="M3 18v-6a9 9 0 0 1 18 0v6"></path>
                            <path
                                d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"
                            ></path>
                        </svg>
                    </div>
                    <div class="feature-details">
                        <h3>Help Support</h3>
                        <p>Phone And Email</p>
                    </div>
                </div>
            </div>

            <div class="feature-card rc-zoom-in-up">
                <div class="feature-card-inner">
                    <div class="feature-icon-box">
                        <svg
                            width="48"
                            height="48"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.5"
                        >
                            <path
                                d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"
                            ></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                    </div>
                    <div class="feature-details">
                        <h3>Join Newsletter</h3>
                        <p>Get The Latest Offers</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="feature-highlight rc-zoom-in-up">
            <div class="highlight-content rc-zoom-in-up">
                <h2>Free Home Delivery</h2>
                <p>Free Shipping For Orders Over $50</p>
            </div>
        </div>
    </div>
</section>


<link rel="stylesheet" href="includes/components/features/css/styles.css">
<script src="includes/components/features/js/script.js"></script>