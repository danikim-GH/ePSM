<?php
session_start();

// Security headers
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
header('Content-Type: application/json');

// Database configuration
$config = [
    'host' => 'localhost',
    'dbname' => 'website_project',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8mb4'
];

// User level mapping
$userLevels = [
    'admin' => 9,
    'staff' => 1,
    'medium' => 3,
    'guest' => 2
];

// Response function
function sendResponse($success, $message, $data = null, $errors = null) {
    $response = [
        'success' => $success,
        'message' => $message,
        'timestamp' => date('c'),
        'data' => $data,
        'errors' => $errors
    ];
    
    echo json_encode($response);
    exit;
}

// Input sanitization
function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

// Email validation
function validateEmail($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }
    
    // Check for common disposable email providers
    $disposableProviders = ['10minutemail.com', 'tempmail.org', 'guerrillamail.com'];
    $domain = strtolower(substr(strrchr($email, "@"), 1));
    
    return !in_array($domain, $disposableProviders);
}

// Phone number validation and formatting
function validateAndFormatPhone($phone) {
    // Remove all non-numeric characters except +
    $phone = preg_replace('/[^\d+]/', '', $phone);
    
    // Ensure it starts with + for international format
    if (!str_starts_with($phone, '+')) {
        $phone = '+' . $phone;
    }
    
    // Basic length check (8-15 digits after country code)
    $digits = preg_replace('/[^\d]/', '', $phone);
    if (strlen($digits) < 8 || strlen($digits) > 15) {
        return false;
    }
    
    return $phone;
}

// Password strength validation
function validatePasswordStrength($password) {
    $errors = [];
    
    if (strlen($password) < 8) {
        $errors[] = 'Password must be at least 8 characters long';
    }
    
    if (!preg_match('/[a-z]/', $password)) {
        $errors[] = 'Password must contain at least one lowercase letter';
    }
    
    if (!preg_match('/[A-Z]/', $password)) {
        $errors[] = 'Password must contain at least one uppercase letter';
    }
    
    if (!preg_match('/\d/', $password)) {
        $errors[] = 'Password must contain at least one number';
    }
    
    if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
        $errors[] = 'Password must contain at least one special character';
    }
    
    return $errors;
}

// Username validation
function validateUsername($username, $pdo) {
    $errors = [];
    
    // Length check
    if (strlen($username) < 3 || strlen($username) > 30) {
        $errors[] = 'Username must be between 3 and 30 characters';
    }
    
    // Character check
    if (!preg_match('/^[a-zA-Z0-9._-]+$/', $username)) {
        $errors[] = 'Username can only contain letters, numbers, dots, underscores, and hyphens';
    }
    
    // Reserved usernames
    $reserved = ['admin', 'administrator', 'root', 'system', 'test', 'null', 'undefined'];
    if (in_array(strtolower($username), $reserved)) {
        $errors[] = 'This username is reserved and cannot be used';
    }
    
    // Check if username already exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
        $errors[] = 'Username is already taken';
    }
    
    return $errors;
}

// Email uniqueness check
function checkEmailExists($email, $pdo) {
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    return $stmt->fetch() !== false;
}

// Rate limiting for registration
function checkRegistrationRateLimit($ip, $maxAttempts = 5, $timeWindow = 3600) { // 1 hour
    $file = 'registration_attempts.json';
    $attempts = [];
    
    if (file_exists($file)) {
        $attempts = json_decode(file_get_contents($file), true) ?: [];
    }
    
    $currentTime = time();
    $recentAttempts = array_filter($attempts, function($attempt) use ($ip, $currentTime, $timeWindow) {
        return $attempt['ip'] === $ip && 
               ($currentTime - $attempt['timestamp']) < $timeWindow;
    });
    
    return count($recentAttempts) < $maxAttempts;
}

// Log registration attempt
function logRegistrationAttempt($ip, $success, $username = null) {
    $file = 'registration_attempts.json';
    $attempts = [];
    
    if (file_exists($file)) {
        $attempts = json_decode(file_get_contents($file), true) ?: [];
    }
    
    $attempts[] = [
        'ip' => $ip,
        'timestamp' => time(),
        'success' => $success,
        'username' => $username,
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown'
    ];
    
    // Keep only last 1000 attempts
    if (count($attempts) > 1000) {
        $attempts = array_slice($attempts, -1000);
    }
    
    file_put_contents($file, json_encode($attempts));
}

// Generate verification token
function generateVerificationToken() {
    return bin2hex(random_bytes(32));
}

// Send welcome email (mock function)
function sendWelcomeEmail($email, $username, $verificationToken = null) {
    // In production, implement actual email sending
    // For now, just log the email details
    $logData = [
        'to' => $email,
        'username' => $username,
        'verification_token' => $verificationToken,
        'timestamp' => date('c'),
        'type' => 'welcome_email'
    ];
    
    file_put_contents('email_log.json', json_encode($logData) . "\n", FILE_APPEND);
    return true;
}

// Main registration processing
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $clientIP = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        
        // Check rate limiting
        if (!checkRegistrationRateLimit($clientIP)) {
            logRegistrationAttempt($clientIP, false);
            sendResponse(false, 'Too many registration attempts. Please try again later.');
        }
        
        // Validate required fields
        $requiredFields = ['username', 'email', 'phone', 'userLevel', 'userLevelId', 'password', 'confirmPassword'];
        $missingFields = [];
        
        foreach ($requiredFields as $field) {
            if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
                $missingFields[] = $field;
            }
        }
        
        if (!empty($missingFields)) {
            sendResponse(false, 'Missing required fields: ' . implode(', ', $missingFields));
        }
        
        // Check terms agreement
        if (!isset($_POST['agreeTerms']) || $_POST['agreeTerms'] !== 'on') {
            sendResponse(false, 'You must agree to the terms and conditions');
        }
        
        // Sanitize inputs
        $username = sanitizeInput($_POST['username']);
        $email = sanitizeInput($_POST['email']);
        $phone = sanitizeInput($_POST['phone']);
        $userLevel = sanitizeInput($_POST['userLevel']);
        $userLevelId = intval($_POST['userLevelId']);
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];
        
        // Validation errors array
        $fieldErrors = [];
        
        // Database connection
        try {
            $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";
            $pdo = new PDO($dsn, $config['username'], $config['password'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]);
        } catch (PDOException $e) {
            error_log("Database connection failed: " . $e->getMessage());
            logRegistrationAttempt($clientIP, false, $username);
            sendResponse(false, 'System temporarily unavailable. Please try again later.');
        }
        
        // Validate username
        $usernameErrors = validateUsername($username, $pdo);
        if (!empty($usernameErrors)) {
            $fieldErrors['username'] = implode(', ', $usernameErrors);
        }
        
        // Validate email
        if (!validateEmail($email)) {
            $fieldErrors['email'] = 'Please enter a valid email address';
        } elseif (checkEmailExists($email, $pdo)) {
            $fieldErrors['email'] = 'Email address is already registered';
        }
        
        // Validate phone
        $formattedPhone = validateAndFormatPhone($phone);
        if (!$formattedPhone) {
            $fieldErrors['phone'] = 'Please enter a valid phone number';
        } else {
            $phone = $formattedPhone;
        }
        
        // Validate user level
        if (!array_key_exists($userLevel, $userLevels)) {
            $fieldErrors['userLevel'] = 'Invalid user level selected';
        } elseif ($userLevels[$userLevel] !== $userLevelId) {
            $fieldErrors['userLevel'] = 'User level ID does not match selected level';
        }
        
        // Validate password
        $passwordErrors = validatePasswordStrength($password);
        if (!empty($passwordErrors)) {
            $fieldErrors['password'] = implode(', ', $passwordErrors);
        }
        
        // Validate password confirmation
        if ($password !== $confirmPassword) {
            $fieldErrors['confirmPassword'] = 'Passwords do not match';
        }
        
        // If there are validation errors, return them
        if (!empty($fieldErrors)) {
            logRegistrationAttempt($clientIP, false, $username);
            sendResponse(false, 'Please correct the following errors:', null, $fieldErrors);
        }
        
        // Additional security checks for admin registration
        if ($userLevel === 'admin') {
            // In production, you might want additional verification for admin accounts
            // For now, we'll allow it but log it for review
            error_log("Admin registration attempt: $username from IP: $clientIP");
        }
        
        // Hash password
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        
        // Generate verification token
        $verificationToken = generateVerificationToken();
        
        // Begin transaction
        $pdo->beginTransaction();
        
        try {
            // Insert user record
            $stmt = $pdo->prepare("
                INSERT INTO users (
                    username, email, phone, password_hash, user_type, user_level_id,
                    status, verification_token, created_at, created_ip
                ) VALUES (?, ?, ?, ?, ?, ?, 'active', ?, NOW(), ?)
            ");
            
            $stmt->execute([
                $username,
                $email,
                $phone,
                $passwordHash,
                $userLevel,
                $userLevelId,
                $verificationToken,
                $clientIP
            ]);
            
            $userId = $pdo->lastInsertId();
            
            // Insert user profile record
            $stmt = $pdo->prepare("
                INSERT INTO user_profiles (
                    user_id, created_at, updated_at
                ) VALUES (?, NOW(), NOW())
            ");
            
            $stmt->execute([$userId]);
            
            // Log the registration
            $stmt = $pdo->prepare("
                INSERT INTO user_activity_log (
                    user_id, activity_type, activity_description, ip_address, created_at
                ) VALUES (?, 'registration', 'User account created', ?, NOW())
            ");
            
            $stmt->execute([$userId, $clientIP]);
            
            // Commit transaction
            $pdo->commit();
            
            // Send welcome email
            sendWelcomeEmail($email, $username, $verificationToken);
            
            // Log successful registration
            logRegistrationAttempt($clientIP, true, $username);
            
            // Return success response
            sendResponse(true, 'Account created successfully! Welcome to ePSM BPSM.', [
                'user_id' => $userId,
                'username' => $username,
                'user_level' => $userLevel,
                'requires_verification' => false // Set to true if email verification is required
            ]);
            
        } catch (Exception $e) {
            // Rollback transaction
            $pdo->rollback();
            throw $e;
        }
        
    } catch (Exception $e) {
        error_log("Registration error: " . $e->getMessage());
        logRegistrationAttempt($clientIP ?? 'unknown', false, $username ?? null);
        
        // Check for duplicate entry errors
        if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
            if (strpos($e->getMessage(), 'username') !== false) {
                sendResponse(false, 'Username is already taken', null, ['username' => 'This username is not available']);
            } elseif (strpos($e->getMessage(), 'email') !== false) {
                sendResponse(false, 'Email is already registered', null, ['email' => 'This email address is already in use']);
            }
        }
        
        sendResponse(false, 'An unexpected error occurred during registration. Please try again.');
    }
    
} else {
    // Method not allowed
    http_response_code(405);
    sendResponse(false, 'Method not allowed');
}

/*
-- Enhanced SQL schema for the registration system:

CREATE DATABASE IF NOT EXISTS government_portal;
USE government_portal;

-- Main users table
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    phone VARCHAR(20) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    user_type ENUM('admin', 'staff', 'medium', 'guest') NOT NULL,
    user_level_id INT NOT NULL,
    status ENUM('active', 'inactive', 'suspended', 'pending_verification') DEFAULT 'active',
    verification_token VARCHAR(64) NULL,
    email_verified_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL,
    failed_attempts INT DEFAULT 0,
    locked_until TIMESTAMP NULL,
    created_ip VARCHAR(45) NULL,
    
    INDEX idx_username (username),
    INDEX idx_email (email),
    INDEX idx_user_type (user_type),
    INDEX idx_status (status),
    INDEX idx_verification_token (verification_token)
);

-- User profiles table for additional information
CREATE TABLE user_profiles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    first_name VARCHAR(100) NULL,
    last_name VARCHAR(100) NULL,
    department VARCHAR(100) NULL,
    position VARCHAR(100) NULL,
    profile_picture VARCHAR(255) NULL,
    bio TEXT NULL,
    preferences JSON NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id)
);

-- User activity log
CREATE TABLE user_activity_log (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    activity_type VARCHAR(50) NOT NULL,
    activity_description TEXT NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_activity_type (activity_type),
    INDEX idx_created_at (created_at)
);

-- Remember tokens table (from login system)
CREATE TABLE remember_tokens (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    token VARCHAR(255) NOT NULL,
    expires_at TIMESTAMP NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_token (token),
    INDEX idx_expires (expires_at),
    INDEX idx_user_id (user_id)
);

-- Email verification tokens
CREATE TABLE email_verification_tokens (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    token VARCHAR(64) NOT NULL,
    expires_at TIMESTAMP NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    used_at TIMESTAMP NULL,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_token (token),
    INDEX idx_user_id (user_id)
);

-- Password reset tokens
CREATE TABLE password_reset_tokens (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    token VARCHAR(64) NOT NULL,
    expires_at TIMESTAMP NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    used_at TIMESTAMP NULL,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_token (token),
    INDEX idx_user_id (user_id)
);
*/
?>