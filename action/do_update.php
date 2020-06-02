<?php
session_start();
require_once '../config/conf.php';

if (isset($_POST['submit'])){

$id = $_SESSION['user'];
$role = $_SESSION['role'];
$fname = $_POST['fname'];
$email = $_POST['email'];
$date = $_POST['date'];

if ($role == 2) {
    $address = $_POST['address'];
    $office =  $_POST['office'];
    $phone = $_POST['phone'];
    $blog = $_POST['blog'];
    $about = $_POST['about'];
    $info = $_POST['info'];
}

$sql = mysqli_query($conn,"UPDATE tb_user SET user_name = '$fname' , user_email = '$email' , user_dob = '$date' WHERE user_id = '$id'");

if ($role == 2) { 
    $sql_dsn = mysqli_query($conn,"UPDATE tb_lecturer_profile SET 
    profile_address = '$address',
    profile_phone = '$phone',
    profile_office = '$office',
    profile_blog = '$blog',
    profile_about = '$about',
    profile_info = '$info'
    WHERE profile_user = '$id'");}

} 

if ($sql OR $sql_dsn) {
    header("Location: ../?p=akun");
}
?>