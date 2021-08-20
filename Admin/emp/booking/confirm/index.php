<?php
session_start();
require_once('../../../require/config.php');
require_once('../../../require/session.php');

if ($_SESSION["token_admin_uuid"]) {
    $uuid_emp = $_SESSION["token_admin_uuid"];

    $select_emp = $db->prepare("select * from tb_employee where uuid = :uuid_emp");
    $select_emp->bindParam(":uuid_emp", $uuid_emp);
    $select_emp->execute();
    $row = $select_emp->fetch(PDO::FETCH_ASSOC);
    extract($row);

    $date = date("d-m-Y");
    $book_status = 'wait';

    $sql = "select count(uuid_emp) from tb_booking where uuid_emp = '$uuid_emp' and book_st = 'wait' and cre_bks_date = '$date'";
    $res = $db->query($sql);
    $count = $res->fetchColumn();

    
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>อนุมัติการจอง | Beautiful Salon</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="../../../bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../../bower_components/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" href="../../../bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="../../../bower_components/Ionicons/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../../../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../../dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../../../dist/css/skins/_all-skins.min.css">
    <!-- sweetalert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        <header class="main-header">
            <!-- Logo -->
            <a href="index.php" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>A</b>LT</span>
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

                        <!-- Notifications: style can be found in dropdown.less -->
                        <li class="dropdown notifications-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bell-o"></i>
                                <span class="label label-warning">10</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 10 notifications</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
                                                page and may cause design problems
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-users text-red"></i> 5 new members joined
                                            </a>
                                        </li>

                                        <li>
                                            <a href="#">
                                                <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-user text-red"></i> You changed your username
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="footer"><a href="#">View all</a></li>
                            </ul>
                        </li>

                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="../../../dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                                <span class="hidden-xs"><?php echo $fname . ' ' . $lname ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                    <img src="../../../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                                    <p>
                                        Alexander Pierce - Web Developer
                                        <small>Member since Nov. 2012</small>
                                    </p>
                                </li>
                                <!-- Menu Body -->
                                <li class="user-body">
                                    <div class="row">
                                        <div class="col-xs-4 text-center">
                                            <a href="#">Followers</a>
                                        </div>
                                        <div class="col-xs-4 text-center">
                                            <a href="#">Sales</a>
                                        </div>
                                        <div class="col-xs-4 text-center">
                                            <a href="#">Friends</a>
                                        </div>
                                    </div>
                                    <!-- /.row -->
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="#" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="#" class="btn btn-default btn-flat">Sign out</a>
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
                        <img src="../../../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                    </div>
                    <div class="pull-left info">
                        <p>Alexander Pierce</p>
                        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                    </div>
                </div>

                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu kanitB" data-widget="tree">
                    <li class="header">MENU BAR</li>

                    <li>
                        <a href="../../index.php">
                            <i class="fa fa-home"></i> <span>หน้าแรก</span>
                        </a>
                    </li>

                    <li class="treeview active">
                        <a href="#">
                            <i class="fa fa-calendar"></i>
                            <span>การจองคิว</span>
                            <span class="pull-right-container">
                                <span class="label label-primary pull-right"><?php echo $count ?></span>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="../databooking/index.php"><i class="fa  fa-info"></i>ข้อมูลการจองคิว</a></li>
                            <li class="active"><a href="#"><i class="fa  fa-spinner"></i>อนุมัติการจอง
                                    <span class="pull-right-container">
                                        <span class="label label-primary pull-right"><?php echo $count ?></span>
                                    </span>
                                </a></li>
                            <li><a href="../history/index.php"><i class="fa fa-history"></i>ประวัติการจอง</a></li>
                            <!-- <li><a href="pages/layout/collapsed-sidebar.html"><i class="fa fa-circle-o"></i> Collapsed Sidebar</a></li> -->
                        </ul>
                    </li>

                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-file-text-o"></i>
                            <span>รายงาน</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="#"><i class="fa fa-file-o"></i>รายงานการจองคิว</a></li>
                            <li><a href="#"><i class="fa fa-comments"></i>รายงานการประเมิน</a></li>
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
                <?php
                if (isset($errorMsg)) {
                ?>
                    <div class="alert alert-danger alert-dismissible">
                        <strong><i class="icon fa fa-ban"></i>Wrong! <?php echo $errorMsg ?></strong>
                    </div>

                <?php } ?>

                <?php
                if (isset($insertMsg)) {
                ?>
                    <div class="alert alert-success alert-dismissible">
                        <strong><i class="icon fa fa-check"></i>Success <?php echo $insertMsg ?></strong>
                    </div>
                <?php } ?>
                <h1 class="kanitB">
                    อนุมัติการจอง      
                    <!-- <small class="kanitB"><b>การจองคิว</b></small> -->
                </h1>
                <ol class="breadcrumb kanitB">
                    <li><a href="../../index.php"><i class="fa fa-home"></i> หน้าแรก</a></li>
                    <li class="active ">อนุมัติการจอง</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-header">
                                <!-- <h3 class="box-title kanitB">ตารางอนุมัติการจอง</h3> -->
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                            </div>


                            <!-- /.box-header -->
                            <div class="box-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="kanitB">
                                            <th>ลำดับ</th>  
                                            <th>เลขที่รายการ</th>                                         
                                            <th>ชื่อลูกค้า</th>
                                            <th>รายละเอียดบริการ</th>
                                            <th>ราคา</th>
                                            <th>เวลาในการบริการ</th>
                                            <th>ว/ด/ป เวลา</th>
                                            <th>สถานะ</th>
                                            <th>รายละเอียด</th>                                         
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php                                       
                                        $result = $db->prepare('SELECT * from tb_booking where uuid_emp = :uuid_emp and book_st = :book_st and cre_bks_date = :cre_bks_date');
                                        $result->bindParam(":uuid_emp", $uuid_emp);
                                        $result->bindParam(":book_st", $book_status);
                                        $result->bindParam(":cre_bks_date", $date);
                                        $result->execute();

                                        $num = 0;
                                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                            $num++;

                                            if ($row['book_st'] == 'wait') {
                                                $status = 'รอดำเนินการ';
                                            }
                                        ?>
                                            <form method="POST">
                                            <tr class="kanitB">
                                                <td><?php echo $num ?></td>  
                                                <td><?php echo $row['books_nlist'] ?></td>                                            
                                                <td><?php echo $row['book_cus'] ?></td>
                                                <td><?php echo $row['book_serv'] ?></td>
                                                <td class="text-right"><?php echo $row['books_price'] ?></td>
                                                <td><?php echo $row['books_hours'] ?></td>
                                                <td><?php echo $row['cre_bks_time'] . '-' . $row['end_bks_time'] ?></td>
                                                <?php
                                                if ($status == 'รอดำเนินการ') {
                                                    $txt_color = '#f0ad4e';
                                                    $icon = 'fa fa-clock-o';
                                                } else {
                                                    $txt_color = '';
                                                }

                                                echo '<td style="color : ' . $txt_color . '">';
                                                echo '<i class="' . $icon . '"></i>' . ' ' . $status;
                                                echo '</td>';
                                                ?>
                                                <td><a href="confirm.php?num_list=<?php echo $row['books_nlist']?>" class="btn btn-success btn-block" onClick="return confirm('คุณต้องการยืนยันในการจองหรือไม่ ?');"><i class="fa fa-check-square-o"></i> ยืนยัน</a></td>                                               
                                            </tr>
                                        </form>
                                        <?php } ?>
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
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>Version</b> 2.4.0
            </div>
            <strong>Copyright &copy; 2021 By BIS.</strong> For educational purposes only.
            reserved.
            reserved.
        </footer>

        <!-- /.control-sidebar -->

        <div class="control-sidebar-bg"></div>
    </div>
    <!-- ./wrapper -->

    <!-- jQuery 3 -->
    <script src="../../../bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="../../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="../../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="../../../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="../../../bower_components/fastclick/lib/fastclick.js"></script>
    <!-- AdminLTE App -->
    <script src="../../../dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../../dist/js/demo.js"></script>
    <!-- page script -->
    <script>
        $(function() {
            $('#example1').DataTable()
            $('#example2').DataTable({
                'paging': true,
                'lengthChange': false,
                'searching': true,
                'ordering': true,
                'info': true,
                'autoWidth': false
            })
        })
    </script>
</body>

</html>