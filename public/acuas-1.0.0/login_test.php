<?php
// include config / db connection
require_once 'db.php';

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    // Kalau tak login, redirect ke login page
    header('Location: login.php');
    exit;
}

// Kalau ada session, teruskan load page
?>
<!DOCTYPE html>
<html>
<head>
    <title>Private Page</title>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    <p>This page is only accessible after login.</p>
</body>
</html>
