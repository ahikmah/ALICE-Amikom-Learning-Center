<?php
    $uid = $_SESSION['user'];

    $class_all      = mysqli_query($conn, "SELECT class_name, c.class_id, class_header, (SELECT COUNT(*) FROM tb_class_member m WHERE m.class_id = c.class_id) AS class_member FROM tb_class c WHERE class_name LIKE '%$keyword%'");
    $class_student  = mysqli_query($conn, "SELECT class_name, c.class_id, class_header, (SELECT COUNT(*) FROM tb_class_member m WHERE m.class_id = c.class_id) AS class_member FROM tb_class c JOIN tb_class_member m ON c.class_id = m.class_id WHERE m.user_id = '$uid' AND class_name LIKE '%$keyword%'");
    $class_lecturer = mysqli_query($conn, "SELECT class_name, c.class_id, class_header, (SELECT COUNT(*) FROM tb_class_member m WHERE m.class_id = c.class_id) AS class_member FROM tb_class c WHERE class_lecturer = '$uid' AND class_name LIKE '%$keyword%'");

    // put modal if failed join
    if (isset($_SESSION['errorJoinClass']) && $_SESSION['errorJoinClass']) {
        echo    "<script>
                    $(document).ready(function() {
                        $('#modalJoinFail').modal('show');
                    });
                </script>";
        unset($_SESSION['errorJoinClass']);
    }

    // put modal if class suspended
    if (isset($_SESSION['class_suspended']) && $_SESSION['class_suspended']) {
        echo    "<script>
                    $(document).ready(function() {
                        $('#modalClassSuspended').modal('show');
                    });
                </script>";
        unset($_SESSION['class_suspended']);
    }
?>
<div class="container-fluid">
    <div class="d-flex mx-2 justify-content-between align-items-center">
        <div>
        <?php
            if ($role == 3) {
                ?>
                    <a data-toggle="modal" data-target="#modalJoinClass" class="btn purple-gradient btn-rounded waves-effect font-weight-bold btn-dash">
                        Gabung Kelas    
                    </a>
                <?php
            } else if ($role == 2) {
                ?>
                    <a href="?p=class-form&act=add" class="btn purple-gradient btn-rounded waves-effect font-weight-bold btn-dash">
                        Buat Kelas    
                    </a>
                <?php
            }
        ?>
        </div>
        <!-- Search form -->
        <div>
            <form action="" action="GET">
                <input type="text" name="p" value="classroom" hidden>
                <input class="form-control btn-rounded submit-on-enter" type="text" placeholder="Cari kelas" name="keyword" aria-label="Search">
            </form>
        </div>
    </div>
    <div class="d-flex flex-wrap justify-content-start">
        <?php
            if ($role == 1) {
                $temp = $class_all;
            } else if ($role == 2) {
                $temp = $class_lecturer;
            } else {
                $temp = $class_student;
            }
            while ($result = mysqli_fetch_array($temp)) { 
                ?>
                    <div class="alice-class m-3">
                        <div class="card">
                            <!-- Card image -->
                            <div class="view overlay">
                                <img class="card-img-top" src="img/alice-header/<?php echo $result['class_header'] ?>" alt="Class Header">
                                <a>
                                    <div class="mask rgba-white-slight"></div>
                                </a>
                            </div>
                            <!-- Button -->
                            <a href="?p=class&id=<?php echo $result['class_id'];?>" class="btn-floating btn-action ml-auto mr-4 purple-gradient"><i class="fas fa-chevron-right pl-1"></i></a>
                            <!-- Card content -->
                            <div class="card-body">
                                <!-- Title -->
                                <h4 class="card-title mb-0"><?php echo $result['class_name']; ?></h4>
                            </div>
                            <!-- Card footer -->
                            <div class="rounded-bottom purple-gradient lighten-3 text-center py-2">
                                <ul class="list-unstyled list-inline font-small mb-0">
                                    <!-- <li class="list-inline-item pr-2 white-text"><i class="far fa-clock pr-1"></i>05/10/2015</li> -->
                                    <li class="list-inline-item pr-2"><a href="#" class="white-text"><i class="fas fa-user pr-1"></i><?php echo $result['class_member']; ?> Siswa</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php
            }
        ?>
    </div>
</div>