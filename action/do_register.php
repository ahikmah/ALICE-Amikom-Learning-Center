<?php
session_start();
require_once '../config/conf.php';


if ($_POST){
    $_SESSION['register_success'] = false;
    
    $id = $_POST['id'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $ulangi_pass = $_POST['ulangi_pass'];
    $fname = $_POST['fname'];
    $date = $_POST['date'];
    $gender = $_POST['gender'];


    if ($_POST['userRole']=='mahasiswa'){
        $role = 3;
    } else if ($_POST['userRole']=='dosen'){
        $role = 2;
    } 

    if ($pass != $ulangi_pass) {
        $_SESSION['error_pass'] = "*Kata sandi salah";
        header('Location: ../?p=register&u='.$_POST['userRole']);
    } 
    else {
        $sql = "INSERT INTO tb_user (user_id, user_email, user_password, user_name, user_dob , user_gender,user_role) 
        VALUES ('$id','$email',md5('$pass'),'$fname','$date','$gender','$role')";
        
        $simpan = mysqli_query($conn,$sql); 

        if ($simpan) {
            $_SESSION['user'] = $id;
            $_SESSION['fname'] = $fname;
            $_SESSION['email'] = $email; 
            $_SESSION['activate'] = base64_encode(md5($pass)); //email verification
            require_once 'sendmail.php';
    
            $_SESSION['register_success'] = true;
            header('Location: ../?p=register&u='.$_POST['userRole']);
            //echo "<script>location.replace('../?p=register&u=".$_POST['userRole']."')</script>";
        } 
        else 
        { echo "GUAGAL COY"; 
            $sql;
        } 
    }     
}
?>