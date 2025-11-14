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