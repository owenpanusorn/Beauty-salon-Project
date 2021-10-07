<?php
session_start();
require_once '../require/config.php';
require_once '../require/session.php';

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

$result = $db->prepare("select strftime('%Y',date) as 'Year',count(*) as count,sum(price) as sumprice from tb_data  group by Year order by Year desc;");
$result->execute();

$result_Month = $db->prepare("select strftime('%Y',date) as 'Year',strftime('%m',date) as 'Month',count(*) as count,sum(price) as sumprice from tb_data   group by Month,Year order by Year desc,Month asc");
$result_Month->execute();

if (isset($_REQUEST['btn_report'])) {
    try {
        $select_mode = $_REQUEST['select_mode'];
        $for = $_REQUEST['r1'];
        $numreport = $_REQUEST['numreport'];

        if ($select_mode == 'Simple Moving Average') {
            # code...
            $sumindex = 0;
            $sma = 0;
            $index = 0;

            if ($for == 'Year') {
                $result1 = $db->prepare("select strftime('%Y',date) as 'Year',count(*) as count,sum(price) as sumprice from tb_data group by Year order by Year desc;");
                $result1->execute();
            } elseif ($for == 'Month') {
                $result1 = $db->prepare("select strftime('%Y',date) as 'Year',strftime('%m',date) as 'Month',count(*) as count,sum(price) as sumprice from tb_data group by Month,Year order by Year desc,Month asc ;");
                $result1->execute();
            }
            $end_m_y_to = '';

            while ($row = $result1->fetch(PDO::FETCH_ASSOC)) {
                $index++;
                if ($index == 1) {
                    $start_m_y = $row['Year'];

                    if ($for == 'Month') {
                        $start_m_y .= ' เดือน ' . $row['Month'];
                    }

                    if ($for == 'Year') {
                        $end_m_y_to .= $row['Year'] + 1;
                    }
                }
                // print_r($row);
                // echo '<br>';
                $sma += $row['sumprice'];
                $sumindex += $index;
                if (($index) >= $numreport) {
                    $end_m_y = $row['Year'];
                    if ($for == 'Month') {
                        $end_m_y .= ' เดือน ' . $row['Month'];
                    }
                    if ($for == 'Month') {
                        $end_m_y_to .= $row['Year'];
                        $end_m_y_to .= ' เดือน ' . ((int) $row['Month'] + 1);
                    }
                    break;
                }
            }
            $sumtotal = $sma / $index;
            // echo '<hr>';
            // echo 'simple moving average : ' . $sumtotal;

        } elseif ($select_mode == 'Linear Weighted Moving Average') {

            if ($for == 'Year') {
                $result2 = $db->prepare("select strftime('%Y',date) as 'Year',count(*) as count,sum(price) as sumprice from tb_data  group by Year order by Year desc limit :limit ;");
                $result2->bindParam(":limit", $numreport);

                $result2->execute();
            } elseif ($for == 'Month') {
                $result2 = $db->prepare("select strftime('%Y',date) as 'Year',strftime('%m',date) as 'Month',count(*) as count,sum(price) as sumprice from tb_data  group by Month,Year order by Year desc,Month asc limit :limit ;");
                $result2->bindParam(":limit", $numreport);
                $result2->execute();
            }
            $arr1 = [];
            $sma = 0;
            $lwma = 0;
            $sumindex1 = 0;
            $arr = $result2->fetchAll(PDO::FETCH_ASSOC);
            $numcount = count($arr);
            $index = 0;
            $start_m_y = '';
            $end_m_y_to = '';

            for ($i = $numcount - 1; $i >= 0; $i--) {
                $index++;
                if ($index == 1) {
                    $end_m_y = $arr[$i]['Year'];
                    if ($for == 'Month') {
                        $end_m_y .= ' เดือน ' . $arr[$i]['Month'];
                    }
                }
                // echo '<br>';
                // print_r($arr[$i]); 
                // echo '<br>';
                // echo $i;
                $sumindex1 += $i + 1;
                $sma += $arr[$i]['sumprice'] * ($i + 1);
               
                if (($index) >= $numreport) {

                    $start_m_y .= $arr[$i]['Year'];
                    if ($for == 'Month') {
                        $start_m_y .= ' เดือน ' . $arr[$i]['Month'];
                    }
                    if ($for == 'Year') {
                        $end_m_y_to .= $arr[$i]['Year'] + 1;
                    }
                    if ($for == 'Month') {
                        $end_m_y_to .= $arr[$i]['Year'];
                        $end_m_y_to .= ' เดือน ' . ((int) $arr[$i]['Month'] + 1);
                    }
                    break;
                }
            }
            $sumtotal = $sma / $sumindex1;

            // echo '<br>';
            // echo '<hr>';
            // echo 'Linear Weighted Moving Average : ' . $sumtotal;
        } else {
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
    <title>พยากรณ์ยอดขาย | Beautiful Salon</title>
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
                                <span class="hidden-xs"><?php if (!empty($_SESSION["token_admin_uuid"])) {
                                                            echo $fname . ' ' . $lname;
                                                        }
                                                        ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                    <img src="../images/manager/manager.png" class="img-circle" alt="User Image">

                                    <p>
                                        <?php if (!empty($_SESSION["token_admin_uuid"])) {
                                            echo $fname . ' ' . $lname;
                                        }
                                        ?>
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
                        <p><?php if (!empty($_SESSION["token_admin_uuid"])) {
                                echo $fname . ' ' . $lname;
                            }
                            ?></p>
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
                                <span class="label label-primary pull-right"><?php if (!empty($_SESSION["token_admin_uuid"])) {
                                                                                    echo $count;
                                                                                }
                                                                                ?></span>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="../booking/databooking/"><i class="fa  fa-info"></i>ข้อมูลการจองคิว</a></li>
                            <li><a href="../booking/confirm/"><i class="fa  fa-spinner"></i>อนุมัติการจอง
                                    <span class="pull-right-container">
                                        <span class="label label-primary pull-right"><?php if (!empty($_SESSION["token_admin_uuid"])) {
                                                                                            echo $count;
                                                                                        }
                                                                                        ?></span>
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
                            <!-- <li><a href="#"><i class="fa fa-file-o"></i>รายงานการจองคิว</a></li> -->
                            <li class=""><a href="index.php"><i class="fa  fa-paperclip"></i>รายงานแบบประเมิน</a></li>
                            <li class="active"><a href="sales_fore_old.php"><i class="fa fa-bar-chart"></i>พยากรณ์ยอดขาย (เก่า)</a></li>
                            <li class=""><a href="cus_fore_old.php"><i class="fa fa-area-chart"></i>พยากรณ์ลูกค้า (เก่า)</a></li>
                            <li class=""><a href="sales_fore_new.php"><i class="fa fa-bar-chart"></i>พยากรณ์ยอดขาย (ใหม่)</a></li>
                            <li class=""><a href="cus_fore_new.php"><i class="fa fa-area-chart"></i>พยากรณ์ลูกค้า (ใหม่)</a></li>
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
                            <li><a href="../setting/"><i class="fa fa-power-off"></i>กำหนดวันเปิด - ปิดร้าน</a></li>
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
                    <li class="active ">พยากรณ์ยอดขาย</li>
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
                            <form action="" method="get">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-3 text-right">
                                            <h4 class="kanitB">พยากรณ์ด้วยวิธี :</h4>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <!-- <label>Minimal</label> -->
                                                <select class="form-control select2" name="select_mode" style="width: 100%;">
                                                    <option selected="selected">Simple Moving Average</option>
                                                    <!-- <option>Linear Weighted Moving Average</option> -->
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
                                                <input type="radio" value="Year" name="r1" class="minimal " <?php echo isset($_REQUEST['r1']) == "Year" ? "checked" : "" ?> required>
                                                <label>
                                                    ปี
                                                </label>
                                                <input type="radio" value="Month" name="r1" class="minimal-red" <?php echo isset($_REQUEST['r1']) == "Month" ? "checked" : "" ?>>
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
                                            <input type="number" name="numreport" class="form-control" min="0" max="12" required value="<?php echo isset($_REQUEST['numreport']) ? $numreport : "" ?>">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-3">

                                        </div>
                                        <div class="col-md-6">
                                            <button class="btn btn-success kanitB" type="submit" name="btn_report">เริ่มพยากรณ์ยอดขาย</button>
                                        </div>
                                    </div>
                            </form>
                            <hr>
                            <?php
                            if (isset($sumtotal)) {
                            ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4 class="kanitB">ยอดขายตั้งแต่ปี <?php echo $start_m_y ?> จนถึงปี <?php echo $end_m_y ?> พร้อมค่าถ่วงน้ำหนัก</h4>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <h4 class="kanitB"><?php echo number_format($sma) ?></h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4 class="kanitB">นำยอดขายมาหารด้วยผลรวมของค่าถ่วงน้ำหนัก (ทั้งหมด <?php echo $index ?> ปี)</h4>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <h4 class="kanitB"><?php echo number_format($sumtotal) ?></h4>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4 class="kanitB"><u>ดังนั้น สามารถสรุปได้ว่าในปี <?php echo $end_m_y_to ?> มีแนวโน้มที่มียอดขายจะอยู่ที่ประมาณ</u></h4>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <h4 class="kanitB"><?php echo number_format($sumtotal) ?></h4>
                                    </div>
                                </div>
                        </div>
                    <?php } ?>
                    <hr>

                    <div class="col-md-6">
                        <div id="chart-container">
                            <canvas id="graphCanvas"></canvas>
                        </div>                       
                    </div>

                    <div class="col-md-6">
                        <div id="chart-container">
                            <canvas id="graphCanvas1"></canvas>
                        </div>
                    </div>

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
                                <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)) { ?>
                                    <tr class="kanitB">
                                        <td class="text-center"><?php echo $row["Year"] ?></td>
                                        <td class="text-right"><?php echo $row["sumprice"] ?></td>
                                    </tr>

                                <?php } ?>
                            </tbody>

                        </table>
                    </div>
                    <!-- /.box-body -->
                    <!-- /.box-header -->
                    <div class="box-body">
                                <table id="example2" class="table table-bordered table-striped kanitB">
                                    <thead>
                                        <tr>
                                        <th>ปี</th>
                                            <th>เดือน</th>
                                            <th>กำไร (บาท)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php while ($row2 = $result_Month->fetch(PDO::FETCH_ASSOC)) {?>
                                        <tr class="kanitB">
                                        <td class="text-center"><?php echo $row2["Year"] ?></td>
                                            <td class="text-center"><?php echo $row2["Month"] ?></td>
                                            <td class="text-right"><?php echo $row2["sumprice"] ?></td>
                                        </tr>

                                        <?php }?>
                                    </tbody>

                                </table>
                            </div>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js"></script>
    <script>
$(document).ready(function() {
            showGraph();
        });

        function showGraph() {
            {
                $.post("data4.php", function(data) {
                    console.log(data);
                    let name = [];
                    let score = [];

                    for (let i in data) {
                        name.push(data[i].Year);
                        score.push(data[i].sumprice);
                    }

                    let chartdata = {
                        labels: name,
                        datasets: [{
                            label: 'Year',
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

        $(document).ready(function() {
            showGraph1();
        });

        function showGraph1() {
            {
                $.post("data5.php", function(data) {
                    console.log(data);
                    let name = [];
                    let score = [];

                    for (let i in data) {
                        name.push(data[i].Month);
                        score.push(data[i].sumprice);
                    }

                    let chartdata = {
                        labels: name,
                        datasets: [{
                            label: 'Month',
                            backgroundColor: '#00A65A',
                            borderColor: '#00A65A',
                            hoverBackgroundColor: '#CCCCCC',
                            hoverBorderColor: '#666666',
                            data: score
                        }]
                    };

                    let graphTarget = $('#graphCanvas1');
                    let barGraph = new Chart(graphTarget, {
                        type: 'bar',
                        data: chartdata
                    })
                })
            }
        }

        $(function() {
            $('#example1').DataTable()
            $('#example2').DataTable()

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