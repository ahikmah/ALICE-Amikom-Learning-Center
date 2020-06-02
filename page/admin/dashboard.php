<?php
    //counter
    $n_user    = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tb_user"));
    $n_post    = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tb_forum_post"));
    $n_mats    = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tb_material"));
    $n_class   = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tb_class"));
    $n_course  = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tb_course"));
    $n_comment = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tb_forum_comment"));
    $n_mats_dl = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tb_material_downloaded"));
    $n_visit   = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tb_visit"));

    //chart
    $usr_lect_verif     = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tb_user WHERE user_role = '2' AND user_verified = '1'"));
    $usr_lect_notverif  = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tb_user WHERE user_role = '2' AND user_verified = '0'"));
    $usr_stdn_verif     = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tb_user WHERE user_role = '3' AND user_verified = '1'"));
    $usr_stdn_notverif  = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tb_user WHERE user_role = '3' AND user_verified = '0'"));

    //traffic
    $query_traffic = mysqli_query($conn, "SELECT DATE_FORMAT(visit_date, '%d/%m') AS day, COUNT(*) AS count FROM tb_visit WHERE visit_date >= NOW() + INTERVAL -7 DAY AND visit_date < NOW() + INTERVAL 0 DAY GROUP BY DAY(visit_date)");
    $traffic = array();
    while ($result = mysqli_fetch_assoc($query_traffic)){
      $traffic[] = $result;
    }

    //recent
    $recent_post     = mysqli_query($conn, "SELECT post_id, post_subject FROM tb_forum_post ORDER BY post_date DESC LIMIT 5");
    $recent_material = mysqli_query($conn, "SELECT material_id, material_subject FROM tb_material ORDER BY material_date DESC LIMIT 5");
    $recent_user     = mysqli_query($conn, "SELECT user_id, user_name FROM tb_user ORDER BY user_created DESC LIMIT 5");
?>
<!-- Main layout -->
<main>

<div class="container">

  <!-- Section: Intro -->
  <section class="mt-md-4 pt-md-2 mb-5 pb-4">

    <!-- Grid row -->
    <div class="row">

      <!-- Grid column -->
      <div class="col-xl-3 col-md-6 mb-xl-0 mb-4">

        <!-- Card -->
        <div class="card card-cascade cascading-admin-card">

          <!-- Card Data -->
          <div class="admin-up">
            <i class="fas fa-user primary-color mr-3 z-depth-1"></i>
            <div class="data">
              <p class="text-uppercase">Pengguna</p>
              <h4 class="font-weight-bold dark-grey-text"><?php echo $n_user; ?></h4>
            </div>
          </div>

          <!-- Card content -->
          <div class="card-body card-body-cascade pt-2">
            <hr class="mt-0">
            <a href="?p=admin&v=student"><p class="card-text">Lihat semua pengguna<i class="fas fa-angle-right ml-2"></i></p></a>
          </div>

        </div>
        <!-- Card -->

      </div>
      <!-- Grid column -->

      <!-- Grid column -->
      <div class="col-xl-3 col-md-6 mb-xl-0 mb-4">

        <!-- Card -->
        <div class="card card-cascade cascading-admin-card">

          <!-- Card Data -->
          <div class="admin-up">
            <i class="fas fa-copy warning-color mr-3 z-depth-1"></i>
            <div class="data">
              <p class="text-uppercase">Postingan Forum</p>
              <h4 class="font-weight-bold dark-grey-text"><?php echo $n_post; ?></h4>
            </div>
          </div>

          <!-- Card content -->
          <div class="card-body card-body-cascade pt-2">
            <hr class="mt-0">
            <a href="?p=admin&v=post-forum"><p class="card-text">Lihat semua post<i class="fas fa-angle-right ml-2"></i></p></a>
          </div>

        </div>
        <!-- Card -->

      </div>
      <!-- Grid column -->

      <!-- Grid column -->
      <div class="col-xl-3 col-md-6 mb-md-0 mb-4">

        <!-- Card -->
        <div class="card card-cascade cascading-admin-card">

          <!-- Card Data -->
          <div class="admin-up">
            <i class="fas fa-file-archive light-blue lighten-1 mr-3 z-depth-1"></i>
            <div class="data">
              <p class="text-uppercase">Materi</p>
              <h4 class="font-weight-bold dark-grey-text"><?php echo $n_mats; ?></h4>
            </div>
          </div>

          <!-- Card content -->
          <div class="card-body card-body-cascade pt-2">
            <hr class="mt-0">
            <a href="?p=admin&v=post-material"><p class="card-text">Lihat semua materi<i class="fas fa-angle-right ml-2"></i></p></a>
          </div>

        </div>
        <!-- Card -->

      </div>
      <!-- Grid column -->

      <!-- Grid column -->
      <div class="col-xl-3 col-md-6 mb-0">

        <!-- Card -->
        <div class="card card-cascade cascading-admin-card">

          <!-- Card Data -->
          <div class="admin-up">
            <i class="fas fa-chalkboard-teacher red accent-2 mr-3 z-depth-1"></i>
            <div class="data">
              <p class="text-uppercase">Ruang kelas</p>
              <h4 class="font-weight-bold dark-grey-text"><?php echo $n_class; ?></h4>
            </div>
          </div>

          <!-- Card content -->
          <div class="card-body card-body-cascade pt-2">
            <hr class="mt-0">
            <a href="?p=admin&v=classroom"><p class="card-text">Lihat semua kelas<i class="fas fa-angle-right ml-2"></i></p></a>
          </div>

        </div>
        <!-- Card -->

      </div>
      <!-- Grid column -->

    </div>
    <!-- Grid row -->

  </section>
  <!-- Section: Intro -->

  <!-- Section: Main panel -->
  <section class="mb-5">

    <!-- Card -->
    <div class="card card-cascade narrower">

      <!-- Section: Chart -->
      <section>

        <!-- Grid row -->
        <div class="row">

          <!-- Grid column -->
          <div class="col-xl-5 col-lg-12 mr-0 pb-2">

            <!-- Card image -->
            <div class="view view-cascade gradient-card-header purple-gradient lighten-1">
              <h2 class="h2-responsive mb-0 font-weight-500">Trafik</h2>
            </div>

            <!-- Card content -->
            <div class="card-body card-body-cascade pb-0">

              <!-- Panel data -->
              <div class="row py-3 pl-4">

                <!-- First column -->
                <div class="col-md-12">

                  <!-- Date select -->
                  <p class="lead"><span class="badge secondary-color p-2">Jumlah pengguna</span></p>

                  <canvas id="userChart" class="mb-4"></canvas>

                </div>
                <!-- First column -->

              </div>
              <!-- Panel data -->

            </div>
            <!-- Card content -->

          </div>
          <!-- Grid column -->

          <!-- Grid column -->
          <div class="col-xl-7 col-lg-12 mb-4 pb-2">

            <!-- Chart -->
            <div class="view view-cascade gradient-card-header purple-gradient">

              <canvas id="lineChart" height="175"></canvas>

            </div>

          </div>
          <!-- Grid column -->

        </div>
        <!-- Grid row -->

      </section>
      <!-- Section: Chart -->
      
    </div>
    <!-- Card -->

  </section>
  <!-- Section: Main panel -->

  <!-- Section: Cascading panels -->
  <section class="mb-5">

    <!-- Grid row -->
    <div class="row">

      <!-- Grid column -->
      <div class="col-lg-4 col-md-12 mb-lg-0 mb-4">

        <!-- Panel -->
        <div class="card">

          <div class="card-header white-text secondary-color">
            Post terbaru
          </div>

          <div class="card-body px-4 mb-3">
            <div class="list-group list-panel">
              <?php 
                while ($result = mysqli_fetch_array($recent_post)) {
                  ?>
                    <a href="?p=forum&id=<?php echo $result['post_id']; ?>" class="list-group-item d-flex justify-content-between dark-grey-text"><?php echo $result['post_subject']; ?>
                      <i class="fas fa-external-link-alt ml-1" data-toggle="tooltip" data-placement="top"
                        title="Klik untuk melihat"></i>
                    </a>
                  <?php
                }
              ?>
            </div>
          </div>

        </div>
        <!-- Panel -->

      </div>
      <!-- Grid column -->

      <!-- Grid column -->
      <div class="col-lg-4 col-md-6 mb-md-0 mb-4">

        <!-- Panel -->
        <div class="card">

          <div class="card-header white-text secondary-color">
            Materi terbaru
          </div>

          <div class="card-body text-center px-4 mb-3">
            <div class="list-group list-panel">
              <?php 
                while ($result = mysqli_fetch_array($recent_material)) {
                  ?>
                    <a href="?p=materi-post&id=<?php echo $result['material_id']; ?>" class="list-group-item d-flex justify-content-between dark-grey-text"><?php echo $result['material_subject']; ?>
                      <i class="fas fa-external-link-alt ml-1" data-toggle="tooltip" data-placement="top"
                        title="Klik untuk melihat"></i>
                    </a>
                  <?php
                }
              ?>
            </div>
          </div>

        </div>
        <!-- Panel -->

      </div>
      <!-- Grid column -->

      <!-- Grid column -->
      <div class="col-lg-4 col-md-6 mb-0">

        <!-- Panel -->
        <div class="card">

          <div class="card-header white-text secondary-color">
            Pengguna terbaru
          </div>

          <div class="card-body text-center px-4 mb-3">
            <div class="list-group list-panel">
              <?php 
                while ($result = mysqli_fetch_array($recent_user)) {
                  ?>
                    <a href="?p=admin&v=user-form&act=update&id=<?php echo $result['user_id']; ?>" class="list-group-item d-flex justify-content-between dark-grey-text"><?php echo $result['user_name']; ?>
                      <i class="fas fa-external-link-alt ml-1" data-toggle="tooltip" data-placement="top"
                        title="Klik untuk melihat"></i>
                    </a>
                  <?php
                }
              ?>
            </div>
          </div>

        </div>
        <!-- Panel -->

      </div>
      <!-- Grid column -->

    </div>
    <!-- Grid row -->

  </section>
  <!--Section: Cascading panels-->

  <!-- Section: Classic admin cards -->
  <section class="pb-3">

    <!-- Grid row -->
    <div class="row">

      <!-- Grid column -->
      <div class="col-xl-3 col-md-6 mb-xl-0 mb-4">

        <!-- Card Primary -->
        <div class="card classic-admin-card primary-color">
          <div class="card-body">
            <div class="pull-right">
              <i class="fas fa-layer-group"></i>
            </div>
            <p class="white-text">MATA KULIAH</p>
            <h4 class="check"><?php echo $n_course;?></h4>
          </div>
        </div>
        <!-- Card Primary -->

      </div>
      <!-- Grid column -->

      <!-- Grid column -->
      <div class="col-xl-3 col-md-6 mb-xl-0 mb-4">

        <!-- Card Yellow -->
        <div class="card classic-admin-card warning-color">
          <div class="card-body">
            <div class="pull-right">
              <i class="fas fa-comment-alt"></i>
            </div>
            <p>KOMENTAR</p>
            <h4 class="check"><?php echo $n_comment; ?></h4>
          </div>
        </div>
        <!-- Card Yellow -->

      </div>
      <!-- Grid column -->

      <!-- Grid column -->
      <div class="col-xl-3 col-md-6 mb-md-0 mb-4">

        <!-- Card Blue -->
        <div class="card classic-admin-card light-blue lighten-1">
          <div class="card-body">
            <div class="pull-right">
              <i class="fas fa-chart-line"></i>
            </div>
            <p>MATERI DIUNDUH</p>
            <h4 class="check"><?php echo $n_mats_dl;?></h4>
          </div>
        </div>
        <!-- Card Blue -->

      </div>
      <!-- Grid column -->

      <!-- Grid column -->
      <div class="col-xl-3 col-md-6 mb-0">

        <!-- Card Red -->
        <div class="card classic-admin-card red accent-2">
          <div class="card-body">
            <div class="pull-right">
              <i class="fas fa-chart-bar"></i>
            </div>
            <p>PENGUNJUNG</p>
            <h4 class="check"><?php echo $n_visit; ?></h4>
          </div>
        </div>
        <!-- Card Red -->

      </div>
      <!-- Grid column -->

    </div>
    <!-- Grid row -->

  </section>
  <!-- Section: Classic admin cards -->

</div>

</main>
<!-- Main layout -->

<script>
$(document).ready(function(){
    //user chart
    var ctxD = document.getElementById("userChart").getContext('2d');
    var myLineChart = new Chart(ctxD, {
        type: 'doughnut',
        data: {
            labels: ["Dosen Sudah Verifikasi", "Dosen Belum Verifikasi", "Mahasiswa Sudah Verifikasi", "Mahasiswa Belum Verifikasi"],
            datasets: [{
                data: [<?php echo "$usr_lect_verif,$usr_lect_notverif,$usr_stdn_verif,$usr_stdn_notverif"; ?>],
                backgroundColor: ["#F7464A", "#46BFBD", "#FDB45C", "#949FB1"],
                hoverBackgroundColor: ["#FF5A5E", "#5AD3D1", "#FFC870", "#A8B3C5"]
            }]
        },
        options: {
            responsive: true
        }
    });

    //traffic chart
    var ctxL = document.getElementById("lineChart").getContext('2d');
    var myLineChart = new Chart(ctxL, {
        type: 'line',
        data: {
            labels: [<?php 
                $i = 1;
                foreach ($traffic as $value) {
                  if ($i != 1) echo ",";
                  echo '"'.$value['day'].'"';
                  $i++;
                }
              ?>],
            datasets: [{
            label: "Pengunjung",
            fillColor: "#fff",
            backgroundColor: 'rgba(255, 255, 255, .3)',
            borderColor: 'rgba(255, 255, 255)',
            data: [<?php 
                $i = 1;
                foreach ($traffic as $value) {
                  if ($i != 1) echo ",";
                  echo $value['count'];
                  $i++;
                }
              ?>],
            }]
        },
        options: {
            legend: {
                labels: {
                    fontColor: "#fff",
                }
            },
        scales: {
            xAxes: [{
                gridLines: {
                    display: true,
                    color: "rgba(255,255,255,.25)"
                },
                    ticks: {
                    fontColor: "#fff",
                },
        }],
        yAxes: [{
            display: true,
            gridLines: {
                display: true,
                color: "rgba(255,255,255,.25)"
            },
            ticks: {
                fontColor: "#fff",
            },
        }],
        }
        }
    });
});
</script>