<?php
$conn = new mysqli("localhost", "root", "", "website_project");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// contoh ambil ikut info_tajuk atau ID
$id = 1; // boleh datang dari $_GET['id']
$sql = "SELECT info_html FROM info WHERE ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    // Terus echo content HTML yang tersimpan
    echo $row['info_html'];
} else {
    echo "<p>Tiada maklumat ditemui.</p>";
}
?>