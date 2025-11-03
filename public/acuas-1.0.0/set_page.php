<?php
session_start();

if (isset($_GET['id']) && isset($_GET['page'])) {
    $_SESSION['selected_id'] = $_GET['id'];

    // Redirect ke page sebenar
    $page = $_GET['page'] . '.php';
    header("Location: $page");
    exit;
} else {
    header("Location: index.php");
    exit;
}
