<body class="fixed-sn homepage-v3">

  <!-- Main layout -->
  <main class="pt-4">
    <div class="container-fluid">
      <!-- Magazine -->
      <div class="row">
        <!-- Main news -->
        <div class="col-xl-8 col-md-12">
        <?php
          if (isset($_GET['id'])) {
              include 'forum-post.php';
          } else if (isset($_GET['keyword']) && $_GET['keyword'] != "") {
                echo "<h3 class='pt-4 mb-4'>Pencarian: $_GET[keyword]</h3>";
                $query = mysqli_query($conn, "SELECT * FROM tb_forum_post JOIN tb_user ON user_id = post_user WHERE post_subject LIKE '%$_GET[keyword]%'");
                echo '<div class="row">';
                while ($result = mysqli_fetch_array($query)) { 
                    ?>
                        <!-- Grid column -->
                        <div class="col-md-4 my-3">
                            <!-- Card -->
                            <div class="card" style="height: 20rem;">
                            <!-- Card content -->
                            <div class="card-body">
                                <!-- Title -->
                                <h4 class="card-title" style="height: 4rem;"><strong><?php echo $result['post_subject']; ?></strong></h4>
                                <hr>
                                <!-- Text -->
                                <p class="card-text mb-3" style="height: 6rem;"><?php echo substr($result['post_content'], 0, 80); if (strlen($result['post_content']) >= 80) echo '...'; ?>
                                </p>
                                <p class="font-small font-weight-bold dark-grey-text mb-1"><i class="far fa-clock-o"></i>
                                <?php echo date('d/m/Y', strtotime($result['post_date'])); ?></p>
                                <p class="font-small grey-text mb-0"><?php echo $result['user_name']; ?></p>
                                <p class="text-right mb-0 font-small font-weight-bold"><a href="?p=forum&id=<?php echo $result['post_id']; ?>" class="text-secondary">Baca selengkapnya <i
                                    class="fas fa-angle-right"></i></a></p>
                            </div>
                            <!-- Card content -->
                            </div>
                            <!-- Card -->
                        </div>
                        <!-- Grid column -->
                    <?php
                }
                echo '</div>';
          } else {
              ?>
                <!-- Section: Magazine posts -->
                <section class="section extra-margins mt-2">
                    <!-- SELECT post_id, post_subject, post_view FROM tb_forum_post ORDER BY post_date DESC -->
                    <?php
        require_once 'config/conf.php';
        $query  = mysqli_query($conn, "SELECT * FROM tb_forum_post JOIN tb_user ON user_id = post_user ORDER by post_date desc limit 1;");
        $result = mysqli_fetch_array($query);
        $judul = $result['post_subject'];
        $isi = $result['post_content'];
        $tanggal = $result['post_date'];
        $sender = $result['post_user'];
        $id = $result['post_id'];
        //var_dump($judul);
        ?>
                    <h4 class="font-weight-bold"><strong>POST TERBARU</strong></h4>
                    <hr class="red title-hr">

                    <!-- News card -->
                    <div class="card mb-3 text-center">
                    <div class="card-body">
                        <!-- Grid row -->
                        <div class="row">
                        <!-- Grid column -->
                        <div class="col-md-3 mx-3 my-3">
                            <!-- Featured image -->
                            <div class="view overlay">
                            <img src="img/alice-img/<?php echo $result['user_photo']?>" class="rounded-circle img-fluid mx-auto"
                                alt="Avatar">
                            <a>
                                <div class="mask rgba-white-slight"></div>
                            </a>
                            </div>
                        </div>
                        <!-- Grid column -->

                        <!-- Grid column -->
                        <div class="col-md-8 text-left mt-3">
                            <h4 class="mb-4"><strong><?php echo $judul ?></strong></h4>
                            <p class="dark-grey-text"><?php echo substr($result['post_content'], 0, 185); if (strlen($result['post_content']) >= 185) echo '...'; ?></p>
                            <!-- <?php echo $isi; ?> -->
                            <p>by <a><strong><?php echo $result['user_name']?></strong></a>, <?php echo $tanggal; ?></p>
                            <a href="?p=forum&id=<?php echo $id;?>" class="btn btn-secondary btn-sm">Baca selengkapnya</a>
                        </div>
                        <!-- Grid column -->
                        </div>
                        <!-- Grid row -->

                        <!-- Grid row -->
                        <div class="row mt-4">
                        <!-- Grid column -->
                        <div class="col-md-5 mx-4 my-3">
                            <?php 
                    $sql =  "SELECT post_date, post_subject, post_id, user_photo FROM tb_forum_post JOIN tb_user ON user_id = post_user ORDER by post_date desc limit 3";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                                        // output data of each row
                                        while($row = mysqli_fetch_array($result)) {
                                            //var_dump($row[1]);
                    ?>
                                        <!-- Small news -->
                                        <div class="single-news">
                                            <div class="row mb-2">
                                                <div class="col-md-4">
                                                <!-- Image -->
                                                <div class="view overlay rgba-white-slight mb-2">
                                                    <img src="img/alice-img/<?php echo $row['user_photo'];?>"
                                                    class="img-fluid rounded-circle w-75 mx-auto alice-avatar" alt="Avatar">
                                                    <a>
                                                    <div class="mask rgba-white-slight"></div>
                                                    </a>
                                                </div>
                                                </div>
                                                <!-- Excerpt -->
                                                <div class="col-md-8">
                                                <p class="font-small text-left mb-2"><strong><?php echo date('d-m-Y', strtotime($row[0])); ?></strong></p>
                                                <p class="text-left"><a href="?p=forum&id=<?php echo $row[2]; ?>" class="text-secondary stretched-link text" style="height: 1rem;"><?php echo ($row[1]); ?>
                                                    <i class="fas fa-angle-right float-right"></i>
                                                    </a></p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Small news -->
                                    <?php
                                } 
                                }   
                            ?>
                        </div>
                        <!-- Grid column -->

                        <!-- Grid column -->
                        <div class="col-md-5 mx-4 my-3">
                            <?php 
                    $sql =  "SELECT post_date, post_subject, post_id, user_photo FROM tb_forum_post JOIN tb_user ON user_id = post_user ORDER by post_date desc limit 3 offset 3";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                                        // output data of each row
                                        while($row = mysqli_fetch_array($result)) {
                                           
                    ?>
                                        <!-- Small news -->
                                        <div class="single-news">
                                            <div class="row mb-2">
                                                <div class="col-md-4">
                                                <!-- Image -->
                                                <div class="view overlay rgba-white-slight mb-2">
                                                <img src="img/alice-img/<?php echo $row['user_photo']; ?>"
                                                    class="img-fluid rounded-circle w-75 mx-auto alice-avatar" alt="Avatar">
                                                    <a>
                                                    <div class="mask rgba-white-slight"></div>
                                                    </a>
                                                </div>
                                                </div>
                                                <!-- Excerpt -->
                                                <div class="col-md-8">
                                                <p class="font-small text-left mb-2"><strong><?php echo (date('d-m-Y', strtotime($row[0]))); ?></strong></p>
                                                <p class="text-left"><a href="?p=forum&id=<?php echo $row[2]; ?>" class="text-secondary stretched-link text"><?php echo ($row[1]); ?>
                                                    <i class="fas fa-angle-right float-right"></i>
                                                    </a></p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Small news -->
                                    <?php
                                }
                                }    
                            ?>
                        </div>
                        <!-- Grid column -->
                        </div>
                    </div>
                    <!-- News card -->
                    </div>

                    <!-- Grid row -->
                    <h4 class="font-weight-bold mt-5"><strong>POST PALING DIMINATI</strong></h4>
                    <hr class="red title-hr">
                    <!-- Grid row -->
                    <div class="row mb-4">
                    <?php
                        $query = mysqli_query($conn, "SELECT * FROM tb_forum_post JOIN tb_user ON user_id = post_user ORDER BY post_view DESC LIMIT 6");
                        while ($result = mysqli_fetch_array($query)) { 
                            ?>
                                <!-- Grid column -->
                                <div class="col-md-4 my-3">
                                    <!-- Card -->
                                    <div class="card" style="height: 20rem;">
                                    <!-- Card content -->
                                    <div class="card-body">
                                        <!-- Title -->
                                        <h4 class="card-title" style="height: 4rem;"><strong><?php echo substr($result['post_subject'], 0, 25); if (strlen($result['post_subject']) >= 25) echo '...'; ?></strong></h4>
                                        <hr>
                                        <!-- Text -->
                                        <p class="card-text mb-3" style="height: 6rem;"><?php echo substr($result['post_content'], 0, 80); if (strlen($result['post_content']) >= 80) echo '...'; ?>
                                        </p>
                                        <p class="font-small font-weight-bold dark-grey-text mb-1"><i class="far fa-clock-o"></i>
                                        <?php echo date('d/m/Y', strtotime($result['post_date'])); ?></p>
                                        <p class="font-small grey-text mb-0"><?php echo $result['user_name']; ?></p>
                                        <p class="text-right mb-0 font-small font-weight-bold"><a href="?p=forum&id=<?php echo $result['post_id']; ?>" class="text-secondary">Baca selengkapnya <i
                                            class="fas fa-angle-right"></i></a></p>
                                    </div>
                                    <!-- Card content -->
                                    </div>
                                    <!-- Card -->
                                </div>
                                <!-- Grid column -->
                            <?php
                        }
                    ?>
                    </div>
                    <!-- Section: Magazine posts -->
                
                    <div class="row justify-content-center mb-4">
                        <a href="?p=list&type=post" class="btn btn-secondary">Lihat semua post</a>
                    </div>
                    
                </section>
              <?php
          }
        ?>
          

        </div>
        <!-- Main news -->

        <!-- Sidebar -->
        <div class="col-xl-4 col-md-12 widget-column mt-0">

            <!-- Section: Search -->
            <section class="section mb-5">
                <h4 class="font-weight-bold mt-2"><strong>PENCARIAN</strong></h4>
                <hr class="red title-hr">
                <!-- Search form -->
                <form class="w-100 mx-auto py-2" method="get">
                    <input type="text" name="p" value="forum" hidden>
                    <input class="form-control w-100 submit-on-enter btn-rounded" type="text" name="keyword" placeholder="Cari post" aria-label="Search">
                </form>
                <!-- Search form -->
            </section>
            <!-- Section: Search -->

            <!-- Section: Categories -->
            <section class="section mb-5">
                <h4 class="font-weight-bold mt-2"><strong>KATEGORI</strong></h4>
                <hr class="red title-hr">
                <ul class="list-group z-depth-1 mt-4">
                <?php
                //$sql = "SELECT course_id,course_name,course_sks FROM tb_course";
                $sql = "SELECT course_name, count(post_id) as counts, course_id FROM tb_course LEFT JOIN tb_forum_post on course_id = post_course group by course_name, course_id order by counts desc";
                $result = mysqli_query($conn, $sql);
               // $hitung = mysqli_query($conn, $count);
                if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                    $i = 0;
                    while($row = mysqli_fetch_array($result)) {
                        ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="?p=list&type=post-course&id=<?php echo $row[2]; ?>" class="text-secondary"><?php echo $row[0];?></a>
                            <span class="badge badge-danger badge-pill"><?php echo $row[1]; ?></span>
                        </li>
                        <?php
                        if ($i == 5) {
                            echo '<div class="collapse" id="collapseCourse">';
                        }
                        $i++;
                    }
                    echo '</div>'; 
                 } else {
                     echo "0 Result";
                 }
                ?>
                    <li class="list-group-item d-flex justify-content-center align-items-center">
                        <a data-toggle="collapse" data-target="#collapseCourse" class="text-secondary">Lihat Selengkapnya</a>
                    </li>
                </ul>

            </section>
            <!-- Section: Categories -->

            <!-- Section: Featured posts -->
            <section class="section widget-content mt-5">

                <!-- Heading -->
                <h4 class="font-weight-bold mt-2"><strong>POST POPULER</strong></h4>
                <hr class="red title-hr">
                <!-- Heading -->

                <div class="card card-body pb-0 mt-4 mb-4">
                    <?php
                        $i = 0;
                        $query = mysqli_query($conn, "SELECT *, (SELECT COUNT(*) FROM tb_forum_comment WHERE comment_post = post_id) AS post_comment FROM tb_forum_post JOIN tb_user ON user_id = post_user ORDER BY post_comment DESC LIMIT 5");
                        while ($result = mysqli_fetch_array($query)) { 
                            ?>
                                <div class="single-post">
                                    <!-- Grid row -->
                                    <div class="row">
                                        <div class="col-4">
                                            <!-- Image -->
                                            <div class="view overlay rgba-white-slight">
                                                <img src="img/alice-img/<?php echo $result['user_photo'];?>"
                                                    class="img-fluid rounded-0 w-75 ml-2" alt="Avatar">
                                                <a>
                                                    <div class="mask waves-light"></div>
                                                </a>
                                            </div>
                                        </div>
                                        <!-- Excerpt -->
                                        <div class="col-8">
                                            <div class="post-data">
                                                <a href="?p=forum&id=<?php echo $result['post_id']; ?>" class="text-secondary stretched-link"><strong><?php echo $result['post_subject']; ?></strong></a>
                                                <p class="font-small mb-0 text-black-50">
                                                    <?php echo date('d-m-Y', strtotime($result['post_date']));?>
                                                </p>
                                                <a class="font-small mb-0"><i class="fas fa-comment-alt"></i>
                                                    <?php echo $result['post_comment']; ?>
                                                </a>
                                                <a class="font-small mb-0 ml-3"><i class="fas fa-eye"></i></i>
                                                    <?php echo $result['post_view'] ?>
                                                </a>
                                            </div>
                                        </div>
                                        <!-- Excerpt -->
                                    </div>
                                    <!-- Grid row -->
                                </div>
                            <?php
                            if ($i != 4) {
                                echo '<hr>';
                            } else {
                                echo '<div class="mb-4"></div>';
                            }
                            $i++;
                        }
                    ?>
                </div>
            </section>
            <!-- Section: Featured posts -->

        </div>
        <!-- Sidebar -->

      </div>
      <!-- Magazine -->

    </div>

  </main>
  <!-- Main layout -->