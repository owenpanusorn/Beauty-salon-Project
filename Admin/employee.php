<?php
    require_once('require/config.php');

    if (isset($_REQUEST['del_id'])){
      $id = $_REQUEST['del_id'];

      $del_login = $db -> prepare("DELETE FROM tb_login WHERE id = :id ");
      $del_login -> bindParam(":id",$id);
      $del_login -> execute();

      $del_emp = $db -> prepare("DELETE FROM tb_employee WHERE id = :id ");
      $del_emp -> bindParam(":id",$id);
      $del_emp -> execute();
      header('Location:employee.php');

    }
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Employees | Beautiful Salon</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.css">
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
  <!-- sweetalert -->
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
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
        Employees
        <small class="kanitB"><b>รายชื่อพนักงาน</b></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
        <li class="active">Employees</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">      
          <div class="box">
            <div class="box-header">
              <h3 class="box-title kanitB">ตารางข้อมูลพนักงาน</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                      <i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class='btn btn-success' onclick="window.location.href='/-Beauty-salon-Project/Admin/addemployee.php'" > <i class="fa fa-user-plus"></i> Employee</button>
                </div>
            </div>
           
         
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Firstname</th>
                  <th>Lastname</th>
                  <th>Gender</th>
                  <th>Birthday</th>
                  <th>Number Phone</th>
                  <th>ID Card</th>
                  <th>Address</th>
                  <th>Image</th>
                  <th>Crete date</th>
                  <th>Crete time</th>                  
                  <th>Edit</th>
                  <th>Delete</th>
                </tr>
                </thead>
                <tbody>
                  <?php                        
                        $result = $db->prepare('SELECT * from tb_employee');  
                        $result->execute();
                        
                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        
                  ?>                    
                      <tr class="kanitB">
                        <td><?php echo $row["id"]?></td>
                        <td><?php echo $row["fname"]?></td>
                        <td><?php echo $row["lname"]?></td>
                        <td><?php echo $row["gender"]?></td>
                        <td><?php echo $row["birthday"]?></td>
                        <td><?php echo $row["nphone"]?></td>
                        <td><?php echo $row["idcard"]?></td>
                        <td><?php echo $row["address"]?></td>
                        <td><?php echo '<img src="images/'.$row["images"].'" height="50">'?></td>
                        <td><?php echo $row["cre_emp_date"]?></td>
                        <td><?php echo $row["cre_emp_time"]?></td>                        
                        <td><a href="editemp.php?update_id=<?php echo $row['uuid']?>" class="btn btn-warning"><i class="fa fa-pencil-square-o"></i> Edit</a></td>
                        <td><a href="?del_id=<?php echo $row['id']?>" class='btn btn-danger' > <i class="glyphicon glyphicon-trash"></i> Delete</a></td>
                        
                      </tr>
                  <?php } ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>ID</th>
                  <th>Firstname</th>
                  <th>Lastname</th>
                  <th>Gender</th>
                  <th>Birthday</th>
                  <th>Number Phone</th>
                  <th>ID Card</th>
                  <th>Address</th>
                  <th>Image</th>
                  <th>Crete date</th>
                  <th>Crete time</th>
                  <th>Edit</th>
                  <th>Delete</th>
                </tr>
                </tfoot>
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
    <strong>Copyright &copy; 2014-2016 <a href="https://adminlte.io">Almsaeed Studio</a>.</strong> All rights
    reserved.
  </footer>

  <!-- /.control-sidebar -->
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
<!-- page script -->
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
</body>
</html>
