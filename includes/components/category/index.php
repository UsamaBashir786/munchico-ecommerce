
    
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background-color: #f9fafb;
        }

        /* Banner Header Styles */
        .munchico-category-banner-header {
            position: relative;
            padding: 64px 48px;
            margin-bottom: 64px;
            overflow: hidden;
            border-radius: 24px;
            background: linear-gradient(135deg, #5b4d3f 0%, #3d3229 100%);
            box-shadow: 0 10px 40px rgba(91, 77, 63, 0.15);
        }

        .munchico-banner-background {
            position: absolute;
            inset: 0;
            overflow: hidden;
            pointer-events: none;
        }

        .munchico-banner-pattern {
            position: absolute;
            inset: 0;
            background-image: radial-gradient(circle at 20% 30%, rgba(229, 164, 67, 0.1) 0%, transparent 50%),
                              radial-gradient(circle at 80% 70%, rgba(78, 148, 79, 0.1) 0%, transparent 50%);
            animation: munchico-patternFloat 20s ease-in-out infinite;
        }

        .munchico-banner-content {
            position: relative;
            text-align: center;
            max-width: 800px;
            margin: 0 auto;
            z-index: 2;
        }

        .munchico-banner-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: rgba(229, 164, 67, 0.15);
            border: 1px solid rgba(229, 164, 67, 0.3);
            border-radius: 9999px;
            color: #e5a443;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 24px;
            backdrop-filter: blur(10px);
        }

        .munchico-banner-title {
            font-size: clamp(2rem, 5vw, 3.5rem);
            font-weight: 800;
            color: #fff;
            margin-bottom: 16px;
            line-height: 1.2;
        }

        .munchico-highlight-text {
            background: linear-gradient(135deg, #e5a443, #f4c563);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .munchico-banner-subtitle {
            font-size: 18px;
            color: rgba(255, 255, 255, 0.85);
            margin-bottom: 48px;
        }

        .munchico-banner-stats {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 48px;
            flex-wrap: wrap;
            margin-top: 48px;
        }

        .munchico-stat-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }

        .munchico-stat-number {
            font-size: clamp(1.5rem, 3vw, 2rem);
            font-weight: 700;
            color: #e5a443;
        }

        .munchico-stat-label {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.7);
            font-weight: 500;
            text-transform: uppercase;
        }

        .munchico-stat-divider {
            width: 1px;
            height: 40px;
            background: linear-gradient(to bottom, transparent, rgba(255, 255, 255, 0.3), transparent);
        }

        @keyframes munchico-patternFloat {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            50% { transform: translate(20px, 20px) rotate(5deg); }
        }

        /* Shop By Category Section */
        .munchico-shop-by-category {
            padding: 64px 0;
        }

        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Swiper Container */
        .munchico-category-swiper-container {
            position: relative;
            margin: 48px 0;
        }

        .munchico-swiper {
            width: 100%;
            padding: 20px 0 60px;
        }

        /* Category Cards */
        .munchico-category-card {
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: all 0.3s ease;
            cursor: pointer;
            height: auto;
        }

        .munchico-category-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        }

        .munchico-category-image {
            position: relative;
            height: 220px;
            overflow: hidden;
        }

        .munchico-category-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .munchico-category-card:hover .munchico-category-img {
            transform: scale(1.05);
        }

        /* Category Badges */
        .munchico-category-badge {
            position: absolute;
            padding: 6px 12px;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            z-index: 2;
        }

        .munchico-discount-badge {
            top: 12px;
            right: 12px;
            background: #e5a443;
            color: #fff;
        }

        .munchico-hot-badge {
            top: 12px;
            left: 12px;
            background: #dc2626;
            color: #fff;
        }

        .munchico-new-badge {
            top: 12px;
            left: 12px;
            background: #4e944f;
            color: #fff;
        }

        /* Category Content */
        .munchico-category-content {
            padding: 24px;
            text-align: center;
        }

        .munchico-category-name {
            font-size: 18px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        .munchico-category-count {
            font-size: 14px;
            color: #6b7280;
            font-weight: 500;
            margin-bottom: 12px;
        }

        .munchico-quantity-badge {
            display: inline-block;
            padding: 6px 12px;
            background: #f3f4f6;
            color: #374151;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }

        /* Custom Swiper Navigation */
        .munchico-swiper-button-prev,
        .munchico-swiper-button-next {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: #fff;
            border: 2px solid #e5e7eb;
            color: #5b4d3f;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .munchico-swiper-button-prev:hover,
        .munchico-swiper-button-next:hover {
            background: #5b4d3f;
            color: #fff;
            border-color: #5b4d3f;
            transform: scale(1.1);
        }

        .munchico-swiper-button-prev::after,
        .munchico-swiper-button-next::after {
            font-size: 20px;
            font-weight: bold;
        }

        /* Custom Pagination */
        .munchico-swiper-pagination {
            bottom: 20px !important;
        }

        .munchico-swiper-pagination .swiper-pagination-bullet {
            width: 12px;
            height: 12px;
            background: #d1d5db;
            opacity: 1;
            transition: all 0.3s ease;
        }

        .munchico-swiper-pagination .swiper-pagination-bullet-active {
            background: #5b4d3f;
            width: 32px;
            border-radius: 6px;
        }

        /* View All Button */
        .munchico-view-all-btn-container {
            margin-top: 48px;
            display: flex;
            justify-content: center;
        }

        .munchico-view-all-btn {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 14px 32px;
            background: #5b4d3f;
            color: #fff;
            border: 2px solid #5b4d3f;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .munchico-view-all-btn:hover {
            background: #fff;
            color: #5b4d3f;
        }

        .munchico-view-all-btn svg {
            transition: transform 0.3s ease;
        }

        .munchico-view-all-btn:hover svg {
            transform: translateX(4px);
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .munchico-category-banner-header {
                padding: 48px 24px;
                margin-bottom: 48px;
            }

            .munchico-banner-stats {
                gap: 24px;
            }

            .munchico-category-image {
                height: 180px;
            }

            .munchico-swiper-button-prev,
            .munchico-swiper-button-next {
                width: 40px;
                height: 40px;
            }
        }

        @media (max-width: 480px) {
            .munchico-category-image {
                height: 150px;
            }

            .munchico-category-content {
                padding: 16px;
            }

            .munchico-swiper-button-prev,
            .munchico-swiper-button-next {
                display: none;
            }
        }
    </style>
</head>
<body>
    
    <section class="munchico-shop-by-category">
        <div class="container">
<section class="section-title">
  <h2 class="title">🌾 Categories</h2>
</section>

<style>
.section-title {
  padding: 0 var(--container-padding);
  margin: var(--space-2xl) 0 var(--space-xl);
}

.section-title .title {
  font-family: var(--font-primary);
  font-size: var(--font-size-3xl);
  color: var(--primary-dark);
  letter-spacing: 0.5px;
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
  margin-top: var(--space-sm);
  box-shadow: var(--shadow-sm);
}
</style>

            

            <!-- Swiper Slider -->
            <div class="munchico-category-swiper-container">
                <div class="swiper munchico-swiper">
                    <div class="swiper-wrapper">
                        <!-- Slide 1 -->
                        <div class="swiper-slide">
                            <div class="munchico-category-card">
                                <div class="munchico-category-image">
                                    <img src="https://images.unsplash.com/photo-1508736793122-f516e3ba5569?w=400&h=300&fit=crop" alt="Almonds" class="munchico-category-img">
                                    <div class="munchico-category-badge munchico-discount-badge">50% OFF</div>
                                    <div class="munchico-category-badge munchico-hot-badge">HOT</div>
                                </div>
                                <div class="munchico-category-content">
                                    <h3 class="munchico-category-name">ALMONDS</h3>
                                    <p class="munchico-category-count">20 PRODUCTS</p>
                                    <div class="munchico-quantity-badge">Limited Stock</div>
                                </div>
                            </div>
                        </div>

                        <!-- Slide 2 -->
                        <div class="swiper-slide">
                            <div class="munchico-category-card">
                                <div class="munchico-category-image">
                                    <img src="https://images.unsplash.com/photo-1599599810769-bcde5a160d32?w=400&h=300&fit=crop" alt="Cashews" class="munchico-category-img">
                                    <div class="munchico-category-badge munchico-hot-badge">HOT</div>
                                </div>
                                <div class="munchico-category-content">
                                    <h3 class="munchico-category-name">CASHEWS</h3>
                                    <p class="munchico-category-count">12 PRODUCTS</p>
                                    <div class="munchico-quantity-badge">In Stock</div>
                                </div>
                            </div>
                        </div>

                        <!-- Slide 3 -->
                        <div class="swiper-slide">
                            <div class="munchico-category-card">
                                <div class="munchico-category-image">
                                    <img src="https://images.unsplash.com/photo-1610832958506-aa56368176cf?w=400&h=300&fit=crop" alt="Walnuts" class="munchico-category-img">
                                    <div class="munchico-category-badge munchico-new-badge">NEW</div>
                                </div>
                                <div class="munchico-category-content">
                                    <h3 class="munchico-category-name">WALNUTS</h3>
                                    <p class="munchico-category-count">15 PRODUCTS</p>
                                    <div class="munchico-quantity-badge">In Stock</div>
                                </div>
                            </div>
                        </div>

                        <!-- Slide 4 -->
                        <div class="swiper-slide">
                            <div class="munchico-category-card">
                                <div class="munchico-category-image">
                                    <img src="https://images.unsplash.com/photo-1580042740579-f4ba47e81f37?w=400&h=300&fit=crop" alt="Pistachios" class="munchico-category-img">
                                    <div class="munchico-category-badge munchico-discount-badge">30% OFF</div>
                                </div>
                                <div class="munchico-category-content">
                                    <h3 class="munchico-category-name">PISTACHIOS</h3>
                                    <p class="munchico-category-count">18 PRODUCTS</p>
                                    <div class="munchico-quantity-badge">Almost Gone</div>
                                </div>
                            </div>
                        </div>

                        <!-- Slide 5 -->
                        <div class="swiper-slide">
                            <div class="munchico-category-card">
                                <div class="munchico-category-image">
                                    <img src="https://images.unsplash.com/photo-1577003833154-a2d9d8e9a68e?w=400&h=300&fit=crop" alt="Dates" class="munchico-category-img">
                                    <div class="munchico-category-badge munchico-hot-badge">HOT</div>
                                </div>
                                <div class="munchico-category-content">
                                    <h3 class="munchico-category-name">DATES</h3>
                                    <p class="munchico-category-count">14 PRODUCTS</p>
                                    <div class="munchico-quantity-badge">In Stock</div>
                                </div>
                            </div>
                        </div>

                        <!-- Slide 6 -->
                        <div class="swiper-slide">
                            <div class="munchico-category-card">
                                <div class="munchico-category-image">
                                    <img src="https://images.unsplash.com/photo-1587049352846-4a222e784262?w=400&h=300&fit=crop" alt="Raisins" class="munchico-category-img">
                                    <div class="munchico-category-badge munchico-new-badge">NEW</div>
                                </div>
                                <div class="munchico-category-content">
                                    <h3 class="munchico-category-name">RAISINS</h3>
                                    <p class="munchico-category-count">22 PRODUCTS</p>
                                    <div class="munchico-quantity-badge">Best Seller</div>
                                </div>
                            </div>
                        </div>

                        <!-- Slide 7 -->
                        <div class="swiper-slide">
                            <div class="munchico-category-card">
                                <div class="munchico-category-image">
                                    <img src="https://images.unsplash.com/photo-1628863353691-0071c8c1874c?w=400&h=300&fit=crop" alt="Dried Figs" class="munchico-category-img">
                                    <div class="munchico-category-badge munchico-discount-badge">25% OFF</div>
                                </div>
                                <div class="munchico-category-content">
                                    <h3 class="munchico-category-name">DRIED FIGS</h3>
                                    <p class="munchico-category-count">9 PRODUCTS</p>
                                    <div class="munchico-quantity-badge">Limited Stock</div>
                                </div>
                            </div>
                        </div>

                        <!-- Slide 8 -->
                        <div class="swiper-slide">
                            <div class="munchico-category-card">
                                <div class="munchico-category-image">
                                    <img src="https://images.unsplash.com/photo-1589927986089-35812388d1f4?w=400&h=300&fit=crop" alt="Apricots" class="munchico-category-img">
                                    <div class="munchico-category-badge munchico-hot-badge">HOT</div>
                                </div>
                                <div class="munchico-category-content">
                                    <h3 class="munchico-category-name">APRICOTS</h3>
                                    <p class="munchico-category-count">10 PRODUCTS</p>
                                    <div class="munchico-quantity-badge">In Stock</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation buttons -->
                    <div class="swiper-button-next munchico-swiper-button-next"></div>
                    <div class="swiper-button-prev munchico-swiper-button-prev"></div>
                    
                    <!-- Pagination -->
                    <div class="swiper-pagination munchico-swiper-pagination"></div>
                </div>
            </div>

            <!-- View All Button -->
            <div class="munchico-view-all-btn-container">
                <a href="#" class="munchico-view-all-btn">
                    <span>View All Categories</span>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                        <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- Initialize Swiper -->
    <script>
        var swiper = new Swiper(".munchico-swiper", {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            },
            speed: 800,
            grabCursor: true,
            pagination: {
                el: ".munchico-swiper-pagination",
                clickable: true,
                dynamicBullets: true,
            },
            navigation: {
                nextEl: ".munchico-swiper-button-next",
                prevEl: ".munchico-swiper-button-prev",
            },
            breakpoints: {
                480: {
                    slidesPerView: 1.5,
                    spaceBetween: 15,
                },
                640: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 2.5,
                    spaceBetween: 20,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 24,
                },
                1280: {
                    slidesPerView: 4,
                    spaceBetween: 24,
                },
            },
        });

        // Add click event to category cards
        document.querySelectorAll('.munchico-category-card').forEach(card => {
            card.addEventListener('click', function() {
                const categoryName = this.querySelector('.munchico-category-name').textContent;
                console.log(`Navigating to ${categoryName} category`);
                // Add your navigation logic here
            });
        });
    </script>
