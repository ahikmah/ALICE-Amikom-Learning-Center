<?php
    $type = $_GET['type'];

    if ($type == 'notif') {
        $title = 'Pemberitahuan';
    } else if ($type == 'post') {
        $title = 'Postingan Forum';
    } else if ($type == 'post-course') {
        $title = 'Post: '.mysqli_fetch_array(mysqli_query($conn, "SELECT course_name FROM tb_course WHERE course_id = '$_GET[id]'"))[0];
    } else if ($type == 'material') {
        $title = 'Materi';
    } else if ($type == 'material-course') {
        $title = 'Materi: '.mysqli_fetch_array(mysqli_query($conn, "SELECT course_name FROM tb_course WHERE course_id = '$_GET[id]'"))[0];
    } 
?>
<div class="container">
    <div class="col-md-12">
        <h3 class="pt-4 mb-4"><?php echo $title; ?></h3>
        <div class="list-group-flush">
            <?php
                if ($type == 'notif') {
                    $query = mysqli_query($conn, "SELECT * FROM tb_notification n JOIN tb_user u ON n.notif_from_user = u.user_id LEFT JOIN tb_class c ON n.notif_class_id = c.class_id WHERE notif_for_user = '$_SESSION[user]' ORDER BY notif_date DESC");
                    while ($result = mysqli_fetch_array($query)) {
                        if ($result['notif_type'] == 'post') {
                            echo "<div class='list-group-item'><a class='text-secondary' href='?p=class&id=$result[class_id]&view=post&pid=$result[notif_class_post]'>";
                            echo '<b>'.strstr($result['user_name'], ' ', true).'</b> memposting di <b>'.$result['class_name'].'</b> - <span style="opacity:0.75">'.date('d/m/Y', strtotime($result['notif_date'])).'</span>';
                            echo "</a></div>";
                        } else if ($result['notif_type'] == 'comment_class') {
                            echo "<div class='list-group-item'><a class='text-secondary' href='?p=class&id=$result[class_id]&view=post&pid=$result[notif_class_post]'>";
                            echo '<b>'.strstr($result['user_name'], ' ', true).'</b> mengomentari post anda di <b>'.$result['class_name'].'</b> - <span style="opacity:0.75">'.date('d/m/Y', strtotime($result['notif_date'])).'</span>';
                            echo "</a></div>";
                        } else if ($result['notif_type'] == 'comment_forum') {
                            $subject = mysqli_fetch_array(mysqli_query($conn, "SELECT post_subject FROM tb_forum_post WHERE post_id = '$result[notif_forum_post]'"))[0];
                            echo "<div class='list-group-item'><a class='text-secondary' href='?p=forum&id=$result[notif_forum_post]'>";
                            echo '<b>'.strstr($result['user_name'], ' ', true).'</b> mengomentari post anda di <b>'.$subject.'</b> - <span style="opacity:0.75">'.date('d/m/Y', strtotime($result['notif_date'])).'</span>';
                            echo "</a></div>";
                        }
                    }    
                } else if ($type == 'post') {
                    $query = mysqli_query($conn, "SELECT * FROM tb_forum_post JOIN tb_course ON post_course = course_id ORDER BY post_date DESC");
                    while ($result = mysqli_fetch_array($query)) {
                        echo "<div class='list-group-item'><a class='text-secondary' href='?p=forum&id=$result[post_id]'>";
                        echo '<b>'.$result['post_subject'].'</b> - <i>'.$result['course_name'].'</i> - <span style="opacity:0.75">'.date('d/m/Y', strtotime($result['post_date'])).'</span>';
                        echo "</a></div>";
                    }
                } else if ($type == 'post-course') {
                    $query = mysqli_query($conn, "SELECT * FROM tb_forum_post JOIN tb_course ON post_course = course_id WHERE post_course = '$_GET[id]' ORDER BY post_date DESC");
                    while ($result = mysqli_fetch_array($query)) {
                        echo "<div class='list-group-item'><a class='text-secondary' href='?p=forum&id=$result[post_id]'>";
                        echo '<b>'.$result['post_subject'].'</b> - <i>'.$result['course_name'].'</i> - <span style="opacity:0.75">'.date('d/m/Y', strtotime($result['post_date'])).'</span>';
                        echo "</a></div>";
                    }
                } else if ($type == 'material') {
                    $query = mysqli_query($conn, "SELECT * FROM tb_material JOIN tb_course ON material_course = course_id ORDER BY material_date DESC");
                    while ($result = mysqli_fetch_array($query)) {
                        echo "<div class='list-group-item'><a class='text-secondary' href='?p=materi-post&id=$result[material_id]'>";
                        echo '<b>'.$result['material_subject'].'</b> - <i>'.$result['course_name'].'</i> - <span style="opacity:0.75">'.date('d/m/Y', strtotime($result['material_date'])).'</span>';
                        echo "</a></div>";
                    }
                } else if ($type == 'material-course') {
                    $query = mysqli_query($conn, "SELECT * FROM tb_material JOIN tb_course ON material_course = course_id WHERE material_course = '$_GET[id]' ORDER BY material_date DESC");
                    while ($result = mysqli_fetch_array($query)) {
                        echo "<div class='list-group-item'><a class='text-secondary' href='?p=materi-post&id=$result[material_id]'>";
                        echo '<b>'.$result['material_subject'].'</b> - <i>'.$result['course_name'].'</i> - <span style="opacity:0.75">'.date('d/m/Y', strtotime($result['material_date'])).'</span>';
                        echo "</a></div>";
                    }
                }
            ?>
        </div>
    </div>
</div>