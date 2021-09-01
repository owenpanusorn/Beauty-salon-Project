<?php
session_start();
require_once 'require/config.php';
require_once 'require/session.php';

$message = 'คุณไม่มีสิทธิ์เข้าถึงหน้านี้ !';

if (empty($_SESSION["token_uuid"])) {
    echo "<script type='text/javascript'>alert('$message');</script>";
    header("refresh:0;index.php");
}

if (isset($_REQUEST['btn_logout'])) {
    try {
        session_unset();
        $_SESSION["token_loing"] = false;
        $seMsg = 'ออกจากระบบแล้ว';
        header("refresh:2;index.php");
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

if (isset($_REQUEST['uu_id'])) {

    // $date = $_REQUEST['start_date'];
    // $start_time = $_REQUEST['start_time'];

    try {
        $uuid_emp = $_REQUEST['uu_id'];
        $select_emp = $db->prepare("SELECT * FROM tb_employee WHERE uuid = :id"); //เตรียมคำสั่งที่ query
        $select_emp->bindParam(':id', $uuid_emp); //ผูกพารามิเตอรฺ์ โดยใช้ชื่อตัวแปร
        $select_emp->execute(); // ประมวลผลคำสัง prepare
        $row = $select_emp->fetch(PDO::FETCH_ASSOC);  //ส่งค่ากลับ array index โดยใช้ชื่อ column ในตาราง
        extract($row);

        if ($gender == 'male') {
            $gender = 'ชาย';
        } else {
            $gender = 'หญิง';
        }

        if ($birthday) {
            $birthday = explode("/", $birthday); //แยกตัวอักษร
            $age = (date("md", date("U", mktime(0, 0, 0, $birthday[0], $birthday[1], $birthday[2]))) > date("md")
                ? ((date("Y") - $birthday[2]) - 1)
                : (date("Y") - $birthday[2]));
        }
    } catch (PDOException $e) {
        $e->getMessage();
    }
}

$date = date("d-m-Y");

$sql = "select count(books_nlist) from tb_booking where uuid_emp = '$uuid_emp' and book_st = 'success' and book_score is not null";
$res = $db->query($sql);
$count_cus = $res->fetchColumn();

$sql1 = "select sum(books_hours) from tb_booking where uuid_emp = '$uuid_emp' and book_st = 'success' and book_score is not null";
$res1 = $db->query($sql1);
$sumhours = $res1->fetchColumn();

$totalhours = $sumhours / 60;

$sql2 = "select count(books_nlist) from tb_booking where uuid_emp = '$uuid_emp' and book_st = 'wait'";
$res2 = $db->query($sql2);
$sumcus = $res2->fetchColumn();

$sql3 = "select sum(book_score) / count(book_score) as score from tb_booking where uuid_emp = '$uuid_emp' and book_st = 'success' and book_score is not null";
$res3 = $db->query($sql3);
$score_all = $res3->fetchColumn();

$sql4 = "select count(*) from tb_booking where uuid_emp = '$uuid_emp' and book_st = 'success' and book_score is not null";
$res4 = $db->query($sql4);
$comment = $res4->fetchColumn();

if (isset($_REQUEST['btn_check'])) {

    $start_date = $_REQUEST['startDate'];
    $time_start = $_REQUEST['startTime'];

    $etime = new DateTime($time_start);

    // echo $etime->format('H:i') . "<br>";

    $etime->setTime($etime->format('H') + 2, $etime->format('i'));
    // 
    $etimeq = $etime->format('H:i');
    echo $etimeq;

    $sql5 = "SELECT count(*) FROM tb_employee emp INNER JOIN tb_booking bk ON emp.uuid = bk.uuid_emp where emp.uuid = '$uuid_emp'  and (bk.cre_bks_time BETWEEN '$time_start' and '$etimeq' and  bk.cre_bks_date = '$start_date') or (bk.end_bks_time BETWEEN '$time_start' and '$etimeq' and  bk.cre_bks_date = '$start_date')";
    // $sql5 = "SELECT count(*) FROM tb_employee emp INNER JOIN tb_booking bk ON emp.uuid = bk.uuid_emp where emp.uuid = '$uuid_emp' and  bk.cre_bks_date = '$start_date' and bk.cre_bks_time >= '$time_start' or bk.end_bks_time <= '$etimeq'";
    $res5 = $db->query($sql5);
    $chk_bk = $res5->fetchColumn();

    if ($chk_bk >= 1) {
        $errMsg = 'เวลานี้ได้ทำการจองแล้ว !' . $chk_bk;
    } else {
        $chkk_book = true;
        $insertMsg = 'เวลานี้สามารถจองคิวได้' . $chk_bk;
    }
}

if (!empty($_SESSION["token_loing"]) && $_SESSION["token_loing"] === true) {

    $uuid_cus = $_SESSION['token_uuid'];
    $date = date("d-m-Y");

    $sql5 = "SELECT count(*) FROM tb_booking where uuid_cus = '$uuid_cus' and book_st = 'success' and  cre_bks_date = '$date' ORDER BY end_bks_time DESC";
    $res5 = $db->query($sql5);
    $notify = $res5->fetchColumn();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายละเอียดช่างทำผม</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" href="css/rome.css">
    <!-- time picker -->
    <link rel="stylesheet" href="jquery/jquery.timepicker.min.css">
    <link rel="stylesheet" href="jquery/jquery.timepicker.css">
    <!-- regisform -->
    <!-- <link rel="stylesheet" href="css/style1.css"> -->
    <!-- Select Employee -->
    <link rel="stylesheet" href="css/select_emp.css">
    <link rel="icon" href="img/hairsalon-icon.png" type="image/gif" sizes="16x16">
    <!-- time picker -->
    <link rel="stylesheet" href="jquery/jquery.timepicker.min.css">
    <link rel="stylesheet" href="jquery/jquery.timepicker.css">
    <!-- datepicker -->
    <link rel="stylesheet" href="css/bootstrap-datepicker.min.css" />

    <style>
        #btn-back-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: none;
        }
    </style>

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <!-- Main content -->
        <?php
        if (isset($errorMsg)) {
        ?>
            <div class="alert alert-danger alert-dismissible">
                <p><i class="icon fa fa-ban"></i><?php echo $errorMsg ?></p>
            </div>
        <?php } ?>

        <?php
        if (isset($seMsg)) {
        ?>
            <div class="alert alert-success alert-dismissible">
                <p><i class="icon fa fa-check"></i><?php echo $seMsg ?></p>
            </div>
        <?php } ?>

        <div class="container">
            <a href="index.php" class="navbar-brand">Beautiful Salon</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 kanitB">
                    <li class="nav-item">
                        <a href="index.php" class="nav-link active" aria-current="page">หน้าหลัก</a>
                    </li>
                    <li class="nav-item">
                        <a href="#p1" class="nav-link ">รายละเอียดช่าง</a>
                    </li>
                    <li class="nav-item">
                        <a href="#p2" class="nav-link ">รายการจองคิว</a>
                    </li>
                    <?php
                    if (!empty($_SESSION["token_loing"]) && $_SESSION["token_loing"] === true) {
                    ?>
                        <li class="nav-item">
                            <a href="history.php" class="nav-link">
                                <i class="fa fa-bell-o"></i>
                                <?php if ($notify >= 1) { ?>
                                    <span class="bg-warning rounded-3 p-1"><?php echo $notify ?></span>
                                <?php } ?>
                            </a>
                        </li>
                    <?php
                    }
                    ?>

                    <?php
                    if (empty($_SESSION["token_loing"]) || $_SESSION["token_loing"] === false) {
                    ?>
                        <li class="navbar-item">
                            <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">Sign In</button>

                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header text-center">
                                            <h5 class="modal-title" id="exampleModalLabel">Sign In</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="limiter">
                                                <div class="container-login100">
                                                    <div class="wrap-login100 p-t-20 p-b-10">
                                                        <form class="login100-form validate-form" method="post">
                                                            <span class="login100-form-title ">
                                                                Beautiful Salon
                                                            </span>
                                                            <h5 class="text-center welcome-spacing kanitB">ยินดีต้อนรับ</h5>
                                                            <div class="wrap-input100 validate-input m-t-50 m-b-35" data-validate="Enter username">
                                                                <input class="input100" type="text" name="username" placeholder="Username" autocomplete="off">
                                                                <!-- <span class="focus-input100" data-placeholder="Username"></span> -->
                                                            </div>

                                                            <div class="wrap-input100 validate-input m-b-50" data-validate="Enter password">
                                                                <input class="input100" type="password" name="pass" placeholder="Password">
                                                                <!-- <span class="focus-input100" data-placeholder="Password"></span> -->
                                                            </div>

                                                            <div class="container-login100-form-btn">
                                                                <button type="submit" name="btn_login" class="login100-form-btn">
                                                                    Login
                                                                </button>
                                                            </div>

                                                            <ul class="login-more p-t-50 ms-auto ">
                                                                <li>
                                                                    <span class="kanitB" style="color: #999999;">
                                                                        สามารถสมัครได้ที่นี่ >
                                                                    </span>

                                                                    <a href="signup.php" class="kanitB" style="color: #57b846;">
                                                                        สมัครสมาชิก
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>>

                                            <div id="dropDownSelect1"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php
                    } else if (!empty($_SESSION["token_loing"]) && $_SESSION["token_loing"] === true) {
                    ?>
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                                คุณ <?php echo $_SESSION["token_username"] ?>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                <li><a href="history.php" class="dropdown-item" type="button"><i class="fa fa-book" aria-hidden="true"></i> ประวัติการจอง</a></li>
                                <li>
                                    <form method="post">
                                        <button type="submit" name="btn_logout" class="dropdown-item"><i class="fa fa-sign-out" aria-hidden="true"></i> ออกจากระบบ</button>
                                    </form>
                                </li>
                        </div>
                    <?php
                    }
                    ?>
                </ul>
            </div>

        </div>
    </nav>
    <!-- Navbar -->


    <div class="container-fluid bcrumb">
        <div class="container mt-3 bcrumb-in">
            <div class="row">
                <div class="col-md-12 mt-3">
                    <nav>
                        <ul class=" changcrumb">
                            <li class="kanitB"><a href="index.php">หน้าแรก / </a></li>
                            <li class="active kanitB">รายละเอียดช่างทำผม</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <section class="">
        <div class="container">
            <?php
            if (isset($errMsg)) {
            ?>
                <div class="alert alert-danger alert-dismissible mt-3">
                    <p class="kanitB"><i class="icon fa fa-ban"></i> <?php echo $errMsg ?></p>
                </div>
            <?php } ?>

            <?php
            if (isset($insertMsg)) {
            ?>
                <div class="alert alert-success alert-dismissible mt-3">
                    <p class="kanitB"><i class="icon fa fa-check"></i> <?php echo $insertMsg ?></p>
                </div>
            <?php } ?>
            <a name="p1">
                <h4 class="kanitB fw-bolder mt-5 mb-3">รายละเอียดช่าง <?php echo $fname ?></h4>
            </a>

            <div class="row">
                <div class="col-md-6">
                    <?php echo '<img src="../Admin/images/employee/' . $row["images"] . '" class="img-fluid d-blok mb-5 img-radius ">' ?>
                    <div class="contact-card">
                        <p class="text-justify kanitB">
                            ร้านเสริมสวยหน่อยบิวตี้ 162/2 ถ.ต้นขาม2 ต.ท่าสาลา อ.เมืองเชียงใหม่ จ.เชียงใหม่ 50000
                        </p>
                    </div>
                </div>

                <div class="col-md-6">
                    <form action="">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="kanitB fw-bolder">รายละเอียด</h4>
                                </div>

                                <div class="col-md-6  text-end kanitB">
                                    <p style="color : #f0ad4e;" class="text-center card-text">
                                        <?php
                                        for ($i = 0; $i < 5; $i++) {
                                            if ($i < $score_all) {
                                                echo '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                                    </svg>';
                                            } else {
                                                echo '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                                                <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
                                              </svg>';
                                            }
                                        }
                                        ?>
                                        <span class="kanitB text-center mb-1 fw-bold card-text"> ( <?php echo number_format((float)$score_all, 1, '.', ''); ?>)</span>
                                    </p>

                                </div>

                                <div class="col-md-12 mt-2">
                                    <div class="row detail-card">
                                        <div class="col-md-6 ">
                                            <p class="kanitB fw-bolder fs-6">ชื่อ</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="kanitB fw-bolder fs-6"><?php echo $fname; ?></p>
                                        </div>
                                    </div>
                                    <div class="row detail-card">
                                        <div class="col-md-6 ">
                                            <p class="kanitB fw-bolder fs-6">เพศ</p>
                                        </div>
                                        <div class="col-md-6 ">
                                            <p class="kanitB fw-bolder fs-6"><?php echo $gender; ?></p>
                                        </div>
                                    </div>

                                    <div class="row detail-card">
                                        <div class="col-md-6 ">
                                            <p class="kanitB fw-bolder fs-6">อายุ</p>
                                        </div>
                                        <div class="col-md-6 ">
                                            <p class="kanitB fw-bolder fs-6"><?php echo $age; ?></p>
                                        </div>
                                    </div>

                                    <div class="row detail-card">
                                        <div class="col-md-6 ">
                                            <p class="kanitB fw-bolder fs-6">เบอร์โทร</p>
                                        </div>
                                        <div class="col-md-6 ">
                                            <p class="kanitB fw-bolder fs-6"><?php echo $nphone; ?></p>
                                        </div>
                                    </div>

                                    <div class="row detail-card">
                                        <div class="col-md-6 ">
                                            <p class="kanitB fw-bolder fs-6">จำนวนลูกค้า</p>
                                        </div>
                                        <div class="col-md-6 ">
                                            <p class="kanitB fw-bolder fs-6"><?php echo $count_cus ?></p>
                                        </div>
                                    </div>

                                    <div class="row detail-card">
                                        <div class="col-md-6 ">
                                            <p class="kanitB fw-bolder fs-6">จำนวนลูกค้าการรอจองคิว</p>
                                        </div>
                                        <div class="col-md-6 ">
                                            <p class="kanitB fw-bolder fs-6"><?php echo $sumcus ?></p>
                                        </div>
                                    </div>

                                    <div class="row detail-card">
                                        <div class="col-md-6 ">
                                            <p class="kanitB fw-bolder fs-6">เวลาในการทำงาน</p>
                                        </div>
                                        <div class="col-md-6 ">
                                            <p class="kanitB fw-bolder fs-6"><?php echo $totalhours ?> ชั่วโมง</p>
                                        </div>
                                    </div>

                                    <form action="" method="GET">
                                        <div class="row detail-card">
                                            <div class="row">
                                                <div class="col-md-12 mb-3 mt-3 ">
                                                    <h4 class="kanitB fw-bolder">เลือกวันที่ และเวลาที่จอง</h4>
                                                </div>
                                            </div>

                                            <input type="hidden" name="uu_id" value="<?php echo $uuid_emp ?>">

                                            <div class="col-md-6 ">
                                                <p class="kanitB fw-bolder fs-6 my-2">วันที่จอง</p>
                                            </div>
                                            <div class="col-md-6 mb-1">
                                                <input type="text" class="form-control-lg kanitB border" id="datepicker" name="startDate" autocomplete="off" placeholder="เลือกวันที่" required>
                                            </div>
                                            <div class="col-md-6 ">
                                                <p class="kanitB fw-bolder fs-6 my-2">เวลาที่จอง</p>
                                            </div>
                                            <div class="col-md-6 ">
                                                <input type="text" class="form-control-lg kanitB border" id="startTime" name="startTime" autocomplete="off" placeholder="เลือกเวลา" required>
                                            </div>
                                        </div>

                                        <div class="row ">
                                            <div class="col-md-12 mt-3 kanitB">
                                                <?php
                                                if (!empty($_SESSION["token_loing"])) {
                                                ?>
                                                    <button type="submit" class="btn-fluid btn-block btn-lg text-center set-btn progress-bar-striped
                                            progress-bar-animated" name="btn_check">ตรวจสอบคิว</button>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </form>

                                    <?php if (isset($chkk_book)) { ?>
                                        <div class="row ">
                                            <div class="col-md-12 mt-3 kanitB">
                                                <?php
                                                if (!empty($_SESSION["token_loing"])) {
                                                ?>
                                                    <a href="form_booking.php?uu_id=<?php echo $row['uuid'] ?>&fname=<?php echo $fname ?>&start_date=<?php echo $start_date ?>&start_time=<?php echo $time_start ?>" class="btn-fluid btn-block btn-success btn-lg text-center progress-bar-striped
                                            progress-bar-animated">จองคิว</a>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <button type="button" class="btn btn_booking btn-floating btn-lg" id="btn-back-to-top">
                <i class="fa fa-arrow-up"></i>
            </button>

            <ul class="nav nav-tabs mt-5" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active kanitB fw-bolder" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">รายการจองคิว</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link kanitB fw-bolder" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">รีวิว ( <?php echo $comment ?> )</button>
                </li>

            </ul>

            <div class="tab-content border" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="container mt-4">

                        <form action="#">
                            <div class="row">
                                <div class="col-12 col-md-2 mt-2">
                                    <a name="p2">
                                        <h5 class="kanitB fw-bolder text-center">รายการจองคิว</h5>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control selDate border" id="input" value="<?php echo $date; ?>" disabled>
                                    </div>
                                </div>

                            </div>
                        </form>

                        <table class="table table-hover kanitB">
                            <thead class="">
                                <tr>
                                    <th>ลำดับ</th>
                                    <th>รายการบริการ</th>
                                    <th>เวลาเริ่มต้น</th>
                                    <th>เวลาสิ้นสุด</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $result = $db->prepare('SELECT * from tb_booking where uuid_emp = :id and cre_bks_date = :stardate');
                                $result->bindParam(':id', $uuid_emp); //ผูกพารามิเตอรฺ์ 
                                $result->bindParam(':stardate', $date);
                                $result->execute();
                                $num = 0;
                                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                    $num++;
                                ?>
                                    <tr>
                                        <th><?php echo $num; ?></th>
                                        <td><?php echo $row['book_serv']; ?></td>
                                        <td><?php echo $row['cre_bks_time']; ?></td>
                                        <td><?php echo $row['end_bks_time']; ?></td>
                                    </tr>
                            </tbody>
                        <?php } ?>
                        </table>
                    </div>

                </div>

                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="container p-5">
                        <?php
                        $book_status = 'success';

                        $result2 = $db->prepare('SELECT * from tb_booking where uuid_emp = :id and book_st = :bookst and book_score is not null');
                        $result2->bindParam(':id', $uuid_emp); //ผูกพารามิเตอรฺ์ 
                        $result2->bindParam(':bookst', $book_status);
                        $result2->execute();

                        while ($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {

                        ?>
                            <div class="row kanitB">
                                <div class="col-lg-12 mb-3">
                                    <div class="row border p-3">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <p style="color : #f0ad4e;" class="card-text">
                                                    <?php
                                                    for ($i = 0; $i < 5; $i++) {
                                                        if ($i < $row2['book_score']) {
                                                            echo '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                                    </svg>';
                                                        } else {
                                                            echo '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                                                <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
                                              </svg>';
                                                        }
                                                    }
                                                    ?>
                                                    <span class="kanitB text-center mb-1 fw-bold card-text"> ( <?php echo number_format((float)$row2['book_score'], 1, '.', ''); ?>)</span>
                                                </p>
                                            </div>


                                            <div class="row ">
                                                <div class="col-md-12 mb-3">
                                                    <p class="kanitB"><?php echo $row2['book_comment'] ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        <?php } ?>

                    </div>
                </div>
            </div>


        </div>

    </section>



    <!-- Footer -->
    <footer class="bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mt-5">
                    <p class="text-mired">&copy; Beautiful Salon 2021. All Right Reserved.</p>
                </div>
            </div>
        </div>
    </footer>




    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <!-- caledate -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/rome.js"></script>
    <script src="js/main.js"></script>
    <script src="js/main1.js"></script>
    <!-- time picker -->
    <script src="jquery/jquery.timepicker.min.js"></script>
    <script src="jquery/jquery.timepicker.js"></script>
    <!--===============================================================================================-->
    <!-- <script src="vendor/jquery/jquery-3.2.1.min.js"></script> -->
    <!--===============================================================================================-->
    <script src="vendor/animsition/js/animsition.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/bootstrap/js/popper.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/select2/select2.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/daterangepicker/moment.min.js"></script>
    <script src="vendor/daterangepicker/daterangepicker.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/countdowntime/countdowntime.js"></script>
    <!--===============================================================================================-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.th.min.js" integrity="sha512-cp+S0Bkyv7xKBSbmjJR0K7va0cor7vHYhETzm2Jy//ZTQDUvugH/byC4eWuTii9o5HN9msulx2zqhEXWau20Dg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>



    <script>
        var date_start = new Date()
        var date_end = new Date()
        date_start.setDate(date_start.getDate());
        date_end.setDate(date_end.getDate() + 30);

        $('#datepicker').datepicker({
            format: 'dd-mm-yyyy',
            language: 'th',
            startDate: date_start,
            endDate: date_end

        });

        $(document).ready(function() {
            $('#startTime').timepicker({
                timeFormat: 'HH:mm',
                interval: 30,
                minTime: '10.30',
                maxTime: '19.00',
                startTime: '10:30',
                dynamic: false,
                dropdown: true,
                scrollbar: true,
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

        //Get the button
        let mybutton = document.getElementById("btn-back-to-top");

        // When the user scrolls down 20px from the top of the document, show the button
        window.onscroll = function() {
            scrollFunction();
        };

        function scrollFunction() {
            if (
                document.body.scrollTop > 20 ||
                document.documentElement.scrollTop > 20
            ) {
                mybutton.style.display = "block";
            } else {
                mybutton.style.display = "none";
            }
        }
        // When the user clicks on the button, scroll to the top of the document
        mybutton.addEventListener("click", backToTop);

        function backToTop() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }
    </script>
</body>

</html>