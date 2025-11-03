<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Government Portal - Secure Login</title>
    <link rel="stylesheet" href="login_styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="login-container">
        <!-- Background Elements -->
        <div class="bg-pattern"></div>
        <div class="floating-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
        </div>

        <!-- Main Login Card -->
        <div class="login-card">
            <!-- Header Section -->
            <div class="login-header">
                <div class="gov-seal">
                    <img src="cropped-kedah-baru.png" alt="ePSM BPSM Logo" class="logo-image">
                </div>
                <h1 class="portal-title">ePSM BPSM</h1>
                <p class="portal-subtitle">Bahagian Sumber Manusia</p>
            </div>

            <!-- Login Form -->
            <form class="login-form" id="loginForm" action="login.php" method="POST">
                <div class="form-group">
                    <label for="userType" class="form-label">Access Level</label>
                    <div class="select-wrapper">
                        <select id="userType" name="userType" class="form-select" required>
                            <option value="">Select Access Level</option>
                            <option value="admin">Administrator</option>
                            <option value="user">Standard User</option>
                        </select>
                        <i class="fas fa-chevron-down select-icon"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label for="username" class="form-label">Username</label>
                    <div class="input-wrapper">
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" id="username" name="username" class="form-input" placeholder="Enter your username" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" id="password" name="password" class="form-input" placeholder="Enter your password" required>
                        <button type="button" class="password-toggle" id="passwordToggle">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="form-options">
                    <label class="checkbox-wrapper">
                        <input type="checkbox" id="rememberMe" name="rememberMe">
                        <span class="checkbox-custom"></span>
                        <span class="checkbox-label">Remember me</span>
                    </label>
                    <a href="#" class="forgot-password">Forgot Password?</a>
                </div>

                <button type="submit" class="login-btn" id="loginBtn">
                    <span class="btn-text">Sign In</span>
                    <i class="fas fa-arrow-right btn-icon"></i>
                    <div class="btn-loader">
                        <i class="fas fa-spinner fa-spin"></i>
                    </div>
                </button>

                <!-- Alert Messages -->
                <div class="alert alert-error" id="errorAlert" style="display: none;">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span class="alert-text"></span>
                </div>

                <div class="alert alert-success" id="successAlert" style="display: none;">
                    <i class="fas fa-check-circle"></i>
                    <span class="alert-text"></span>
                </div>
            </form>

            <!-- Footer -->
            <div class="login-footer">
                <div class="security-info">
                    <i class="fas fa-lock"></i>
                    <span>256-bit SSL Encrypted Connection</span>
                </div>
                <p class="copyright">© 2024 Government Portal. All rights reserved.</p>
            </div>
        </div>
    </div>

    <script src="login.js"></script>
</body>
</html>