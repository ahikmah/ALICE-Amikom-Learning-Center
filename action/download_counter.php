<?php
    session_start();
    require_once '../config/conf.php';

    if (isset($_POST['material_id'])) {
        $material_id = $_POST['material_id'];
        $material_user = $_POST['material_user'];

        $query = mysqli_query($conn, "INSERT INTO tb_material_downloaded (material_id, material_user) VALUES ('$material_id', '$material_user') ON DUPLICATE KEY UPDATE material_date = CURRENT_TIMESTAMP");
    }
?>