<?php
header('Content-Type: application/json');
session_start();

require_once "db_pdo.php"; // pastikan file ni define $conn (PDO)

$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');

if ($username === '' || $password === '') {
    echo json_encode([
        "success" => false,
        "message" => "All fields are required"
    ]);
    exit;
}

try {
    $stmt = $conn->prepare("SELECT id, username, password_hash FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        echo json_encode([
            "success" => false,
            "message" => "Invalid username or password"
        ]);
        exit;
    }
    
    if (!password_verify($password, $user['password_hash'])) {
        echo json_encode([
            "success" => false,
            "message" => "Invalid username or password"
        ]);
        exit;
    }

    //login mandatory fields
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];

    //track user activity
    
    echo json_encode([
        "success" => true,
        "message" => "Login successful",
        "redirect" => "nigga.html"
    ]);

} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => "Server error: " . $e->getMessage()
    ]);
}
