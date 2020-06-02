<?php
    session_start();
    include '../config/conf.php';

    $act = $_GET['act'];

    if (!isset($_SESSION['role']) || $_SESSION['role'] != 1) {
        die();
    }

    if ($act == 'add') {
        // if ($_POST) {
        //     $name = $_POST['courseName'];
        //     $sks  = $_POST['courseSKS'];

        //     $query = mysqli_query($conn, "INSERT INTO tb_course (course_name, course_sks) VALUES ('$name','$sks')");

        //     if (!$query) {
        //         echo "<script>alert('gagal')</script>";
        //     } else {
        //         header('Location: ../?p=admin&v=course');
        //     }
        // }
    } else if ($act == 'delete') {
        if (isset($_GET['id'])) {
            $uid  = $_GET['id'];
            $view = $_GET['v'];

            $query = mysqli_query($conn, "DELETE FROM tb_user WHERE user_id = '$uid'");

            if (!$query) {
                echo "<script>alert('gagal')</script>";
            } else {
                header("Location: ../?p=admin&v=$view");
            }
        }
    } else if ($act == 'update') {
        if ($_POST) {
            $uid    = $_POST['userId'];
            $name   = $_POST['userName'];
            $dob    = $_POST['userDate'];
            $role   = $_POST['userRole'];
            $view   = $_POST['userView'];

            if ($role == 2) {
                $address = $_POST['userAddress'];
                $phone   = $_POST['userPhone'];
                $office  = $_POST['userOffice'];
                $blog    = $_POST['userBlog'];
                $about   = $_POST['userAbout'];
                $info    = $_POST['userInfo'];
                $status  = $_POST['userStatus'];
            }

            $query = mysqli_query($conn, "UPDATE tb_user SET user_name = '$name', user_dob = '$dob' WHERE user_id = '$uid'");

            if ($role == 2) {
                $query_profile = mysqli_query($conn, "UPDATE tb_lecturer_profile 
                                                        SET profile_address = '$address',
                                                            profile_phone = '$phone',
                                                            profile_office = '$office',
                                                            profile_blog = '$blog',
                                                            profile_about = '$about',
                                                            profile_info = '$info',
                                                            profile_status = '$status'
                                                        WHERE profile_user = '$uid'");
            }

            if (!$query) {
                echo "<script>alert('gagal')</script>";
            } else {
                header("Location: ../?p=admin&v=$view");
            }
        }
    } else if ($act == 'verify') {
        if (isset($_GET['id'])) {
            $uid  = $_GET['id'];
            $view = $_GET['v'];

            $query = mysqli_query($conn, "UPDATE tb_user SET user_verified = '1' WHERE user_id = '$uid'");

            if (!$query) {
                echo "<script>alert('gagal')</script>";
            } else {
                header("Location: ../?p=admin&v=$view");
            }
        }
    } else if ($act == 'unverify') {
        if (isset($_GET['id'])) {
            $uid  = $_GET['id'];
            $view = $_GET['v'];

            $query = mysqli_query($conn, "UPDATE tb_user SET user_verified = '0' WHERE user_id = '$uid'");

            if (!$query) {
                echo "<script>alert('gagal')</script>";
            } else {
                header("Location: ../?p=admin&v=$view");
            }
        }
    }
?>