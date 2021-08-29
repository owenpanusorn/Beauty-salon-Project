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

if (isset($_REQUEST['uu_id']) && isset($_REQUEST['start_date']) && isset($_REQUEST['start_time'])) {

    $date = $_REQUEST['start_date'];
    $start_time = $_REQUEST['start_time'];

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
$res4 = $db->query($sql3);
$comment = $res4->fetchColumn();


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
                        <a href="#" class="nav-link active" aria-current="page">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link ">About</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link ">Services</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link ">Contact</a>
                    </li>

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
            <h4 class="kanitB fw-bolder mt-5 mb-3">รายละเอียดช่าง <?php echo $fname ?></h4>

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
                                    <span style="color : #f0ad4e;">
                                        <?php
                                        for ($i = 0; $i <  $score_all; $i++) {
                                            echo '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                                    </svg>';
                                        }
                                        ?>

                                        ( <?php echo number_format((float)$score_all, 1, '.', ''); ?>)
                                    </span>
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

                                    <div class="row ">
                                        <div class="col-md-12 mt-5">
                                            <?php
                                            if (!empty($_SESSION["token_loing"])) {
                                            ?>
                                                <a href="form_booking.php?uu_id=<?php echo $row['uuid'] ?>&fname=<?php echo $fname ?>&start_date=<?php echo $date ?>&start_time=<?php echo $start_time ?>" class="btn-fluid btn-block btn-lg text-center set-btn progress-bar-striped
                                            progress-bar-animated">Booking</a>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

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
                                    <h5 class="kanitB fw-bolder text-center">รายการจองคิว</h5>
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
                            <div class="row">
                                <div class="col-lg-12 mb-3">
                                    <div class="row border p-3">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <span class="text-warning mx-auto kanitB fw-bolder">

                                                    <?php

                                                    for ($i = 0; $i < $row2['book_score']; $i++) {
                                                        echo '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                            </svg>';
                                                    }

                                                    ?>
                                                    <?php echo '('.' '.$row2['book_score'].' '.')' ?>
                                                </span>
                                            </div>


                                            <div class="row ">
                                                <div class="col-md-12 mb-3">
                                                    <p><?php echo $row2['book_comment'] ?></p>
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


    <script src="/script.js"></script>


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


    <script>
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
    </script>
</body>

</html>