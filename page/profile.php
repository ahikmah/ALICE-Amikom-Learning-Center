<?php
  $profile_id = $_GET['id'];
  $sql = "SELECT * FROM tb_user JOIN tb_lecturer_profile ON tb_user.user_id = tb_lecturer_profile.profile_user WHERE user_id = '$profile_id'";
  $result = mysqli_query($conn, $sql);
  $data = mysqli_fetch_array($result);
?>
<!--Main Layout-->
<main>

<div class="container">

  <!--Section: Team v.1-->
  <section class="text-center team-section">

    <!--Grid row-->
    <div class="row text-center">

      <!--Grid column-->
      <div class="col-md-12 mt-5">

        <div class="avatar mx-auto">
          <img src="img/alice-img/<?php echo $data['user_photo'];?>" class="img-fluid rounded-circle z-depth-1" style="width:100px;height:100px;" alt="Avatar">
        </div>
        <h3 class="my-3 font-weight-bold">
          <strong>
                <a><?php echo $data['user_name']; ?></a>
          </strong>
        </h3>
        <span class="badge badge-pill badge-success">
          <?php echo $data['profile_status']; ?>
        </span>

        <!-- About Lecturer -->
        <p class="mt-3">
          <?php echo $data['profile_about']; ?>
        </p>

      </div>
      <!--Grid column-->

    </div>
    <!--Grid row-->

  </section>
  <!--Section: Team v.1-->

  <!--Section: Tabs-->
  <section>

    <ul class="nav md-pills pills-secondary d-flex justify-content-center">
      <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#panel11" role="tab">
          <i class="fas fa-user-tie mr-1" aria-hidden="true"></i>
          <strong>Informasi Umum</strong>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#panel12" role="tab">
          <i class="fas fa-bars mr-1" aria-hidden="true"></i>
          <strong>Informasi Perkuliahan</strong>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#panel13" role="tab">
        <i class="fas fa-calendar-alt mr-1" aria-hidden="true"></i>
          <strong>Daftar Kelas</strong>
        </a>
      </li>
    </ul>

    <!-- Tab panels -->
    <div class="tab-content">

      <!--Panel 1-->
      <div class="tab-pane fade show active" id="panel11" role="tabpanel">
        <br>

        <!--Grid row-->
        <div class="row justify-content-center">

          <!--Grid column-->
          <div class="col-md-10">

            <div class="jumbotron">
              <div class="row">
                <div class="col-md-4 col-sm-12">
                  <h4 class="h4"><i class="fas fa-envelope mr-3"></i>Alamat email</h4>
                  <a href="mailto:example@mail.com">
                    <p class="lead">
                      <?php
                          echo $data['user_email'];
                      ?>
                    </p>
                  </a>
                </div>
                <div class="col-md-4 col-sm-12">
                  <h4 class="h4"><i class="fas fa-phone mr-3"></i>Nomor Telepon</h4>
                  <p class="lead">
                  <?php
                    echo $data['profile_phone'];
                  ?>
                  </p>
                </div>
                <div class="col-md-4 col-sm-12">
                  <h4 class="h4"><i class="fas fa-globe-americas mr-3"></i>Website</h4>
                  <a href="#" target="_blank"><p class="lead">
                  <?php
                    echo $data['profile_blog'];
                  ?>
                  </p></a>
                </div>
              </div>
              <div class="row mt-4">
                <div class="col-md-4 col-sm-12">
                  <h4 class="h4"><i class="fas fa-building mr-3"></i>Alamat Kantor</h4>
                  <p class="lead">
                  <?php
                    echo $data['profile_office'];
                   ?>

                  </p>
                </div>
                <div class="col-md-8 col-sm-12">
                  <h4 class="h4"><i class="fas fa-home mr-3"></i>Alamat Rumah</h4>
                  <p class="lead">
                  <?php
                    echo $data['profile_address'];
                   ?>
                  </p>
                </div>
              </div>
            </div>

          </div>
          <!--Grid column-->

        </div>
        <!--Grid row-->

      </div>
      <!--/.Panel 1-->

      <!--Panel 2-->
      <div class="tab-pane fade" id="panel12" role="tabpanel">
        <br>

        <div class="row d-flex justify-content-center">
          <!--Grid column-->
          <div class="col-md-10">
            <div class="jumbotron">
              <div class="row">
                <div class="col-md-12 col-sm-12">
                  <p><?php echo $data['profile_info'];?></p>
                </div>
              </div>
            </div>
          </div>
          <!--Grid column-->
        </div>
      </div>
      <!--/.Panel 2-->

      <!--Panel 3-->
      <div class="tab-pane fade" id="panel13" role="tabpanel">
        <br>

        <div class="row d-flex justify-content-center">
          <div class="col-md-10">

            <!-- Table with panel -->
                <div class="card card-cascade narrower">

                <!--Card image-->
                <div class="view view-cascade gradient-card-header purple-gradient narrower py-2 mx-4 mb-3 d-flex justify-content-center align-items-center">

                <a href="" class="white-text mx-3">Kelas yang diampu</a>

                </div>
                <!--/Card image-->

                <div class="px-4">

                <div class="table-wrapper table-responsive">
                    <!--Table-->
                    <table class="table mb-0">

                    <!--Table head-->
                    <thead>
                        <tr class="text-uppercase">
                            <th class="th-md">
                                <a>No.</a>
                            </th>
                            <th class="th-md">
                                <a href="">Nama Kelas</a>
                            </th>
                        </tr>
                    </thead>
                    <!--Table head-->

                    <!--Table body-->


                        <tbody>
                        <?php
                          $query = mysqli_query($conn, "SELECT * FROM tb_class WHERE class_lecturer = $data[user_id]");
                          $i = 1;
                          if (mysqli_num_rows($query) <= 0) {
                            echo "<tr><td></td><td>Tidak ada kelas</td></tr>";
                          }
                          while ($result = mysqli_fetch_array($query)) {
                            echo "<tr>
                                      <td>$i</td>
                                      <td>$result[class_name]</td>
                                  </tr>";
                            $i++;
                          }
                        ?>
                        
                    </tbody>
                    <!--Table body-->
                    </table>
                    <!--Table-->
                </div>

                </div>

                </div>
                <!-- Table with panel -->

          </div>
        </div>

      </div>
      <!--/.Panel 3-->

    </div>

  </section>
  <!--Section: Tabs-->

</div>

</main>
<!--Main Layout-->