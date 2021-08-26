<!DOCTYPE html>
<html>
<?php
require_once '../../require/config.php';

if(empty($_SESSION["token_admin_uuid"])){
  session_unset();
  header("refresh:0;../../../login.php");
}

if (isset($_REQUEST['update_id'])) {
  try {
    $id_serv = $_REQUEST['update_id'];
    $qry = $db->prepare("select * from tb_service where serv_id = :ser_id");
    $qry->bindParam(":ser_id", $id_serv);
    $qry->execute();
    $row = $qry->fetch(PDO::FETCH_ASSOC);
    extract($row);
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}

if (isset($_REQUEST['btn_update'])) {
  try {

    $update_serv_id = $_REQUEST['serv_id'];
    $serv_code_up = $_REQUEST['serv_code'];
    $serv_ser_up = $_REQUEST['serv_ser'];
    $serv_price_up = $_REQUEST['serv_price'];
    $serv_time_up = $_REQUEST['serv_time'];

    if (empty($serv_code_up)) {
      $errorMsg = "Please Enter Service Code";
    } else if (empty($serv_ser_up)) {
      $errorMsg = "Please Enter Service Name";
    } else if (empty($serv_price_up)) {
      $errorMsg = "Please Enter Service Price";
    } else if (empty($serv_time_up)) {
      $errorMsg = "Please Enter Service Time";
    } else {
      try {
        if (!isset($errorMsg)) {

          $update_serv = $db->prepare('update tb_service set serv_code = :code_serv,serv_type = :type_serv,
          serv_price = :price_serv ,serv_process_time = :process_time_serv,up_serv_date = :up_serv_date,up_serv_time = :up_serv_time where serv_id = :update_id');

          $update_serv->bindParam(':update_id', $update_serv_id);
          $update_serv->bindParam(':code_serv', $serv_code_up);
          $update_serv->bindParam(':type_serv', $serv_ser_up);
          $update_serv->bindParam(':price_serv', $serv_price_up);
          $update_serv->bindParam(':process_time_serv', $serv_time_up);
          $update_serv->bindParam(':up_serv_date', $date);
          $update_serv->bindParam(':up_serv_time', $time);

          if ($update_serv->execute()) {
            $insertMsg = "update Successfully . . .";
            header("refresh:2;../index.php");
          }
        }
      } catch (PDOException $e) {
        echo $e->getMessage();
      }
    }
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}

?>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Service | Beautiful Salon</title>

  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../../dist/css/skins/_all-skins.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="../../bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="../../bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="../../plugins/iCheck/all.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="../../bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
  <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="../../plugins/timepicker/bootstrap-timepicker.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="../../bower_components/select2/dist/css/select2.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

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
        <span class="logo-lg"><b>Admin</b>LTE</span>
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
                <img src="../../dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                <span class="hidden-xs">Alexander Pierce</span>
              </a>
              <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                  <img src="../../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

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
            <img src="../../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
          </div>
          <div class="pull-left info">
            <p>Alexander Pierce</p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
          </div>
        </div>

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
          <li class="header">MENU BAR</li>

          <li>
            <a href="index.php">
              <i class="fa fa-home"></i> <span>หน้าแรก</span>
              <!-- <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span> -->
            </a>
            <!-- <ul class="treeview-menu">
            <li class="active"><a href="index.php"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>
            <li><a href="index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
          </ul> -->
          </li>

          <li class="treeview">
            <a href="#">
              <i class="fa fa-calendar"></i>
              <span>การจองคิว</span>
              <span class="pull-right-container">
                <span class="label label-primary pull-right">4</span>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="pages/layout/top-nav.html"><i class="fa  fa-info"></i>ข้อมูลการจองคิว</a></li>
              <li><a href="pages/layout/boxed.html"><i class="fa  fa-spinner"></i>อนุมัติการจอง
                  <span class="pull-right-container">
                    <span class="label label-primary pull-right">4</span>
                  </span>
                </a></li>
              <li><a href="pages/layout/fixed.html"><i class="fa fa-history"></i>ประวัติการจอง</a></li>
              <!-- <li><a href="pages/layout/collapsed-sidebar.html"><i class="fa fa-circle-o"></i> Collapsed Sidebar</a></li> -->
            </ul>
          </li>
          <li>

          <li>
            <a href="#">
              <i class="fa fa-shopping-cart"></i> <span>สินค้า</span>
            </a>
          </li>

          <li class="active">
            <a href="#">
              <i class="fa fa-thumbs-up"></i> <span>บริการ</span>
            </a>
          </li>

          <li>
            <a href="users.php">
              <i class="fa fa-users"></i> <span>ลูกค้า</span>
            </a>
          </li>

          <li>
            <a href="index.php">
              <i class="fa fa-smile-o"></i> <span>พนักงาน</span>
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
              <li><a href="pages/layout/top-nav.html"><i class="fa fa-file-o"></i>รายงานการจองคิว</a></li>
              <li><a href="pages/layout/top-nav.html"><i class="fa  fa-paperclip"></i>รายงานแบบประเมิน</a></li>
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
              <li><a href="pages/layout/collapsed-sidebar.html"><i class="fa fa-user"></i>กำหนดจำนวนลูกค้าต่อวัน</a></li>
              <li><a href="pages/layout/top-nav.html"><i class="fa fa-power-off"></i>กำหนดวันเปิด - ปิดร้าน</a></li>
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
        <h1>
          Service
          <small class="kanitB"><b>แก้ไขการบริการ</b></small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="../../index.php"><i class="fa fa-home"></i> Home</a></li>
          <li><a href="../">Service</a></li>
          <li class="active">Edit Service</li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">
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

        <form role="form" method="POST" enctype="multipart/form-data">
          <div class="row">
            <div class="col-xs-12">

              <!-- ข้อมูลบริการ -->
              <div class="box box-primary">
                <!-- <div class="box-header with-border">
                  <h3 class="box-title">
                    Profile
                  </h3>
                </div> -->
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body kanitB">
                  <input type="hidden" class="form-control" id="serv_id" name="serv_id" value="<?php echo $serv_id; ?>">
                  <div class="form-group">
                    <label for="title">รหัสบริการ</label>
                    <input type="text" class="form-control" id="serv_code" name="serv_code" placeholder="S100X" value="<?php echo $serv_code; ?>">
                  </div>
                  <div class="form-group">
                    <label for="description">ชื่อบริการ</label>
                    <input type="text" class="form-control" id="serv_ser" name="serv_ser" placeholder="สระผม" value="<?php echo $serv_type; ?>">
                  </div>
                  <!-- radio -->
                  <div class="form-group">
                    <label for="title">ราคา</label>
                    <input type="number" class="form-control" id="serv_price" name="serv_price" placeholder="100.00" min='0' max='10000' value="<?php echo $serv_price; ?>">
                  </div>
                  <!-- /.form group -->
                  <!-- Date -->
                  <div class="form-group">
                    <label>เวลาในการบริการ</label>
                    <!-- selected -->
                    <select class="form-control" name="serv_time">
                      <option style="font-weight: bolder;">เลือกเวลาในการบริการ</option>
                      <option style="font-weight: bolder;" value="00:30:00" <?php echo $serv_process_time == "00:30:00" ? 'selected' : ''  ?>>00:30:00</option>
                      <option style="font-weight: bolder;" value="01:00:00" <?php echo $serv_process_time == "01:00:00" ? 'selected' : ''  ?>>01:00:00</option>
                      <option style="font-weight: bolder;" value="01:30:00" <?php echo $serv_process_time == "01:30:00" ? 'selected' : ''  ?>>01:30:00</option>
                      <option style="font-weight: bolder;" value="02:00:00" <?php echo $serv_process_time == "02:00:00" ? 'selected' : ''  ?>>02:00:00</option>
                    </select>
                    <!-- /.input group -->
                  </div>
                  <!-- /.form group -->

                  <!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" name="btn_update" class="btn btn-success"> <i class="fa fa-pencil-square-o"></i> Update</button>
                  </div>
                </div>
                <!-- /ข้อมูลส้วนตัว -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
        </form>
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
    </footer>

    <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
  </div>
  <!-- ./wrapper -->
  <!-- jQuery 3 -->
  <script src="../../bower_components/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- DataTables -->
  <script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <!-- SlimScroll -->
  <script src="../../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
  <!-- FastClick -->
  <script src="../../bower_components/fastclick/lib/fastclick.js"></script>
  <!-- AdminLTE App -->
  <script src="../../dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="../../dist/js/demo.js"></script>
  <!-- Select2 -->
  <script src="../../bower_components/select2/dist/js/select2.full.min.js"></script>
  <!-- InputMask -->
  <script src="../../plugins/input-mask/jquery.inputmask.js"></script>
  <script src="../../plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
  <script src="../../plugins/input-mask/jquery.inputmask.extensions.js"></script>
  <!-- date-range-picker -->
  <script src="../../bower_components/moment/min/moment.min.js"></script>
  <script src="../../bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
  <!-- bootstrap datepicker -->
  <script src="../../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  <!-- bootstrap color picker -->
  <script src="../../bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
  <!-- bootstrap time picker -->
  <script src="../../plugins/timepicker/bootstrap-timepicker.min.js"></script>
  <!-- SlimScroll -->
  <script src="../../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
  <!-- iCheck 1.0.1 -->
  <script src="../../plugins/iCheck/icheck.min.js"></script>
  <!-- Page script -->

  <!-- page script -->
  <script>
    $(function() {
      //Initialize Select2 Elements
      $('.select2').select2()

      //Datemask dd/mm/yyyy
      $('#datemask').inputmask('dd/mm/yyyy', {
        'placeholder': 'dd/mm/yyyy'
      })
      //Datemask2 mm/dd/yyyy
      $('#datemask2').inputmask('mm/dd/yyyy', {
        'placeholder': 'mm/dd/yyyy'
      })
      //Money Euro
      $('[data-mask]').inputmask()

      //Date range picker
      $('#reservation').daterangepicker()
      //Date range picker with time picker
      $('#reservationtime').daterangepicker({
        timePicker: true,
        timePickerIncrement: 30,
        format: 'MM/DD/YYYY h:mm A'
      })
      //Date range as a button
      $('#daterange-btn').daterangepicker({
          ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          startDate: moment().subtract(29, 'days'),
          endDate: moment()
        },
        function(start, end) {
          $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
        }
      )

      //Date picker
      $('#datepicker').datepicker({
        autoclose: true
      })

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

      //Colorpicker
      $('.my-colorpicker1').colorpicker()
      //color picker with addon
      $('.my-colorpicker2').colorpicker()

      //Timepicker
      $('.timepicker').timepicker({
        showInputs: false
      })
    })
  </script>
</body>

</html>