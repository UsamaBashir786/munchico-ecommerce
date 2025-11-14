  <style>
    .auto-reload-timer {
      position: fixed;
      bottom: 20px;
      right: 20px;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      padding: 15px 20px;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(102, 126, 234, 0.4);
      z-index: 9998;
      display: flex;
      align-items: center;
      gap: 15px;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      transition: all 0.3s ease;
    }

    .auto-reload-timer:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 25px rgba(102, 126, 234, 0.6);
    }

    .timer-icon {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 40px;
      height: 40px;
      background: rgba(255, 255, 255, 0.2);
      border-radius: 50%;
      position: relative;
    }

    .timer-icon svg {
      width: 22px;
      height: 22px;
      animation: rotate 2s linear infinite;
    }

    @keyframes rotate {
      from { transform: rotate(0deg); }
      to { transform: rotate(360deg); }
    }

    .timer-content {
      display: flex;
      flex-direction: column;
      gap: 3px;
    }

    .timer-label {
      font-size: 11px;
      font-weight: 500;
      opacity: 0.9;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .timer-display {
      font-size: 18px;
      font-weight: 700;
      font-family: 'Courier New', monospace;
      letter-spacing: 1px;
    }

    .timer-controls {
      display: flex;
      gap: 8px;
      align-items: center;
      padding-left: 15px;
      border-left: 1px solid rgba(255, 255, 255, 0.3);
    }

    .timer-btn {
      background: rgba(255, 255, 255, 0.2);
      border: none;
      color: white;
      width: 32px;
      height: 32px;
      border-radius: 6px;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.2s ease;
      font-size: 14px;
      font-weight: bold;
    }

    .timer-btn:hover {
      background: rgba(255, 255, 255, 0.3);
      transform: scale(1.05);
    }

    .timer-btn:active {
      transform: scale(0.95);
    }

    .timer-btn.pause-btn svg {
      width: 16px;
      height: 16px;
    }

    .timer-btn.settings-btn svg {
      width: 16px;
      height: 16px;
    }

    /* Settings Modal */
    .timer-modal {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.6);
      backdrop-filter: blur(5px);
      z-index: 9999;
      display: none;
      align-items: center;
      justify-content: center;
      animation: fadeIn 0.3s ease;
    }

    .timer-modal.active {
      display: flex;
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    .timer-modal-content {
      background: white;
      padding: 30px;
      border-radius: 16px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
      max-width: 400px;
      width: 90%;
      animation: slideUp 0.3s ease;
    }

    @keyframes slideUp {
      from {
        transform: translateY(30px);
        opacity: 0;
      }
      to {
        transform: translateY(0);
        opacity: 1;
      }
    }

    .modal-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 25px;
      padding-bottom: 15px;
      border-bottom: 2px solid #f0f0f0;
    }

    .modal-title {
      font-size: 20px;
      font-weight: 700;
      color: #2c3e50;
    }

    .modal-close {
      background: none;
      border: none;
      font-size: 28px;
      color: #95a5a6;
      cursor: pointer;
      width: 32px;
      height: 32px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 6px;
      transition: all 0.2s;
    }

    .modal-close:hover {
      background: #f0f0f0;
      color: #2c3e50;
    }

    .time-options {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 12px;
      margin-bottom: 20px;
    }

    .time-option {
      background: #f8f9fa;
      border: 2px solid transparent;
      padding: 15px;
      border-radius: 10px;
      cursor: pointer;
      text-align: center;
      transition: all 0.3s ease;
      font-weight: 600;
      color: #495057;
    }

    .time-option:hover {
      background: #e9ecef;
      transform: translateY(-2px);
    }

    .time-option.active {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      border-color: #667eea;
    }

    .time-value {
      font-size: 24px;
      font-weight: 700;
      margin-bottom: 5px;
    }

    .time-label {
      font-size: 12px;
      opacity: 0.8;
    }

    .custom-time {
      margin-top: 20px;
      padding-top: 20px;
      border-top: 2px solid #f0f0f0;
    }

    .custom-time-label {
      font-size: 14px;
      font-weight: 600;
      color: #2c3e50;
      margin-bottom: 10px;
    }

    .custom-time-input {
      display: flex;
      gap: 10px;
      align-items: center;
    }

    .custom-time-input input {
      flex: 1;
      padding: 12px;
      border: 2px solid #e9ecef;
      border-radius: 8px;
      font-size: 16px;
      font-weight: 600;
      text-align: center;
      transition: all 0.3s;
    }

    .custom-time-input input:focus {
      outline: none;
      border-color: #667eea;
    }

    .custom-time-input select {
      padding: 12px;
      border: 2px solid #e9ecef;
      border-radius: 8px;
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
      background: white;
      transition: all 0.3s;
    }

    .custom-time-input select:focus {
      outline: none;
      border-color: #667eea;
    }

    .apply-btn {
      width: 100%;
      padding: 14px;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      margin-top: 20px;
      transition: all 0.3s;
    }

    .apply-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    .apply-btn:active {
      transform: translateY(0);
    }

    /* Notification */
    .reload-notification {
      position: fixed;
      top: -100px;
      left: 50%;
      transform: translateX(-50%);
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      padding: 15px 30px;
      border-radius: 10px;
      box-shadow: 0 4px 20px rgba(102, 126, 234, 0.4);
      z-index: 10000;
      font-weight: 600;
      transition: all 0.5s ease;
    }

    .reload-notification.show {
      top: 20px;
    }

    /* Minimized State */
    .auto-reload-timer.minimized {
      padding: 10px;
      border-radius: 50%;
      width: 50px;
      height: 50px;
    }

    .auto-reload-timer.minimized .timer-content,
    .auto-reload-timer.minimized .timer-controls {
      display: none;
    }

    .auto-reload-timer.minimized .timer-icon {
      width: 30px;
      height: 30px;
    }

    .minimize-btn {
      background: rgba(255, 255, 255, 0.2);
      border: none;
      color: white;
      width: 32px;
      height: 32px;
      border-radius: 6px;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.2s ease;
      font-size: 16px;
    }

    .minimize-btn:hover {
      background: rgba(255, 255, 255, 0.3);
    }
    .d-none{
        display: none;
    }
  </style>

  <!-- Auto Reload Timer Component -->
  <div class="auto-reload-timer" id="autoReloadTimer">
    <div class="timer-icon">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
      </svg>
    </div>
    <div class="timer-content">
      <div class="timer-label">Next Reload In</div>
      <div class="timer-display" id="timerDisplay">05:00</div>
    </div>
    <div class="timer-controls">
      <button class="timer-btn pause-btn" id="pauseBtn" title="Pause/Resume">
        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
          <path d="M6 4h4v16H6V4zm8 0h4v16h-4V4z"/>
        </svg>
      </button>
      <button class="timer-btn settings-btn" id="settingsBtn" title="Settings">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
      </button>
      <!-- <button class="minimize-btn" id="minimizeBtn" title="Minimize">−</button> -->
      <button class="d-none" id="minimizeBtn" title="Minimize"></button>
    </div>
  </div>

  <!-- Settings Modal -->
  <div class="timer-modal" id="timerModal">
    <div class="timer-modal-content">
      <div class="modal-header">
        <div class="modal-title">⏱️ Auto Reload Settings</div>
        <button class="modal-close" id="closeModal">&times;</button>
      </div>

      <div class="time-options">
        <div class="time-option" data-time="30">
          <div class="time-value">30</div>
          <div class="time-label">Seconds</div>
        </div>
        <div class="time-option" data-time="60">
          <div class="time-value">1</div>
          <div class="time-label">Minute</div>
        </div>
        <div class="time-option active" data-time="300">
          <div class="time-value">5</div>
          <div class="time-label">Minutes</div>
        </div>
        <div class="time-option" data-time="600">
          <div class="time-value">10</div>
          <div class="time-label">Minutes</div>
        </div>
        <div class="time-option" data-time="1800">
          <div class="time-value">30</div>
          <div class="time-label">Minutes</div>
        </div>
        <div class="time-option" data-time="3600">
          <div class="time-value">1</div>
          <div class="time-label">Hour</div>
        </div>
      </div>


      <button class="apply-btn" id="applyBtn">Apply Settings</button>
    </div>
  </div>

  <!-- Reload Notification -->
  <div class="reload-notification" id="reloadNotification">
    🔄 Reloading page for fresh data...
  </div>

  <script>
    class AutoReloadTimer {
      constructor() {
        this.reloadInterval = 300; // Default 5 minutes in seconds
        this.remainingTime = this.reloadInterval;
        this.isPaused = false;
        this.isMinimized = false;
        this.timer = null;
        
        this.initElements();
        this.initEventListeners();
        this.startTimer();
        this.loadSettings();
      }

      initElements() {
        this.timerElement = document.getElementById('autoReloadTimer');
        this.displayElement = document.getElementById('timerDisplay');
        this.pauseBtn = document.getElementById('pauseBtn');
        this.settingsBtn = document.getElementById('settingsBtn');
        this.minimizeBtn = document.getElementById('minimizeBtn');
        this.modal = document.getElementById('timerModal');
        this.closeModal = document.getElementById('closeModal');
        this.applyBtn = document.getElementById('applyBtn');
        this.notification = document.getElementById('reloadNotification');
        this.timeOptions = document.querySelectorAll('.time-option');
        this.customTimeValue = document.getElementById('customTimeValue');
        this.customTimeUnit = document.getElementById('customTimeUnit');
      }

      initEventListeners() {
        this.pauseBtn.addEventListener('click', () => this.togglePause());
        this.settingsBtn.addEventListener('click', () => this.openSettings());
        this.minimizeBtn.addEventListener('click', () => this.toggleMinimize());
        this.closeModal.addEventListener('click', () => this.closeSettings());
        this.applyBtn.addEventListener('click', () => this.applySettings());
        
        this.timeOptions.forEach(option => {
          option.addEventListener('click', (e) => {
            this.timeOptions.forEach(opt => opt.classList.remove('active'));
            e.currentTarget.classList.add('active');
          });
        });

        this.modal.addEventListener('click', (e) => {
          if (e.target === this.modal) this.closeSettings();
        });

        this.timerElement.addEventListener('click', () => {
          if (this.isMinimized) this.toggleMinimize();
        });
      }

      startTimer() {
        this.timer = setInterval(() => {
          if (!this.isPaused) {
            this.remainingTime--;
            this.updateDisplay();
            
            if (this.remainingTime <= 0) {
              this.reloadPage();
            }
          }
        }, 1000);
      }

      updateDisplay() {
        const minutes = Math.floor(this.remainingTime / 60);
        const seconds = this.remainingTime % 60;
        this.displayElement.textContent = 
          `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
      }

      togglePause() {
        this.isPaused = !this.isPaused;
        
        if (this.isPaused) {
          this.pauseBtn.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
              <path d="M8 5v14l11-7z"/>
            </svg>
          `;
          this.pauseBtn.title = 'Resume';
        } else {
          this.pauseBtn.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
              <path d="M6 4h4v16H6V4zm8 0h4v16h-4V4z"/>
            </svg>
          `;
          this.pauseBtn.title = 'Pause';
        }
      }

      toggleMinimize() {
        this.isMinimized = !this.isMinimized;
        this.timerElement.classList.toggle('minimized');
        this.minimizeBtn.textContent = this.isMinimized ? '+' : '−';
      }

      openSettings() {
        this.modal.classList.add('active');
      }

      closeSettings() {
        this.modal.classList.remove('active');
      }

      applySettings() {
        const activeOption = document.querySelector('.time-option.active');
        let newInterval;

        if (activeOption) {
          newInterval = parseInt(activeOption.dataset.time);
        } else {
          const value = parseInt(this.customTimeValue.value);
          const unit = this.customTimeUnit.value;
          
          switch(unit) {
            case 'seconds':
              newInterval = value;
              break;
            case 'minutes':
              newInterval = value * 60;
              break;
            case 'hours':
              newInterval = value * 3600;
              break;
          }
        }

        this.reloadInterval = newInterval;
        this.remainingTime = newInterval;
        this.saveSettings();
        this.closeSettings();
      }

      saveSettings() {
        localStorage.setItem('autoReloadInterval', this.reloadInterval);
      }

      loadSettings() {
        const saved = localStorage.getItem('autoReloadInterval');
        if (saved) {
          this.reloadInterval = parseInt(saved);
          this.remainingTime = this.reloadInterval;
        }
      }

      reloadPage() {
        this.notification.classList.add('show');
        
        setTimeout(() => {
          location.reload();
        }, 1500);
      }
    }

    // Initialize the timer when page loads
    window.addEventListener('load', () => {
      new AutoReloadTimer();
    });
  </script>
