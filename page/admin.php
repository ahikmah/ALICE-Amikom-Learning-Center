<?php
    if ($role == 1) {
        if (isset($_GET['v'])) {
            $view = $_GET['v'];
        } else {
            $view = '';
        }
    }
    
?>

<!-- DataTables  -->
<script type="text/javascript" src="js/addons/datatables.min.js"></script>
<!-- DataTables Select  -->
<script type="text/javascript" src="js/addons/datatables-select.min.js"></script>

<?php
    // check if page file doesn't exist
    if (!file_exists('page/admin/'.$view.'.php')) {
        $view = 'dashboard';
    }

    //include view
    include 'page/admin/'.$view.'.php';
?>
