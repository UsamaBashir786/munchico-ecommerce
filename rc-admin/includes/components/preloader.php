  <style>
      * {
          margin: 0;
          padding: 0;
          box-sizing: border-box;
      }

      body {
          font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
          background: #f5f7fa;
          overflow: hidden;
      }

      .preloader-wrapper {
          position: fixed;
          top: 0;
          left: 0;
          width: 100%;
          height: 100vh;
          background: #f5f7fa;
          z-index: 99999;
          display: flex;
      }

      /* Sidebar Skeleton */
      .skeleton-sidebar {
          width: 265px;
          height: 100vh;
          background: #2c3e50;
          padding: 20px;
          display: flex;
          flex-direction: column;
          gap: 15px;
      }

      .skeleton-logo {
          width: 180px;
          height: 40px;
          background: linear-gradient(90deg, #34495e 25%, #455a73 50%, #34495e 75%);
          background-size: 200% 100%;
          animation: shimmer 1.5s infinite;
          border-radius: 8px;
          margin-bottom: 30px;
      }

      .skeleton-menu-item {
          width: 100%;
          height: 45px;
          background: linear-gradient(90deg, #34495e 25%, #455a73 50%, #34495e 75%);
          background-size: 200% 100%;
          animation: shimmer 1.5s infinite;
          border-radius: 8px;
          margin-bottom: 8px;
      }

      .skeleton-menu-item:nth-child(2) {
          animation-delay: 0.1s;
      }

      .skeleton-menu-item:nth-child(3) {
          animation-delay: 0.2s;
      }

      .skeleton-menu-item:nth-child(4) {
          animation-delay: 0.3s;
      }

      .skeleton-menu-item:nth-child(5) {
          animation-delay: 0.4s;
      }

      .skeleton-menu-item:nth-child(6) {
          animation-delay: 0.5s;
      }

      .skeleton-menu-item:nth-child(7) {
          animation-delay: 0.6s;
      }

      .skeleton-menu-item:nth-child(8) {
          animation-delay: 0.7s;
      }

      .skeleton-logout {
          margin-top: auto;
          width: 100%;
          height: 45px;
          background: linear-gradient(90deg, #34495e 25%, #455a73 50%, #34495e 75%);
          background-size: 200% 100%;
          animation: shimmer 1.5s infinite;
          border-radius: 8px;
      }

      /* Main Content Area */
      .skeleton-main {
          flex: 1;
          display: flex;
          flex-direction: column;
          padding: 20px;
          overflow: hidden;
      }

      /* Top Bar Skeleton */
      .skeleton-topbar {
          display: flex;
          justify-content: space-between;
          align-items: center;
          margin-bottom: 30px;
          padding: 15px 20px;
          background: white;
          border-radius: 10px;
      }

      .skeleton-menu-icon {
          width: 40px;
          height: 40px;
          background: linear-gradient(90deg, #e0e0e0 25%, #f0f0f0 50%, #e0e0e0 75%);
          background-size: 200% 100%;
          animation: shimmer 1.5s infinite;
          border-radius: 8px;
      }

      .skeleton-user-info {
          display: flex;
          align-items: center;
          gap: 12px;
      }

      .skeleton-user-text {
          width: 120px;
          height: 20px;
          background: linear-gradient(90deg, #e0e0e0 25%, #f0f0f0 50%, #e0e0e0 75%);
          background-size: 200% 100%;
          animation: shimmer 1.5s infinite;
          border-radius: 4px;
      }

      .skeleton-user-avatar {
          width: 40px;
          height: 40px;
          background: linear-gradient(90deg, #e0e0e0 25%, #f0f0f0 50%, #e0e0e0 75%);
          background-size: 200% 100%;
          animation: shimmer 1.5s infinite;
          border-radius: 50%;
      }

      /* Stats Cards Skeleton */
      .skeleton-stats {
          display: grid;
          grid-template-columns: repeat(4, 1fr);
          gap: 20px;
          margin-bottom: 30px;
      }

      .skeleton-stat-card {
          background: white;
          padding: 25px;
          border-radius: 12px;
          border-left: 4px solid #e0e0e0;
      }

      .skeleton-stat-card:nth-child(1) {
          border-left-color: #3498db;
      }

      .skeleton-stat-card:nth-child(2) {
          border-left-color: #2ecc71;
      }

      .skeleton-stat-card:nth-child(3) {
          border-left-color: #f39c12;
      }

      .skeleton-stat-card:nth-child(4) {
          border-left-color: #9b59b6;
      }

      .skeleton-stat-icon {
          width: 50px;
          height: 50px;
          background: linear-gradient(90deg, #e0e0e0 25%, #f0f0f0 50%, #e0e0e0 75%);
          background-size: 200% 100%;
          animation: shimmer 1.5s infinite;
          border-radius: 10px;
          margin-bottom: 15px;
      }

      .skeleton-stat-number {
          width: 80%;
          height: 32px;
          background: linear-gradient(90deg, #e0e0e0 25%, #f0f0f0 50%, #e0e0e0 75%);
          background-size: 200% 100%;
          animation: shimmer 1.5s infinite;
          border-radius: 6px;
          margin-bottom: 8px;
      }

      .skeleton-stat-label {
          width: 60%;
          height: 18px;
          background: linear-gradient(90deg, #e0e0e0 25%, #f0f0f0 50%, #e0e0e0 75%);
          background-size: 200% 100%;
          animation: shimmer 1.5s infinite;
          border-radius: 4px;
      }

      /* Quick Actions Section */
      .skeleton-section-title {
          width: 200px;
          height: 28px;
          background: linear-gradient(90deg, #e0e0e0 25%, #f0f0f0 50%, #e0e0e0 75%);
          background-size: 200% 100%;
          animation: shimmer 1.5s infinite;
          border-radius: 6px;
          margin-bottom: 20px;
      }

      .skeleton-actions {
          display: grid;
          grid-template-columns: repeat(2, 1fr);
          gap: 20px;
      }

      .skeleton-action-card {
          background: white;
          padding: 25px;
          border-radius: 12px;
          display: flex;
          justify-content: space-between;
          align-items: center;
      }

      .skeleton-action-content {
          flex: 1;
      }

      .skeleton-action-title {
          width: 150px;
          height: 22px;
          background: linear-gradient(90deg, #e0e0e0 25%, #f0f0f0 50%, #e0e0e0 75%);
          background-size: 200% 100%;
          animation: shimmer 1.5s infinite;
          border-radius: 4px;
          margin-bottom: 10px;
      }

      .skeleton-action-text {
          width: 220px;
          height: 16px;
          background: linear-gradient(90deg, #e0e0e0 25%, #f0f0f0 50%, #e0e0e0 75%);
          background-size: 200% 100%;
          animation: shimmer 1.5s infinite;
          border-radius: 4px;
      }

      .skeleton-action-button {
          width: 140px;
          height: 45px;
          background: linear-gradient(90deg, #e0e0e0 25%, #f0f0f0 50%, #e0e0e0 75%);
          background-size: 200% 100%;
          animation: shimmer 1.5s infinite;
          border-radius: 8px;
      }

      /* Shimmer Animation */
      @keyframes shimmer {
          0% {
              background-position: -200% 0;
          }

          100% {
              background-position: 200% 0;
          }
      }

      /* Fade Out Animation */
      .preloader-wrapper.fade-out {
          animation: fadeOut 0.5s ease-out forwards;
      }

      @keyframes fadeOut {
          to {
              opacity: 0;
              visibility: hidden;
          }
      }

      /* Responsive */
      @media (max-width: 1200px) {
          .skeleton-stats {
              grid-template-columns: repeat(2, 1fr);
          }
      }

      @media (max-width: 768px) {
          .skeleton-sidebar {
              width: 200px;
          }

          .skeleton-stats {
              grid-template-columns: 1fr;
          }

          .skeleton-actions {
              grid-template-columns: 1fr;
          }
      }
  </style>

  <div class="preloader-wrapper" id="preloader">
      <!-- Sidebar Skeleton -->
      <div class="skeleton-sidebar">
          <div class="skeleton-logo"></div>
          <div class="skeleton-menu-item"></div>
          <div class="skeleton-menu-item"></div>
          <div class="skeleton-menu-item"></div>
          <div class="skeleton-menu-item"></div>
          <div class="skeleton-menu-item"></div>
          <div class="skeleton-menu-item"></div>
          <div class="skeleton-menu-item"></div>
          <div class="skeleton-logout"></div>
      </div>

      <!-- Main Content Skeleton -->
      <div class="skeleton-main">
          <!-- Top Bar -->
          <div class="skeleton-topbar">
              <div class="skeleton-menu-icon"></div>
              <div class="skeleton-user-info">
                  <div class="skeleton-user-text"></div>
                  <div class="skeleton-user-avatar"></div>
              </div>
          </div>

          <!-- Stats Cards -->
          <div class="skeleton-stats">
              <div class="skeleton-stat-card">
                  <div class="skeleton-stat-icon"></div>
                  <div class="skeleton-stat-number"></div>
                  <div class="skeleton-stat-label"></div>
              </div>
              <div class="skeleton-stat-card">
                  <div class="skeleton-stat-icon"></div>
                  <div class="skeleton-stat-number"></div>
                  <div class="skeleton-stat-label"></div>
              </div>
              <div class="skeleton-stat-card">
                  <div class="skeleton-stat-icon"></div>
                  <div class="skeleton-stat-number"></div>
                  <div class="skeleton-stat-label"></div>
              </div>
              <div class="skeleton-stat-card">
                  <div class="skeleton-stat-icon"></div>
                  <div class="skeleton-stat-number"></div>
                  <div class="skeleton-stat-label"></div>
              </div>
          </div>

          <!-- Quick Actions Section -->
          <div class="skeleton-section-title"></div>
          <div class="skeleton-actions">
              <div class="skeleton-action-card">
                  <div class="skeleton-action-content">
                      <div class="skeleton-action-title"></div>
                      <div class="skeleton-action-text"></div>
                  </div>
                  <div class="skeleton-action-button"></div>
              </div>
              <div class="skeleton-action-card">
                  <div class="skeleton-action-content">
                      <div class="skeleton-action-title"></div>
                      <div class="skeleton-action-text"></div>
                  </div>
                  <div class="skeleton-action-button"></div>
              </div>
              <div class="skeleton-action-card">
                  <div class="skeleton-action-content">
                      <div class="skeleton-action-title"></div>
                      <div class="skeleton-action-text"></div>
                  </div>
                  <div class="skeleton-action-button"></div>
              </div>
              <div class="skeleton-action-card">
                  <div class="skeleton-action-content">
                      <div class="skeleton-action-title"></div>
                      <div class="skeleton-action-text"></div>
                  </div>
                  <div class="skeleton-action-button"></div>
              </div>
              <div class="skeleton-action-card">
                  <div class="skeleton-action-content">
                      <div class="skeleton-action-title"></div>
                      <div class="skeleton-action-text"></div>
                  </div>
                  <div class="skeleton-action-button"></div>
              </div>
              <div class="skeleton-action-card">
                  <div class="skeleton-action-content">
                      <div class="skeleton-action-title"></div>
                      <div class="skeleton-action-text"></div>
                  </div>
                  <div class="skeleton-action-button"></div>
              </div>
          </div>
      </div>
  </div>

  <script>
      // Auto-hide preloader after 2 seconds (for demo purposes)
      window.addEventListener('load', function() {
          setTimeout(function() {
              const preloader = document.getElementById('preloader');
              preloader.classList.add('fade-out');
              setTimeout(function() {
                  preloader.style.display = 'none';
              }, 500);
          }, 2000);
      });
  </script>