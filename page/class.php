<?php
    if (!isset($_GET['id'])){
        echo "<script>window.location='?p=classroom'</script>";
    } else {
        $cid = $_GET['id'];
    }

    if (!isset($_GET['view'])) {
        $view = 'home';
    } else {
        $view = $_GET['view'];
    }

    if (!isset($_GET['pid'])) {
        $pid = '';
    } else {
        $pid = $_GET['pid'];
    }

    $suspended = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tb_class WHERE class_id = '$cid' AND class_suspended = '1'"));
    if ($suspended > 0) {
        $_SESSION['class_suspended'] = true;
        echo "<script>window.location = 'http://$host$uri?p=classroom'</script>";
    }

    $class            = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_class JOIN tb_course ON class_course = course_id WHERE class_id = '$cid'"));
    $lecturer         = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_user JOIN tb_lecturer_profile ON user_id = profile_user WHERE user_id = '$class[class_lecturer]'"));
    $member           = mysqli_query($conn, "SELECT u.user_id, user_name, user_photo FROM tb_user u JOIN tb_class_member m ON u.user_id = m.user_id WHERE m.class_id = '$cid' ORDER BY u.user_id ASC");
    $assignment       = mysqli_query($conn, "SELECT * FROM tb_class_post WHERE post_is_assignment = '1' AND post_class_id = '$cid' ORDER BY post_date DESC");
    $classPost        = mysqli_query($conn, "SELECT *, (SELECT COUNT(*) FROM tb_class_comment WHERE comment_post = post_id) AS n_comment FROM tb_class_post p JOIN tb_user u ON p.post_user = u.user_id WHERE post_class_id = '$cid' ORDER BY post_date DESC");
    $commentDetail    = mysqli_query($conn, "SELECT * FROM tb_class_comment c JOIN tb_user u ON c.comment_user = u.user_id WHERE comment_post = '$pid' ORDER BY comment_date ASC");
    $assignmentDetail = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_class_assignment WHERE assignment_user = '$_SESSION[user]' AND assignment_post = '$pid'"));
    $grade            = mysqli_query($conn, "SELECT * FROM tb_user u JOIN tb_class_member m ON u.user_id = m.user_id JOIN tb_class_assignment a ON u.user_id = a.assignment_user WHERE m.class_id = '$cid' AND assignment_post = '$pid' ORDER BY u.user_id ASC");
    
    echo "<script>document.title = '$class[class_name] | ALICE' </script>";

    
    if (isset($_SESSION['fileZip'])){
        echo    '<script>
                window.onload = function(){
                    window.open("'.$_SESSION['fileZip'].'", "_self"); 
                }
            </script>';
        unset($_SESSION['fileZip']);
    }
?>
<!-- Main layout -->
<main class="grey lighten-4" style="min-height: 100vh;">

<!-- Intro -->
<section class="" style="padding: 130px 0 70px 0; background: url('img/alice-header/<?php echo $class['class_header'];?>'); background-size:cover;">
  <div class="container justify-content-start">

    <div class="card col-md-4 p-4">
        <!-- Excerpt -->
        <h1 class="dark-grey-text"><?php echo $class['class_name']; ?></h1>

        <p class="dark-grey-text text-uppercase spacing"><i class="fas fa-layer-group mr-2"></i> <?php echo $class['course_name']; ?></p>

        <!-- Grid row -->
        <div class="row">

        <!-- Grid column -->
        <div class="col-md-12">

            <p class="dark-grey-text mb-1">
            <em>"<?php echo $class['class_desc'];?>"</em>
            </p>

            <p>
                Kode kelas: <?php echo $class['class_code'];?>
            </p>
            
            <?php
                if ($role == 2) {
                    ?>
                        <div class="row ml-1">
                            <a href="?p=class-form&act=update&id=<?php echo $cid; ?>" class="text-secondary mr-3"><i class="fas fa-cog"></i></a>
                            <!-- <input type="file" name="upload_image" id="upload_cover" accept="image/*" hidden/> -->
                            <!-- <a href="" id="uploadCover" class="text-secondary mr-3"><i class="fas fa-camera"></i></a> -->
                            <a href="#" data-toggle="modal" data-target="#alertDeleteClass" class="text-secondary"><i class="far fa-trash-alt"></i></a>
                        </div>    
                    <?php
                }
            ?>
        </div>
        <!-- Grid column -->

        </div>
        <!-- Grid row -->
    </div>

  </div>
</section>
<!-- Intro -->
<ul class="nav nav-tabs justify-content-center white">
  <li class="nav-item">
    <a class="nav-link <?php if ($view == 'home') echo 'active alice-active';?>" href="?p=class&id=<?php echo $class['class_id'];?>&view=home">Home</a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?php if ($view == 'work') echo 'active alice-active';?>" href="?p=class&id=<?php echo $class['class_id'];?>&view=work">Tugas</a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?php if ($view == 'member') echo 'active alice-active';?>" href="?p=class&id=<?php echo $class['class_id'];?>&view=member">Member</a>
  </li>
</ul>
<!-- Blog section -->
<section>
  <div class="container-fluid">
    <div class="container">

      <!-- Blog -->
      <div class="row pt-5">

        <?php
            if ($view == 'home') {
                ?>
                    <!-- Main listing -->
                    <div class="col-lg-8 col-12 mt-1 mx-lg-4">
                        <!-- Section: Blog v.3 -->
                        <section class="pb-3 text-center text-lg-left">

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body px-3 py-3">
                                        <form action="action/classroom.php?act=add-post" method="POST" enctype="multipart/form-data">
                                            <!-- hidden -->
                                            <input type="text" name="classID" value="<?php echo $class['class_id'];?>" hidden>
                                            <input type="text" name="userID" value="<?php echo $_SESSION['user'];?>" hidden>
                                            <input type="file" name="attachFile" id="upload" hidden>
                                            <!-- Material input -->
                                            <div class="md-form m-1 mt-3 collapse" id="collapseTitle">
                                                <input type="text" id="postFormTitle" name="postTitle" class="form-control">
                                                <label for="postFormTitle">Masukkan judul</label>
                                            </div>
                                            <!--Message-->
                                            <div class="md-form m-1 mb-0 mt-3">
                                                <textarea id="postFormContent" name="postContent" class="form-control md-textarea py-2" required></textarea>
                                                <label for="postFormContent">Tulis sesuatu...</label>
                                            </div>
                                            <!-- Material input -->
                                            <div class="md-form m-1 mt-3 collapse" id="collapseLink">
                                                <input type="url" id="postFormLink" name="postLink" class="form-control">
                                                <label for="postFormLink">Masukkan link</label>
                                            </div>
                                            <div class="row pl-3 mt-3 align-items-center">
                                                <div class="col-md-6 mt-2 d-flex">
                                                    <a class="text-secondary h5 mr-4" data-toggle="collapse" data-target="#collapseLink"><i class="fas fa-link" aria-hidden="true"></i></a>
                                                    <a class="text-secondary h5 mr-4" id="upload_file"><i class="fas fa-folder" aria-hidden="true"></i></a>
                                                    <a class="text-muted text-truncate" id="upload_name"></a>
                                                </div>
                                                <div class="col-md-6 row align-items-center justify-content-end pr-0">
                                                    <div class="input-group-sm mr-3 collapse" id="collapseDate">
                                                        <input class="form-control" type="date" name="postDueDate" id="postDueDate">
                                                        <input type="text" id="manual-operations-input" class="form-control" name="postDueTime" placeholder="Now">
                                                    </div>
                                                    <select class="browser-default custom-select custom-select-sm w-25 mr-2" id="postType" name="postType">
                                                        <option value="Post" selected>Post</option>
                                                        <option value="Materi" <?php if ($role == 3) echo 'disabled';?>>Materi</option>
                                                        <option value="Tugas" <?php if ($role == 3) echo 'disabled';?>>Tugas</option>
                                                    </select>
                                                    <button class="btn btn-secondary btn-sm z-depth-0">Post</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                            if (mysqli_num_rows($classPost) > 0) {
                                while ($result = mysqli_fetch_array($classPost)){
                                    ?>
                                        <!-- Grid row -->
                                        <div class="row mb-4">
                                            <!-- Grid column -->
                                            <div class="col-md-12">
                                            <!-- Card -->
                                            <div class="card">
                                                <!-- Card content -->
                                                <div class="card-body mx-2 row">
                                                    <div class="col-md-2">
                                                        <p class="text-center mt-4">
                                                            <?php
                                                                if ($result['post_is_material'] == '1') {
                                                                    echo '<i class="far fa-file-archive display-4"></i>';
                                                                } else if ($result['post_is_assignment'] == '1') {
                                                                    echo '<i class="far fa-file-alt display-4"></i>';
                                                                } else {
                                                                    echo '<i class="far fa-copy display-4"></i>';
                                                                }
                                                            ?>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <!-- Title -->
                                                        <div class="card-title row justify-content-between px-3 mb-0">
                                                            <h5 class="mb-0">
                                                                <?php echo $result['user_name']; ?>
                                                            </h5>
                                                            <p class="mb-0 text-muted"><?php echo date('d/m/Y', strtotime($result['post_date'])); ?></p>
                                                        </div>
                                                        <hr>
                                                        <!-- Text -->
                                                        <p class="dark-grey-text mb-3"><?php echo $result['post_content']; ?></p>
                                                        <?php
                                                            if ($result['post_attachment'] != '') {
                                                                echo "<a href='filemateri-kelas/$result[post_attachment]' class='badge badge-success mb-3 mr-3'><i class='fas fa-paperclip'></i> Lampiran</a>";
                                                            }
                                                            if ($result['post_attachment_link'] != '') {
                                                                echo "<a href='$result[post_attachment_link]' class='badge badge-success mb-3'><i class='fas fa-link'></i> Tautan</a>";
                                                            }
                                                        ?>
                                                        <div class="row justify-content-between mx-0">
                                                            <p class="font-small dark-grey-text mb-0 font-weight-bold"><i class="fas fa-comment"></i> <?php echo $result['n_comment']; ?> Komentar</p>
                                                            <p class="font-small mb-0 text-uppercase dark-grey-text font-weight-bold">
                                                                <a class="text-secondary" href="?p=class&id=<?php echo $cid;?>&view=post&pid=<?php echo $result['post_id'];?>">Lihat
                                                                <i class="fas fa-chevron-right" aria-hidden="true"></i>
                                                                </a>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Card content -->
                                            </div>
                                            <!-- Card -->
                                            </div>
                                            <!-- Grid column -->
                                        </div>
                                        <!-- Grid row -->
                                    <?php
                                }
                            }    
                        ?>
                        
                        </section>
                        <!-- Section: Blog v.3 -->
                    </div>
                    <!-- Main listing -->

                    
                    <!-- Sidebar -->
                    <div class="col-lg-3 col-12 mt-1">

                        <!-- Card -->
                        <div class="card">

                        <!-- Card image -->
                        <div class="view overlay row justify-content-center mt-4">
                            <img src="img/alice-img/<?php echo $lecturer['user_photo']; ?>" class="card-img-top " style="width:100px;" alt="Avatar">
                        </div>
                        <!-- Card image -->

                        <!-- Card content -->
                        <div class="card-body">
                            <!-- Title -->
                            <h5 class="card-title dark-grey-text text-center grey lighten-4 py-2">
                            <strong><?php echo $lecturer['user_name']; ?></strong>
                            </h5>

                            <p class="text-center">
                                <span class='badge badge-pill badge-success mt-1'><?php echo $lecturer['profile_status']; ?></span>
                            </p>
                            
                            <!-- Description -->
                            <p class="mt-3 dark-grey-text font-small text-center">
                            <em><?php echo $lecturer['profile_info']; ?></em>
                            </p>
                        </div>
                        <!-- Card content -->

                        </div>
                        <!-- Card -->

                        </div>
                        <!-- Sidebar -->
                <?php
            } else if ($view == 'work') {
                if (mysqli_num_rows($assignment) > 0) {
                    echo '<div class="col-md-12"><h3 class="pt-4">Tugas</h3>';
                    echo '<div class="list-group-flush">';
                    while ($result = mysqli_fetch_array($assignment)) {
                        echo "<div class='list-group-item'><a href='?p=class&id=$cid&view=post&pid=$result[post_id]'>$result[post_subject]</a></div>";
                    }
                    echo '</div></div>';
                } else {
                    ?>
                        <div class="col-md-12 dark-grey-text row justify-content-center mt-5">
                            <em>Aseeek tidak ada tugas</em>
                        </div>
                    <?php
                }
            } else if ($view == 'member') {
                ?>
                    <div class="col-md-12">
                        <h3 class="pt-4">Dosen</h3>
                        <div class="list-group-flush">
                            <div class="list-group-item">
                                <h5 class="mb-0">
                                    <img src="img/alice-img/<?php echo $lecturer['user_photo'];?>" style="width: 50px;" class="mr-3" alt="Avatar">
                                    <?php echo $lecturer['user_name'];?>
                                </h5>
                            </div>
                        </div>
                        <h3 class="pt-4">Mahasiswa</h3>
                        <div class="list-group-flush">
                            <?php
                                while ($result = mysqli_fetch_array($member)) {
                                    ?>
                                    <div class="list-group-item">
                                        <h5 class="mb-0">
                                            <img src="img/alice-img/<?php echo $result['user_photo'];?>" style="width: 50px;" class="mr-3" alt="Avatar">
                                            <?php echo $result['user_name'];?>
                                        </h5>
                                    </div> 
                                    <?php
                                }    
                            ?>
                        </div>
                    </div>
                <?php
            } else if ($view == 'post') {
                $postDetail = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_class_post p JOIN tb_user u ON p.post_user = u.user_id WHERE post_id = '$_GET[pid]'"))
                ?>
                    <!-- Main listing -->
                    <div class="col-lg-8 col-12 mt-1 mx-lg-4">
                        <!-- Section: Blog v.3 -->
                        <section class="pb-3 text-center text-lg-left">

                         <!-- Grid row -->
                         <div class="row mb-4">
                            <!-- Grid column -->
                            <div class="col-md-12">
                            <!-- Card -->
                            <div class="card">
                                <!-- Card content -->
                                <div class="card-body mx-2 row">
                                    <div class="col-md-2">
                                        <p class="text-center mt-4">
                                            <?php
                                                if ($postDetail['post_is_material'] == '1') {
                                                    echo '<i class="far fa-file-archive display-4"></i>';
                                                } else if ($postDetail['post_is_assignment'] == '1') {
                                                    echo '<i class="far fa-file-alt display-4"></i>';
                                                } else {
                                                    echo '<i class="far fa-copy display-4"></i>';
                                                }
                                            ?>
                                        </p>
                                    </div>
                                    <div class="col-md-10">
                                        <!-- Title -->
                                        <div class="card-title row justify-content-between px-3 mb-0">
                                            <h5 class="mb-0">
                                                <?php echo $postDetail['user_name']; ?>
                                            </h5>
                                            <p class="mb-0 text-muted"><?php echo date('d/m/Y', strtotime($postDetail['post_date'])); ?></p>
                                        </div>
                                        <hr>
                                        <!-- Text -->
                                        <div class="md-form m-1 mb-0 mt-3">
                                            <textarea id="postFormContent" name="postContent" class="form-control md-textarea py-2" required disabled><?php echo $postDetail['post_content']; ?></textarea>
                                            <button id="btnSavePost" class="btn btn-secondary btn-sm float-right" hidden>Simpan</button>
                                            <button id="btnCancelPost" class="btn btn-light btn-sm float-right" hidden>Batal</button>
                                        </div>
                                        <?php
                                            if ($postDetail['post_attachment'] != '') {
                                                echo "<a href='filemateri-kelas/$postDetail[post_attachment]' class='badge badge-success mb-3 mr-3'><i class='fas fa-paperclip'></i> Lampiran</a>";
                                            }
                                            if ($postDetail['post_attachment_link'] != '') {
                                                echo "<a href='$postDetail[post_attachment_link]' class='badge badge-success mb-3'><i class='fas fa-link'></i> Tautan</a>";
                                            }
                                        ?>
                                    </div>
                                </div>
                                <?php
                                    if ($_SESSION['user'] == $postDetail['post_user']) {
                                        ?>
                                            <hr class="my-0 mx-3">
                                            <div class="row justify-content-center">
                                                    <a id="btnUpdatePost" class="btn btn-secondary btn-sm">Ubah Post</a>
                                                    <a href="action/classroom.php?act=delete-post&id=<?php echo $postDetail['post_id'];?>&user=<?php echo $_SESSION['user'];?>&class=<?php echo $cid;?>" class="btn btn-danger btn-sm">Hapus Post</a>
                                            </div>
                                        <?php
                                    }
                                ?>
                                <hr class="mt-0 mx-3">
                                <div class="row px-4">
                                    <h5 class="ml-2">Komentar</h5>
                                    <form action="action/classroom.php?act=add-comment" method="post" class="col-md-12">
                                        <input type="text" name="userID" value="<?php echo $_SESSION['user'];?>" hidden>
                                        <input type="text" name="postID" value="<?php echo $_GET['pid'];?>" hidden>
                                        <input type="text" name="classID" value="<?php echo $_GET['id'];?>" hidden>
                                        <div class="form-group purple-border mt-2 mb-1">
                                            <textarea class="form-control" name="commentContent" rows="3" placeholder="Tulis komentar..." required></textarea>
                                        </div>
                                        <input class="btn btn-secondary btn-sm mx-0 my-1" type="submit" value="Kirim">
                                    </form>
                                </div>
                                <hr class="mx-3">
                                <?php
                                    while ($result = mysqli_fetch_array($commentDetail)) { 
                                        ?>
                                            <div class="row px-5">
                                                <!-- Comments -->
                                                <div class="d-flex p-2 align-items-start">
                                                    <div class="flex-shrink-1 mr-3">
                                                        <div class="view overlay">
                                                            <img src="img/alice-img/<?php echo $result['user_photo'];?>" class="rounded-circle img-fluid alice-avatar"
                                                                alt="Avatar">
                                                        </div>
                                                    </div>
                                                    <div class="w-100">
                                                        <h6 class="h6 mb-0"><?php echo $result['user_name']; ?>
                                                            <span class="text-black-50 ml-2 font-small"><?php echo $result['comment_date']; ?></span>
                                                            <?php
                                                                $uid = $_SESSION['user'];
                                                                if ($uid == $result['comment_user'])                                                                 
                                                                    echo "<a href='action/classroom.php?act=delete-comment&id=$result[comment_id]&class=$cid&post=$pid&user=$uid' class='text-danger font-small'>Hapus</a>";  
                                                            ?>
                                                        </h6>
                                                        <p class="dark-grey-text article mb-0">
                                                            <?php echo $result['comment_content']; ?>
                                                        </p>
                                                    </div>
                                                </div>
                                                <!-- Comments -->
                                            </div>

                                            <hr class="mx-3">
                                        <?php
                                    }    
                                ?>
                                <!-- Card content -->
                            </div>
                            <!-- Card -->
                            </div>
                            <!-- Grid column -->
                        </div>
                        <!-- Grid row -->
                        
                        </section>
                        <!-- Section: Blog v.3 -->
                    </div>
                    <!-- Main listing -->
                  
                    <?php
                        if ($postDetail['post_is_assignment'] == '1' && $role == 3) {
                            ?>
                                <!-- Sidebar -->
                                <div class="col-lg-3 col-12 mt-1">

                                    <!-- Card -->
                                    <div class="card">

                                    <!-- Card content -->
                                    <div class="card-body">
                                        <h5>
                                            File tugas
                                        </h5>
                                        <hr>
                                        <!-- Title -->
                                        <h6 class="card-title dark-grey-text text-center grey lighten-4 py-2 px-2 text-truncate" id="attachAssignment">
                                           <?php
                                               if ($assignmentDetail['assignment_is_turned'] == '1') {
                                                   echo $assignmentDetail['assignment_attachment'];
                                                   $disable = true;
                                               } else {
                                                   echo 'Tidak ada file';
                                                   $disable = false;
                                               }
                                               $due = $postDetail['post_due_date'];
                                               $now = date('Y-m-d H:i:s');
                                               if ($now < $due){
                                                   $disable_deadline = false;
                                               } else {
                                                   $disable_deadline = true;
                                               }
                                           ?>
                                        </h6>

                                        <form action="action/classroom.php?act=add-assignment" method="POST" id="formAssignment" enctype="multipart/form-data">
                                            <!-- hidden -->
                                            <input type="text" name="classID" value="<?php echo $class['class_id'];?>" hidden>
                                            <input type="text" name="userID" value="<?php echo $_SESSION['user'];?>" hidden>
                                            <input type="text" name="postID" value="<?php echo $pid;?>" hidden>
                                            <input type="file" name="attachFile" id="upload" hidden required>
                                            <div class="row px-2">
                                                <div class="col-md-6 px-2">
                                                    <button class="btn btn-sm btn-secondary btn-block m-0" id="upload_file" <?php if ($disable || $disable_deadline) echo 'disabled'; ?>>Browse</button>
                                                </div>
                                                <div class="col-md-6 px-2">
                                                    <button class="btn btn-sm btn-secondary btn-block m-0" id="btnSubmit" <?php if ($disable || $disable_deadline) echo 'disabled'; ?>>Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                        
                                        <!-- Description -->
                                        <p class="mt-3 dark-grey-text font-small font-weight-light text-center">
                                            Deadline: <?php echo $postDetail['post_due_date'];?><br>
                                        <em>Hanya dapat satu kali submit</em>
                                        </p>
                                        <p class="text-center">
                                            Nilai: <?php echo $assignmentDetail['assignment_score']; ?>
                                        </p>
                                    </div>
                                    <!-- Card content -->

                                    </div>
                                    <!-- Card -->

                                </div>
                                <!-- Sidebar -->
                            <?php
                        } else if ($postDetail['post_is_assignment'] == '1' && $role == 2) {
                        ?>
                            <!-- Sidebar -->
                            <div class="col-lg-3 col-12 mt-1">

                                <!-- Card -->
                                <div class="card">

                                <!-- Card content -->
                                <div class="card-body">
                                    <h5>
                                        File tugas
                                    </h5>
                                    <hr>

                                    <form action="action/classroom.php?act=zip" method="POST">
                                       
                                        <input type="text" name="classID" value="<?php echo $class['class_id'];?>" hidden>
                                        <input type="text" name="userID" value="<?php echo $_SESSION['user'];?>" hidden>
                                        <input type="text" name="postID" value="<?php echo $pid;?>" hidden>
                                        <button class="btn btn-sm btn-secondary btn-block m-0" id="btnSubmit">Unduh</button>
                                    </form>
                                </div>
                                <p class="mt-3 dark-grey-text font-small font-weight-light text-center">
                                    Deadline: <?php echo $postDetail['post_due_date'];?><br>
                                </p>
                                <!-- Card content -->
                                <div class="card-body">
                                    <h5>Nilai</h5>
                                    <hr>
                                    <a href="?p=class&id=<?php echo $cid; ?>&view=grade&pid=<?php echo $pid; ?>" class="btn btn-sm btn-secondary btn-block m-0">Beri penilaian</a>
                                </div>

                                </div>
                                <!-- Card -->

                                </div>
                                <!-- Sidebar -->
                        <?php
                    }
            } else if ($view == 'grade') {
                ?>
                <div class="col-md-12">
                    <h3>Beri Nilai</h3>
                    <div class="list-group-flush">
                        <?php
                            while ($result = mysqli_fetch_array($grade)) {
                                ?>
                                <div class="list-group-item">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="mb-0"><?php echo $result['user_id'].' - '. $result['user_name'];?></p>
                                        </div>
                                        <div class="col-md-3">
                                            <a class="text-secondary" href="filetugas-kelas/<?php echo $pid.'/'.$result['assignment_attachment'];?>"><?php echo $result['assignment_attachment'];?></a>
                                        </div>
                                        <div class="col-md-3">
                                            <form class="row formGrade">
                                                <input type="text" name="classID" value="<?php echo $class['class_id'];?>" hidden>
                                                <input type="text" name="userID" value="<?php echo $_SESSION['user'];?>" hidden>
                                                <input type="text" name="postID" value="<?php echo $pid;?>" hidden>
                                                <input type="text" name="assignID" value="<?php echo $result['assignment_id'];?>" hidden>
                                                <input type="number" name="valueGrade" min="0" max="100" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" class="form-control w-50 inputGrade" value="<?php echo $result['assignment_score'];?>" disabled required/>
                                                <button type="button" class="btn btn-secondary btn-sm btnGrade btnSave">Perbarui</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        ?>
                    </div>
                </div>
                <?php
            }
        ?>

      </div>
      <!-- Blog -->

    </div>

  </div>

</section>
<!-- Blog section -->

</main>

<!-- Central Modal Medium Danger -->
<div class="modal fade" id="alertDeleteClass" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-danger" role="document">
    <!--Content-->
    <div class="modal-content">
      <!--Header-->
      <div class="modal-header">
        <p class="heading lead">Hapus Kelas</p>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>

      <!--Body-->
      <div class="modal-body">
        <div class="text-center">
          <i class="fas fa-times fa-4x mb-3 animated rotateIn"></i>
          <p>Apakah anda yakin ingin menghapus kelas ini? Sekali anda hapus, data anda akan hilang selamanya.</p>
        </div>
      </div>

      <!--Footer-->
      <div class="modal-footer justify-content-center">
        <a type="button" class="btn btn-outline-danger waves-effect" data-dismiss="modal">Batal</a>
        <a type="button" class="btn btn-danger waves-effect" href="action/classroom.php?act=delete&id=<?php echo $cid?>">Hapus</a>
      </div>
    </div>
    <!--/.Content-->
  </div>
</div>
<!-- Modal alert delete class-->

<!-- Main layout -->
<script>
    
    $(function(){
        $("#upload_file").on('click', function(e){
            e.preventDefault();
            $("#upload:hidden").trigger('click');
        });
        $("#upload").on('change', function(e) {
            e.preventDefault();
            $("#upload_name").text(this.files[0].name);
            $("#attachAssignment").text(this.files[0].name);
        });
        $("#btnSubmit").click(function(){
            if (!($("#upload").get(0).files.length === 0)) {
                $("#formAssignment").submit();
            }
        });

        $(".btnGrade").click(function(){
            var btn = $(this).text();
            if (btn == 'Simpan') {
                var len = $(this).prev().val();
                if (len < 0 || len > 100) {
                    alert('Range nilai 1-100');
                } else {
                    $.ajax({
                        type: "POST",
                        url: "action/classroom.php?act=grade",
                        data: $(this).parent().serialize(), // changed
                        success: function(data) {
                            //alert('saved'); // show response from the php script.
                        }
                    });
                    $(this).siblings().prop('disabled',true);
                    $(this).html("Perbarui");
                }
            } else {
                $(this).siblings().prop('disabled',false);
                $(this).html("Simpan");
            }
        });   

        $("#upload_cover").change(function(){
            // $.ajax({
            //     type: "POST",
            //     url: "action/classroom.php?act=cover&cid=",
            //     data: {'image':$(this).serialize()}, // changed
            //     success: function(data) {
            //         alert('saved'); // show response from the php script.
            //     }
            // });
        });

        $("#uploadCover").click(function(){
            $("#upload_cover").click();
        });


        $("#postType").change(function(){
            var type = $("#postType option:selected").text();
            if (type != 'Post') {
                $("#collapseTitle").collapse('show');
                $("#postFormTitle").prop('required',true);
            } else {
                $("#collapseTitle").collapse('hide');
                $("#postFormTitle").prop('required',false);
            }
            if (type == 'Tugas') {
                $("#collapseDate").collapse('show');
                $("#postDueDate").prop('required',true);
            } else {
                $("#collapseDate").collapse('hide');
                $("#postDueDate").prop('required',false);
            }
        });

        var dtToday = new Date();
        var month = dtToday.getMonth() + 1;
        var day = dtToday.getDate();
        var year = dtToday.getFullYear();
        if(month < 10)
            month = '0' + month.toString();
        if(day < 10)
            day = '0' + day.toString();
        
        var maxDate = year + '-' + month + '-' + day;
        $('#postDueDate').attr('min', maxDate);

        var input = $('#manual-operations-input').pickatime({
            autoclose: true,
            'default': 'now'
        });

        // Manually toggle to the minutes view
        $('#check-minutes').click(function(e){
            e.stopPropagation();
            input.pickatime('show').pickatime('toggleView', 'minutes');
        });

        $("#btnUpdatePost").click(function(){
            $("#btnSavePost").prop('hidden',false);
            $("#btnCancelPost").prop('hidden',false);
            $("#postFormContent").prop('disabled', false);
            $("#postFormContent").focus();
        });

        $("#btnCancelPost").click(function(){
            $("#btnSavePost").prop('hidden',true);
            $("#btnCancelPost").prop('hidden',true);
            $("#postFormContent").prop('disabled', true);
        });

        $("#btnSavePost").click(function(){
            var content = $("#postFormContent").val();
            //alert(content);
            $.ajax({
                type: "POST",
                url: "action/classroom.php?act=update-post&id=<?php echo $pid;?>&user=<?php echo $_SESSION['user'];?>&class=<?php echo $cid;?>",
                data: {'postContent': content}, // changed
                success: function(data) {
                    $("#btnCancelPost").click();
                }
            });
        });
    });
</script>