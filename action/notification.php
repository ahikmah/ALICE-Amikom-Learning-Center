<?php
    include '../config/conf.php';
    if ($_POST) {
        $uid = $_POST['userID'];

        mysqli_query($conn, "UPDATE tb_notification SET notif_status = '1' WHERE notif_for_user = '$uid'");
    }
?>