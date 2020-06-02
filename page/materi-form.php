<?php

    $material_id = isset ($_GET['material_id']) ? $_GET['material_id'] : false;

    $user = isset($_SESSION['user'])? $_SESSION['user'] : false;
    
    $subject= '';
    $content= '';
    $course = '';
    $date = '';
    $nama_file = '';
    $button = 'TAMBAH';
    $title  = 'Unggah Materi Baru';

    if($material_id) {
        $query = mysqli_query($conn, "SELECT * FROM tb_material WHERE material_id = $material_id");
        $row = mysqli_fetch_assoc($query);

        $title = 'Edit Materi';
        $button = 'SIMPAN';
        $materi_id = $row['material_id'];
        $subject = $row ['material_subject'];
        $content = $row ['material_content'];
        $course = $row ['material_course'];
        $date = $row ['material_date'];
        $nama_file = $row ['material_attachment'];
    }
?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="jumbotron">
                <h2 class="display-6"><?php echo $title; ?></h2>
                <hr class="my-4">
                <form action="action/add_materi.php?<?php if($material_id){ echo 'materi_id='.$row['material_id'];}?>" method="post" enctype="multipart/form-data">
                <!-- Body -->
                    <!-- User -->
                    <input type="text" id="materiFormUser" name="materiUser" value="<?php echo $user;?>" class="form-control" hidden>
                    <input type="date" name="materiDate" value="<?php echo $date; ?>" hidden>
                    <!-- Material input -->
                    <div class="md-form">
                        <input type="text" id="materiFormTitle" name="materiName" value="<?php echo $subject;?>" class="form-control" required>
                        <label for="materiFormTitle">Judul Materi</label>
                    </div>
                    <!--Message-->
                    <div class="md-form">
                        <textarea id="materiFormContent" name="materiContent" class="form-control md-textarea" rows="3" required><?php echo $content; ?></textarea>
                        <label for="materiFormContent">Deskripsi Materi</label>
                    </div>
                    <!--Material Course select-->
                    <select class="mdb-select mt-3 w-50" name="course" searchable="Cari Mata Kuliah" required>
                        <option value="0" disabled >Pilih Mata Kuliah</option>
                        <?php
                            $query  = mysqli_query($conn, "SELECT course_id, course_name FROM tb_course ORDER BY course_name ASC");
                            while ($row=mysqli_fetch_assoc($query)) {
                                echo "<option value = '$row[course_id]'>$row[course_name]</option>";
                            }
                        ?>
                    </select>
                    <!-- Upload Material -->
                    <div class="md-form">
                        <input type="file" id="materiFormUpload" name="materiFile" value="<?php echo $nama_file;?>" class="form-control" required>
                        
                    </div>
                    <!-- Body -->
                    <div class="float-right mt-4">
                        <a href="?p=materi"><button type="button" class="btn btn-md btn-danger">Batal</button></a>
                        <input type="submit" name= "button" class="btn btn-md btn-success" value="<?php echo $button; ?>"/>
                    </div>
                </form>
                <div class="m-5"></div>
            </div>      
        </div>
    </div>
</div>
