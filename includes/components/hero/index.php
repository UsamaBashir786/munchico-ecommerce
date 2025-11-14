
    <style>

        .banner-section {
            padding: var(--space-2xl) 0;
            background: var(--gray-50);
        }

        .hero-swiper {
            width: 100%;
            border-radius: var(--radius-xl);

            overflow: hidden;
            box-shadow: var(--shadow-xxl);
        }

        .hero-swiper .swiper-slide {
            position: relative;
            height: 500px;
            display: flex;
            cursor: pointer;
            align-items: center;
            justify-content: center;
        }

        .banner-image {
            position: absolute;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .banner-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(44, 95, 45, 0.7) 0%, rgba(27, 58, 28, 0.5) 100%);
            z-index: 1;
        }

        .banner-content {
            position: relative;
            z-index: 2;
            text-align: center;
            color: var(--white);
            padding: 0 var(--space-xl);
            max-width: 800px;
            animation: fadeInUp 0.8s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .banner-subtitle {
            font-size: 16px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 3px;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 16px;
            animation: fadeInUp 0.8s ease-out 0.2s backwards;
        }

        .banner-title {
            font-size: 56px;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 20px;
            text-shadow: 2px 4px 8px rgba(0, 0, 0, 0.3);
            animation: fadeInUp 0.8s ease-out 0.4s backwards;
        }

        .banner-description {
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 32px;
            color: rgba(255, 255, 255, 0.95);
            animation: fadeInUp 0.8s ease-out 0.6s backwards;
        }

        .banner-shop-btn {
            display: inline-block;
            background: linear-gradient(135deg, #7CB342, #558B2F);
            color: var(--white);
            border: none;
            padding: 16px 48px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 16px;
            cursor: pointer;
            transition: all var(--transition-base);
            box-shadow: 0 10px 30px rgba(124, 179, 66, 0.4);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            animation: fadeInUp 0.8s ease-out 0.8s backwards;
        }

        .banner-shop-btn:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 15px 40px rgba(124, 179, 66, 0.6);
            background: linear-gradient(135deg, #558B2F, #33691E);
        }

        .banner-shop-btn:active {
            transform: translateY(-1px) scale(1.02);
        }

        /* Swiper Navigation Buttons */
        .swiper-button-next,
        .swiper-button-prev {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            width: 50px;
            height: 50px;
            border-radius: 50%;
            color: var(--white);
            transition: all var(--transition-base);
        }

        .swiper-button-next:after,
        .swiper-button-prev:after {
            font-size: 20px;
            font-weight: bold;
        }

        .swiper-button-next:hover,
        .swiper-button-prev:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.5);
            transform: scale(1.1);
        }

        /* Swiper Pagination */
        .swiper-pagination {
            bottom: 30px !important;
        }

        .swiper-pagination-bullet {
            width: 12px;
            height: 12px;
            background: rgba(255, 255, 255, 0.5);
            opacity: 1;
            transition: all 0.3s ease;
        }

        .swiper-pagination-bullet-active {
            background: var(--white);
            width: 40px;
            border-radius: 6px;
        }

        /* Slide-specific backgrounds */
        .slide-1 {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .slide-2 {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .slide-3 {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .slide-4 {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }

        @media (max-width: 768px) {
            .swiper-slide {
                height: 450px;
            }

            .banner-title {
                font-size: 40px;
            }

            .banner-description {
                font-size: 16px;
            }

            .banner-shop-btn {
                padding: 14px 36px;
                font-size: 14px;
            }

            .swiper-button-next,
            .swiper-button-prev {
                width: 40px;
                height: 40px;
            }

            .swiper-button-next:after,
            .swiper-button-prev:after {
                font-size: 16px;
            }
        }

        @media (max-width: 480px) {
            .swiper-slide {
                height: 400px;
            }

            .banner-title {
                font-size: 32px;
            }

            .banner-subtitle {
                font-size: 12px;
                letter-spacing: 2px;
            }

            .banner-description {
                font-size: 14px;
                margin-bottom: 24px;
            }

            .banner-shop-btn {
                padding: 12px 30px;
                font-size: 13px;
            }

            .swiper-button-next,
            .swiper-button-prev {
                display: none;
            }
        }
    </style>

    <section class="banner-section rc-zoom-in-up" aria-label="Promotional Banner">
        <div class="container">
            <div class="swiper hero-swiper">
                <div class="swiper-wrapper">
                    
                    <!-- Slide 1 -->
                    <div class="swiper-slide">
                        <img src="https://images.unsplash.com/photo-1610832958506-aa56368176cf?w=1400" alt="Premium Dried Fruits" class="banner-image">
                        <div class="banner-overlay"></div>
                        <div class="banner-content">
                            <div class="banner-subtitle">100% Natural & Organic</div>
                            <h1 class="banner-title">Premium Dried Fruits Collection</h1>
                            <p class="banner-description">Discover our handpicked selection of the finest dried fruits from around the world. Rich in nutrients, bursting with natural flavor.</p>
                            <button class="banner-shop-btn">SHOP NOW</button>
                        </div>
                    </div>

                    <!-- Slide 2 -->
                    <div class="swiper-slide">
                        <img src="https://images.unsplash.com/photo-1610832958506-aa56368176cf?w=1400" alt="Fresh Dates" class="banner-image">
                        <div class="banner-overlay"></div>
                        <div class="banner-content">
                            <div class="banner-subtitle">Limited Time Offer</div>
                            <h1 class="banner-title">Medjool Dates Sale</h1>
                            <p class="banner-description">Indulge in the king of dates. Sweet, succulent, and packed with energy. Get up to 25% off on premium Medjool dates.</p>
                            <button class="banner-shop-btn">GET OFFER</button>
                        </div>
                    </div>

                    <!-- Slide 3 -->
                    <div class="swiper-slide">
                        <img src="https://images.unsplash.com/photo-1610832958506-aa56368176cf?w=1400" alt="Golden Raisins" class="banner-image">
                        <div class="banner-overlay"></div>
                        <div class="banner-content">
                            <div class="banner-subtitle">New Arrival</div>
                            <h1 class="banner-title">Golden Raisins & More</h1>
                            <p class="banner-description">Experience the golden sweetness of our specially sourced raisins. Perfect for snacking, baking, and healthy living.</p>
                            <button class="banner-shop-btn">EXPLORE NOW</button>
                        </div>
                    </div>

                    <!-- Slide 4 -->
                    <div class="swiper-slide">
                        <img src="https://images.unsplash.com/photo-1610832958506-aa56368176cf?w=1400" alt="Organic Figs" class="banner-image">
                        <div class="banner-overlay"></div>
                        <div class="banner-content">
                            <div class="banner-subtitle">Health & Wellness</div>
                            <h1 class="banner-title">Organic Dried Figs</h1>
                            <p class="banner-description">Nature's candy packed with fiber and minerals. Our organic figs are sun-dried to perfection for maximum taste and nutrition.</p>
                            <button class="banner-shop-btn">DISCOVER MORE</button>
                        </div>
                    </div>

                </div>
                
                <!-- Navigation buttons -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                
                <!-- Pagination -->
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>
  <!-- Swiper JS -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>


    <script>
        const heroSwiper = new Swiper('.hero-swiper', {
            slidesPerView: 1,
            spaceBetween: 0,
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            },
            speed: 1000,
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
        });

        // Optional: Add click handlers for buttons
        document.querySelectorAll('.banner-shop-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('Shop button clicked!');
                // Add your navigation logic here
                // window.location.href = '/shop';
            });
        });
    </script>
