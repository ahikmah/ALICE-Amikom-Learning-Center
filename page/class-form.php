<?php
    if (isset($_GET['act'])){
        $act = $_GET['act'];
    } else {
        die();
    }

    if ($role == 3) {
        die();
    }

    if ($act == 'add') {
        $id     = '';
        $user   = $_SESSION['user'];
        $name   = '';
        $course = '';
        $desc   = '';
        $button = 'Buat';
        $title  = 'Buat Kelas Baru';
    } else if ($act == 'update') {
        if (isset($_GET['id'])) {
            $id     = $_GET['id'];
            $query  = mysqli_query($conn, "SELECT * FROM tb_class WHERE class_id = '$id'");
            $result = mysqli_fetch_array($query);
            $user   = $result['class_lecturer'];
            $name   = $result['class_name'];
            $desc   = $result['class_desc'];
            $course = $result['class_course'];
            $button = 'Ubah';
            $title  = 'Ubah Kelas';
        }
    }


?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="jumbotron">
                <h2 class="display-6"><?php echo $title; ?></h2>
                <hr class="my-4">
                <!-- Form action -->
                <form action="action/classroom.php?act=<?php echo $act; ?>" method="post">
                <!-- Body -->
                    <!-- Material input -->
                    <div class="md-form">
                        <input type="text" id="classFormName" name="className" value="<?php echo $name;?>" class="form-control" required>
                        <label for="classFormName">Nama kelas</label>
                    </div>
                    <!--Message-->
                    <div class="md-form">
                        <textarea id="classFormDesc" name="classDesc" class="form-control md-textarea" rows="3" required><?php echo $desc; ?></textarea>
                        <label for="classFormDesc">Deskripsi kelas</label>
                    </div>
                    <!--Blue select-->
                    <select class="mdb-select mt-3 w-50" name="classCourse" searchable="Cari Mata Kuliah" required>
                        <option value="0" disabled <?php if ($act == 'add') echo 'selected'; ?>>Pilih Mata Kuliah</option>
                        <!-- Dynamic Course List -->
                        <?php
                            $query  = mysqli_query($conn, "SELECT course_id, course_name FROM tb_course ORDER BY course_name ASC");
                            while ($result = mysqli_fetch_array($query)) {
                                echo "<option value='$result[0]'";
                                if ($act == 'update' && $result['course_id'] == $course) 
                                    echo 'selected';
                                echo ">$result[1]</option>";
                            }
                        ?>
                    </select>
                    <input type="text" name="classId" value="<?php echo $id; ?>" hidden>
                    <input type="text" name="classUser" value="<?php echo $user; ?>" hidden>
                    <!-- Body -->
                    <div class="float-right mt-4">
                        <a href="?p=forum"><button type="button" class="btn btn-md btn-danger">Batal</button></a>
                        <button type="submit" name = "button" class="btn btn-md btn-success"><?php echo $button; ?></button>
                    </div>
                </form>
                <div class="m-5"></div>
            </div>      
        </div>
    </div>
</div>
