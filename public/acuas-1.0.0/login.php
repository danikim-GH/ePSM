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

    //user after success login
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];

    //declare to assign value ip and agent
    $ip= $_SERVER['REMOTE_ADDR']??'';
    $agent = $_SERVER['HTTP_USER_AGENT']??'';

    $logstmt = $conn->prepare(
        "INSERT INTO user_activity_log
                (user_id, activity_type, activity_description, ip_address, user_agent, created_at)
                VALUES (:user_id, :type, :desc, :ip, :agent, NOW())"
    );

    $logstmt->execute([
        ':user_id' =>$user['id'],
        ':type' => 'login',
        ':desc' => 'user successful login',
        ':ip' => $ip,
        ':agent' => $agent
    ]);

    echo json_encode([
        "success" => true,
        "message" => "Login successful",
        "redirect" => "index.php"
    ]);

} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => "Server error: " . $e->getMessage()
    ]);
}
