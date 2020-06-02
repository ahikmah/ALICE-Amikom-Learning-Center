<?php
ob_start();
    include '../config/conf.php';
    mysqli_query($conn, "DELETE FROM tb_forum_post WHERE post_id='$_GET[id]'");
    {
    	echo '<script language="javascript">
    	alert ("Thread dihapus");
    	window.location="../?p=forum";
    	</script>';
    	exit();
    }
 //    $pid = $_GET['post_id'];

	// $sql = mysqli_query($conn,"DELETE FROM tb_forum_post WHERE post_id='$pid'");

	// var_dump($sql);
	// //or die(mysqli_error());
	// header("Location: ../?p=forum");
?>