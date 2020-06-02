<?php
    session_start();
    include '../config/conf.php';

    $act = $_GET['act'];

    if (!isset($_SESSION['role']) || $_SESSION['role'] != 1) {
        die();
    }

    if ($act == 'delete') {
        if (isset($_GET['id'])) {
            $uid  = $_GET['id'];
            $view = $_GET['v'];

            if ($view == 'post-forum') {
                $table = 'tb_forum_post';
            } else if ($view == 'post-material') {
                $table = 'tb_material';
            }

            $query = mysqli_query($conn, "DELETE FROM $table WHERE post_id = '$uid'");

            if (!$query) {
                echo "<script>alert('gagal')</script>";
            } else {
                header("Location: ../?p=admin&v=$view");
            }
        }
    } else if ($act == 'update') {
        // if ($_POST) {
        //     $id   = $_POST['courseID'];
        //     $name = $_POST['courseName'];
        //     $sks  = $_POST['courseSKS'];

        //     $query = mysqli_query($conn, "UPDATE tb_course SET course_name = '$name', course_sks = '$sks' WHERE course_id = $id");

        //     if (!$query) {
        //         echo "<script>alert('gagal')</script>";
        //     } else {
        //         header('Location: ../?p=admin&v=course');
        //     }
        // }
    } 
?>