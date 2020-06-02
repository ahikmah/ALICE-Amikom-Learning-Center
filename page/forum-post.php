<?php
        require_once 'config/conf.php';
        $post_id = $_GET['id'];
        $query  = mysqli_query($conn, "SELECT tb_forum_post.post_course, tb_forum_post.post_user, tb_forum_post.post_subject, tb_forum_post.post_content, tb_forum_post.post_date, tb_course.course_name, post_view, user_name, course_id FROM tb_forum_post JOIN tb_course ON tb_forum_post.post_course = tb_course.course_id JOIN tb_user ON user_id = post_user WHERE post_id = '$post_id'");
        $result = mysqli_fetch_array($query);
        $user_id = $result['post_user'];
        $subject= $result['post_subject'];
        $content= $result['post_content'];
        $course = $result['course_name'];
        $course_id = $result['course_id'];
        $post_date = $result['post_date']; 
        $n_view = $result['post_view'];
        $n_comment = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tb_forum_comment WHERE comment_post = $post_id"));
        
        mysqli_query($conn, "UPDATE tb_forum_post SET post_view = post_view + 1 WHERE post_id = '$post_id'");
?>


<!-- Main news -->
<div class="col-xl-12 col-md-12">
    <!-- Post -->
    <div class="row mt-2 mb-5 pb-3 mx-2">
        <!-- Card -->
        <div class="card card-body mb-5">
            <div class="post-data mb-4">
                <div class="row justify-content-between">
                    <div class="col-md-4 mb-3">
                        <p class="font-small dark-grey-text mb-1">
                            <strong>Penulis: </strong><?php echo $result['user_name']; ?></p>
                        <p class="font-small grey-text">
                            <strong>Pada tanggal </strong><?php echo $post_date; ?></p>
                        <a href="?p=list&type=post-course&id=<?php echo $course_id;?>">
                            <span class="badge badge-danger"><?php echo $course; ?></span>
                        </a>
                    </div>
                    <?php
                        if ($_SESSION['user'] == $result['post_user']) {
                            ?>
                                <div class="col-md-4">
                                    <!-- Basic dropdown -->
                                    <a class="dropdown-toggle float-right m-0 alice-dropdown" type="button" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-h" style="font-size:20px;"></i></a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="alice-dropdown">
                                        <a class="dropdown-item" href="?p=forum-form&id=<?php echo $post_id; ?>&act=update">Edit</a>
                                        <a class="dropdown-item" href="action/delete_thread.php?id=<?php echo $post_id; ?>" onclick="javascript: return confirm('Yakin Hapus?')" >Hapus</a>

                                    </div>
                                    <!-- Basic dropdown -->
                                </div>
                            <?php
                        }
                    ?>
                </div>
            </div>
            <!-- Title -->
            <h2 class="font-weight-bold">
            <strong><?php echo $subject; ?></strong>
            </h2>
            <hr class="red title-hr">
            <!-- Title -->
            
            <!-- Grid row -->
            <div class="row">
                <!-- Grid column -->
                <div class="col-md-8 mt-2">
                    <div class="row justify-content-between">
                        <div class="col-md-6">
                            <h6 class="font-weight-bold dark-grey-text">
                                <i class="far fa-lg fa-newspaper mr-2 dark-grey-text"></i>
                                <strong><?php echo $n_view;?></strong> Dibaca
                            </h6>
                        </div>
                        <div class="col-md-6">
                            <h6 class="font-weight-bold dark-grey-text">
                                <i class="far fa-lg fa-comment-alt mr-2 dark-grey-text"></i>
                                <strong><?php echo $n_comment;?></strong> Komentar
                            </h6>
                        </div>
                    </div>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-6 d-flex justify-content-end">
                    <!-- like dislike (not yet implemented) -->
                </div>
                <!-- Grid column -->
            </div>
            <!-- Grid row -->

            <hr>

            <!-- Grid row -->
            <div class="row mx-md-4 px-4 mt-3">
                <p class="dark-grey-text article" align="justify"><?php echo $content; ?></p>
            
            </div>
            <!-- Grid row -->
            <hr>
            <div class="row px-4">
                <h4>Komentar</h4>
                <form action="action/add_comment.php" method="post" class="col-md-12">
                   <input type="text" name="userID" value="<?php echo $_SESSION['user'];?>" hidden>
                    <input type="text" name="postID" value="<?php echo $_GET['id'];?>" hidden>
                                        <div class="form-group purple-border mt-2 mb-1">
                                            <textarea class="form-control" name="commentContent" rows="3" placeholder="Tulis komentar..." required></textarea>
                                        </div>
                                        <input class="btn btn-secondary btn-sm mx-0 my-1" type="submit" value="Kirim">
             </form>
            </div>
            <hr>

            <?php 
                    $sql =  "SELECT tb_forum_post.post_id, tb_forum_comment.comment_id, tb_forum_comment.comment_post, tb_forum_comment.comment_user, tb_forum_comment.comment_content, tb_forum_comment.comment_date, user_name, user_photo from tb_forum_post JOIN tb_forum_comment on tb_forum_post.post_id = tb_forum_comment.comment_post JOIN tb_user ON user_id = comment_user where post_id = $post_id";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                                        // output data of each row
                                        while($row = mysqli_fetch_array($result)) {
                                            //var_dump($row);
                    ?>
                        <div class="row px-4">
                            <!-- Comments -->
                            <div class="d-flex p-2 align-items-start">
                                <div class="flex-shrink-1 mr-3">
                                    <div class="view overlay">
                                        <img src="img/alice-img/<?php echo $row['user_photo'];?>" class="rounded-circle img-fluid alice-avatar"
                                            alt="Avatar">
                                        <a>
                                            <div class="mask rgba-white-slight"></div>
                                        </a>
                                    </div>
                                </div>
                                <div class="w-100">
                                    <h6 class="h6 mb-0"> <?php echo $row['user_name']; ?>
                                        <span class="text-black-50 ml-2 font-small"><?php echo $row[5]; ?></span>
                                        <?php
                                            $uid = $_SESSION['user'];
                                            if ($uid == $row['comment_user'])                                                                 
                                                echo "<a href='action/_formpost.php?act=delete-comment&id=$row[1]&post=$post_id&user=$uid' class='text-danger font-small'>Hapus</a>";  
                                        ?>
                                    </h6>
                                    <p class="dark-grey-text article mb-0"><?php echo $row[4]; ?></p>
                                </div>
                            </div>
                            <!-- Comments -->
                        </div>

                        <hr>
                    <?php
                }
                }    
            ?>
        </div>
    </div>
</div>
<!-- Main news -->