<?php
// session_start();
// require_once('../require/config.php');
// require_once('../require/session.php');

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>พยากรณ์ลูกค้า | Beautiful Salon</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <!-- <link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.css"> -->
    <link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="../bower_components/Ionicons/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
    <!-- sweetalert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <link rel="stylesheet" href="../css/fontkanit.css">
    <link rel="icon" href="../images/hairsalon-icon.png" type="image/gif" sizes="16x16">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="../plugins/iCheck/all.css">
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        <header class="main-header">
            <!-- Logo -->
            <a href="../../index.php" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>BT</b>S</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>Beautiful</b> Salon</span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>

                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="../images/manager/manager.png" class="user-image" alt="User Image">
                                <span class="hidden-xs"><?php if (!empty($_SESSION["token_admin_uuid"])) echo $fname . ' ' . $lname; ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                    <img src="../images/manager/manager.png" class="img-circle" alt="User Image">

                                    <p>
                                        <?php if (!empty($_SESSION["token_admin_uuid"])) echo $fname . ' ' . $lname; ?>
                                        <small class="kanitB">พนักงาน</small>
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-right">
                                        <form method="post">
                                            <button class="btn btn-default btn-flat kanitB" type="submit" name="btn_logout">ออกจากระบบ</button>
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <!-- Control Sidebar Toggle Button -->
                    </ul>
                </div>
            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar kanitB">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- Sidebar user panel -->
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="../images/manager/manager.png" class="img-circle" alt="User Image">
                    </div>
                    <div class="pull-left info">
                        <p><?php if (!empty($_SESSION["token_admin_uuid"])) echo $fname . ' ' . $lname; ?></p>
                        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                    </div>
                </div>

                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu kanitB" data-widget="tree">
                    <li class="header">เมนูบาร์</li>

                    <li>
                        <a href="../index.php">
                            <i class="fa fa-home"></i> <span>หน้าแรก</span>
                        </a>
                    </li>

                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-calendar"></i>
                            <span>การจองคิว</span>
                            <span class="pull-right-container">
                                <span class="label label-primary pull-right"><?php if (!empty($_SESSION["token_admin_uuid"])) echo $count ?></span>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="../booking/databooking/"><i class="fa  fa-info"></i>ข้อมูลการจองคิว</a></li>
                            <li><a href="../booking/confirm/"><i class="fa  fa-spinner"></i>อนุมัติการจอง
                                    <span class="pull-right-container">
                                        <span class="label label-primary pull-right"><?php if (!empty($_SESSION["token_admin_uuid"])) echo $count ?></span>
                                    </span>
                                </a></li>
                            <li><a href="../booking/history/"><i class="fa fa-history"></i>ประวัติการจอง</a></li>
                            <!-- <li><a href="pages/layout/collapsed-sidebar.html"><i class="fa fa-circle-o"></i> Collapsed Sidebar</a></li> -->
                        </ul>
                    </li>
                    <li>

                    <li>
                        <a href="../product/">
                            <i class="fa fa-shopping-cart"></i> <span>สินค้า</span>
                        </a>
                    </li>

                    <li>
                        <a href="../serv/">
                            <i class="fa fa-thumbs-up"></i> <span>บริการ</span>
                        </a>
                    </li>

                    <li>
                        <a href="../customer/">
                            <i class="fa fa-users"></i> <span>ลูกค้า</span>
                        </a>
                    </li>

                    <li>
                        <a href="../employee/">
                            <i class="fa fa-smile-o"></i> <span>พนักงาน</span>
                        </a>
                    </li>

                    <li>
                        <a href="../manager/">
                            <i class="fa fa-user"></i> <span>ผู้จัดการ</span>
                        </a>
                    </li>

                    <li class="treeview active">
                        <a href="#">
                            <i class="fa fa-file-text-o"></i>
                            <span>รายงาน</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="#"><i class="fa fa-file-o"></i>รายงานการจองคิว</a></li>
                            <li class=""><a href="index.php"><i class="fa  fa-paperclip"></i>รายงานแบบประเมิน</a></li>
                            <li class=""><a href="sales_fore.php"><i class="fa fa-bar-chart"></i>พยากรณ์ยอดขาย</a></li>
                            <li class="active"><a href="cus_fore.php"><i class="fa fa-area-chart"></i>พยากรณ์ลูกค้า</a></li>
                        </ul>
                    </li>

                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-gear"></i>
                            <span>ตั้งค่า</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <!-- <li><a href="pages/layout/collapsed-sidebar.html"><i class="fa fa-user"></i>กำหนดจำนวนลูกค้าต่อวัน</a></li> -->
                            <li><a href="#"><i class="fa fa-power-off"></i>กำหนดวันเปิด - ปิดร้าน</a></li>
                        </ul>
                    </li>
                    </li>
                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <section class="content-header">
                <h1 class="kanitB">
                    พยากรณ์ยอดขาย
                    <!-- <small class="kanitB"><b>การจองคิว</b></small> -->
                </h1>
                <ol class="breadcrumb kanitB">
                    <li><a href="../../index.php"><i class="fa fa-home"></i> หน้าแรก</a></li>
                    <li class="active ">รายงานการประเมิน</li>
                </ol>
            </section>



            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-header">
                                <!-- <h3 class="box-title kanitB">ตารางรายการสินค้า</h3> -->
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                    <!-- <button type="button" class='btn btn-success kanitB' onclick="window.location.href='addproduct/'"> <i class="fa  fa-cart-plus"></i> เพิ่มสินค้า</button> -->
                                </div>
                            </div>
                            <form action="" method="POST">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-3 text-right">
                                        <h4 class="kanitB">พยากรณ์ด้วยวิธี :</h4>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <!-- <label>Minimal</label> -->
                                            <select class="form-control select2" style="width: 100%;">
                                                <option selected="selected">Simple Moving Average</option>
                                                <option>Linear Weighted Moving Average</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 text-right">
                                        <h4 class="kanitB">พยากรณ์ข้อมูลตาม :</h4>
                                    </div>
                                    <div class="col-md-6">
                                        <!-- radio -->
                                        <div class="form-group kanitB">
                                            <input type="radio" name="r1" class="minimal " checked>
                                            <label>
                                                ปี
                                            </label>
                                            <input type="radio" name="r1" class="minimal-red">
                                            <label>
                                                เดือน
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <h4 class="kanitB">โดยใช้ข้อมูลย้อนหลังทั้งหมด (รายการ) : </h4>
                                    </div>
                                    <div class="col-md-1">
                                        <input type="number" class="form-control" min="0" max="12">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-3">

                                    </div>
                                    <div class="col-md-6">
                                        <button class="btn btn-success kanitB">เริ่มพยากรณ์ลูกค้า</button>
                                    </div>
                                </div>
                                </form>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4 class="kanitB">ยอดลูกค้าตั้งแต่ปี 2562 จนถึงปี 2563 พร้อมค่าถ่วงน้ำหนัก</h4>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <h4 class="kanitB">1,200,000.00</h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4 class="kanitB">นำยอดขายมาหารด้วยผลรวมของค่าถ่วงน้ำหนัก (ทั้งหมด 2 ปี)</h4>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <h4 class="kanitB">600,000.00</h4>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4 class="kanitB"><u>ดังนั้น สามารถสรุปได้ว่าในปี 2564 มีแนวโน้มที่มียอดขายจะอยู่ที่ประมาณ</u></h4>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <h4 class="kanitB">600,000.00</h4>
                                    </div>
                                </div>
                            </div>
                            
                            <hr>

                            <!-- /.box-header -->
                            <div class="box-body">
                                <table id="example1" class="table table-bordered table-striped kanitB">
                                    <thead>
                                        <tr>
                                            <th>ปีพุทธศักราช</th>
                                            <th>กำไร (บาท)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="kanitB">
                                            <td class="text-center">2563</td>
                                            <td class="text-right">100,000.00</td>
                                        </tr>
                                        <tr class="kanitB">
                                            <td class="text-center">2562</td>
                                            <td class="text-right">50,000.00</td>
                                        </tr>
                                    </tbody>

                                </table>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </section>

        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <div class="pull-right hidden-xs kanitB">
                <b>เวอร์ชั่น</b> 1.0.1
            </div>
            <strong>Copyright &copy; 2021 By BIS.</strong> For educational purposes only.
        </footer>

        <!-- /.control-sidebar -->

        <div class="control-sidebar-bg"></div>
    </div>
    <!-- ./wrapper -->

    <!-- jQuery 3 -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="../bower_components/fastclick/lib/fastclick.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../dist/js/demo.js"></script>
    <!-- page script -->
    <!-- iCheck 1.0.1 -->
    <script src="../plugins/iCheck/icheck.min.js"></script>
    <script>
        $(function() {
            $('#example1').DataTable()

        });

        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        })
        //Red color scheme for iCheck
        $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
            checkboxClass: 'icheckbox_minimal-red',
            radioClass: 'iradio_minimal-red'
        })
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass: 'iradio_flat-green'
        })
    </script>
</body>

</html>