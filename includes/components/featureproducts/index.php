<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Featured Products</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
        :root {
            --primary-color: #2C5F2D;
            --secondary-color: #97B43F;
            --gray-50: #f9fafb;
            --gray-300: #d1d5db;
            --gray-900: #111827;
            --white: #ffffff;
            --space-md: 0.5rem;
            --space-lg: 1rem;
            --space-xl: 1.5rem;
            --space-2xl: 2rem;
            --space-3xl: 3rem;
            --font-size-2xl: 2rem;
            --radius-lg: 12px;
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            --transition-base: 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }

        .featured-products {
            background: var(--gray-50);
            padding: var(--space-xl) 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 var(--space-lg);
        }

        .section-title {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: var(--space-lg);
            font-size: var(--font-size-2xl);
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: var(--space-2xl);
            text-transform: capitalize;
        }

        .title-line {
            color: var(--secondary-color);
            font-weight: 400;
        }

        .swiper {
            width: 100%;
            padding: var(--space-md) 0 var(--space-2xl) 0;
        }

        .swiper-slide {
            background: transparent;
        }

        .product-slider-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-md);
            transition: transform var(--transition-base), box-shadow var(--transition-base);
            height: 100%;
        }

        .product-slider-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-xl);
        }

        .product-slider-image {
            position: relative;
            background: linear-gradient(135deg, #2C5F2D 0%, #1B3A1C 100%);
            padding: var(--space-2xl);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 300px;
        }

        .product-slider-image img {
            width: 100%;
            max-width: 180px;
            height: auto;
            border-radius: var(--radius-lg);
            transition: transform var(--transition-base);
        }

        .product-slider-card:hover .product-slider-image img {
            transform: scale(1.05);
        }

        .discount-badge, .quality-badge, .brand-small-badge {
            position: absolute;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            z-index: 2;
        }

        .discount-badge {
            top: 15px;
            right: 15px;
            background: #dc2626;
            color: var(--white);
        }

        .quality-badge {
            top: 15px;
            left: 15px;
            background: rgba(255, 255, 255, 0.95);
            color: var(--primary-color);
            font-size: 10px;
            padding: 4px 8px;
        }

        .brand-small-badge {
            top: 50px;
            left: 15px;
            background: var(--secondary-color);
            color: var(--white);
            font-size: 10px;
            padding: 4px 8px;
        }

        .product-actions {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            display: flex;
            flex-direction: column;
            gap: 10px;
            opacity: 0;
            transition: opacity var(--transition-base);
        }

        .product-slider-card:hover .product-actions {
            opacity: 1;
        }

        .action-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--white);
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .action-btn:hover {
            background: var(--secondary-color);
            color: var(--white);
            transform: scale(1.1);
        }

        .action-btn svg {
            width: 20px;
            height: 20px;
        }

        .order-now-btn {
            position: absolute;
            bottom: 15px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--white);
            color: var(--primary-color);
            border: none;
            padding: 10px 30px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            opacity: 0;
        }

        .product-slider-card:hover .order-now-btn {
            opacity: 1;
        }

        .order-now-btn:hover {
            background: var(--secondary-color);
            color: var(--white);
            transform: translateX(-50%) scale(1.05);
        }

        .product-slider-content {
            padding: var(--space-xl);
        }

        .product-slider-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: var(--space-md);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .product-rating {
            display: flex;
            align-items: center;
            gap: var(--space-md);
            margin-bottom: var(--space-md);
        }

        .stars {
            color: #fbbf24;
            font-size: 16px;
            letter-spacing: 2px;
        }

        .review-count {
            font-size: 13px;
            color: #6b7280;
        }

        .product-price {
            display: flex;
            align-items: center;
            gap: var(--space-md);
        }

        .price-current {
            font-size: 18px;
            font-weight: 700;
            color: var(--primary-color);
        }

        .price-old {
            font-size: 15px;
            color: #9ca3af;
            text-decoration: line-through;
        }

        .swiper-button-next, .swiper-button-prev {
            background: var(--primary-color);
            border: 2px solid var(--gray-300);
            width: 45px;
            height: 45px;
            border-radius: 50%;
            box-shadow: var(--shadow-md);
        }

        .swiper-button-next:after, .swiper-button-prev:after {
            font-size: 18px;
            color: var(--white);
            font-weight: bold;
        }

        .swiper-button-next:hover, .swiper-button-prev:hover {
            background: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .swiper-pagination-bullet {
            background: var(--gray-300);
            opacity: 1;
        }

        .swiper-pagination-bullet-active {
            background: var(--primary-color);
        }

        @media (max-width: 768px) {
            .section-title {
                font-size: 1.5rem;
            }

            .swiper-button-next, .swiper-button-prev {
                width: 35px;
                height: 35px;
            }

            .swiper-button-next:after, .swiper-button-prev:after {
                font-size: 14px;
            }
        }

        @media (max-width: 480px) {
            .product-slider-image {
                min-height: 250px;
                padding: var(--space-xl);
            }

            .product-slider-image img {
                max-width: 150px;
            }
        }
    </style>
</head>
<body>
    <section class="featured-products" aria-labelledby="featured-products-title">
        <div class="container">
            <h2 id="featured-products-title" class="section-title">
                <span class="title-line">—</span>
                Featured Products
                <span class="title-line">—</span>
            </h2>

            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="product-slider-card">
                            <div class="product-slider-image">
                                <img src="https://placehold.co/300x300/2C5F2D/white?text=Pistachio" alt="Roasted Pistachio" />
                                <span class="discount-badge">-32%</span>
                                <span class="quality-badge">HIGH QUALITY</span>
                                <span class="brand-small-badge">PREMIUM</span>
                                <div class="product-actions">
                                    <button class="action-btn" aria-label="Add to wishlist">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
                                        </svg>
                                    </button>
                                    <button class="action-btn" aria-label="Add to cart">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z" />
                                            <line x1="3" y1="6" x2="21" y2="6" />
                                            <path d="M16 10a4 4 0 0 1-8 0" />
                                        </svg>
                                    </button>
                                    <button class="action-btn" aria-label="Quick view">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                    </button>
                                </div>
                                <button class="order-now-btn">ORDER NOW</button>
                            </div>
                            <div class="product-slider-content">
                                <h3 class="product-slider-title">Roasted Pistachio 1kg Pack...</h3>
                                <div class="product-rating">
                                    <span class="stars">★★★★☆</span>
                                    <span class="review-count">5 Reviews</span>
                                </div>
                                <div class="product-price">
                                    <span class="price-current">Rs.4,100.00</span>
                                    <span class="price-old">Rs.6,000.00</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="product-slider-card">
                            <div class="product-slider-image">
                                <img src="https://placehold.co/300x300/2C5F2D/white?text=Salted" alt="Salted Pistachios" />
                                <span class="discount-badge">-8%</span>
                                <span class="quality-badge">HIGH QUALITY</span>
                                <span class="brand-small-badge">PREMIUM</span>
                                <div class="product-actions">
                                    <button class="action-btn" aria-label="Add to wishlist">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
                                        </svg>
                                    </button>
                                    <button class="action-btn" aria-label="Add to cart">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z" />
                                            <line x1="3" y1="6" x2="21" y2="6" />
                                            <path d="M16 10a4 4 0 0 1-8 0" />
                                        </svg>
                                    </button>
                                    <button class="action-btn" aria-label="Quick view">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                    </button>
                                </div>
                                <button class="order-now-btn">ORDER NOW</button>
                            </div>
                            <div class="product-slider-content">
                                <h3 class="product-slider-title">Salted Pistachios 250gm Fr...</h3>
                                <div class="product-rating">
                                    <span class="stars">★★★★★</span>
                                    <span class="review-count">1 Review</span>
                                </div>
                                <div class="product-price">
                                    <span class="price-current">Rs.1,100.00</span>
                                    <span class="price-old">Rs.1,200.00</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="product-slider-card">
                            <div class="product-slider-image">
                                <img src="https://placehold.co/300x300/2C5F2D/white?text=Kernels" alt="Pistachio Kernels" />
                                <span class="quality-badge">HIGH QUALITY</span>
                                <span class="brand-small-badge">PREMIUM</span>
                                <div class="product-actions">
                                    <button class="action-btn" aria-label="Add to wishlist">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
                                        </svg>
                                    </button>
                                    <button class="action-btn" aria-label="Add to cart">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z" />
                                            <line x1="3" y1="6" x2="21" y2="6" />
                                            <path d="M16 10a4 4 0 0 1-8 0" />
                                        </svg>
                                    </button>
                                    <button class="action-btn" aria-label="Quick view">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                    </button>
                                </div>
                                <button class="order-now-btn">ORDER NOW</button>
                            </div>
                            <div class="product-slider-content">
                                <h3 class="product-slider-title">Pistachio Kernels: 1kg Pack...</h3>
                                <div class="product-rating">
                                    <span class="stars">★★★★★</span>
                                    <span class="review-count">0 Reviews</span>
                                </div>
                                <div class="product-price">
                                    <span class="price-current">Rs.1,680.00</span>
                                    <span class="price-old">Rs.2,500.00</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="product-slider-card">
                            <div class="product-slider-image">
                                <img src="https://placehold.co/300x300/2C5F2D/white?text=Hazelnuts" alt="Roasted Hazelnuts" />
                                <span class="discount-badge">-17%</span>
                                <span class="quality-badge">HIGH QUALITY</span>
                                <span class="brand-small-badge">PREMIUM</span>
                                <div class="product-actions">
                                    <button class="action-btn" aria-label="Add to wishlist">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
                                        </svg>
                                    </button>
                                    <button class="action-btn" aria-label="Add to cart">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z" />
                                            <line x1="3" y1="6" x2="21" y2="6" />
                                            <path d="M16 10a4 4 0 0 1-8 0" />
                                        </svg>
                                    </button>
                                    <button class="action-btn" aria-label="Quick view">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                    </button>
                                </div>
                                <button class="order-now-btn">ORDER NOW</button>
                            </div>
                            <div class="product-slider-content">
                                <h3 class="product-slider-title">Roasted Hazelnuts - (250gm...)</h3>
                                <div class="product-rating">
                                    <span class="stars">★★★★☆</span>
                                    <span class="review-count">3 Reviews</span>
                                </div>
                                <div class="product-price">
                                    <span class="price-current">Rs.1,900.00</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="product-slider-card">
                            <div class="product-slider-image">
                                <img src="https://placehold.co/300x300/2C5F2D/white?text=Almonds" alt="Premium Almonds" />
                                <span class="discount-badge">-20%</span>
                                <span class="quality-badge">HIGH QUALITY</span>
                                <span class="brand-small-badge">PREMIUM</span>
                                <div class="product-actions">
                                    <button class="action-btn" aria-label="Add to wishlist">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
                                        </svg>
                                    </button>
                                    <button class="action-btn" aria-label="Add to cart">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z" />
                                            <line x1="3" y1="6" x2="21" y2="6" />
                                            <path d="M16 10a4 4 0 0 1-8 0" />
                                        </svg>
                                    </button>
                                    <button class="action-btn" aria-label="Quick view">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                    </button>
                                </div>
                                <button class="order-now-btn">ORDER NOW</button>
                            </div>
                            <div class="product-slider-content">
                                <h3 class="product-slider-title">Premium Almonds 500gm...</h3>
                                <div class="product-rating">
                                    <span class="stars">★★★★★</span>
                                    <span class="review-count">8 Reviews</span>
                                </div>
                                <div class="product-price">
                                    <span class="price-current">Rs.2,400.00</span>
                                    <span class="price-old">Rs.3,000.00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".mySwiper", {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                480: {
                    slidesPerView: 1,
                    spaceBetween: 20,
                },
                640: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 25,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
                1280: {
                    slidesPerView: 4,
                    spaceBetween: 30,
                }
            }
        });
    </script>
</body>
</html>