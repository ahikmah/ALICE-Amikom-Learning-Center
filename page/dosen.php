<?php

require_once 'config/conf.php';



?>

<div class="container">
    <div class="row justify-content-center mt-4">
        <div class="col-md-8 text-center">
            <h3 class="h3">Dosen</h3>
            <p class="mt-2">Sebagai sekolah tinggi di bidang informatika, proses belajar-mengajar di UNIVERSITAS AMIKOM didukung oleh tenaga pengajar yang berkualitas.</p>
            <!-- Search form -->

            <form class="w-50 mx-auto py-2" method="get">
                <input type="text" name="p" value="dosen" hidden>
                <input class="form-control w-100 submit-on-enter btn-rounded" type="text" name="keyword" placeholder="Cari dosen" aria-label="Search">
            </form>
            <!-- Search form -->
        </div>
    </div>
    <div class="row mt-4">
        <!-- Dosen Thumbnail -->
        <?php
            $sql = "SELECT user_id, user_name, profile_status, user_photo FROM tb_user JOIN tb_lecturer_profile ON tb_user.user_id = tb_lecturer_profile.profile_user WHERE user_role=2 AND user_verified = 1 AND user_name LIKE '%$keyword%' ORDER BY user_name ASC";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                // output data of each row
                while($row = mysqli_fetch_array($result)) {
                ?>
                    <div class="col-sm-12 col-md-4 col-xl-3 mb-4">
                        <div class="card">
                            <div class="card-body p-2 d-flex align-items-center">
                                <div class="flex-shrink-1 mr-2">
                                    <img src="img/alice-img/<?php echo $row[3];?>" class="img-fluid rounded-circle alice-avatar" alt="Avatar">
                                </div>
                                <div class="w-75">
                                    <div class="row m-0" id="myDosen">
                                    <?php
                                        echo "<a href='?p=profile&id=$row[0]' class='w-100 stretched-link text-secondary text-truncate' style='line-height:1.1;'>";
                                        echo $row[1];
                                        echo "</a>";
                                        echo "<span class='badge badge-pill badge-success mt-1 mr-5'>$row[2]</span>";          
                                    ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
            } 
        } else {
            echo "0 Result";
        }
        ?>

        <script>
        function myFunction() {
            var input, filter,a, i, txtValue;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            a = document.getElementById("myDosen");
            for (i = 0; i < a.length; i++) {
            a = a[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
            a[i].style.display = "";
            } else {
            a[i].style.display = "none";
             }
            }
            }
        </script>

        <!-- ./Dosen Thumbnail -->
    </div>
</div>