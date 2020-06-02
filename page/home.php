<?php
    $uid = $_SESSION['user'];

    $status          = mysqli_fetch_array(mysqli_query($conn, "SELECT profile_status FROM tb_lecturer_profile WHERE profile_user = '$uid'"))[0];
    $profile         = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tb_user WHERE user_id = '$uid'")); 

    $assignment_stu  = mysqli_query($conn, "SELECT * FROM tb_class_post p JOIN tb_class_member m ON p.post_class_id = m.class_id WHERE post_is_assignment = '1' AND m.user_id = '$uid' AND post_due_date >= NOW() ORDER BY post_date DESC");
    $assignment_lec  = mysqli_query($conn, "SELECT * FROM tb_class_post p JOIN tb_class c ON p.post_class_id = c.class_id WHERE post_is_assignment = '1' AND class_lecturer = '$uid' AND post_due_date >= NOW() ORDER BY post_date DESC");
    $recent_post     = mysqli_query($conn, "SELECT post_id, post_subject, post_view, (SELECT COUNT(*) FROM tb_forum_comment WHERE comment_post = post_id) AS post_comment FROM tb_forum_post WHERE post_user = '$uid' ORDER BY post_date DESC");
    $recent_material = mysqli_query($conn, "SELECT material_id, material_subject, (SELECT COUNT(*) FROM tb_material_downloaded WHERE tb_material_downloaded.material_id = tb_material.material_id) AS material_download FROM tb_material WHERE material_user = '$uid' ORDER BY material_date DESC");
    $recent_comment  = mysqli_query($conn, "SELECT comment_post, comment_content, comment_user, post_subject FROM tb_forum_comment c JOIN tb_forum_post p ON c.comment_post = p.post_id  WHERE comment_user = '$uid' ORDER BY comment_date DESC");
    $recent_download = mysqli_query($conn, "SELECT d.material_id, material_subject, course_name, material_course FROM tb_material_downloaded d JOIN tb_material m ON d.material_id = m.material_id JOIN tb_course ON m.material_course = course_id WHERE d.material_user = '$uid' ORDER BY d.material_date DESC");

    $n_class         = mysqli_num_rows(mysqli_query($conn, "SELECT class_id FROM tb_class_member WHERE user_id = '$uid'"));
    $n_class_created = mysqli_num_rows(mysqli_query($conn, "SELECT class_id FROM tb_class WHERE class_lecturer = '$uid'"));
    $n_post          = mysqli_num_rows($recent_post);
    $n_comment       = mysqli_num_rows($recent_comment);
    $n_material_dl   = mysqli_num_rows($recent_download);
    $n_material_up   = mysqli_num_rows($recent_material);

    //form
    if ($_POST) {
      if ($role == 2) {
        $getStatus = $_POST['userStatus'];
        $query     = mysqli_query($conn, "UPDATE tb_lecturer_profile SET profile_status = '$getStatus' WHERE profile_user = '$uid'");
        echo "<meta http-equiv='refresh' content='0'>";
      }
    }
?>

<!-- DataTables  -->
<script type="text/javascript" src="js/addons/datatables.min.js"></script>
<!-- DataTables Select  -->
<script type="text/javascript" src="js/addons/datatables-select.min.js"></script>

<?php
  if ($role == 2) {  
?>
<!-- Main layout Lecturer-->

<main>

  <div class="container">

    <!-- Section: data tables -->
    <section class="mt-md-4 pb-3">

      <div class="row">

        <div class="col-xl-4 col-md-6">

          <div class="card mb-4">
            <div class="card-body">
              <h5 class="h5-responsive my-2">Status</h5>
              <hr class="purple">
              <form action="" method="post">
                <!-- Blue select -->
                <select class="mdb-select mt-2" id="userFormStatus" name="userStatus" required>
                    <option value="1" disabled>Pilih Status Mengajar</option>
                    <option value="Selo" <?php if ($status == 'Selo') echo 'selected'; ?>>Selo</option>
                    <option value="Mengajar" <?php if ($status == 'Mengajar') echo 'selected'; ?>>Mengajar</option>
                    <option value="Rapat" <?php if ($status == 'Rapat') echo 'selected'; ?>>Rapat</option>
                    <option value="di Rumah" <?php if ($status == 'di Rumah') echo 'selected'; ?>>di Rumah</option>
                </select>
                <div class="float-right">
                  <input type="submit" value="Perbarui" class="btn btn-secondary btn-rounded btn-sm z-depth-1">
                </div>
              </form>
            </div>
          </div>

          <div class="card mb-4">
            <div class="card-body">
              <h5 class="h5-responsive my-2">Tugas</h5>
              <hr class="purple">
              <div class="list-group list-panel">
                <?php 
                  if ($role == 2) {
                    $temp = $assignment_lec;
                  } else {
                    $temp = $assignment_stu;
                  }
                  if (mysqli_num_rows($temp) > 0) {
                      echo '<div class="list-group-flush">';
                      while ($result = mysqli_fetch_array($temp)) {
                          ?>
                            <a href="?p=class&id=<?php echo $result['post_class_id']; ?>&view=post&pid=<?php echo $result['post_id']; ?>" class="list-group-item d-flex justify-content-between dark-grey-text"><?php echo $result['post_subject']; ?>
                              <i class="fas fa-external-link-alt ml-1" data-toggle="tooltip" data-placement="top"
                                title="Klik untuk melihat"></i>
                            </a>
                          <?php
                      }
                      echo '</div>';
                  } else {
                      echo "<p class='font-weight-light font-italic text-center my-5' style='line-height: 0.9;'>Aseeek tidak ada tugas</p>";
                  }
                ?>
              </div>
            </div>
          </div>

          <div class="card mb-4">
            <div class="card-body">
              <h5 class="h5-responsive my-2">Statistik</h5>
              <hr class="purple">
              <div class="list-group list-panel">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    Kelas dibuat
                    <span class="badge badge-secondary badge-pill z-depth-0"><?php echo $n_class_created;?></span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    Posting Forum
                    <span class="badge badge-secondary badge-pill z-depth-0"><?php echo $n_post;?></span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    Komentar Forum
                    <span class="badge badge-secondary badge-pill z-depth-0"><?php echo $n_comment;?></span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    Materi diunggah
                    <span class="badge badge-secondary badge-pill z-depth-0"><?php echo $n_material_up;?></span>
                  </li>
                </ul>
              </div>
            </div>
          </div>

        </div>

        <div class="col-xl-8 col-md-6">
          <div class="row">
              <div class="col-md-12">
                <a href="?p=class-form&act=add" class="btn purple-gradient btn-rounded waves-effect font-weight-bold btn-dash float-right">
                    Buat Kelas 
                </a>
                <a href="?p=forum-form&act=add" class="btn purple-gradient btn-rounded waves-effect font-weight-bold btn-dash float-right">
                    Tulis Post 
                </a>
                <a href="?p=materi-form" class="btn purple-gradient btn-rounded waves-effect font-weight-bold btn-dash float-right">
                    Unggah Materi
                </a>
              </div>
          </div>

          <div class="card my-4">
            <div class="card-body">
              <div class="table-responsive p-2">
                <table id="dataTablePost" class="table table-fixed mb-0">
                  <thead>
                    <tr style="display: none;">
                      <th></th>
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                        while ($result = mysqli_fetch_array($recent_post)){
                            echo "<tr>";
                            echo "<td class='text-truncate'><a href='?p=forum&id=$result[post_id]'>$result[post_subject]</a></td>";
                            echo "<td style='width:150px;'><i class='far fa-comment mr-2'></i>$result[post_comment]</td>";
                            echo "<td style='width:150px;'><i class='far fa-eye mr-2'></i>$result[post_view]</td>";
                            echo "</tr>";
                        }
                    ?>
                  </tbody>
                </table>
              </div>
              <a href="?p=forum" class="btn btn btn-flat grey lighten-3 btn-rounded waves-effect float-right font-weight-bold  btn-dash" style="margin-top: -1rem;">
                  Lihat post lainnya
              </a>
            </div>
          </div>

          <div class="card my-4">
            <div class="card-body">
              <div class="table-responsive p-2">
                <table id="dataTableMaterial" class="table table-fixed mb-0">
                  <thead>
                    <tr style="display: none;">
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                        while ($result = mysqli_fetch_array($recent_material)){
                            echo "<tr>";
                            echo "<td class='text-truncate'><a href='?p=materi-post&id=$result[material_id]'>$result[material_subject]</a></td>";
                            echo "<td style='width:150px;'><i class='fas fa-download mr-2'></i>$result[material_download]</td>";
                            echo "</tr>";
                        }
                    ?>
                  </tbody>
                </table>
              </div>
              <a href="?p=materi" class="btn btn btn-flat grey lighten-3 btn-rounded waves-effect float-right font-weight-bold  btn-dash" style="margin-top: -1rem;">
                  Lihat materi lainnya
              </a>
            </div>
          </div>

          <div class="card my-4">
            <div class="card-body pb-0">
              <div class="table-responsive p-2">
                <table id="dataTableComment" class="table table-fixed mb-0">
                  <thead>
                    <tr style="display: none;">
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                        while ($result = mysqli_fetch_array($recent_comment)){
                            echo "<tr>";
                            echo "<td class='text-truncate'><a href='?p=forum&id=$result[comment_post]'>$result[comment_content]</a></td>";
                            echo "<td class='text-truncate'><i class='far fa-copy mr-2'></i><a href='?p=forum&id=$result[comment_post]'>$result[post_subject]</a></td>";
                            echo "</tr>";
                        }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>

      </div>

    </section>
    <!-- Section: data tables -->

  </div>

</main>
<!-- Main layout -->
<?php
  } else if ($role == 3) {
?>
<!-- Main layout Students-->
<main>

  <div class="container">

    <!-- Section: data tables -->
    <section class="mt-md-4 pb-3">

      <div class="row">

        <div class="col-xl-4 col-md-6">

          <div class="card mb-4">
            <div class="card-body row justify-content-center">
              <div class="col-md-4">
                  <img src="img/reward.png" alt="reward" class="img-fluid">
              </div>
              <div class="col-md-12">
                  <h5 class="h5-responsive my-2 text-center"><?php fn_title($conn, $uid); ?></h5>
                  <?php
                      $exp = $profile['user_exp'];
                      if ($exp <= 0) { 
                          $min = 0;
                          $max = 300;
                      } else if ($exp <= 300) {
                          $min = 0;
                          $max = 300;
                      } else if ($exp <= 1000) {
                          $min = 300;
                          $max = 1000;
                      } else if ($exp <= 2200) {
                          $min = 1000;
                          $max = 2200;
                      } else if ($exp <= 4000) {
                          $min = 2200;
                          $max = 4000;
                      } else {
                          $min = 4000;
                          $max = 9999;
                          $exp = 9999;
                      } 
                      $bar_percent = (float)(($exp-$min)/($max-$min)*100);
                  ?>
                  <p class="font-weight-light font-italic text-center" style="line-height: 0.9;"><?php echo $profile['user_exp'];?> exp <br><span style="font-size: 12px;">(selanjutnya: <?php echo $max;?>)</span></p>
                  <div class="progress md-progress mt-4">
                      <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $bar_percent;?>%" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
              </div>
            </div>
          </div>

          <div class="card mb-4">
            <div class="card-body">
              <h5 class="h5-responsive my-2">Tugas</h5>
              <hr class="purple">
              <div class="list-group list-panel">
                <?php 
                  if ($role == 2) {
                    $temp = $assignment_lec;
                  } else {
                    $temp = $assignment_stu;
                  }
                  if (mysqli_num_rows($temp) > 0) {
                      echo '<div class="list-group-flush">';
                      while ($result = mysqli_fetch_array($temp)) {
                          ?>
                            <a href="?p=class&id=<?php echo $result['post_class_id']; ?>&view=post&pid=<?php echo $result['post_id']; ?>" class="list-group-item d-flex justify-content-between dark-grey-text"><?php echo $result['post_subject']; ?>
                              <i class="fas fa-external-link-alt ml-1" data-toggle="tooltip" data-placement="top"
                                title="Klik untuk melihat"></i>
                            </a>
                          <?php
                      }
                      echo '</div>';
                  } else {
                      echo "<p class='font-weight-light font-italic text-center my-5' style='line-height: 0.9;'>Aseeek tidak ada tugas</p>";
                  }
                ?>
              </div>
            </div>
          </div>

          <div class="card mb-4">
            <div class="card-body">
              <h5 class="h5-responsive my-2">Statistik</h5>
              <hr class="purple">
              <div class="list-group list-panel">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    Kelas yang diikuti
                    <span class="badge badge-secondary badge-pill z-depth-0"><?php echo $n_class;?></span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    Posting Forum
                    <span class="badge badge-secondary badge-pill z-depth-0"><?php echo $n_post;?></span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    Komentar Forum
                    <span class="badge badge-secondary badge-pill z-depth-0"><?php echo $n_comment;?></span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    Materi diunduh
                    <span class="badge badge-secondary badge-pill z-depth-0"><?php echo $n_material_dl;?></span>
                  </li>
                </ul>
              </div>
            </div>
          </div>

        </div>

        <div class="col-xl-8 col-md-6">
          <div class="row">
              <div class="col-md-12">
                  <a data-toggle="modal" data-target="#modalJoinClass" class="btn purple-gradient btn-rounded waves-effect font-weight-bold btn-dash float-right">
                      Gabung Kelas    
                  </a>
                  <a href="?p=forum-form&act=add" class="btn purple-gradient btn-rounded waves-effect font-weight-bold btn-dash float-right">
                      Tulis Post 
                  </a>
              </div>
          </div>
          <div class="card my-4">
            <div class="card-body">
              <div class="table-responsive p-2">
                <table id="dataTablePost" class="table table-fixed mb-0">
                  <thead>
                    <tr style="display: none;">
                      <th></th>
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                        while ($result = mysqli_fetch_array($recent_post)){
                            echo "<tr>";
                            echo "<td class='text-truncate'><a href='?p=forum&id=$result[post_id]'>$result[post_subject]</a></td>";
                            echo "<td style='width:150px;'><i class='far fa-comment mr-2'></i>$result[post_comment]</td>";
                            echo "<td style='width:150px;'><i class='far fa-eye mr-2'></i>$result[post_view]</td>";
                            echo "</tr>";
                        }
                    ?>
                  </tbody>
                </table>
              </div>
              <a href="?p=forum" class="btn btn btn-flat grey lighten-3 btn-rounded waves-effect float-right font-weight-bold  btn-dash" style="margin-top: -1rem;">
                  Lihat post lainnya
              </a>
            </div>
          </div>

          <div class="card my-4">
            <div class="card-body pb-0">
              <div class="table-responsive p-2">
                <table id="dataTableComment" class="table table-fixed mb-0">
                  <thead>
                    <tr style="display: none;">
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                        while ($result = mysqli_fetch_array($recent_comment)){
                            echo "<tr>";
                            echo "<td class='text-truncate'><a href='?p=forum&id=$result[comment_post]'>$result[comment_content]</a></td>";
                            echo "<td class='text-truncate'><i class='far fa-copy mr-2'></i><a href='?p=forum&id=$result[comment_post]'>$result[post_subject]</a></td>";
                            echo "</tr>";
                        }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          
          <div class="card my-4">
            <div class="card-body">
              <div class="table-responsive p-2">
                <table id="dataTableMaterialDownloaded" class="table table-fixed mb-0">
                  <thead>
                    <tr style="display: none;">
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                        while ($result = mysqli_fetch_array($recent_download)){
                            echo "<tr>";
                            echo "<td class='text-truncate'><a href='?p=materi-post&id=$result[material_id]'>$result[material_subject]</a></td>";
                            echo "<td class='text-truncate'><a href='?p=list&type=material-course&id=$result[material_course]'><i class='fas fa-layer-group mr-2'></i>$result[course_name]</a></td>";
                            echo "</tr>";
                        }
                    ?>
                  </tbody>
                </table>
              </div>
              <a href="?p=material" class="btn btn btn-flat grey lighten-3 btn-rounded waves-effect float-right font-weight-bold  btn-dash" style="margin-top: -1rem;">
                  Lihat materi lainnya
              </a>
            </div>
          </div>

        </div>

      </div>

    </section>
    <!-- Section: data tables -->

  </div>

</main>
<?php } ?>

<script>
    $('#dataTablePost').DataTable({
        "pagingType" : "simple_numbers",
        "ordering" : false,
        "pageLength" : 5
    });
    $('#dataTableMaterial').DataTable({
        "pagingType" : "simple_numbers",
        "ordering" : false,
        "pageLength" : 5
    });
    $('#dataTableMaterialDownloaded').DataTable({
        "pagingType" : "simple_numbers",
        "ordering" : false,
        "pageLength" : 5
    });
    $('#dataTableComment').DataTable({
        "pagingType" : "simple_numbers",
        "ordering" : false,
        "pageLength" : 5
    });
    $('#dataTablePost_length label').replaceWith("<label>Post Saya</label>");
    $('#dataTableMaterial_length label').replaceWith("<label>Materi Saya</label>");
    $('#dataTableMaterialDownloaded_length label').replaceWith("<label>Materi Diunduh</label>");
    $('#dataTableComment_length label').replaceWith("<label>Komentar Saya</label>");
    $('.pagination').css("margin", "0px");
    $('.dataTables_wrapper').css("padding","10px");
    //$('.dataTables_info').hide();
</script>