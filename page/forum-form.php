<?php
    if (isset($_GET['act'])){
        $act = $_GET['act'];
    } else {
        die();
    }

    if ($act == 'add') {
        $id     = '';
        $user   = $_SESSION['user'];
        $subject= '';
        $content= '';
        $course = '';
        $button = 'Post';
        $title  = 'Buat Post Baru';
    } elseif ($act == 'update') {
        $post_id = $_GET['id'];
        $query = mysqli_query($conn, "SELECT post_course, post_user, post_subject, post_content, post_date FROM tb_forum_post 
       JOIN tb_course ON tb_forum_post.post_course = tb_course.course_id WHERE post_id = '$post_id'");
        $row = mysqli_fetch_array($query);
        $title = 'Edit Post';
        $button = 'SIMPAN';
       
        $user = $_SESSION['user'];
        $subject = $row ['post_subject'];
        $content = $row ['post_content'];
        $course = $row ['post_course'];
        $date = $row ['post_date'];
        //var_dump($row);
    }


?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="jumbotron">
                <h2 class="display-6"><?php echo $title; ?></h2>
                <hr class="my-4">
                <!-- Form action -->
                <form action="action/_formpost.php?act=<?php echo $act; ?>" method="post">
                <!-- Body -->
                    <!-- Material input -->
                    <?php
                        if ($act == 'update') {
                            echo '<input type="hidden" name="post_id" value="'.$post_id.'">';
                        }
                    ?>
                    <div class="md-form">
                        <input type="text" id="postFormTitle" name="postName" value="<?php echo $subject;?>" class="form-control" required>
                        <label for="postFormTitle">Judul post</label>
                    </div>
                    <!--Message-->
                    <div class="md-form">
                        <textarea id="postFormContent" name="postContent" class="form-control md-textarea" rows="3" required><?php echo $content; ?></textarea>
                        <label for="postFormContent">Isi post</label>
                    </div>
                    <!--Blue select-->
                    <select class="mdb-select mt-3 w-50" name="course" searchable="Cari Mata Kuliah" required>
                        <option value="0" disabled <?php if ($act == 'add' or 'update') echo 'selected'; ?>>Pilih Mata Kuliah</option>
                        <!-- Dynamic Course List -->
                        <?php
                            $query  = mysqli_query($conn, "SELECT course_id, course_name FROM tb_course ORDER BY course_name ASC");
                            while ($result = mysqli_fetch_array($query)) {
                                echo "<option value='$result[0]'";
                                if ($act == 'update' && $sks = 2) 
                                    echo 'selected';
                                echo ">$result[1]</option>";
                            }
                        ?>
                    </select>
                    <input type="text" name="postUser" value="<?php echo $user; ?>" hidden>
                    <!-- Body -->
                    <div class="float-right mt-4">
                        <a href="?p=forum"><button type="button" class="btn btn-md btn-danger">Batal</button></a>
                        <button type="submit" name = "button" class="btn btn-md btn-success"><?php echo $button; ?></button>
                    </div>
                </form>
                <div class="m-5"></div>
            </div>      
        </div>
    </div>
</div>
