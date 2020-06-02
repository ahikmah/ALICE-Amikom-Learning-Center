<?php
    $query  = mysqli_query($conn, 'SELECT post_id, post_subject, user_name, course_name, post_view, post_date FROM tb_forum_post 
                                    JOIN tb_user ON tb_forum_post.post_user = tb_user.user_id 
                                    JOIN tb_course ON tb_forum_post.post_course = tb_course.course_id');
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
                    <h2 class="h2-responsive mb-0 font-weight-500">Post Forum</h2>
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
                <a href="" class="white-text mx-3">Daftar Post Forum</a>
              </div>
              <div class="px-4">
                <div class="table-responsive p-2">
                  <!--Table-->
                  <table id="dataTablePostForum" class="table table-hover mb-0">
                    <!-- Table head -->
                    <thead>
                      <tr>
                        <th class="th-lg" style="width:15px;min-width:15px;"><a>No.</a></th>
                        <th class="th-lg"><a>Judul</a></th>
                        <th class="th-lg"><a>Nama</a></th>
                        <th class="th-lg"><a>Mata Kuliah</a></th>
                        <th class="th-lg"><a>Dilihat</a></th>
                        <th class="th-lg"><a>Tanggal</a></th>
                        <th class="th-lg"><a>Aksi</a></th>
                      </tr>
                    </thead>
                    <!-- Table head -->

                    <!-- Table body -->
                    <tbody>
                      <?php
                        $i = 1;
                        while ($data = mysqli_fetch_array($query)) {
                            echo "<tr>";
                            echo "<td>$i</td>";
                            echo "<td>$data[1]</td>";
                            echo "<td>$data[2]</td>";
                            echo "<td>$data[3]</td>";
                            echo "<td>$data[4]</td>";
                            echo "<td>$data[5]</td>";
                            echo "<td>";
                            echo "<a href='action/_post.php?act=delete&id=$data[0]&v=post-forum' class='ml-2'><span class='badge badge-danger'>HAPUS</span></a>";
                            echo "<a href='?p=forum&id=$data[0]' class='ml-2'><span class='badge badge-primary'>LIHAT</span></a>";
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
    $('#dataTablePostForum').DataTable({
        columnDefs: [{
            orderable: false,
            targets: 6
        }]
    });
    $('.dataTables_length').addClass('bs-select');
    $('.dataTables_wrapper').css("padding","10px");
</script>