<?php
include "db.php";

if (!isset($_GET['id'])) {
    die("Info tidak sah!");
}

$id = intval($_GET['id']);
$data = mysqli_query($conn, "SELECT * FROM info WHERE ID='$id'");
$info = mysqli_fetch_assoc($data);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $info['info_tajuk']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
    <h2><?php echo $info['info_tajuk']; ?></h2>
    <p><small><?php echo date("d-m-Y", strtotime($info['info_daftar'])); ?></small></p>
    <hr>
    <div>
        <?php echo $info['info_html']; ?>
    </div>
</body>
</html>
