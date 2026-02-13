<?php
include "db.php";
$menuID = $_GET['id'] ?? null;

$query = "SELECT * FROM direktori WHERE dir_papar='Y'";
if ($menuID) {
    $query .= " AND dir_idmenu='$menuID'";
}
$query .= " ORDER BY dir_nama ASC";

$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    echo "<div class='card'>";
    echo "<img src='uploads/direktori/{$row['dir_gambar']}' alt='{$row['dir_nama']}' class='card-img-top'>";
    echo "<div class='card-body'>";
    echo "<h5>{$row['dir_nama']}</h5>";
    echo "<p>{$row['dir_jawatan']} ({$row['dir_gred']})</p>";
    echo "<p>Tel: {$row['dir_tel']}</p>";
    echo "<p>Email: <a href='mailto:{$row['dir_emel']}'>{$row['dir_emel']}</a></p>";
    echo "</div>";
    echo "</div>";
}
?>
