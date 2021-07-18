<!DOCTYPE html>
<html>
<?php
require_once('require/config.php');

if (isset($_REQUEST['btn_insert'])) {
  $data = $data ?? random_bytes(16);
  assert(strlen($data) == 16);

  // Set version to 0100
  $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
  // Set bits 6-7 to 10
  $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

  // Output the 36 character UUID.
  $myuuid = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));

  $username = $_REQUEST['username'];
  $password = $_REQUEST['password'];
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);
  $role = 201;

  $fname = $_REQUEST['fname'];
  $lname = $_REQUEST['lname'];
  $gender = $_REQUEST['gender'];
  $birthday = $_REQUEST['birthday'];
  $numberphone = $_REQUEST['numberphone'];
  $idcard = $_REQUEST['idcard'];
  $address = $_REQUEST['address'];
  $date = date("d/m/Y");
  $time = date("h:i:sa");
  $newtime = str_replace(['pm', 'am'], '', $time);
  $newphone = str_replace(['(', ')',' ','-','_'], '', $numberphone);
  $newcard = str_replace(['(', ')',' ','-','_'], '', $idcard);
  $lenphone = strlen($newphone);
  $lencard = strlen($newcard);

  if (empty($username)) {
    $errorMsg = "Please Enter Username";
  } else if (empty($password)) {
    $errorMsg = "Please Enter Password";
  } else if (empty($fname)) {
    $errorMsg = "Please Enter Firstname";
  } else if (empty($lname)) {
    $errorMsg = "Please Enter Lastname";
  } else if (empty($gender)) {
    $errorMsg = "Please Select Gender";
  } else if (empty($birthday)) {
    $errorMsg = "Please Select Birthday";
  } else if (empty($numberphone)) {
    $errorMsg = "Please Enter Number Phone";
  } else if ($lenphone < 10) {
    $errorMsg = "Please Enter Number Phone To Complete 10 Digits ";
  } else if ($lencard < 13) { 
    $errorMsg = "Please Enter ID Card To Complete 13 Digits ";
  } else if (empty($idcard)) {
    $errorMsg = "Please Enter Number IDCard";
  } else if (empty($address)) {
    $errorMsg = "Please Enter Address";
    // } else if (empty($fileupload)) {
    //   $errorMsg = "Please Upload File";
  } else if (empty($_FILES['image']['name'])) {
    $errorMsg = "Please Select Images";
  } else {
    try {
      if (!isset($errorMsg)) {
        $insert_login = $db->prepare("INSERT INTO tb_login(uuid, username, password, role , cre_login_date, cre_login_time) VALUES (:uuid, :user, :password, :role, :cre_login_date, :cre_login_time)");
        $insert_login->bindParam(':uuid', $myuuid);
        $insert_login->bindParam(':user', $username);
        $insert_login->bindParam(':password', $hashed_password);
        $insert_login->bindParam(':role', $role);
        $insert_login->bindParam(':cre_login_date', $date);
        $insert_login->bindParam(':cre_login_time', $newtime);

        if (isset($_FILES['image'])) {
          $file_name = $_FILES['image']['name'];
          $file_size = $_FILES['image']['size'];
          $file_tmp = $_FILES['image']['tmp_name'];
          $file_type = $_FILES['image']['type'];
          $file_ext = substr(str_shuffle("0123456789"), 0, 5) . $file_name;

          if (!move_uploaded_file($file_tmp, "images/" . $file_ext)) {
            $$errorMsg = "Wrong! i . . .";
          }
          // $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));


          // if(in_array($file_ext,$extensions)=== false){
          //    $errors[]="extension not allowed, please choose a JPEG or PNG file.";
          // }

          // if ($file_size > 2097152) {
          //   $errors[] = 'File size must be excately 2 MB';   // }

        }

        $insert_emp = $db->prepare("INSERT INTO tb_employee(uuid, fname, lname, gender, birthday, nphone, idcard, address, images, cre_emp_date, cre_emp_time) VALUES (:uuid, :firname, :lasname, :ggender, :bbirthday, :nnphone, :iidcard, :aaddress, :iimages, :cre_emp_date, :cre_emp_time)");
        $insert_emp->bindParam(':uuid', $myuuid);
        $insert_emp->bindParam(':firname', $fname);
        $insert_emp->bindParam(':lasname', $lname);
        $insert_emp->bindParam(':ggender', $gender);
        $insert_emp->bindParam(':bbirthday', $birthday);
        $insert_emp->bindParam(':nnphone', $numberphone);
        $insert_emp->bindParam(':iidcard', $idcard);
        $insert_emp->bindParam(':aaddress', $address);
        $insert_emp->bindParam(':iimages', $file_ext);
        $insert_emp->bindParam(':cre_emp_date', $date);
        $insert_emp->bindParam(':cre_emp_time', $newtime);

        if ($insert_login->execute() && $insert_emp->execute()) {
          $insertMsg = "Insert Successfully . . .";
          header("refresh:2;employee.php");
        }
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }
}

?>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Add Employee | Beautiful Salon</title>

  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="plugins/iCheck/all.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
  <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="plugins/timepicker/bootstrap-timepicker.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="bower_components/select2/dist/css/select2.min.css">

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
                <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                <span class="hidden-xs">Alexander Pierce</span>
              </a>
              <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                  <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

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
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
          <div class="pull-left image">
            <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
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

          <li>
            <a href="users.php">
              <i class="fa fa-users"></i> <span>ลูกค้า</span>
            </a>
          </li>

          <li class="active">
            <a href="employee.php">
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
          Add Employees
          <small>Beautiful Salon</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
          <li><a href="employee.php">Employees</a></li>
          <li class="active">Add Employee</li>
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

              <!-- Username and Password -->
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">

                    Username and Passowrd
                  </h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                  <!-- phone mask -->
                  <div class="form-group">
                    <label>Username</label>

                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-user"></i>
                      </div>
                      <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username">
                    </div>
                  </div>
                  <!-- /.input group -->
                  <div class="form-group">
                    <label for="description">Password</label>

                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="glyphicon glyphicon-lock"></i>
                      </div>
                      <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
                    </div>
                  </div>

                  <!-- /.box-body -->
                </div>
              </div>
              <!-- /Username and Password -->

              <!-- ข้อมูลส้วนตัว -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">
                    Profile
                  </h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                  <div class="form-group">
                    <label for="title">Firstname</label>
                    <input type="text" class="form-control" id="fname" name="fname" placeholder="Enter Firstname">
                  </div>
                  <div class="form-group">
                    <label for="description">Lastname</label>
                    <input type="text" class="form-control" id="lname" name="lname" placeholder="Enter Lastname">
                  </div>
                  <!-- radio -->
                  <div class="form-group">
                    <label for="title">Gender</label><br>
                    <input type="radio" name="gender" class="minimal" value='male' checked>
                    <label>
                      Male
                    </label>
                    <input type="radio" name="gender" class="minimal-red" value='female'>
                    <label>
                      Female
                    </label>
                  </div>
                  <!-- /.form group -->
                  <!-- Date -->
                  <div class="form-group">
                    <label>BirthDay</label>

                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right selector" id="datepicker" name="birthday">
                    </div>
                    <!-- /.input group -->
                  </div>
                  <!-- /.form group -->
                  <!-- phone mask -->
                  <div class="form-group">
                    <label>Number Phone</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-phone"></i>
                      </div>
                      <input type="text" class="form-control" name="numberphone" data-inputmask='"mask": "(99) 9999-9999"' data-mask>
                    </div>
                  </div>
                  <!-- /.input group -->

                  <!-- ID Card-->
                  <div class="form-group">
                    <label>ID Card</label>

                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="glyphicon glyphicon-credit-card"></i>
                      </div>
                      <input type="text" class="form-control" data-inputmask='"mask": "9-9999-99999-99-9"' data-mask name="idcard">
                    </div>
                    <!-- /.input group -->
                  </div>
                  <!-- /.form group -->
                  <!-- Text area -->
                  <div class="form-group">
                    <label>Address</label>
                    <textarea class="form-control" name="address" rows="3" placeholder="Enter ..."></textarea>
                  </div>
                  <div class="form-group">
                    <label for="fileupload">Profile picture</label>
                    <input type="file" class="form-control" name="image">
                  </div>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                  <button type="submit" name="btn_insert" class="btn btn-success">Add Employee</button>
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
  <!-- Select2 -->
  <script src="bower_components/select2/dist/js/select2.full.min.js"></script>
  <!-- InputMask -->
  <script src="plugins/input-mask/jquery.inputmask.js"></script>
  <script src="plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
  <script src="plugins/input-mask/jquery.inputmask.extensions.js"></script>
  <!-- date-range-picker -->
  <script src="bower_components/moment/min/moment.min.js"></script>
  <script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
  <!-- bootstrap datepicker -->
  <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  <!-- bootstrap color picker -->
  <script src="bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
  <!-- bootstrap time picker -->
  <script src="plugins/timepicker/bootstrap-timepicker.min.js"></script>
  <!-- SlimScroll -->
  <script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
  <!-- iCheck 1.0.1 -->
  <script src="plugins/iCheck/icheck.min.js"></script>
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
      $('#datemask2').inputmask('dd/mm/yyyy', {
        'placeholder': 'dd/mm/yyyy'
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
        format: 'dd/mm/yyyy',
        autoclose: true
      })

      $(".selector").datepicker("setDate", new Date());
      // Or on the init
      $(".selector").datepicker({
        defaultDate: new Date()
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