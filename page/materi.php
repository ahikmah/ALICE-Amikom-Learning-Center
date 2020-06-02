<?php

    require_once 'config/conf.php';
    $i=0;
    $j=0;        
?>
<script type="text/javascript" src="js/addons/datatables.min.js"></script>
<!-- DataTables Select  -->
<script type="text/javascript" src="js/addons/datatables-select.min.js"></script>
<body class="fixed-sn homepage-v3">

  <!-- Main layout -->
  <main class="pt-4">
    <div class="container-fluid">

      <!-- Magazine -->
      <div class="row">
        <!-- Main news -->
        <div class="col-xl-12 col-md-12">
        <?php
          if (isset($_GET['id'])) {
              include 'materi-post.php';
          } else {
              ?>

  
            <div id="carousel-example-multi" class="carousel slide carousel-multi-item v-2" data-ride="carousel">
                <!-- Search form -->
                    <form class="w-50 mx-auto py-2" action ="" action="GET">
                        <input type="text" name="p" value="materi" hidden>
                        <input class="form-control w-100 submit-on-enter btn-rounded" type="text" name="keyword" placeholder="Cari materi" aria-label="Search">
                    </form>
                <!-- Search form -->
                    <div class="row align-items-center controls-top">

                        <div class="col-md-1 d-none d-md-block d-lg-block">
                        </div>
                        <div class="col-md-10">
                            <div class="carousel-inner v-2" role="listbox">
                                <?php
                                    $materi_all      = mysqli_query($conn, "SELECT * FROM tb_material JOIN tb_course ON tb_material.material_course = tb_course.course_id JOIN tb_user ON tb_user.user_id=tb_material.material_user  WHERE tb_material.material_subject LIKE '%$keyword%' || tb_course.course_name LIKE '%$keyword%' || tb_user.user_name LIKE '%$keyword%' ORDER BY tb_material.material_date DESC");                                
                                while ($result = mysqli_fetch_array($materi_all)) {
                                    if($keyword){ 
                                ?>       
                                    <div class="col-12 col-md-4 my-2">
                                        <!-- Card -->
                                        <div class="card">
                                            <!-- Card content -->
                                            <div class=" view overlay card-body">
                                                <!-- Title -->
                                                <h6 class="card-title"><strong><?php echo $result['material_subject'] ?></strong></h6>
                                                <a href="?p=list&type=material-course&id=<?php echo $result['material_course'];?>"><span class="badge badge-pill badge-success text-truncate z-depth-0">
                                                <?php echo $result['course_name']?></span></span></a>
                                                <hr class="mt-1">
                                                <div class="row mb-3">
                                                    <p class="col-md-6 mb-0 font-small dark-grey-text text-truncate"><i class="fas fa-download"></i>
                                                    <?php 
                                                        $materi_id = $result['material_id'];
                                                        $jml_download = mysqli_query($conn, "SELECT * FROM tb_material_downloaded WHERE material_id = $materi_id");
                                                        echo mysqli_num_rows($jml_download);
                                                    ?>    </p>
                                                    <p class="col-md-6 mb-0 font-small font-weight-bold dark-grey-text"><i class="far fa-clock"></i>
                                                    <?php echo date('d-m-Y', strtotime($result['material_date'])) ?></p>
                                                </div>
                                                <p class="col-md-12 font-small my-3"><?php echo substr($result['material_content'],0,30) ?></p></p>
                                                <hr>
                                                <div class="row">
                                                    <p class="col-md-6 mb-0 font-small font-weight-bold dark-grey-text text-truncate"><i class="far fa-user"></i>
                                                    <a href="?p=profile&id=<?php echo $result['material_user']?>" class="text-secondary">
                                                    <?php echo $result['user_name'] ?></a></a></p>
                                                    <p class="col-md-6 mb-0 font-small font-weight-bold dark-grey-text">
                                                    <a href="?p=materi-post&id=<?php echo $result['material_id']?>" class="text-secondary">
                                                    Lihat materi <i class="fas fa-angle-right"></i></a></p>
                                                </div>
                                            
                                            <!-- Card content -->
                                            </div>
                                        </div>
                                        <!-- Card -->
                                    </div>
                                <?php
                                    }}
                                ?>
                            </div>
                        </div>
                        <div class="col-md-1 d-none d-md-block d-lg-block">
                            <!-- <a class="" href="#carousel-example-multi" data-slide="next"><i
                                class="fas fa-chevron-right"></i></a> -->
                        </div>
                    </div>
            </div>
 

                <!-- Section: Magazine posts -->
                <section class="section extra-margins mt-2">
                    <!-- Grid row -->
                    <h4 class="font-weight-bold mt-5"><strong>MATERI TERBARU</strong></h4>
                    <hr class="red title-hr">
                    <!-- Grid row -->
                    <div id="carousel-example-multi" class="carousel slide carousel-multi-item v-2" data-ride="carousel">
                        <div class="row align-items-center controls-top">
                            <div class="col-md-1 d-none d-md-block d-lg-block">
                                <a class="" href="#carousel-example-multi" data-slide="prev"><i
                                    class="fas fa-chevron-left"></i></a>
                            </div>
                            <div class="col-md-10">
                                <div class="carousel-inner v-2" role="listbox">
                                <?php
                                $query = mysqli_query($conn, "SELECT * FROM tb_material JOIN tb_course ON tb_material.material_course = tb_course.course_id JOIN tb_user ON tb_user.user_id=tb_material.material_user ORDER BY tb_material.material_date DESC");                                
                                    while ($row=mysqli_fetch_assoc($query)) { 
                                           $i++;                                                           
                                        ?>
                                            <div class="carousel-item <?php if ($i ==1  ) echo 'active'; ?>">
                                                <div class="col-12 col-md-4 my-2">
                                                    <!-- Card -->
                                                    <div class="card">
                                                        <!-- Card content -->
                                                        <div class="card-body">
                                                            
                                                            <!-- Title -->
                                                            <h6 class="card-title"><strong><?php echo $row['material_subject'] ?></strong></h6>
                                                            <a href="?p=list&type=material-course&id=<?php echo $row['material_course'];?>"><span class="badge badge-pill badge-success text-truncate z-depth-0">
                                                            <?php echo $row['course_name']?></span></a>
                                                            <hr class="mt-1">
                                                            <div class="row mb-3">
                                                                <p class="col-md-6 mb-0 font-small dark-grey-text text-truncate"><i class="fas fa-download"></i>
                                                                <?php 
                                                                    $materi_id = $row['material_id'];
                                                                    $jml_download = mysqli_query($conn, "SELECT * FROM tb_material_downloaded WHERE material_id = $materi_id");
                                                                    echo mysqli_num_rows($jml_download);
                                                                ?>                                               
                                                                <p class="col-md-6 mb-0 font-small font-weight-bold dark-grey-text"><i class="far fa-clock"></i>
                                                                <?php echo date('d-m-Y', strtotime($row['material_date'])) ?></p>
                                                            </div>
                                                            <p class="col-md-12 font-small my-3"><?php echo substr($row['material_content'],0,30) ?></p>
                                                            <hr>
                                                            <div class="row">
                                                                <p class="col-md-6 mb-0 font-small font-weight-bold dark-grey-text text-truncate"><i class="far fa-user"></i>
                                                                <a href="?p=profile&id=<?php echo $row['material_user']?>" class="text-secondary">
                                                                <?php echo $row['user_name'] ?></a></p>
                                                                <p class="col-md-6 mb-0 font-small font-weight-bold dark-grey-text">
                                                                <a href="?p=materi-post&id=<?php echo $row['material_id']?>" class="text-secondary">
                                                                Lihat materi <i class="fas fa-angle-right"></i></a></p>
                                                            </div>
                                                        
                                                            
                                                        </div>
                                                        
                                                        <!-- Card content -->
                                                    </div>
                                                    
                                                    <!-- Card -->
                                                </div>
                                                
                                            </div>
                                        <?php
                                        }
                                    ?>      
                                </div>
                                
                            </div>
                            <div class="col-md-1 d-none d-md-block d-lg-block">
                                <a class="" href="#carousel-example-multi" data-slide="next"><i
                                    class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </div>

                    <!-- Grid row -->
                    <h4 class="font-weight-bold mt-5"><strong>PALING BANYAK DIUNDUH</strong></h4>
                    <hr class="red title-hr">
                    <!-- Grid row -->
                    <div id="carousel-example-multi" class="carousel slide carousel-multi-item v-2" data-ride="carousel">
                        <div class="row align-items-center controls-top">
                            <div class="col-md-1 d-none d-md-block d-lg-block">
                                <a class="" href="#carousel-example-multi" data-slide="prev"><i
                                    class="fas fa-chevron-left"></i></a>
                            </div>
                            <div class="col-md-10">
                                <div class="carousel-inner v-2" role="listbox">
                                    <?php
                                        $query = mysqli_query($conn, "SELECT * FROM tb_material JOIN tb_course ON tb_material.material_course = tb_course.course_id JOIN tb_user ON tb_user.user_id=tb_material.material_user ORDER BY tb_material.material_date ASC");                                
                                        while ($row=mysqli_fetch_assoc($query)) { 
                                               $j++; 
                                            ?>
                                                <div class="carousel-item <?php if ($j == 1) echo 'active'; ?>">
                                                    <div class="col-12 col-md-4 my-2">
                                                        <!-- Card -->
                                                        <div class="card">
                                                            <!-- Card content -->
                                                            <div class="card-body">
                                                                <!-- Title -->
                                                                <h6 class="card-title"><strong><?php echo $row['material_subject'] ?></strong></h6>
                                                                <a href="?p=list&type=material-course&id=<?php echo $row['material_course'];?>"><span class="badge badge-pill badge-success text-truncate z-depth-0">
                                                                <?php echo $row['course_name']?></span></span></a>
                                                                <hr class="mt-1">
                                                                <div class="row mb-3">
                                                                    <p class="col-md-6 mb-0 font-small dark-grey-text text-truncate"><i class="fas fa-download"></i>
                                                                    <?php 
                                                                    $materi_id = $row['material_id'];
                                                                    $jml_download = mysqli_query($conn, "SELECT * FROM tb_material_downloaded WHERE material_id = $materi_id");
                                                                    echo mysqli_num_rows($jml_download);
                                                                    ?>    </p>
                                                                    <p class="col-md-6 mb-0 font-small font-weight-bold dark-grey-text"><i class="far fa-clock"></i>
                                                                    <?php echo date('d-m-Y', strtotime($row['material_date'])) ?></p>
                                                                </div>
                                                                <p class="col-md-12 font-small my-3"><?php echo substr($row['material_content'],0,30) ?></p></p>
                                                                <hr>
                                                                <div class="row">
                                                                    <p class="col-md-6 mb-0 font-small font-weight-bold dark-grey-text text-truncate"><i class="far fa-user"></i>
                                                                    <a href="?p=profile&id=<?php echo $row['material_user']?>" class="text-secondary">
                                                                    <?php echo $row['user_name'] ?></a></a></p>
                                                                    <p class="col-md-6 mb-0 font-small font-weight-bold dark-grey-text">
                                                                    <a class="text-secondary" href="?p=materi-post&id=<?php echo $row['material_id']?>" >
                                                                    Lihat materi <i class="fas fa-angle-right"></i></a></p>
                                                                </div>
                                                            </div>
                                                            <!-- Card content -->
                                                        </div>
                                                        <!-- Card -->
                                                    </div>
                                                </div>
                                            <?php
                                        }
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-1 d-none d-md-block d-lg-block">
                                <a class="" href="#carousel-example-multi" data-slide="next"><i
                                    class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </div>
                
                    <div class="row justify-content-center mb-4">
                        <a href="?p=list&type=material" class="btn btn-secondary">Lihat semua materi</a>                    
                    <!-- Grid row -->
                    </div>
                    
                </section>
              <?php
          }
        ?>
          

        </div>
        <!-- Main news -->

        <!-- sidebar -->

      </div>
      <!-- Magazine -->

    </div>

  </main>
  <!-- Main layout -->