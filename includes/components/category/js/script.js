/* ========================================
   🍂 CATEGORY SLIDER - JAVASCRIPT
   Component: Shop by Category Slider
   Author: Usama Bashir
   ======================================== */

// Category slider functionality with navigation buttons
document.addEventListener('DOMContentLoaded', function() {
  const categorySlider = document.querySelector('.category-slider');
  const categoryTrack = document.querySelector('.category-slider-track');
  const categoryCards = document.querySelectorAll('.category-card');
  const prevBtn = document.querySelector('.prev-btn');
  const nextBtn = document.querySelector('.next-btn');
  
  if (!categorySlider || !categoryTrack || !categoryCards.length) {
    console.error('Category slider elements not found');
    return;
  }
  
  // Slider state
  let currentIndex = 0;
  let autoSlideInterval;
  let isTransitioning = false;
  
  // Get slider dimensions
  function getSliderDimensions() {
    const cardStyle = getComputedStyle(categoryCards[0]);
    const cardWidth = categoryCards[0].offsetWidth;
    const gap = parseInt(getComputedStyle(categorySlider).gap) || 0;
    const trackWidth = categoryTrack.offsetWidth;
    const visibleCards = Math.floor(trackWidth / (cardWidth + gap));
    const maxIndex = Math.max(0, categoryCards.length - visibleCards);
    
    return {
      cardWidth,
      gap,
      visibleCards,
      maxIndex,
      slideWidth: cardWidth + gap
    };
  }
  
  let dimensions = getSliderDimensions();
  
  // Update slider position
  function updateSlider(smooth = true) {
    const offset = currentIndex * dimensions.slideWidth;
    
    if (smooth) {
      categorySlider.style.transition = 'transform 0.5s ease-in-out';
    } else {
      categorySlider.style.transition = 'none';
    }
    
    categorySlider.style.transform = `translateX(-${offset}px)`;
    updateButtonStates();
  }
  
  // Update button states
  function updateButtonStates() {
    if (prevBtn && nextBtn) {
      prevBtn.disabled = currentIndex === 0;
      prevBtn.style.opacity = currentIndex === 0 ? '0.5' : '1';
      
      nextBtn.disabled = currentIndex >= dimensions.maxIndex;
      nextBtn.style.opacity = currentIndex >= dimensions.maxIndex ? '0.5' : '1';
    }
  }
  
  // Next slide
  function nextSlide() {
    if (isTransitioning) return;
    
    isTransitioning = true;
    
    if (currentIndex < dimensions.maxIndex) {
      currentIndex++;
    } else {
      currentIndex = 0;
    }
    
    updateSlider();
    
    setTimeout(() => {
      isTransitioning = false;
    }, 500);
  }
  
  // Previous slide
  function prevSlide() {
    if (isTransitioning) return;
    
    isTransitioning = true;
    
    if (currentIndex > 0) {
      currentIndex--;
    } else {
      currentIndex = dimensions.maxIndex;
    }
    
    updateSlider();
    
    setTimeout(() => {
      isTransitioning = false;
    }, 500);
  }
  
  // Start auto slide
  function startAutoSlide() {
    stopAutoSlide();
    autoSlideInterval = setInterval(() => {
      nextSlide();
    }, 4000);
  }
  
  // Stop auto slide
  function stopAutoSlide() {
    if (autoSlideInterval) {
      clearInterval(autoSlideInterval);
      autoSlideInterval = null;
    }
  }
  
  // Event listeners for navigation buttons
  if (prevBtn) {
    prevBtn.addEventListener('click', () => {
      stopAutoSlide();
      prevSlide();
      setTimeout(startAutoSlide, 5000);
    });
  }
  
  if (nextBtn) {
    nextBtn.addEventListener('click', () => {
      stopAutoSlide();
      nextSlide();
      setTimeout(startAutoSlide, 5000);
    });
  }
  
  // Pause auto-slide on hover
  categorySlider.addEventListener('mouseenter', stopAutoSlide);
  categorySlider.addEventListener('mouseleave', startAutoSlide);
  
  // Add click event to category cards
  categoryCards.forEach(card => {
    card.addEventListener('click', function() {
      const categoryName = this.querySelector('.category-name').textContent;
      console.log(`Navigating to ${categoryName} category`);
      // Add your navigation logic here
      // window.location.href = `category.php?name=${categoryName}`;
    });
  });
  
  // Touch swipe functionality for mobile
  let touchStartX = 0;
  let touchEndX = 0;
  let isSwiping = false;
  
  categorySlider.addEventListener('touchstart', (e) => {
    touchStartX = e.changedTouches[0].screenX;
    isSwiping = true;
    stopAutoSlide();
  }, { passive: true });
  
  categorySlider.addEventListener('touchmove', (e) => {
    if (!isSwiping) return;
    touchEndX = e.changedTouches[0].screenX;
  }, { passive: true });
  
  categorySlider.addEventListener('touchend', () => {
    if (!isSwiping) return;
    
    handleSwipe();
    isSwiping = false;
    setTimeout(startAutoSlide, 3000);
  });
  
  function handleSwipe() {
    const swipeThreshold = 50;
    const diff = touchStartX - touchEndX;
    
    if (Math.abs(diff) > swipeThreshold) {
      if (diff > 0) {
        nextSlide();
      } else {
        prevSlide();
      }
    }
  }
  
  // Handle window resize
  let resizeTimeout;
  window.addEventListener('resize', () => {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(() => {
      dimensions = getSliderDimensions();
      
      // Adjust current index if needed
      if (currentIndex > dimensions.maxIndex) {
        currentIndex = dimensions.maxIndex;
      }
      
      updateSlider(false);
    }, 250);
  });
  
  // Initialize the slider
  updateSlider(false);
  startAutoSlide();
  
  console.log('Category slider loaded successfully');
  console.log('Slider info:', {
    totalCards: categoryCards.length,
    visibleCards: dimensions.visibleCards,
    maxIndex: dimensions.maxIndex
  });
});