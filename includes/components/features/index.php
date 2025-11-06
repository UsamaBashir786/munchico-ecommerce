<!-- ==========================================
     STRUCTURE 1: HORIZONTAL CARD LAYOUT
     ========================================== -->
     <section class="section-title">
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
            <div class="feature-card">
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

            <div class="feature-card">
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

            <div class="feature-card">
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

            <div class="feature-card">
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
        <div class="feature-highlight">
            <div class="highlight-content">
                <h2>Free Home Delivery</h2>
                <p>Free Shipping For Orders Over $50</p>
            </div>
        </div>
    </div>
</section>



<style>
/* ==========================================
   STRUCTURE 1: HORIZONTAL CARD LAYOUT
   ========================================== */
.features-horizontal {
    background: linear-gradient(135deg, var(--gray-100) 0%, var(--gray-200) 100%);
    padding: var(--space-3xl) 0;
    border-top: 2px solid var(--gray-300);
}

.features-wrapper-h {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: var(--space-xl);
    margin-bottom: var(--space-2xl);
}

.feature-card {
    background: var(--white);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-md);
    transition: transform var(--transition-base), box-shadow var(--transition-base);
    overflow: hidden;
    border: 1px solid var(--gray-200);
}

.feature-card:hover {
    transform: translateY(-6px);
    box-shadow: var(--shadow-xl);
    border-color: var(--primary-light);
}

.feature-card-inner {
    display: flex;
    align-items: center;
    gap: var(--space-lg);
    padding: var(--space-xl);
}

.feature-icon-box {
    flex-shrink: 0;
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
    border-radius: var(--radius-md);
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: var(--shadow-md);
}

.feature-icon-box svg {
    stroke: var(--white);
}

.feature-details h3 {
    font-family: var(--font-primary);
    font-size: var(--font-size-lg);
    font-weight: 700;
    color: var(--black);
    margin: 0 0 var(--space-xs) 0;
}

.feature-details p {
    font-family: var(--font-secondary);
    font-size: var(--font-size-sm);
    color: var(--gray-600);
    margin: 0;
}

.feature-highlight {
    background: linear-gradient(135deg, var(--accent-color) 0%, var(--primary-color) 100%);
    border-radius: var(--radius-xl);
    padding: var(--space-2xl);
    text-align: center;
    box-shadow: var(--shadow-xl);
}

.highlight-content h2 {
    font-family: var(--font-primary);
    font-size: var(--font-size-3xl);
    font-weight: 800;
    color: var(--white);
    margin: 0 0 var(--space-sm) 0;
}

.highlight-content p {
    font-family: var(--font-secondary);
    font-size: var(--font-size-lg);
    color: var(--white);
    margin: 0;
    opacity: 0.95;
}

/* ==========================================
   STRUCTURE 2: VERTICAL ICON TOP LAYOUT
   ========================================== */
.features-vertical {
    background: var(--gray-50);
    padding: var(--space-3xl) 0;
    border-bottom: 1px solid var(--gray-200);
}

.features-grid-v {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: var(--space-2xl);
}

.feature-box {
    text-align: center;
    padding: var(--space-2xl) var(--space-lg);
    border: 2px solid var(--gray-200);
    border-radius: var(--radius-xl);
    transition: all var(--transition-base);
    background: var(--white);
}

.feature-box:hover {
    border-color: var(--secondary-color);
    background: var(--gray-50);
    transform: scale(1.05);
    box-shadow: var(--shadow-lg);
}

.icon-circle {
    width: 72px;
    height: 72px;
    background: linear-gradient(135deg, var(--secondary-color) 0%, var(--primary-color) 100%);
    border-radius: var(--radius-full);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto var(--space-lg);
    box-shadow: var(--shadow-md);
}

.icon-circle svg {
    stroke: var(--white);
}

.feature-box h4 {
    font-family: var(--font-primary);
    font-size: var(--font-size-xl);
    font-weight: 700;
    color: var(--black);
    margin: 0 0 var(--space-sm) 0;
}

.feature-box span {
    font-family: var(--font-secondary);
    font-size: var(--font-size-sm);
    color: var(--gray-600);
    display: block;
}

.feature-special {
    background: linear-gradient(135deg, var(--accent-color) 0%, var(--primary-color) 100%);
    border-color: var(--accent-color);
    grid-column: span 1;
}

.feature-special h4 {
    color: var(--white);
}

.feature-special span {
    color: var(--white);
    opacity: 0.95;
}

/* ==========================================
   STRUCTURE 3: MINIMAL SPLIT LAYOUT
   ========================================== */
.features-minimal {
    background: var(--gray-100);
    padding: var(--space-2xl) 0;
    border-top: 1px solid var(--gray-300);
    border-bottom: 1px solid var(--gray-300);
}

.features-split {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: var(--space-3xl);
}

.features-left,
.features-center {
    display: flex;
    flex-direction: column;
    gap: var(--space-lg);
    flex: 1;
}

.mini-feature {
    display: flex;
    align-items: center;
    gap: var(--space-md);
    padding: var(--space-md);
    background: var(--white);
    border-radius: var(--radius-md);
    box-shadow: var(--shadow-sm);
    transition: all var(--transition-base);
    border: 1px solid var(--gray-200);
}

.mini-feature:hover {
    box-shadow: var(--shadow-md);
    transform: translateX(6px);
    border-color: var(--primary-light);
}

.mini-feature svg {
    flex-shrink: 0;
    stroke: var(--primary-color);
}

.mini-feature strong {
    display: block;
    font-family: var(--font-primary);
    font-size: var(--font-size-base);
    font-weight: 700;
    color: var(--black);
    margin-bottom: var(--space-xs);
}

.mini-feature small {
    font-family: var(--font-secondary);
    font-size: var(--font-size-xs);
    color: var(--gray-600);
}

.features-right {
    flex-shrink: 0;
}

.promo-badge {
    background: linear-gradient(135deg, var(--accent-color) 0%, var(--primary-color) 100%);
    padding: var(--space-2xl) var(--space-xl);
    border-radius: var(--radius-lg);
    text-align: center;
    box-shadow: var(--shadow-xl);
    min-width: 240px;
}

.promo-badge h5 {
    font-family: var(--font-primary);
    font-size: var(--font-size-2xl);
    font-weight: 800;
    color: var(--white);
    margin: 0 0 var(--space-xs) 0;
}

.promo-badge p {
    font-family: var(--font-secondary);
    font-size: var(--font-size-base);
    color: var(--white);
    margin: 0;
    opacity: 0.95;
}

/* ==========================================
   RESPONSIVE DESIGN
   ========================================== */
@media (max-width: 992px) {
    .features-wrapper-h {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .features-grid-v {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .features-split {
        flex-direction: column;
        gap: var(--space-xl);
    }
    
    .features-left,
    .features-center {
        width: 100%;
    }
    
    .promo-badge {
        width: 100%;
    }
}

@media (max-width: 768px) {
    .features-horizontal,
    .features-vertical {
        padding: var(--space-2xl) 0;
    }
    
    .features-wrapper-h {
        grid-template-columns: 1fr;
        gap: var(--space-md);
    }
    
    .feature-card-inner {
        padding: var(--space-lg);
    }
    
    .feature-icon-box {
        width: 50px;
        height: 50px;
    }
    
    .feature-highlight {
        padding: var(--space-xl);
    }
    
    .highlight-content h2 {
        font-size: var(--font-size-xl);
    }
    
    .features-grid-v {
        grid-template-columns: 1fr;
        gap: var(--space-lg);
    }
    
    .feature-box {
        padding: var(--space-xl) var(--space-md);
    }
    
    .icon-circle {
        width: 60px;
        height: 60px;
    }
    
    .mini-feature:hover {
        transform: translateX(4px);
    }
}

@media (max-width: 480px) {
    .feature-details h3 {
        font-size: var(--font-size-base);
    }
    
    .feature-details p {
        font-size: var(--font-size-xs);
    }
    
    .feature-box h4 {
        font-size: var(--font-size-lg);
    }
    
    .mini-feature {
        padding: var(--space-sm);
        gap: var(--space-sm);
    }
    
    .mini-feature svg {
        width: 28px;
        height: 28px;
    }
    
    .promo-badge {
        padding: var(--space-xl) var(--space-lg);
        min-width: auto;
    }
    
    .promo-badge h5 {
        font-size: var(--font-size-xl);
    }
}
</style>