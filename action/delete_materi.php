<?php
    require '../config/conf.php';
      $sql = mysqli_query($conn, "DELETE FROM tb_material where material_id = $_GET[id]");
      if ($sql) {
      header("Location: ../?p=materi");
      }else{
        echo "error";
      }
?>