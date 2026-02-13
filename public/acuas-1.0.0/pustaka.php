<?php
include "db.php";

if (isset($_GET['idmenu'])) {
    $idmenu = intval($_GET['idmenu']);

    // ambil semua data pustaka ikut pus_idmenu
    $result = mysqli_query($conn, "SELECT * FROM pustaka WHERE pus_idmenu = '$idmenu' ORDER BY pus_tarikh DESC");
} else {
    die("ID menu tak sah!");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pustaka</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
    <h2 class="mb-4">Senarai Pustaka</h2>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Tajuk</th>
                <th>Ringkasan</th>
                <th>Pengarang</th>
                <th>Tarikh</th>
                <th>Fail</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['pus_tajuk']; ?></td>
                    <td><?php echo $row['pus_ringkasan']; ?></td>
                    <td><?php echo $row['pus_pengarang']; ?></td>
                    <td><?php echo date("d-m-Y", strtotime($row['pus_tarikh'])); ?></td>
                    <td>
                        <?php if (!empty($row['pus_fail'])) { ?>
                            <a href="uploads/<?php echo $row['pus_fail']; ?>" target="_blank">Muat Turun</a>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
