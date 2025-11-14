<?php
session_start();
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Register - MUNCHICO</title>
        <link rel="stylesheet" href="assets/css/base/fonts.css" />
        <link rel="stylesheet" href="assets/css/base/reset.css" />
        <link rel="stylesheet" href="assets/css/base/typography.css" />
        <link rel="stylesheet" href="assets/css/components/buttons.css" />
        <link rel="stylesheet" href="assets/css/components/forms.css" />
        <link rel="stylesheet" href="assets/css/components/cards.css" />
        <link rel="stylesheet" href="assets/css/themes/variables.css" />
        <link rel="stylesheet" href="assets/main.css" />
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
                <p class="brand-tagline">Join thousands of food lovers</p>
            </div>
            <div class="feature-list">
                <div class="feature-item">
                    <div class="feature-icon">🎁</div>
                    <div class="feature-text">
                        <h3>Welcome Bonus</h3>
                        <p>Get 20% off on your first order</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">💳</div>
                    <div class="feature-text">
                        <h3>Easy Payments</h3>
                        <p>Multiple payment options available</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">🔔</div>
                    <div class="feature-text">
                        <h3>Order Tracking</h3>
                        <p>Track your order in real-time</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="auth-right">
            <div class="auth-form-wrapper">
                <div class="auth-header">
                    <h2>Create Account</h2>
                    <p>Sign up to start ordering delicious food</p>
                </div>

                <?php if(isset($_SESSION['error'])): ?>
                    <div class="alert alert-error">
                        <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                    </div>
                <?php endif; ?>

                <form class="auth-form" method="POST" action="register_process.php">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" id="first_name" name="first_name" placeholder="John" required />
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" id="last_name" name="last_name" placeholder="Doe" required />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" placeholder="john@example.com" required />
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone" placeholder="+92 300 1234567" required />
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="At least 8 characters" required minlength="8" />
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Re-enter password" required />
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea id="address" name="address" placeholder="Enter your complete address" rows="3"></textarea>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" id="city" name="city" placeholder="e.g., Karachi" />
                        </div>
                        <div class="form-group">
                            <label for="postal_code">Postal Code</label>
                            <input type="text" id="postal_code" name="postal_code" placeholder="e.g., 75500" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="terms" required />
                            <span>I agree to the <a href="#">Terms & Conditions</a> and <a href="#">Privacy Policy</a></span>
                        </label>
                    </div>

                    <button type="submit" class="auth-btn">Create Account</button>
                </form>

                <div class="auth-footer">
                    <p>Already have an account? <a href="login.php">Login here</a></p>
                </div>
            </div>
        </div>
    </div>

        <script>
            function validateForm() {
                const password = document.getElementById("password").value;
                const confirmPassword = document.getElementById("confirmPassword").value;
                const terms = document.getElementById("terms").checked;

                if (password !== confirmPassword) {
                    alert("Passwords do not match!");
                    return false;
                }

                if (!terms) {
                    alert("Please accept the Terms & Conditions");
                    return false;
                }

                return true;
            }
        </script>

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
                font-weight: 300;
                color: var(--primary-light);
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
                opacity: 0.85;
                color: var(--primary-light);
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
                max-width: 580px;
                padding: 2rem 0;
            }

            .auth-header {
                margin-bottom: 2.5rem;
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

            .form-row {
                display: grid;
                grid-template-columns: 1fr 1fr;
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

            .terms-group {
                margin-top: 0.5rem;
            }

            .checkbox-label {
                display: flex;
                align-items: flex-start;
                gap: 0.75rem;
                cursor: pointer;
                color: #666;
                font-size: 0.95rem;
                line-height: 1.6;
            }

            .checkbox-label input[type="checkbox"] {
                width: 18px;
                height: 18px;
                cursor: pointer;
                margin-top: 2px;
                flex-shrink: 0;
            }

            .terms-link {
                color: #8b4513;
                text-decoration: none;
                font-weight: 600;
            }

            .terms-link:hover {
                text-decoration: underline;
            }
            /* Add this CSS to your existing styles in the register.php file */

.form-group textarea {
    padding: 1rem;
    border: 2px solid #e0e0e0;
    border-radius: 10px;
    font-size: 1rem;
    transition: all 0.3s;
    background: #fafafa;
    font-family: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
    resize: vertical;
    min-height: 100px;
    line-height: 1.5;
}

.form-group textarea:focus {
    outline: none;
    border-color: #8b4513;
    background: #fff;
    box-shadow: 0 0 0 4px rgba(139, 69, 19, 0.1);
}

.form-group textarea::placeholder {
    color: #999;
}

/* Optional: Limit max height for textarea */
.form-group textarea {
    max-height: 200px;
}

/* Scrollbar styling for textarea (optional) */
.form-group textarea::-webkit-scrollbar {
    width: 8px;
}

.form-group textarea::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.form-group textarea::-webkit-scrollbar-thumb {
    background: #8b4513;
    border-radius: 10px;
}

.form-group textarea::-webkit-scrollbar-thumb:hover {
    background: #6d3410;
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

                .form-row {
                    grid-template-columns: 1fr;
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
