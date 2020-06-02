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

            $query = mysqli_query($conn, "DELETE FROM tb_class WHERE class_id = '$uid'");

            if (!$query) {
                echo "<script>alert('gagal')</script>";
            } else {
                header("Location: ../?p=admin&v=$view");
            }
        }
    } else if ($act == 'suspend') {
        if (isset($_GET['id'])) {
            $uid  = $_GET['id'];
            $view = $_GET['v'];

            $query = mysqli_query($conn, "UPDATE tb_class SET class_suspended = '1' WHERE class_id = '$uid'");

            if (!$query) {
                echo "<script>alert('gagal')</script>";
            } else {
                header("Location: ../?p=admin&v=$view");
            }
        }
    } else if ($act == 'unsuspend') {
        if (isset($_GET['id'])) {
            $uid  = $_GET['id'];
            $view = $_GET['v'];

            $query = mysqli_query($conn, "UPDATE tb_class SET class_suspended = '0' WHERE class_id = '$uid'");

            if (!$query) {
                echo "<script>alert('gagal')</script>";
            } else {
                header("Location: ../?p=admin&v=$view");
            }
        }
    } 
?>