<?php
    require_once 'config/conf.php';
    $material_id = $_GET['id'];
    $query = mysqli_query($conn, "SELECT * FROM tb_material JOIN tb_course ON tb_material.material_course = tb_course.course_id JOIN tb_user ON tb_user.user_id=tb_material.material_user WHERE tb_material.material_id='$material_id'");        
    $row=mysqli_fetch_assoc($query);
    $role = $_SESSION['role'];
    $uploader = $row['user_id'];
    $user =  $_SESSION['user'];
?>

<div class="container">
    <!-- News jumbotron -->
    <div class="col-md-11 jumbotron text-center hoverable p-0 mt-5 row mx-auto">
        <div class="col-md-4 p-0 align-self-stretch" style="background-image:url(img/cover.jpg);
                    background-size: 100% 100%; background-repeat:no-repeat;background-position: center;">
            
        </div>
        <div class="col-md-8 text-md-left p-5">
        

            <!-- Excerpt -->
            <div class="row d-flex justify-content-between px-3">
                <a href="?p=list&type=material-course&id=<?php echo $row['course_id']; ?>" class="green-text">
                    <h6 class="h6 pb-1"><i class="fas fa-layer-group mr-2"></i> <?php echo $row['course_name']?></h6>
                </a>
                <h6 class="h6 pb-1"><i class="far fa-calendar mr-2"></i><?php echo date('d-m-Y', strtotime($row['material_date'])) ?></h6>
            </div>
            <h4 class="h4 mb-4"><?php echo $row['material_subject'] ?></h4>
            <p class="font-weight-normal"><?php echo $row['material_content'] ?></p>
            <p class="font-weight-normal">by <a href="?p=profile&id=<?php echo $row['material_user']?>" class="text-secondary"><strong><?php echo $row['user_name'] ?></strong></a><i class="fas fa-download ml-3"></i>
            <?php 
                $data = mysqli_query($conn, "SELECT * FROM tb_material_downloaded WHERE material_id = '$material_id'");
                echo mysqli_num_rows($data); ?></p>
            <a href="filemateri/<?php echo $row['material_attachment']; ?>" class="btn btn-success" id="btn_download">UNDUH</a>
            <?php
            if ( $role == 2 && $user == $uploader )  {                            
                echo "<a href='?p=materi-form&material_id=$row[material_id]' class='btn btn-warning'>EDIT</a>";
                echo "<a href='action/delete_materi.php?id=$row[material_id]' class='btn btn-danger'>HAPUS</a>";
            }
            ?>
        </div>
    </div>
    <!-- Grid row -->
</div>
<!-- News jumbotron -->
</div>

<script>
    $(document).ready(function(){
        $('#btn_download').click(function(){
            $.ajax({
                url:"action/download_counter.php",
                type: "POST",
                data:{
                    material_id: "<?php echo $row['material_id']; ?>",
                    material_user: "<?php echo $_SESSION['user']; ?>"
                }
            });
        });
    });
</script>