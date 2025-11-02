      <section class="features-section" aria-label="Service Features">
          <div class="container">
              <div class="features-grid">

                  <!-- Feature 1: Fast Shipping -->
                  <div class="feature-item">
                      <div class="feature-icon">
                          <svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                              <rect x="1" y="3" width="15" height="13"></rect>
                              <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                              <circle cx="5.5" cy="18.5" r="2.5"></circle>
                              <circle cx="18.5" cy="18.5" r="2.5"></circle>
                          </svg>
                      </div>
                      <div class="feature-content">
                          <h3 class="feature-title">Fast Shipping</h3>
                          <p class="feature-text">Shipped In 1-3 Days</p>
                      </div>
                  </div>

                  <!-- Feature 2: Free Returns -->
                  <div class="feature-item">
                      <div class="feature-icon">
                          <svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                              <line x1="12" y1="1" x2="12" y2="23"></line>
                              <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                          </svg>
                      </div>
                      <div class="feature-content">
                          <h3 class="feature-title">Free Returns</h3>
                          <p class="feature-text">Free 7 Days Return</p>
                      </div>
                  </div>

                  <!-- Feature 3: Help Support -->
                  <div class="feature-item">
                      <div class="feature-icon">
                          <svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                              <path d="M3 18v-6a9 9 0 0 1 18 0v6"></path>
                              <path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"></path>
                          </svg>
                      </div>
                      <div class="feature-content">
                          <h3 class="feature-title">Help Support</h3>
                          <p class="feature-text">Phone And Email</p>
                      </div>
                  </div>

                  <!-- Feature 4: Join Newsletter -->
                  <div class="feature-item">
                      <div class="feature-icon">
                          <svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                              <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                              <polyline points="22,6 12,13 2,6"></polyline>
                          </svg>
                      </div>
                      <div class="feature-content">
                          <h3 class="feature-title">Join Newsletter</h3>
                          <p class="feature-text">Get The Latest Offers</p>
                      </div>
                  </div>

                  <!-- Feature 5: Free Home Delivery -->
                  <div class="feature-item">
                      <div class="feature-content feature-content-right">
                          <h3 class="feature-title">Free Home Delivery.</h3>
                          <p class="feature-text">Free Shipping For Orders</p>
                          <p class="feature-text">Over $50</p>
                      </div>
                  </div>

              </div>
          </div>
      </section>

      <style>
          /* ==========================================
          FEATURES SECTION STYLES
          ========================================== */

          .features-section {
              background: #f5f5f5;
              padding: var(--space-xl) 0;
              border-top: 1px solid #e0e0e0;
              border-bottom: 1px solid #e0e0e0;
          }

          .features-grid {
              display: flex;
              align-items: center;
              justify-content: space-between;
              gap: var(--space-lg);
              flex-wrap: wrap;
          }

          /* Feature Item */
          .feature-item {
              display: flex;
              align-items: center;
              gap: 16px;
              flex: 1;
              min-width: 200px;
          }

          /* Feature Icon */
          .feature-icon {
              flex-shrink: 0;
              width: 52px;
              height: 52px;
              color: #1a1a1a;
          }

          /* Feature Content */
          .feature-content {
              flex: 1;
          }

          .feature-title {
              font-size: 17px;
              font-weight: 700;
              color: #1a1a1a;
              margin: 0 0 4px 0;
              line-height: 1.3;
          }

          .feature-text {
              font-size: 14px;
              color: #999999;
              line-height: 1.4;
              margin: 0;
          }

          /* Right Aligned Content */
          .feature-content-right {
              text-align: right;
          }

          .feature-icon svg {
              stroke: var(--accent-color);
          }

          /* Responsive Design */
          @media (max-width: 1200px) {
              .features-grid {
                  display: grid;
                  grid-template-columns: repeat(3, 1fr);
                  gap: var(--space-lg);
              }

              .feature-item:last-child {
                  grid-column: 1 / -1;
                  justify-content: flex-end;
              }

              .feature-content-right {
                  text-align: right;
              }
          }

          @media (max-width: 768px) {
              .features-grid {
                  grid-template-columns: repeat(2, 1fr);
                  gap: var(--space-md);
              }

              .feature-item {
                  min-width: auto;
              }

              .feature-icon {
                  width: 44px;
                  height: 44px;
              }

              .feature-title {
                  font-size: 15px;
              }

              .feature-text {
                  font-size: 13px;
              }
          }

          @media (max-width: 480px) {
              .features-grid {
                  grid-template-columns: 1fr;
              }

              .feature-item:last-child {
                  grid-column: 1;
              }

              .feature-content-right {
                  text-align: left;
              }

              .features-section {
                  padding: var(--space-lg) 0;
              }

              .feature-icon {
                  width: 40px;
                  height: 40px;
              }
          }
      </style>