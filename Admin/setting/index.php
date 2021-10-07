<?php
session_start();
require_once('../require/config.php');
require_once('../require/session.php');

$message = 'คุณไม่มีสิทธิ์เข้าถึงหน้านี้ !';

if (empty($_SESSION["token_admin_uuid"])) {
    echo "<script type='text/javascript'>alert('$message');</script>";
    header("refresh:0;../login.php");
}

if ($_SESSION["token_admin_uuid"]) {
    $uuid_mng = $_SESSION["token_admin_uuid"];

    $select_mng = $db->prepare("select * from tb_manager where uuid = :uuid_mng");
    $select_mng->bindParam(":uuid_mng", $uuid_mng);
    $select_mng->execute();
    $row = $select_mng->fetch(PDO::FETCH_ASSOC);
    extract($row);

    // $date = date("d-m-Y"); //thai
    $date = date("Y-m-d");
    $time = date("h:i:sa");
    $newtime = str_replace(['pm', 'am'], '', $time);

    $book_status = 'success';

    $sql = "select count(books_nlist) from tb_booking where book_st = 'wait' and cre_bks_date >= '$date'";
    $res = $db->query($sql);
    $count = $res->fetchColumn();

    if (isset($_REQUEST['num_list'])) {
        $num_list = $_REQUEST['num_list'];

        $select_time = $db->prepare('select * from tb_booking where books_nlist = :books_nlist');
        $select_time->bindParam(":books_nlist", $num_list);
        $select_time->execute();
        $row1 = $select_time->fetch(PDO::FETCH_ASSOC);
        extract($row1);
    }

    if (isset($_REQUEST['btn_logout'])) {
        try {
            session_unset();
            $_SESSION["token_admin_loing"] = false;
            $seMsg = 'ออกจากระบบแล้ว';
            header("refresh:0;../login.php");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}

if (isset($_REQUEST['btn_agree'])) {

    try {
        $startDate = $_REQUEST['startDate'];
        $endDate = $_REQUEST['endDate'];
        $switch = $_REQUEST['switch'];

        $insert_serv = $db->prepare("INSERT INTO tb_onoff(start_date,end_date,status) VALUES (:start_date, :end_date, :status)");
        $insert_serv->bindParam(':start_date', $startDate);
        $insert_serv->bindParam(':end_date', $endDate);
        $insert_serv->bindParam(':status', $switch);

        if ($insert_serv->execute()) {
            $insertMsg = "บันทึกสำเร็จ . . .";
            header("refresh:2;index.php");
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>กำหนดเปิด - ปิดร้าน | Beautiful Salon</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.css">
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

    <!-- time picker -->
    <link rel="stylesheet" href="../emp/jquery/jquery.timepicker.min.css">
    <link rel="stylesheet" href="../emp/jquery/jquery.timepicker.css">
    <!-- datepicker -->
    <link rel="stylesheet" href="../emp/css/bootstrap-datepicker.min.css" />
    <link rel="icon" href="../images/hairsalon-icon.png" type="image/gif" sizes="16x16">
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        <header class="main-header">
            <!-- Logo -->
            <a href="../index.php" class="logo">
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
                                <span class="hidden-xs"><?php echo $fname . ' ' . $lname ?></span>
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

                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-file-text-o"></i>
                            <span>รายงาน</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <!-- <li><a href="#"><i class="fa fa-file-o"></i>รายงานการจองคิว</a></li> -->
                            <li class=""><a href="../report/index.php"><i class="fa  fa-paperclip"></i>รายงานแบบประเมิน</a></li>
                            <li class=""><a href="../report/sales_fore_old.php"><i class="fa fa-bar-chart"></i>พยากรณ์ยอดขาย (เก่า)</a></li>
                            <li class=""><a href="../report/cus_fore_old.php"><i class="fa fa-area-chart"></i>พยากรณ์ลูกค้า (เก่า)</a></li>
                            <li class=""><a href="../report/sales_fore_new.php"><i class="fa fa-bar-chart"></i>พยากรณ์ยอดขาย (ใหม่)</a></li>
                            <li class=""><a href="../report/cus_fore_new.php"><i class="fa fa-area-chart"></i>พยากรณ์ลูกค้า (ใหม่)</a></li>
                        </ul>
                    </li>

                    <li class="treeview active">
                        <a href="#">
                            <i class="fa fa-gear"></i>
                            <span>ตั้งค่า</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <!-- <li><a href="pages/layout/collapsed-sidebar.html"><i class="fa fa-user"></i>กำหนดจำนวนลูกค้าต่อวัน</a></li> -->
                            <li class="active"><a href="#"><i class="fa fa-power-off"></i>กำหนดวันเปิด - ปิดร้าน</a></li>
                        </ul>
                    </li>
                    </li>
                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <?php
            if (isset($errorMsg)) {
            ?>
                <div class="alert alert-danger alert-dismissible kanitB">
                    <strong><i class="icon fa fa-ban"></i>Wrong! <?php echo $errorMsg ?></strong>
                </div>

            <?php } ?>

            <?php
            if (isset($insertMsg)) {
            ?>
                <div class="alert alert-success alert-dismissible kanitB">
                    <strong><i class="icon fa fa-check"></i>Success <?php echo $insertMsg ?></strong>
                </div>
            <?php } ?>
            <!-- Content Header (Page header) -->
            <section class="content-header">

                <h1 class="kanitB">
                    กำหนดวันเปิด - ปิดร้าน
                    <!-- <small class="kanitB"><b>การจองคิว</b></small> -->
                </h1>
                <ol class="breadcrumb kanitB">
                    <li><a href="../index.php"><i class="fa fa-home"></i> หน้าแรก</a></li>
                    <li class="active "> กำหนดวันเปิด - ปิดร้าน</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="row kanitB">
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
                                <form action="" method="POST">
                                    <div class="row">
                                        <div class="col-12 col-md-4 mb-2">
                                            <div class="form-group">
                                                <label>ปิดร้าน ตั้งแต่วันที่</label>
                                                <div class="input-group date">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input type="text" class="form-control pull-right" autocomplete="off" id="datepicker" name="startDate" placeholder="เลือกวันที่" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-4 mb-2">
                                            <div class="form-group">
                                                <label>จนถึงวันที่ </label>
                                                <div class="input-group date">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input type="text" class="form-control pull-right" autocomplete="off" id="end-datepicker" name="endDate" placeholder="เลือกวันที่" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-4 mb-2">
                                            <div class="form-group">
                                                <label>เลือก </label>
                                                <div class="form-group">
                                                    <!-- <label>Minimal</label> -->
                                                    <select class="form-control select2" name="switch" style="width: 100%;">
                                                        <option selected="selected" value="off">ปิด</option>
                                                        <option value="on">เปิด</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="box-footer">
                                        <div class="row">
                                            <div class="col-md-12 ">
                                                <div class="col-md-4">
                                                    <a href="index.php" class="btn btn-default btn-block">ยกเลิก</a>
                                                </div>
                                                <div class="col-md-8">
                                                    <button type="submit" class="btn btn-success btn-block" name="btn_agree"><i class="fa Example of check-circle-o fa-check-circle-o"></i> ยืนยันการปิดร้าน</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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
            <section class="content-header">
                <h1 class="kanitB">
                    รายละเอียด
                    <!-- <small class="kanitB"><b>การจองคิว</b></small> -->
                </h1>
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
                                            <th>ตั้งแต่</th>
                                            <th>จนถึง</th>
                                            <th>สถานะ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $result = $db->prepare('SELECT * from tb_onoff order by id desc limit 1');
                                        $result->execute();

                                        $num = 0;
                                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                            $num++;

                                            if ($row['status'] == 'off') {
                                                $status = 'ปิด';
                                            } else {
                                                $status = 'เปิด';
                                            }

                                        ?>
                                            <form method="POST">
                                                <tr class="kanitB">
                                                    <td><?php echo $num ?></td>
                                                    <td><?php echo $row['start_date'] ?></td>
                                                    <td><?php echo $row['end_date'] ?></td>
                                                    <td><?php echo $status ?></td>
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
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <div class="pull-right hidden-xs kanitB">
                <b>เวอร์ชั่น</b> 1.0.1
            </div>
            <strong>Copyright &copy; 2021 By BIS.</strong> For educational purposes only.
            reserved.

        </footer>

        <!-- /.control-sidebar -->

        <div class="control-sidebar-bg"></div>
    </div>
    <!-- ./wrapper -->

    <!-- time picker -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../emp/js/bootstrap.min.js"></script>
    <script src="../emp/jquery/jquery.timepicker.min.js"></script>
    <script src="../emp/jquery/jquery.timepicker.js"></script>
    <!-- jQuery 3 -->
    <!-- <script src="../bower_components/jquery/dist/jquery.min.js"></script> -->
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.th.min.js" integrity="sha512-cp+S0Bkyv7xKBSbmjJR0K7va0cor7vHYhETzm2Jy//ZTQDUvugH/byC4eWuTii9o5HN9msulx2zqhEXWau20Dg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://momentjs.com/downloads/moment.js"></script>

    <script>
        function addMinutes(date, minutes) {
            date = new Date(date.getTime() + minutes * 60000);
            return date.getHours() + ':' + ("0" + date.getMinutes()).slice(-2)
        }

        function deMinutes(date, minutes) {
            date = new Date(date.getTime() - minutes * 60000);
            return date.getHours() + ':' + ("0" + date.getMinutes()).slice(-2)
        }
        var date_start = new Date()
        var date_end = new Date()
        date_start.setDate(date_start.getDate());
        date_end.setDate(date_end.getDate() + 30);

        $(function() {
            $('#example1').DataTable()
        })

        $('#datepicker').datepicker({
            format: 'yyyy-mm-dd',
            language: 'th',
            startDate: date_start,
            endDate: date_end,
        });

        $('#end-datepicker').datepicker({
            format: 'yyyy-mm-dd',
            language: 'th',
            startDate: date_start,
            endDate: date_end,
        });

        $(document).ready(function(v) {
            $('#startTime').timepicker({
                timeFormat: 'HH:mm',
                interval: 30,
                minTime: '10.30',
                maxTime: '19.00',
                startTime: '10:30',
                dynamic: false,
                dropdown: true,
                scrollbar: true,
                change: function() {
                    var firstDate = new Date(moment($(this).val(), 'HH:mm'));
                    let mtimemin = document.getElementById("endTimemin").value;
                    let retime = addMinutes(firstDate, mtimemin)
                    // console.log(retime);
                    document.getElementById("endTime").value = retime
                }
            });



            $('#endTime').timepicker({
                timeFormat: 'HH:mm',
                interval: 30,
                minTime: '10.30',
                maxTime: '19.00',
                startTime: '10:30',
                dynamic: false,
                dropdown: true,
                scrollbar: true,
            });
        });
    </script>
</body>

</html>