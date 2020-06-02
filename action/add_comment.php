<?php
    include '../config/conf.php';
            $user_id = $_POST['userID'];
            $post_id = $_POST['postID'];
            $content = $_POST['commentContent'];

            $query = mysqli_query($conn, "INSERT INTO tb_forum_comment (comment_post, comment_user, comment_content) VALUES ('$post_id','$user_id','$content')");

            var_dump($comment_content);

            //header("Location: ../?p=forum-post&id='.$post_id");
            if (!$query) {
              echo "<script>alert('data tidak tersimpan')</script>";
              header('Location: ../?p=forum');
            } else {
              $last_post = mysqli_insert_id($conn);
              header('Location: ../?p=forum&id='.$post_id);
            }
        
?>