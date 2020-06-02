<?php
    include '../config/conf.php';

    $data = mysqli_query($conn,"SELECT * FROM tb_material");
    $ambil = mysqli_fetch_array($data);
    session_start();
    $_SESSION['material_id'] = $ambil['material_id'] ;


    $user   = $_POST['materiUser'];
    $subject= $_POST['materiName'];
    $course = $_POST['course'];
    $content= $_POST['materiContent'];
    $button = $_POST['button'];

    $nama_file = $_FILES["materiFile"]["name"];
    move_uploaded_file($_FILES["materiFile"]["tmp_name"],"../filemateri/".$nama_file);


    if($button == "TAMBAH") {
        mysqli_query($conn, "INSERT INTO tb_material (material_course, material_user, material_subject, material_content, material_attachment) VALUES ('$course', '$user','$subject','$content', '$nama_file')");
        header('Location: ../?p=materi');
    }
    else if($button == "SIMPAN") {
        $materi_id=$_GET['materi_id'];
        mysqli_query($conn, "UPDATE tb_material SET material_course='$course', material_user='$user', material_subject='$subject', material_content='$content', material_attachment='$nama_file' WHERE material_id='$materi_id'");
        header('Location: ../?p=materi');
    }

        
?>