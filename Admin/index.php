<?php
session_start();
require_once 'require/config.php';
require_once 'require/session.php';

$message = 'คุณไม่มีสิทธิ์เข้าถึงหน้านี้ !';

if (empty($_SESSION["token_admin_uuid"])) {
  echo "<script type='text/javascript'>alert('$message');</script>";
  header("refresh:0;login.php");
}

if (isset($_REQUEST['btn_logout'])) {
  try {
    session_unset();
    $_SESSION["token_admin_loing"] = false;
    $seMsg = 'ออกจากระบบแล้ว';
    header("refresh:2;login.php");
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}


if (!empty($_SESSION["token_admin_uuid"])) {
  $uuid_mng = $_SESSION["token_admin_uuid"];

  $select_mng = $db->prepare("select * from tb_manager where uuid = :uuid_mng");
  $select_mng->bindParam(":uuid_mng", $uuid_mng);
  $select_mng->execute();
  $row = $select_mng->fetch(PDO::FETCH_ASSOC);
  extract($row);

  $date = date("Y-m-d");

  $sql = "select count(books_nlist) from tb_booking where book_st = 'wait' and cre_bks_date = '$date'";
  $res = $db->query($sql);
  $count = $res->fetchColumn();

  $sql1 = "select count(books_nlist) from tb_booking where cre_bks_date = '$date'";
  $res1 = $db->query($sql1);
  $count_cus = $res1->fetchColumn();

  $sql2 = "select sum(books_price) as price from tb_booking where cre_bks_date = '$date'";
  $res2 = $db->query($sql2);
  $sum_price = $res2->fetchColumn();
}


?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Beautiful Salon</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <link rel="stylesheet" href="css/fontkanit.css">
  <link rel="icon" href="images/hairsalon-icon.png" type="image/gif" sizes="16x16">
  <style>
    #chart-container {
      width: 100%;
      height: auto;
    }
  </style>

</head>

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    <header class="main-header">
      <!-- Logo -->
      <a href="index.php" class="logo">
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
        </a>

        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">

            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="images/manager/manager.png" class="user-image" alt="User Image">
                <span class="hidden-xs"><?php if (!empty($_SESSION["token_admin_uuid"])) echo $fname . ' ' . $lname; ?></span>
              </a>
              <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                  <img src="images/manager/manager.png" class="img-circle" alt="User Image">

                  <p>
                    <?php if (!empty($_SESSION["token_admin_uuid"])) echo $fname . ' ' . $lname; ?>
                    <small class="kanitB">ผู้จัดการ</small>
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
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
          <div class="pull-left image">
            <img src="images/manager/manager.png" class="img-circle" alt="User Image">
          </div>
          <div class="pull-left info">
            <p><?php if (!empty($_SESSION["token_admin_uuid"])) echo $fname . ' ' . $lname; ?></p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
          </div>
        </div>

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu kanitB" data-widget="tree">
          <li class="header">เมนูบาร์</li>

          <li class="active">
            <a href="index.php">
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
              <li><a href="booking/databooking/"><i class="fa  fa-info"></i>ข้อมูลการจองคิว</a></li>
              <li><a href="booking/confirm/"><i class="fa  fa-spinner"></i>อนุมัติการจอง
                  <span class="pull-right-container">
                    <span class="label label-primary pull-right"><?php if (!empty($_SESSION["token_admin_uuid"])) echo $count ?></span>
                  </span>
                </a></li>
              <li><a href="booking/history/"><i class="fa fa-history"></i>ประวัติการจอง</a></li>
              <!-- <li><a href="pages/layout/collapsed-sidebar.html"><i class="fa fa-circle-o"></i> Collapsed Sidebar</a></li> -->
            </ul>
          </li>
          <li>

          <li>
            <a href="product/">
              <i class="fa fa-shopping-cart"></i> <span>สินค้า</span>
            </a>
          </li>

          <li>
            <a href="serv/">
              <i class="fa fa-thumbs-up"></i> <span>บริการ</span>
            </a>
          </li>

          <li>
            <a href="customer/">
              <i class="fa fa-users"></i> <span>ลูกค้า</span>
            </a>
          </li>

          <li>
            <a href="employee/">
              <i class="fa fa-smile-o"></i> <span>พนักงาน</span>
            </a>
          </li>

          <li>
            <a href="manager/">
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
              <li><a href="report/"><i class="fa  fa-paperclip"></i>รายงานแบบประเมิน</a></li>
              <li class=""><a href="report/sales_fore_old.php"><i class="fa fa-bar-chart"></i>พยากรณ์ยอดขาย (เก่า)</a></li>
              <li class=""><a href="report/cus_fore_old.php"><i class="fa fa-area-chart"></i>พยากรณ์ลูกค้า (เก่า)</a></li>
              <li class=""><a href="report/sales_fore_new.php"><i class="fa fa-bar-chart"></i>พยากรณ์ยอดขาย (ใหม่)</a></li>
              <li class=""><a href="report/cus_fore_new.php"><i class="fa fa-area-chart"></i>พยากรณ์ลูกค้า (ใหม่)</a></li>
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
              <li><a href="setting/index.php"><i class="fa fa-power-off"></i>กำหนดวันเปิด - ปิดร้าน</a></li>
            </ul>
          </li>
          </li>
        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1 class="kanitB">
          แดชบอร์ด
          <!-- <small>Control panel</small> -->
        </h1>
        <ol class="breadcrumb kanitB">
          <li><a href="#"><i class="fa fa-home"></i> หน้าแรก</a></li>
          <li class="active">แดชบอร์ด</li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row kanitB">

          <!-- ./col -->
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
              <div class="inner">
                <h3><?php if (!empty($_SESSION["token_admin_uuid"])) echo $count_cus ?></h3>

                <p>จำนวนลูกค้าทั้งหมด</p>
              </div>
              <div class="icon">
                <i class="ion ion-person"></i>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
              <div class="inner">
                <h3 class="kanitB"><?php if (!empty($_SESSION["token_admin_uuid"])) echo number_format($sum_price); ?> <sup style="font-size: 20px">บาท</sup></h3>

                <p>รายรับทั้งหมด</p>
              </div>
              <div class="icon">
                <i class="ion ion-cash"></i>
              </div>

            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->

        <!-- Main row -->
        <section class="container-fluid">
          <div class="row kanitB">
            <!-- Left col -->

            <!-- Custom tabs (Charts with tabs)-->
            <div class="nav-tabs-custom">
              <!-- Tabs within a box -->
              <ul class="nav nav-tabs pull-right">
                <li class="active"><a href="#revenue-chart" data-toggle="tab">กราฟ</a></li>
                <li class="pull-left header"><i class="ion ion-person"></i> กราฟลูกค้า </li>
              </ul>
              <div class="tab-content no-padding">
                <!-- Morris chart - Sales -->
                <div class="chart tab-pane active" id="revenue-chart" style="position: relative; ">
                <div class="col-md-8">
                  <div id="chart-container">
                    <canvas id="graphCanvas"></canvas>
                  </div>
                </div>
              </div>
               
              </div>
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
          <!-- /.row (main row) -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
      <div class="pull-right hidden-xs">
        <b>Version</b> 1.0.1
      </div>
      <strong>Copyright &copy; 2021 By BIS.</strong> For educational purposes only.
    </footer>

    <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
  </div>
  
  <!-- ./wrapper -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- jQuery 3 -->
  <script src="bower_components/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- DataTables -->
  <script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <!-- SlimScroll -->
  <script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
  <!-- FastClick -->
  <script src="bower_components/fastclick/lib/fastclick.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>
  <!-- page script -->
  <!-- iCheck 1.0.1 -->
  <script src="plugins/iCheck/icheck.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js"></script>
  <script>
    $(document).ready(function() {
      showGraph();
    });

    function showGraph() {
      {
        $.post("data.php", function(data) {
          console.log(data);
          let name = [];
          let name1 = [];
          let score = [];

          for (let i in data) {
            name.push(data[i].Day + "/" + data[i].Month);
            score.push(data[i].count);
          }

          let chartdata = {
            labels: name,
            datasets: [{
              label: 'ลูกค้า',
              backgroundColor: '#49e2ff',
              borderColor: '#46d5f1',
              hoverBackgroundColor: '#CCCCCC',
              hoverBorderColor: '#666666',
              data: score
            }]
          };

          let graphTarget = $('#graphCanvas');
          let barGraph = new Chart(graphTarget, {
            type: 'bar',
            data: chartdata
          })
        })
      }
    }
  </script>
</body>

</html>