<?php
include "db.php"; 


// Ambil user level id
$user_id = $_SESSION['user_id'];
$queryUser = mysqli_query($conn, "SELECT user_level_id FROM users WHERE id = '$user_id'");
$user = mysqli_fetch_assoc($queryUser);
$user_level = $user['user_level_id'];

 

// Ambil MAIN MENU ikut level user
 
$mainMenu = mysqli_query($conn, 
    "SELECT * FROM menu 
     WHERE menu_level = 1 
     AND FIND_IN_SET('$user_level', userlevel)
     ORDER BY menu_sort ASC");

while ($menu = mysqli_fetch_assoc($mainMenu)) {

     

    // MENU DENGAN SUBMENU KHAS
    $submenu = null;     


    // Info Latihan
    if ($menu['menu_tajuk'] == 'Info Latihan') {
        $submenu = mysqli_query($conn, 
            "SELECT * FROM menu 
             WHERE menu_level = 2 
             AND menu_arah = 'info'
             AND FIND_IN_SET('$user_level', userlevel)
             ORDER BY menu_sort ASC");
    }

    // Pustaka
    else if ($menu['menu_tajuk'] == 'Pustaka') {
        $submenu = mysqli_query($conn, 
            "SELECT * FROM menu 
             WHERE menu_level = 2 
             AND menu_arah = 'pustaka'
             AND FIND_IN_SET('$user_level', userlevel)
             ORDER BY menu_sort ASC");
    }

    // Direktori
    else if ($menu['menu_tajuk'] == 'Direktori') {
        $submenu = mysqli_query($conn, 
            "SELECT * FROM menu 
             WHERE menu_level = 2 
             AND menu_arah = 'direktori'
             AND FIND_IN_SET('$user_level', userlevel)
             ORDER BY menu_sort ASC");
    }

    // Kalau menu ada submenu
    if (isset($submenu) && mysqli_num_rows($submenu) > 0) {
        echo '<div class="nav-item dropdown">';
        echo '<a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">' . $menu['menu_tajuk'] . '</a>';
        echo '<div class="dropdown-menu m-0">';
        while ($sub = mysqli_fetch_assoc($submenu)) {
            // Link ikut jenis submenu
            $link = ($menu['menu_tajuk'] == 'Info Latihan') ? "info.php?id={$sub['ID']}" :
                    (($menu['menu_tajuk'] == 'Pustaka') ? "pustaka.php?idmenu={$sub['ID']}" :
                    (($menu['menu_tajuk'] == 'Direktori') ? "direktori.php?id={$sub['ID']}" : '#'));
            echo '<a href="'.$link.'" class="dropdown-item">'.$sub['menu_tajuk'].'</a>';
        }
        echo '</div></div>';
        unset($submenu); // reset untuk elak carry over
    }

     

    // MENU TANPA SUB
     

    else if ($menu['menu_tajuk'] == 'Helpdesk') {
      echo '<a href="helpdesk.php" class="nav-item nav-link">'.$menu['menu_tajuk'].'</a>';
    } 
    else if($menu['menu_tajuk'] == 'User'){
      echo '<a href="logout.php" class="nav-item nav-link">'.$menu['menu_tajuk'].'</a>';
    }
    else if($menu['menu_tajuk'] == 'Home'){
      echo '<a href="index.php" class="nav-item nav-link">'.$menu['menu_tajuk'].'</a>';
    }
    else if($menu['menu_tajuk'] == 'Galeri'){
      echo '<a href="galeri.php" class="nav-item nav-link">'.$menu['menu_tajuk'].'</a>';
    }
    else {
        $link = ($menu['menu_url'] == '-' || empty($menu['menu_url'])) ? "#" : $menu['menu_url'];
        echo '<a href="'.$link.'" class="nav-item nav-link">'.$menu['menu_tajuk'].'</a>';
    }
}
?>


<!-- Profile Modal -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-3 shadow">
      
      <!-- Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="profileModalLabel">User Profile</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Body -->
      <div class="modal-body text-center">
        <img src="<?php //echo $_SESSION['avatar']; ?>" alt="User Avatar" class="rounded-circle mb-3" width="100" height="100">
        <h5 class="mb-1"><?php echo $_SESSION['username']; ?></h5>
        <p class="text-muted mb-2"><?php echo $_SESSION['email']; ?></p>
        <p class="mb-2"><i class="fa fa-phone me-2"></i><?php echo $_SESSION['phone']; ?></p>
      </div>

      <!-- Footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <a href="logout.php" class="btn btn-danger">Logout</a>
      </div>

    </div>
  </div>
</div>
