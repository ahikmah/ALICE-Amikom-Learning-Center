<?php
    if (isset($_GET['act'])){
        $act = $_GET['act'];
    } else {
        die();
    }

    if ($act == 'update') {
        if (isset($_GET['id'])) {
            $id     = $_GET['id'];
            $query  = mysqli_query($conn, "SELECT * FROM tb_user WHERE user_id = '$id'");
            $result = mysqli_fetch_array($query);
            $role   = $result['user_role'];
            $button = 'Ubah';
            if ($role == 2) {
                $title   = 'Dosen';
                $query   = mysqli_query($conn, "SELECT * FROM tb_lecturer_profile WHERE profile_user = '$id'");
                $profile = mysqli_fetch_array($query);
            } else {
                $title   = 'Mahasiswa';
            }
        }
    }
?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="jumbotron">
                <h2 class="display-6"><?php echo $button.' Akun '.$title;?></h2>
                <hr class="my-4">
                <form action="action/_user.php?act=<?php echo $act; ?>" method="post">
                <!-- Body -->
                    <!-- Material input -->
                    <div class="md-form">
                        <input type="text" id="userFormId" name="userId" value="<?php echo $result['user_id'];?>" class="form-control" readonly>
                        <label for="userFormId">
                            <?php
                                if ($role == 2) {
                                    echo 'NIDN';
                                } else {
                                    echo 'NIM';
                                }
                            ?>
                        </label>
                    </div>
                    <div class="md-form">
                        <input type="text" id="userFormName" name="userName" value="<?php echo $result['user_name'];?>" class="form-control" required>
                        <label for="userFormName">Nama Lengkap</label>
                    </div>
                    <div class="md-form">
                        <input type="text" id="userFormEmail" name="userEmail" value="<?php echo $result['user_email'];?>" class="form-control" readonly>
                        <label for="userFormEmail">Email</label>
                    </div>
                    <div class="row mt-0">
                        <div class="col-md-6">
                            <!-- Dob -->
                            <div class="md-form mt-0">
                                <input type="date" id="datepickers" class="form-control" name="userDate" value="<?php echo $result['user_dob'];?>" required>
                                <label class="alice-date" for="datepickers">Tanggal Lahir</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <!-- Blue select -->
                            <!-- <select class="mdb-select pb-2" id="userFormGender" name="userGender" readonly>
                                <option value="1" disabled>Pilih Jenis Kelamin</option>
                                <option value="Laki-laki" <?php //if ($result['user_gender'] == 'Laki-laki') echo 'selected'; ?>>Laki-Laki</option>
                                <option value="Perempuan" <?php //if ($result['user_gender'] == 'Perempuan') echo 'selected'; ?>>Perempuan</option>
                            </select> -->
                            <div class="md-form mb-0 mt-0">
                                <input type="text" id="userFormGender" class="form-control" value="<?php echo $result['user_gender'];?>" readonly>
                                <label for="userFormGender">Jenis Kelamin</label>
                            </div>
                        </div>
                    </div>
                    <?php
                        if ($role == 2) {
                            ?>
                                <h2 class="display-6 mt-3">Informasi Profile</h2>
                                <hr>
                                    <!-- Blue select -->
                                <select class="mdb-select pb-2" id="userFormStatus" name="userStatus" required>
                                    <option value="1" disabled>Pilih Status Mengajar</option>
                                    <option value="Selo" <?php if ($profile['profile_status'] == 'Selo') echo 'selected'; ?>>Selo</option>
                                    <option value="Mengajar" <?php if ($profile['profile_status'] == 'Mengajar') echo 'selected'; ?>>Mengajar</option>
                                    <option value="Rapat" <?php if ($profile['profile_status'] == 'Rapat') echo 'selected'; ?>>Rapat</option>
                                    <option value="di Rumah" <?php if ($profile['profile_status'] == 'di Rumah') echo 'selected'; ?>>di Rumah</option>
                                </select>
                                <div class="md-form mt-0">
                                    <input type="text" id="userFormAddress" name="userAddress" value="<?php echo $profile['profile_address'];?>" class="form-control">
                                    <label for="userFormAddress">Alamat</label>
                                </div>
                                <div class="md-form">
                                    <input type="text" id="userFormPhone" name="userPhone" value="<?php echo $profile['profile_phone'];?>" class="form-control" minlength="9" maxlength="13" onkeyup="this.value=this.value.replace(/[^\d]/,'')">
                                    <label for="userFormPhone">No. Telepon</label>
                                </div>
                                <div class="md-form">
                                    <input type="text" id="userFormOffice" name="userOffice" value="<?php echo $profile['profile_office'];?>" class="form-control">
                                    <label for="userFormOffice">Alamat Kantor</label>
                                </div>
                                <div class="md-form">
                                    <input type="text" id="userFormBlog" name="userBlog" value="<?php echo $profile['profile_blog'];?>" class="form-control">
                                    <label for="userFormBlog">Blog/Website</label>
                                </div>
                                <div class="md-form">
                                    <textarea type="text" id="userFormAbout" name="userAbout" class="md-textarea form-control" rows="2"><?php echo $profile['profile_about'];?></textarea>
                                    <label for="userFormAbout">Tentang</label>
                                </div>
                                <div class="md-form">
                                    <textarea type="text" id="userFormInfo" name="userInfo" class="md-textarea form-control" rows="3"><?php echo $profile['profile_info'];?></textarea>
                                    <label for="userFormInfo">Info Perkuliahan</label>
                                </div>
                            <?php
                        }
                    ?>
                    <input type="text" value="<?php echo $result['user_role'];?>" name="userRole" hidden>
                    <input type="text" value="<?php echo ($role == 2 ? 'lecturer' : 'student'); ?>" name="userView" hidden>
                    <!-- Body -->
                    <div class="float-right mt-4">
                        <a href="?p=admin&v=<?php echo ($role == 2 ? 'lecturer' : 'student'); ?>"><button type="button" class="btn btn-md btn-danger">Batal</button></a>
                        <button type="submit" class="btn btn-md btn-success"><?php echo $button; ?></button>
                    </div>
                </form>
                <div class="m-5"></div>
            </div>      
        </div>
    </div>
</div>
