<?php
session_start();
require_once '../config/conf.php';


if (isset($_POST['ganti_pass'])){

    $id = $_SESSION['user'];
    $newpass = $_POST['pwnew'];
    $newpass2 = $_POST['pwnew2'];

    if ($newpass != $newpass2){
        $_SESSION['error_pass'] = "*Kata sandi salah";
        header("Location: ../?p=akun");
    } else { $sql = mysqli_query($conn,"UPDATE tb_user SET user_password = md5('$newpass') WHERE user_id = '$id'");} 
}

if ($sql) {
    header("Location: ../?p=akun");
}
?>