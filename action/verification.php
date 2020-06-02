<?php
    require_once '../config/conf.php';

    if ($_GET) {
        $uid = $_GET['id'];
        $activate = base64_decode($_GET['activate']);

        $query  = mysqli_query($conn, "SELECT user_name, user_id, user_password FROM tb_user WHERE user_id = '$uid' && user_password = '$activate'");
        $exist  = mysqli_num_rows($query);
        $result = mysqli_fetch_array($query);

        echo $exist;
        die();
        if ($exist > 0) {
            $query = mysqli_query($conn, "UPDATE tb_user SET user_verified = '1' WHERE user_id = '$result[1]' && user_password = '$result[2]'");
            if ($query) {
                echo 'Selamat, '.$result[0];
                echo '<br />';
                echo 'Akun anda telah aktif';
            }
        }
    }
?>