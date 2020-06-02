<?php
    session_start();
    require_once '../config/conf.php';

    if (isset($_SESSION['user'])) {
        $uid = $_SESSION['user'];
    }

    //upload.php
    $path = '../img/alice-img/';

    if(isset($_POST["image"]))
    {
        $data = $_POST["image"];

        $image_array_1 = explode(";", $data);

        $image_array_2 = explode(",", $image_array_1[1]);

        $data = base64_decode($image_array_2[1]);

        $imageName = $uid . '_' . time() . '.png';

        //query and delete 
        $query   = mysqli_query($conn, "SELECT user_photo FROM tb_user WHERE user_id = '$uid'");
        $result  = mysqli_fetch_row($query);
        $imgName = $result[0];
        
        if ($imgName != 'avatar.png') {
            unlink($path.$imgName);
        }

        file_put_contents($path.$imageName, $data);

        //query
        $query = mysqli_query($conn, "UPDATE tb_user SET user_photo = '$imageName' WHERE user_id = '$uid'");

        if (!$query) {
            echo "<script>alert('gagal')</script>";
        } 
    }

?>