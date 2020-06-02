<?php

    if (isset($_SESSION['user'])) {
        $uid = $_SESSION['user'];
    }

    $query  = mysqli_query($conn, "SELECT * FROM tb_user WHERE user_id = '$uid'");
    $result = mysqli_fetch_array($query);

    $photo  = $result['user_photo']; 
    $fname  = $result['user_name'];
    $email  = $result['user_email'];
    $dob    = $result['user_dob'];  
    $gender = $result['user_gender'];
    $exp = $result['user_exp'];

    if ($role == '2') {
        $query_dsn = mysqli_query($conn, "SELECT * FROM tb_lecturer_profile WHERE profile_user = '$uid'");
        $result_dsn = mysqli_fetch_array($query_dsn);

        $address = $result_dsn['profile_address'];
        $office =  $result_dsn['profile_office'];
        $phone = $result_dsn['profile_phone'];
        $blog = $result_dsn['profile_blog'];
        $about = $result_dsn['profile_about'];
        $info = $result_dsn['profile_info'];
    }

    if (isset($_SESSION['error_pass']) && $_SESSION['error_pass'] != ""){
        
        $error_pass=$_SESSION['error_pass'];
        unset($_SESSION['error_pass']);

    } else {
    
        $error_pass = ""; 
    }

?>
<!-- Main layout -->
<main>
    <div class="container mt-4">

    <!-- Section: Edit Account -->
    <section class="section">
        <!-- First row -->
        <div class="row">
        <!-- First column -->
        <div class="col-lg-4 mb-4">
            <!-- Card -->
            <div class="card card-cascade narrower">
            <!-- Card image -->
            <div class="view view-cascade gradient-card-header purple-gradient">
                <h5 class="mb-0 font-weight-bold">Ubah Foto</h5>
            </div>
            <!-- Card image -->
            <!-- Card content -->
            <div class="card-body card-body-cascade text-center">
                <img src="img/alice-img/<?php echo $photo; ?>" alt="User Photo" class="z-depth-1 mb-3 mx-auto rounded-circle" />
                <p class="text-muted"><small><?php if ($role == '3') echo fn_title($conn,$uid).' <br>Skor : '.$exp.' XP'; ?></small></p>
                <p class="text-muted"><small>Foto profil akan terganti otomatis</small></p>
                <div class="row justify-content-center">
                    <input type="file" name="upload_image" id="upload_image" accept="image/*" hidden/>
                    <button id="uploadAvatar" class="btn btn-info btn-rounded btn-sm">Unggah foto baru</button><br>
                    <a href="action/delete_picture.php"><button class="btn btn-danger btn-rounded btn-sm">Hapus</button></a>
                </div>
            </div>
            <!-- Card content -->
            </div>
            <!-- Card -->

            <!-- Card -->
            <div class="card card-cascade narrower mt-5">
            <!-- Card image -->
            <div class="view view-cascade gradient-card-header purple-gradient">
                <h5 class="mb-0 font-weight-bold">Ubah Kata Sandi</h5>
            </div>
            <!-- Card image -->
            <!-- Card content -->
            <form method="post" action="action/update_pass.php">
            <div class="card-body card-body-cascade text-center">
                <div class="col-md-12">
                    <div class="md-form mb-0">
                        <input type="password" name="pwnew" id="pwnew" minlength="8" class="form-control" required>
                        <label for="pwnew" >Kata sandi baru</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="md-form mb-0">
                        <input type="password" name="pwnew2" id="pwnew2" minlength="8" class="form-control" required>
                        <label for="pwnew2" >Ulangi kata sandi</label>
                        <p style="color: red"><?php echo $error_pass; ?></p>
                    </div>
                </div>
                <div class="row justify-content-center mt-4">
                    <button name="ganti_pass" class="btn btn-info btn-rounded btn-sm">Perbarui Kata Sandi</button><br>
                </div>
            </div>
            </form>
            <!-- Card content -->
            </div>
            <!-- Card -->
        </div>
        <!-- First column -->

        <!-- Second column -->
        <div class="col-lg-8 mb-4">
            <!-- Card -->
            <div class="card card-cascade narrower">
            <!-- Card image -->
            <div class="view view-cascade gradient-card-header purple-gradient">
                <h5 class="mb-0 font-weight-bold">Ubah Akun</h5>
            </div>
            <!-- Card image -->
            <!-- Card content -->
            <div class="card-body card-body-cascade text-center px-5">
                <!-- Edit Form -->
                <form method="POST" action="action/do_update.php">

                <!-- First row -->
                <div class="row">
                    <!-- First column -->
                    <div class="col-md-6">
                        <div class="md-form mb-0">
                            <input type="text" id="form1" class="form-control validate" value="<?php echo $uid; ?>" readonly >
                            <label for="form1" data-error="wrong" data-success="right">
                                <?php 
                                    if ($role == '3') 
                                        echo 'NIM'; 
                                    elseif ($role == '2') 
                                        echo 'NIDN'; 
                                    else 
                                        echo 'admin';
                                ?>
                            </label>
                        </div>
                    </div>

                    <!-- Second column -->
                    <div class="col-md-6">
                        <div class="md-form mb-0">
                            <input type="text" name="fname" id="form2" class="form-control validate" value="<?php echo $fname;?>" required>
                            <label for="form2" data-error="wrong" data-success="right">Nama Lengkap</label>
                        </div>
                    </div>
                </div>
                <!-- First row -->

                <!-- Second row -->
                <div class="row">

                    <!-- First column -->
                    <div class="col-md-6">
                        <div class="md-form mb-0">
                            <input type="email" name="email" id="form76" class="form-control validate mb-sm-0" value="<?php echo $email;?>" readonly>
                            <label for="form76">Alamat Email</label>
                        </div>
                    </div>

                    <!-- Second column -->
                    <div class="col-md-3">
                        <div class="md-form mb-0">
                            <input type="text" name="date" id="date-picker" class="form-control datepicker mb-5" value="<?php echo $dob;?>" required>
                            <label for="date-picker" data-error="wrong" data-success="right">Tanggal Lahir</label>
                        </div>
                    </div>

                    <!-- Third column -->
                    <div class="col-md-3">
                        <!-- <select class="mdb-select mt-3 w-50" name="course" searchable="Jenis Kelamin" disabled>
                            <option value="Laki-laki" <?php //if ($gender == 'Laki-laki') echo 'selected'; ?>>Laki-laki</option>
                            <option value="Perempuan" <?php //if ($gender == 'Perempuan') echo 'selected'; ?>>Perempuan</option>
                        </select> -->
                        <div class="md-form mb-0">
                            <input type="text" id="jk" class="form-control" value="<?php echo $gender;?>" readonly>
                            <label for="jk" data-error="wrong" data-success="right">Jenis Kelamin</label>
                        </div>
                    </div>
                </div>
                <!-- Second row -->

                <?php
                    if ($role == '2') {
                ?>
                <!-- Third row -->
                <div class="row">

                    <!-- First column -->
                    <div class="col-md-6">
                        <div class="md-form mb-0">
                            <input type="text" name="address" id="adrresshome" class="form-control validate" value="<?php echo $address;?>">
                            <label for="adrresshome" data-error="wrong" data-success="right">Alamat Rumah</label>
                        </div>
                    </div>

                    <!-- Second column -->
                    <div class="col-md-6">
                        <div class="md-form mb-0">
                            <input type="text" name="office" id="adrressoffice" class="form-control validate" value="<?php echo $office;?>">
                            <label for="adrressoffice" data-error="wrong" data-success="right">Alamat Kantor</label>
                        </div>
                    </div>

                </div>
                <!-- Third row -->

                <!-- Fourth row -->
                <div class="row">

                    <!-- First column -->
                    <div class="col-md-6">
                        <div class="md-form mb-0">
                            <input type="text" name="phone" id="phone" class="form-control validate" value="<?php echo $phone;?>">
                            <label for="phone" data-error="wrong" data-success="right">Nomor Telepon</label>
                        </div>
                    </div>

                    <!-- Second column -->
                    <div class="col-md-6">
                        <div class="md-form mb-0">
                            <input type="text" name="blog" id="blog" class="form-control validate" value="<?php echo $blog;?>">
                            <label for="blog" data-error="wrong" data-success="right">Alamat Blog</label>
                        </div>
                    </div>

                </div>
                <!-- Fourth row -->

                <!-- Fifth row -->
                <div class="row">
                    <!-- First column -->
                    <div class="col-md-12">
                        <div class="md-form mt-0">
                            <textarea type="text" name="about" id="form78" class="md-textarea form-control" rows="3"><?php echo $about;?></textarea>
                            <label for="form78">Tentang saya</label>
                        </div>
                    </div>
                </div>
                <!-- Fifth row -->
                <!-- Sixth row -->
                <div class="row">
                    <!-- First column -->
                    <div class="col-md-12">
                        <div class="md-form mt-0">
                            <textarea type="text" name="info" id="form78" class="md-textarea form-control" rows="3"><?php echo $info;?></textarea>
                            <label for="form78"> Informasi Perkuliahan </label>
                        </div>
                    </div>
                </div>
                <!-- Sixth row -->
                <?php
                    }
                ?>

                    <!-- Fourth row -->
                    <div class="row justify-content-between">
                        <div class="col text-center my-4">
                            <button type="button" class="btn btn-danger btn-rounded" data-toggle="modal" data-target="#alertDeleteAccount">Hapus Akun</button>
                        </div>
                        <div class="col text-center my-4">
                            <input type="submit" name="submit" value="Perbarui Akun" class="btn btn-info btn-rounded">
                        </div>
                    </div>
                    <!-- Fourth row -->
                </form>
                <!-- Edit Form -->

            </div>
            <!-- Card content -->
            </div>
            <!-- Card -->
        </div>
        <!-- Second column -->
        </div>
        <!-- First row -->
    </section>
    <!-- Section: Edit Account -->
    </div>
</main>
<!-- Main layout -->


