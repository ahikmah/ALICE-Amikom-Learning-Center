<?php
    $query  = mysqli_query($conn, 'SELECT user_id, user_name, user_email, user_created, user_verified FROM tb_user WHERE user_role = 3');
?>
<!-- Main layout -->
  <main>
    <div class="container-fluid pt-sm-2 pt-xl-0">
      <!-- Section: Main panel -->
      <section class="mt-md-4 pt-md-2 mb-5 pb-4">
        <!-- Card -->
        <div class="card card-cascade narrower">
          <!-- Section: Chart -->
          <section>
            <!-- Grid row -->
            <div class="row justify-content-between">
                <!-- Grid column -->
                <div class="col-xl-5 col-lg-12 mr-0 pb-2">
                    <!-- Card image -->
                    <div class="view view-cascade gradient-card-header purple-gradient">
                    <h2 class="h2-responsive mb-0 font-weight-500">Mahasiswa</h2>
                    </div>
                </div>
                <!-- Grid column -->
                <!-- <div class="col-xl-2 col-lg-12 my-3 mr-0 row justify-content-center">
                    <a href="?p=admin&v=course-form&act=add"><button class="btn btn-success" type="button">Tambah</button></a>
                </div> -->
            </div>
            <!-- Grid row -->
          </section>
          <!-- Section: Chart -->

          <!-- Section: Table -->
          <section>
            <div class="card card-cascade narrower z-depth-0 mt-5">
              <div class="view view-cascade gradient-card-header bg-secondary narrower py-2 mx-4 mb-3 d-flex justify-content-center align-items-center">
                <a href="" class="white-text mx-3">Daftar Mahasiswa</a>
              </div>
              <div class="px-4">
                <div class="table-responsive p-2">
                  <!--Table-->
                  <table id="dataTableStudent" class="table table-hover table-fixed mb-0">
                    <!-- Table head -->
                    <thead>
                      <tr>
                        <th style="width:100px;"><a>No.</a></th>
                        <th style="width:150px;"><a>NIM</a></th>
                        <th class="th-lg"><a>Nama</a></th>
                        <th class="th-lg"><a>Email</a></th>
                        <th class="th-lg"><a>Pendaftaran</a></th>
                        <th style="width: 150px;"><a>Verifikasi</a></th>
                        <th class="th-lg"><a>Aksi</a></th>
                      </tr>
                    </thead>
                    <!-- Table head -->

                    <!-- Table body -->
                    <tbody>
                      <?php
                        $i = 1;
                        while ($data = mysqli_fetch_array($query)) {
                            if ($data[4] == 1) {
                              $is_verified = 'Sudah';
                              $unverified = 'un';
                              $btn_verify = 'warning';
                            } else {
                              $is_verified = 'Belum';
                              $unverified = '';
                              $btn_verify = 'success';
                            }
                            echo "<tr>";
                            echo "<td>$i</td>";
                            echo "<td>$data[0]</td>";
                            echo "<td>$data[1]</td>";
                            echo "<td class='text-truncate'>$data[2]</td>";
                            echo "<td>$data[3]</td>";
                            echo "<td>$is_verified</td>";
                            echo "<td>";
                            echo "<a href='?p=admin&v=user-form&act=update&id=$data[0]'><span class='badge badge-lg badge-primary'>UBAH</span></a>";
                            echo "<a href='action/_user.php?act=delete&id=$data[0]&v=student' class='ml-2'><span class='badge badge-danger'>HAPUS</span></a>";
                            echo "<a href='action/_user.php?act=".$unverified."verify&id=$data[0]&v=student' class='ml-2'><span class='badge badge-$btn_verify'>".strtoupper($unverified)."VERIFIKASI</span></a>";
                            echo "</td>";
                            echo "</tr>";
                            $i++;
                        }
                      ?>
                    </tbody>
                    <!-- Table body -->
                  </table>
                  <!-- Table -->
                </div>
              </div>
            </div>
          </section>
          <!--Section: Table-->
        </div>
        <!-- Card -->
      </section>
      <!-- Section: Main panel -->
    </div>

  </main>
  <!-- Main layout -->

<script>
    $('#dataTableStudent').DataTable({
        columnDefs: [{
            orderable: false,
            targets: 6
        }]
    });
    $('.dataTables_length').addClass('bs-select');
    $('.dataTables_wrapper').css("padding","10px");
</script>