<?php
session_start();

if (!isset($_SESSION['email'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['email']);
    header("location: login.php");
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 2 | Dashboard</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/dist/css/skins/_all-skins.min.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/bower_components/morris.js/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/bower_components/morris.js/morris.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-daterangepicker/daterangepicker.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition skin-blue sidebar-mini layout-fixed">

    <div class="wrapper">

        <header class="main-header">
            <!-- Logo -->
            <a href="index.php" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>A</b>LT</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>Admin</b>LTE</span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">

            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- Sidebar user panel -->
                <div class="user-panel">

                    <div class="pull-left">

                        <p><strong>
                                <font color="white"><?php echo $_SESSION['email']; ?></font>
                            </strong></p>

                        <a href="index.php?logout='1'">
                            <font color="red">Sign Out</font>
                        </a>
                    </div>
                </div>
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="header">MAIN NAVIGATION</li>
                    <li class="active treeview">
                        <a href="#">
                            <i class="fa fa-dashboard"></i> <span>Menu</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="index.php"><i class="fa fa-circle-o"></i> Dashboard</a></li>
                            <li><a href="index_2.php"><i class="fa fa-circle-o"></i> Item</a></li>
                            <li><a href="crud.php"><i class="fa fa-circle-o"></i> Table</a></li>
                        </ul>
                    </li>
                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Item List
                </h1>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <?php include 'table_join.php';
                    $result = array();
                    while ($fetch =  mysqli_fetch_assoc($query)) {
                        $result[] = $fetch;
                    }
                    foreach ($result as $fetch) {
                    ?>
                        <div class="col-xs-3" id="datatable" data-target="#ModalAdd" data-toggle="modal">
                            <p><?php echo $fetch['item_image']; ?></p>
                            <br>
                            <p><?php echo $fetch['item_name']; ?></p>
                            <br>
                            <p><?php echo $fetch['item_price']; ?></p>
                            <br>
                            <p><?php echo $fetch['description']; ?></p>
                            <br>
                            <p><?php echo $fetch['item_type']; ?></p>
                            <br>
                            <a><button class="btn-success" id="form-update">Click here</button></a>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <!-- /.row -->
                <div id="ModalEdit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    
                </div>

            </section>
            <!-- /.content -->
        </div>
    </div>
    <!-- ./wrapper -->

    <script type="text/javascript">
        $(document).ready(function() {
            $('#datatable').on('click', '.open_modal', function(e) {
                var m = $(this).attr("id");
                $.ajax({
                    url: "modal_edit.php",
                    type: "GET",
                    data: {
                        id: m,
                    },
                    success: function(ajaxData) {
                        $("#ModalEdit").html(ajaxData);
                        $("#ModalEdit").modal('show', {
                            backdrop: 'true'
                        });
                    }
                });
            });
        });
    </script>

    <script type="text/javascript">
        $('body').on('submit', '#form-save', function(e) {
            e.preventDefault();
            $.ajax({
                    method: $(this).attr("method"),
                    url: $(this).attr("action"),
                    data: {
                        item_name: $('#modal-name').val(),
                        description: $('#description').val(),
                    },
                    success: function(response) {
                        console.log(response);
                        $("#modal-data").empty();
                        $("#modal-data").html(response.data);
                        $("#ModalAdd").modal('hide');
                        $(".modal-backdrop").hide();
                    },
                    error: function(e) {
                        // Error function here
                    },
                    beforeSend: function(b) {
                        // Before function here
                    }
                })
                .done(function(d) {
                    // When ajax finished
                });
        });
    </script>

    <script type="text/javascript">
        $('body').on('submit', '#form-update', function(e) {
            e.preventDefault();
            $.ajax({
                    method: $(this).attr("method"),
                    url: $(this).attr("action"),
                    data: {
                        id: $('#edit-id').val(),
                        item_name: $('#edit-name').val(),
                        description: $('#edit-description').val(),
                    },
                    success: function(response) {
                        console.log(response);
                        $("#modal-data").empty();
                        $("#modal-data").html(response.data);
                        $("#ModalEdit").modal('hide');
                    },
                    error: function(e) {
                        // Error function here
                    },
                    beforeSend: function(b) {
                        // Before function here
                    }
                })
                .done(function(d) {
                    // When ajax finished
                });
        });
    </script>

    <!-- jQuery 3 -->
    <script src="https://adminlte.io/themes/AdminLTE/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="https://adminlte.io/themes/AdminLTE/bower_components/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.7 -->
    <script src="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Morris.js charts -->
    <script src="https://adminlte.io/themes/AdminLTE/bower_components/raphael/raphael.min.js"></script>
    <script src="https://adminlte.io/themes/AdminLTE/bower_components/morris.js/morris.min.js"></script>
    <!-- Sparkline -->
    <script src="https://adminlte.io/themes/AdminLTE/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
    <!-- jvectormap -->
    <script src="https://adminlte.io/themes/AdminLTE/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="https://adminlte.io/themes/AdminLTE/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="https://adminlte.io/themes/AdminLTE/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="https://adminlte.io/themes/AdminLTE/bower_components/moment/min/moment.min.js"></script>
    <script src="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- datepicker -->
    <script src="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="https://adminlte.io/themes/AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <!-- Slimscroll -->
    <script src="https://adminlte.io/themes/AdminLTE/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="https://adminlte.io/themes/AdminLTE/bower_components/fastclick/lib/fastclick.js"></script>
    <!-- AdminLTE App -->
    <script src="https://adminlte.io/themes/AdminLTE/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="https://adminlte.io/themes/AdminLTE/dist/js/pages/dashboard.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="https://adminlte.io/themes/AdminLTE/dist/js/demo.js"></script>
</body>

</html>
