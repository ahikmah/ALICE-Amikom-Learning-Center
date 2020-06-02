<?php 
session_start();
require_once '../config/conf.php';

$id = addslashes($_POST['userID']);
$pass = addslashes(md5($_POST['userPass']));

//menyeleksi data dengan username dan password yang sesuai
$data = mysqli_query($conn,"SELECT * FROM tb_user WHERE user_id='$id' && user_password='$pass'");

//menghitung jumlah data yang ditemukan
$cek = mysqli_num_rows($data);
$ambil = mysqli_fetch_array($data);

if($cek > 0){
    $_SESSION['user'] = $id ;
    $_SESSION['fname'] = $ambil['user_name'];
    $_SESSION['email'] = $ambil['user_email'];
    $_SESSION['activate'] = base64_encode($ambil['user_password']); //email verification
    $_SESSION['role'] = $ambil['user_role'];  
    $_SESSION['user_photo'] = $ambil['user_photo'];

    $query = mysqli_query($conn, "INSERT INTO tb_visit (visit_id) VALUES ('$id')");

    if ($ambil['user_verified'] == 0) {
        $_SESSION['login'] = false ;
        $_SESSION['user_verified'] = $ambil['user_verified'];
        header('Location: ../?p=landing#login');
    } else {
        $_SESSION['login'] = true ;
        if ($ambil['userRole'] == 1) {
            header('Location: ../?p=admin');
        } else {
            header('Location: ../?p=home');
        }
    }
} else {
    $_SESSION['login_failed'] = true;
    header('Location: ../?p=landing#login');
}
?>