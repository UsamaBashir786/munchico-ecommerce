<?php
session_start();
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Login - MUNCHICO</title>
        <link rel="stylesheet" href="assets/css/main.css" />
    </head>
    <body>
        <style>
            .back-home-btn {
                /* display: inline-flex; */
                align-items: center;
                gap: 0.5rem;
                position: absolute !important;
                color: #8b4513;
                text-decoration: none;
                font-weight: 600;
                font-size: 0.95rem;
                /* margin-bottom: 1.5rem; */
                transition: all 0.3s;
            }

            .back-home-btn:hover {
                color: #6d3410;
                transform: translateX(-3px);
            }
        </style>
            <?php include 'includes/reusedComponents/backButton.php' ?>
            <div class="auth-container">
            <div class="auth-left">
                <div class="brand-section">
                    <h1 class="brand-logo">MUNCHICO</h1>
                    <p class="brand-tagline">Delicious food delivered to your doorstep</p>
                </div>
                <div class="feature-list">
                    <div class="feature-item">
                        <div class="feature-icon">🍕</div>
                        <div class="feature-text">
                            <h3>Wide Selection</h3>
                            <p>Choose from thousands of restaurants</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">🚀</div>
                        <div class="feature-text">
                            <h3>Fast Delivery</h3>
                            <p>Get your food delivered in minutes</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">⭐</div>
                        <div class="feature-text">
                            <h3>Quality Assured</h3>
                            <p>Fresh and hygienic food guaranteed</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="auth-right">
                <div class="auth-form-wrapper">
                    <div class="auth-header">
                        <h2>Welcome Back</h2>
                        <p>Login to your account to continue</p>
                    </div>

                    <?php if(isset($_SESSION['error'])): ?>
                        <div class="alert alert-error">
                            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                        </div>
                    <?php endif; ?>

                    <?php if(isset($_SESSION['success'])): ?>
                        <div class="alert alert-success">
                            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                        </div>
                    <?php endif; ?>

                    <form class="auth-form" action="login_process.php" method="POST">
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" placeholder="Enter your email" required />
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Enter your password"
                                required
                            />
                        </div>

                        <div class="form-options">
                            <label class="checkbox-label">
                                <input type="checkbox" name="remember" />
                                <span>Remember me</span>
                            </label>
                            <a href="forgot-password.php" class="forgot-link">Forgot password?</a>
                        </div>

                        <button type="submit" class="auth-btn">Login</button>
                    </form>

                    <div class="auth-footer">
                        <p>Don't have an account? <a href="register.php">Create one</a></p>
                    </div>
                </div>
            </div>
        </div>


        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family:
                    "Inter",
                    -apple-system,
                    BlinkMacSystemFont,
                    "Segoe UI",
                    Roboto,
                    Oxygen,
                    Ubuntu,
                    Cantarell,
                    sans-serif;
                min-height: 100vh;
                overflow: hidden;
            }

            .auth-container {
                display: grid;
                grid-template-columns: 1fr 1fr;
                min-height: 100vh;
                height: 100%;
            }

            .auth-left {
                background: linear-gradient(135deg, #8b4513 0%, #a0522d 100%);
                color: white;
                padding: 4rem;
                display: flex;
                flex-direction: column;
                justify-content: center;
            }

            .brand-section {
                margin-bottom: 4rem;
            }

            .brand-logo {
                font-size: 3rem;
                color: var(--white);
                font-weight: 800;
                margin-bottom: 1rem;
                letter-spacing: -1px;
            }

            .brand-tagline {
                font-size: 1.25rem;
                opacity: 0.9;
                color: var(--primary-light);
                font-weight: 300;
            }

            .feature-list {
                display: flex;
                flex-direction: column;
                gap: 2.5rem;
            }

            .feature-item {
                display: flex;
                gap: 1.5rem;
                align-items: flex-start;
            }

            .feature-icon {
                font-size: 2.5rem;
                flex-shrink: 0;
            }

            .feature-text h3 {
                font-size: 1.25rem;
                margin-bottom: 0.5rem;
                color: var(--white);
                font-weight: 600;
            }

            .feature-text p {
                color: var(--primary-light);
                opacity: 0.85;
                line-height: 1.5;
            }

            .auth-right {
                background: #ffffff;
                display: flex;
                align-items: flex-start;
                justify-content: center;
                padding: 3rem 4rem;
                overflow-y: auto;
                max-height: 100vh;
            }

            .auth-form-wrapper {
                width: 100%;
                max-width: 480px;
                padding: 2rem 0;
            }

            .auth-header {
                margin-bottom: 3rem;
            }

            .auth-header h2 {
                font-size: 2rem;
                font-weight: 700;
                color: #1a1a1a;
                margin-bottom: 0.75rem;
            }

            .auth-header p {
                color: #666;
                font-size: 1rem;
            }

            .auth-form {
                display: flex;
                flex-direction: column;
                gap: 1.5rem;
            }

            .form-group {
                display: flex;
                flex-direction: column;
                gap: 0.5rem;
            }

            .form-group label {
                font-weight: 600;
                color: #333;
                font-size: 0.95rem;
            }

            .form-group input {
                padding: 1rem;
                border: 2px solid #e0e0e0;
                border-radius: 10px;
                font-size: 1rem;
                transition: all 0.3s;
                background: #fafafa;
            }

            .form-group input:focus {
                outline: none;
                border-color: #8b4513;
                background: #fff;
                box-shadow: 0 0 0 4px rgba(139, 69, 19, 0.1);
            }

            .form-group input::placeholder {
                color: #999;
            }

            .form-options {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-top: 0.5rem;
            }

            .checkbox-label {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                cursor: pointer;
                color: #666;
                font-size: 0.95rem;
            }

            .checkbox-label input[type="checkbox"] {
                width: 18px;
                height: 18px;
                cursor: pointer;
            }

            .forgot-link {
                color: #8b4513;
                text-decoration: none;
                font-weight: 600;
                font-size: 0.95rem;
            }

            .forgot-link:hover {
                text-decoration: underline;
            }

            .auth-btn {
                margin-top: 1rem;
                padding: 1.1rem;
                background: #8b4513;
                color: white;
                border: none;
                border-radius: 10px;
                font-size: 1.05rem;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.3s;
            }

            .auth-btn:hover {
                background: #6d3410;
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(139, 69, 19, 0.3);
            }

            .auth-footer {
                margin-top: 2rem;
                text-align: center;
                color: #666;
            }

            .auth-footer a {
                color: #8b4513;
                text-decoration: none;
                font-weight: 600;
            }

            .auth-footer a:hover {
                text-decoration: underline;
            }

            @media (max-width: 968px) {
                body {
                    overflow: auto;
                }

                .auth-container {
                    grid-template-columns: 1fr;
                    height: auto;
                    min-height: 100vh;
                }

                .auth-left {
                    display: none;
                }

                .auth-right {
                    padding: 2rem 1.5rem;
                    height: auto;
                    min-height: 100vh;
                    max-height: none;
                    overflow-y: visible;
                }

                .auth-form-wrapper {
                    padding: 1rem 0;
                }

                .auth-header {
                    margin-bottom: 2rem;
                }

                .auth-header h2 {
                    font-size: 1.75rem;
                }
            }
        </style>
    </body>
</html>
