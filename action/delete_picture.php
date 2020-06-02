<?php
    session_start();
    require_once '../config/conf.php';
    
    if (isset($_SESSION['user'])) {
        $uid = $_SESSION['user'];
    }

    //query and delete
    $path    = '../img/alice-img/';
    $query   = mysqli_query($conn, "SELECT user_photo FROM tb_user WHERE user_id = '$uid'");
    $result  = mysqli_fetch_row($query);
    $imgName = $result[0];

    //query default
    $query   = mysqli_query($conn, "UPDATE tb_user SET user_photo = 'avatar.png' WHERE user_id = '$uid'");
    
    if ($imgName != 'avatar.png') {
        unlink($path.$imgName);
    }

    if (!$query) {
        echo "<script>alert('gagal')</script>";
    } else {
        header("Location: ../?p=akun");
    }
?>