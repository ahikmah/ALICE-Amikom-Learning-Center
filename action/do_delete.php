<?php
    session_start();
    require_once '../config/conf.php';

      $id = $_SESSION['user'];
      $sql = mysqli_query($conn,"DELETE FROM tb_user where user_id = '$id'");
      if ($sql){
      session_destroy();
      header('Location: ../?p=landing');}

?>