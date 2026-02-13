<?php
include "db.php";
session_start();

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $submenuQuery = mysqli_query($conn, "SELECT * FROM menu WHERE ID=$id LIMIT 1");
    $submenu = mysqli_fetch_assoc($submenuQuery);

    if ($submenu) {
        $infoQuery = mysqli_query($conn, 
            "SELECT * FROM info WHERE info_tajuk='" . $submenu['ID'] . "' LIMIT 1"
        );
        $info = mysqli_fetch_assoc($infoQuery);
    }
}
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title><?php echo isset($submenu['menu_tajuk']) ? $submenu['menu_tajuk'] : 'Info Latihan'; ?></title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wdth,wght@0,75..100,300..800;1,75..100,300..800&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet"> 

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">


    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">    
</head>
<body class="bg-light" >
        <?php 
          $navbarClass = "navbar-light bg-white shadow"; // putih solid untuk helpdesk
          include "navbar_wrapper.php"; // kita guna wrapper baru
        ?>
    <div class="container py-4">
        <div class="container py-5">
            <?php if (!empty($info)) { ?>
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-5">
                        <h2 class="fw-bold mb-3 text-primary">
                            <?php echo isset($submenu['menu_tajuk']) ? htmlspecialchars($submenu['menu_tajuk']) : 'Info Latihan'; ?>
                        </h2>
                        <?php if (!empty($info['info_tarikh'])): ?>
                            <p class="text-muted small mb-4">
                                <i class="bi bi-calendar-event me-2"></i>
                                <?php echo date('d F Y', strtotime($info['info_tarikh'])); ?>
                            </p>
                        <?php endif; ?>

                        <div class="content fs-5 lh-lg text-secondary">
                            <?php 
                                // Papar kandungan sama ada dari HTML custom atau text biasa
                                if (!empty($info['info_html'])) {
                                    echo $info['info_html'];
                                } else {
                                    echo nl2br(htmlspecialchars($info['info_kandungan']));
                                }
                            ?>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <div class="alert alert-warning shadow-sm p-4 rounded-3 text-center">
                    <i class="bi bi-exclamation-triangle-fill text-warning fs-3 mb-2"></i><br>
                    <strong>Tiada maklumat ditemui.</strong>
                </div>
            <?php } ?>
        </div>
    </div>
    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>
</html>
