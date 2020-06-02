<!-- Modal Add Forum Post -->
<div class="modal fade" id="createForumPost" tabindex="-1" role="dialog">
  <!-- Add .modal-dialog-centered to .modal-dialog to vertically center the modal -->
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="h5 modal-title">Buat Post Baru</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="post">
            <!-- Body -->
            <!-- Material input -->
            <div class="mb-3">
                <input type="text" id="postTitle" name="title" placeholder="Tulis judul..." class="form-control" required>
            </div>
            <div class="form-group purple-border mb-1">
                <textarea class="form-control" name="content" rows="3" placeholder="Tulis isi post..." required></textarea>
            </div>
            <!--Blue select-->
            <select class="mdb-select mt-3 w-50" name="course" searchable="Cari mata kuliah" required>
                <option value="1" disabled selected>Pilih mata kuliah</option>
                <option value="2">example 1</option>
                <option value="3">example 2</option>
                <option value="4">example 3</option>
            </select>
            <!-- Body -->
            <div class="float-right mt-2">
                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-sm btn-success">Kirim</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Upload Image -->
<div id="uploadimageModal" class="modal" tabindex="-1" role="dialog">
  <!-- Add .modal-dialog-centered to .modal-dialog to vertically center the modal -->
  <div class="modal-dialog modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="h5 modal-title">Unggah dan potong gambar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <!-- Body -->
          <div id="image_demo" class="mt-2" style="height:auto;"></div>
          <!-- Body -->
          <div class="float-right mt-2">
              <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Batal</button>
              <button type="button" id="cropImage" class="btn btn-sm btn-success">Unggah</button>
          </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal register -->
<div class="modal fade" id="registerModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered modal-notify modal-info" role="document">
    <!--Content-->
    <div class="modal-content">
      <!--Header-->
      <div class="modal-header purple-gradient">
        <p class="heading lead"><strong>Daftar Akun</strong></p>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>

      <!--Footer-->
      <div class="modal-footer justify-content-center">
        <a href="?p=register&u=mahasiswa" type="button" class="btn btn-secondary">Mahasiswa</i></a>
        <a href="?p=register&u=dosen" type="button" class="btn btn-outline-secondary waves-effect">Dosen</a>
      </div>
    </div>
    <!--/.Content-->
  </div>
</div>
<!-- Modal register-->

<!-- Modal Login Failed -->
<!-- Central Modal Medium Danger -->
<div class="modal fade" id="loginFailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-danger" role="document">
    <!--Content-->
    <div class="modal-content">
      <!--Header-->
      <div class="modal-header">
        <p class="heading lead">Gagal Masuk</p>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>

      <!--Body-->
      <div class="modal-body">
        <div class="text-center">
          <i class="fas fa-times fa-4x mb-3 animated rotateIn"></i>
          <p>NIM/NIDN atau kata sandi tidak cocok. Pastikan anda mengisi dengan benar dan kemudian coba masuk kembali.</p>
        </div>
      </div>

      <!--Footer-->
      <div class="modal-footer justify-content-center">
        <a type="button" class="btn btn-outline-danger waves-effect" data-dismiss="modal">Tutup</a>
      </div>
    </div>
    <!--/.Content-->
  </div>
</div>
<!-- Modal Login Failed-->

<!-- Modal Registration Success -->
<div class="modal fade" id="registerSuccessModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-success" role="document">
    <!--Content-->
    <div class="modal-content">
      <!--Header-->
      <div class="modal-header">
        <p class="heading lead">Pendaftaran Berhasil</p>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>

      <!--Body-->
      <div class="modal-body">
        <div class="text-center">
          <i class="fas fa-check fa-4x mb-3 animated rotateIn"></i>
          <p>Terima kasih telah melakukan pendaftaran. Untuk mengaktifkan akun anda, tunggu 5-10 menit kemudian silahkan cek informasi yang telah kami kirimkan pada email anda. Jika belum mendapat email, cek email spam anda atau coba untuk masuk dan kirim ulang email verifikasi.</p>
        </div>
      </div>

      <!--Footer-->
      <div class="modal-footer justify-content-center">
        <a href="../?p=landing#login" type="button" class="btn btn-success">Masuk</i></a>
        <a type="button" class="btn btn-outline-success waves-effect" data-dismiss="modal">Tutup</a>
      </div>
    </div>
    <!--/.Content-->
  </div>
</div>
<!-- Modal Registration Success-->

<!-- Resend verification code -->
<div class="modal fade bottom" id="notVerificateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <!-- Add class .modal-frame and then add class .modal-bottom (or other classes from list above) to set a position to the modal -->
  <div class="modal-dialog modal-frame modal-bottom" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row d-flex justify-content-center align-items-center">
          <p class="pt-3 pr-2">Maaf, anda belum dapat masuk. Anda perlu mengaktifkan akun melalui link yang kami kirimkan ke email anda. Apabila belum mendapat email klik tombol dibawah.
          </p>
        </div>
        <div class="row justify-content-center">
          <a href="action/sendmail.php" target="_blank"><button type="button" class="btn btn-secondary">Kirim Ulang</button></a>
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Resend verification code -->


<!-- Modal alert delete account-->
<!-- Central Modal Medium Danger -->
<div class="modal fade" id="alertDeleteAccount" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-danger" role="document">
    <!--Content-->
    <div class="modal-content">
      <!--Header-->
      <div class="modal-header">
        <p class="heading lead">Hapus Akun</p>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>

      <!--Body-->
      <div class="modal-body">
        <div class="text-center">
          <i class="fas fa-times fa-4x mb-3 animated rotateIn"></i>
          <p>Apakah anda yakin ingin menghapus akun ini? Sekali anda hapus, data anda akan hilang selamanya.</p>
        </div>
      </div>

      <!--Footer-->
      <div class="modal-footer justify-content-center">
        <a type="button" class="btn btn-outline-danger waves-effect" data-dismiss="modal">Batal</a>
        <a type="button" class="btn btn-danger waves-effect" href="action/do_delete.php">Hapus</a>
      </div>
    </div>
    <!--/.Content-->
  </div>
</div>
<!-- Modal alert delete account-->

<!--Modal: Join a Class-->
<div class="modal fade" id="modalJoinClass" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog cascading-modal modal-avatar modal-sm" role="document">
    <!--Content-->
    <div class="modal-content">
      <!--Body-->
      <div class="modal-body text-center mb-1">

        <h5 class="mt-1 mb-4">Gabung ke kelas</h5>

        <form action="action/classroom.php?act=join" method="post">
            <input type="text" name="userId" value="<?php echo $_SESSION['user']; ?>" hidden>
          <div class="md-form ml-0 mr-0">
            <input type="text" id="classCode" name="classCode" class="form-control form-control-sm ml-0" required>
            <label data-error="wrong" data-success="right" for="classCode" class="ml-0">Masukkan kode kelas</label>
          </div>

          <div class="text-center mt-3">
            <button class="btn btn-purple mt-1">Gabung <i class="fas fa-sign-in-alt ml-1"></i></button>
          </div>
        </form>
      </div>

    </div>
    <!--/.Content-->
  </div>
</div>
<!--Modal: Join a Class-->

<!-- Modal Login Failed -->
<!-- Central Modal Medium Danger -->
<div class="modal fade" id="modalJoinFail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-danger" role="document">
    <!--Content-->
    <div class="modal-content">
      <!--Header-->
      <div class="modal-header">
        <p class="heading lead">Gagal Bergabung</p>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>

      <!--Body-->
      <div class="modal-body">
        <div class="text-center">
          <i class="fas fa-times fa-4x mb-3 animated rotateIn"></i>
          <p>Kode kelas tidak ditemukan. Pastikan anda mengisi dengan benar dan kemudian coba gabung kembali.</p>
        </div>
      </div>

      <!--Footer-->
      <div class="modal-footer justify-content-center">
        <a type="button" class="btn btn-outline-danger waves-effect" data-dismiss="modal">Tutup</a>
      </div>
    </div>
    <!--/.Content-->
  </div>
</div>
<!-- Modal Login Failed-->

<!-- Modal Login Failed -->
<!-- Central Modal Medium Danger -->
<div class="modal fade" id="modalClassSuspended" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-warning" role="document">
    <!--Content-->
    <div class="modal-content">
      <!--Header-->
      <div class="modal-header">
        <p class="heading lead">Kelas Ditangguhkan</p>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>

      <!--Body-->
      <div class="modal-body">
        <div class="text-center">
          <i class="fas fa-exclamation-circle fa-4x mb-3 animated rotateIn"></i>
          <p>Kelas ini sedang ditangguhkan. Apabila terdapat kesalahan silahkan hubungi administrator.</p>
        </div>
      </div>

      <!--Footer-->
      <div class="modal-footer justify-content-center">
        <a type="button" class="btn btn-outline-warning waves-effect" data-dismiss="modal">Tutup</a>
      </div>
    </div>
    <!--/.Content-->
  </div>
</div>
<!-- Modal Login Failed-->