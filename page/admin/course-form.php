<?php
    if (isset($_GET['act'])){
        $act = $_GET['act'];
    } else {
        die();
    }

    if ($act == 'add') {
        $id     = '';
        $name   = '';
        $sks    = '';
        $button = 'Tambah';
    } else if ($act == 'update') {
        if (isset($_GET['id'])) {
            $id     = $_GET['id'];
            $query  = mysqli_query($conn, "SELECT * FROM tb_course WHERE course_id = $id");
            $result = mysqli_fetch_array($query);
            $name   = $result[1];
            $sks    = $result[2];
            $button = 'Ubah';
        }
    }
?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="jumbotron">
                <h2 class="display-6"><?php echo $button;?> Mata Kuliah</h2>
                <hr class="my-4">
                <form action="action/_course.php?act=<?php echo $act; ?>" method="post">
                <!-- Body -->
                    <!-- Material input -->
                    <div class="md-form">
                        <input type="text" id="courseFormName" name="courseName" value="<?php echo $name;?>" class="form-control" required>
                        <label for="courseFormName">Nama Mata Kuliah</label>
                    </div>
                    <!--Blue select-->
                    <select class="mdb-select mt-3 w-50" name="courseSKS" searchable="Pilih jumlah SKS" required>
                        <option value="1" disabled <?php if ($act == 'add') echo 'selected'; ?>>Pilih jumlah SKS</option>
                        <option value="2" <?php if ($act == 'update' && $sks = 2) echo 'selected'; ?>>2 SKS</option>
                        <option value="4" <?php if ($act == 'update' && $sks = 4) echo 'selected'; ?>>4 SKS</option>
                    </select>
                    <input type="text" name="courseID" value="<?php echo $id; ?>" hidden>
                    <!-- Body -->
                    <div class="float-right mt-4">
                        <a href="?p=admin&v=course"><button type="button" class="btn btn-md btn-danger">Batal</button></a>
                        <button type="submit" class="btn btn-md btn-success"><?php echo $button; ?></button>
                    </div>
                </form>
                <div class="m-5"></div>
            </div>      
        </div>
    </div>
</div>
