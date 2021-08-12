<?php
// Start the session
session_start();
require_once 'require/config.php';
require_once 'require/session.php';

// if(isset($_REQUEST['btn_booking'])){
//     $date = $_REQUEST['startDate'];
//     $stime = $_REQUEST['startTime'];
//     $etime = $_REQUEST['endTime'];

//     print_r($date);
//     print_r($stime);
//     print_r($etime);
// }

if (isset($_REQUEST['books_num'])) {
    $book_num = $_REQUEST['books_num'];

    $select_bks = $db->prepare('SELECT * from tb_booking where books_nlist = :book_list');
    $select_bks->bindParam(":book_list", $book_num);
    $select_bks->execute();
    $row = $select_bks->fetch(PDO::FETCH_ASSOC);
    extract($row);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learn Bootstrap 5</title>

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
    <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!--===============================================================================================-->
    <!-- time picker -->
    <link rel="stylesheet" href="jquery/jquery.timepicker.min.css">
    <link rel="stylesheet" href="jquery/jquery.timepicker.css">
    <!-- datepicker -->
    <link rel="stylesheet" href="css/bootstrap-datepicker.min.css" />
    <!-- datatable -->
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" />




</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <!-- Main content -->
        <?php
        if (isset($errorMsg)) {
        ?>
            <div class="alert alert-danger">
                <p class="kanitB"><i class="fa fa-ban"></i> <?php echo $errorMsg ?></p>
            </div>
        <?php } ?>

        <?php
        if (isset($seMsg)) {
        ?>
            <div class="alert alert-success" role="alert">
                <p class="kanitB"><i class="fa fa-check"></i> <?php echo $seMsg ?></p>
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
                        <a href="index.php" class="nav-link " aria-current="page">หน้าหลัก</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a href="#" class="nav-link ">ช่างทำผม</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link ">สินค้า</a>
                    </li> -->
                    <li class="nav-item">
                        <a href="history.php" class="nav-link">ประวัติการจอง</a>
                    </li>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link active">รายละเอียดการจอง</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link ">ติดต่อ</a>
                    </li>

                    <?php
                    if (empty($_SESSION["token_loing"]) || $_SESSION["token_loing"] === false) {
                    ?>
                        <li class="navbar-item">
                            <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">เข้าสู่ระบบ</button>

                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header text-center">
                                            <h5 class="modal-title" id="exampleModalLabel">เข้าสู่ระบบ</h5>
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
                                                                <input class="input100" type="text" name="username" placeholder="Username">
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
                                            </div>

                                            <div id="dropDownSelect1"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php
                    } else if ($_SESSION["token_loing"] === true) {
                    ?>
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                                คุณ <?php echo $_SESSION["token_username"] ?>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                <li><a href="history.php" class="dropdown-item"><i class="fa fa-book" aria-hidden="true"></i> ประวัติการจอง</a></li>
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

    <!-- Header -->
    <div class="container-fluid bcrumb">
        <div class="container mt-3 bcrumb-in">
            <div class="row">

                <div class="col-md-12 mt-3">
                    <nav>
                        <ul class=" changcrumb kanitB">
                            <li class=""><a href="index.php">หน้าแรก / </a></li>
                            <li class=""><a href="history.php">ประวัติการจอง / </a></li>
                            <li class="active">รายละเอียดการจอง</li>
                        </ul>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <section>
        <div class="container kanitB">
            <h5 class="mt-5">รายละเอียดการจอง</h5>
            <div class="row mt-4">
                <div class="col-lg-12 shadow p-3 mb-5 bg-body rounded">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="mb-4">ข้อมูลการจอง</h6>
                            <div class="container">
                                <div class="form-group ">
                                    <div class="row mb-2">
                                        <div class="col-md-4 text-right my-auto">
                                            <label for="" class="kanitB ">เลขที่บิลการจอง</label>
                                        </div>
                                        <div class="col-md-8">
                                            <p><?php echo $books_nlist ?></p>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row mb-2">
                                            <div class="col-md-4 text-right my-auto">
                                                <label for="" class="kanitB ">วันที่จอง</label>
                                            </div>
                                            <div class="col-md-8">
                                                <p><?php echo $cre_bks_date ?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row mb-2">
                                            <div class="col-md-4 text-right my-auto">
                                                <label for="" class="kanitB ">เวลาการในบริการ</label>
                                            </div>
                                            <div class="col-md-8">
                                                <?php
                                                if ($books_hours == 120) {
                                                    $process = "2 ชั่วโมง";
                                                } else if ($books_hours == 90) {
                                                    $process = "1 ชั่วโมง 30 นาที";
                                                } else if ($books_hours == 60) {
                                                    $process = "1 ชั่วโมง";
                                                } else {
                                                    $process = "30 นาที";
                                                }
                                                ?>
                                                <p class="kanitB"><?php echo $cre_bks_time ?> - <?php echo $end_bks_time ?> ( <?php echo $process ?> )</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row mb-2">
                                            <div class="col-md-4 text-right my-auto">
                                                <label for="" class="kanitB ">โดยช่าง</label>
                                            </div>
                                            <div class="col-md-8">
                                                <p><?php echo $book_emp ?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row mb-2">
                                            <div class="col-md-4 text-right my-auto">
                                                <label for="" class="kanitB ">รายการบริการ</label>
                                            </div>
                                            <div class="col-md-8">
                                                <p class="kanitB"><?php echo $book_serv ?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row mb-2">
                                            <div class="col-md-4 text-right my-auto">
                                                <label for="" class="kanitB ">ราคา</label>
                                            </div>
                                            <div class="col-md-8">
                                                <p class="kanitB"><?php echo $books_price ?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row mb-2">
                                            <div class="col-md-4 text-right my-auto">
                                                <label for="" class="kanitB ">สถานะ</label>
                                            </div>
                                            <div class="col-md-8">
                                                <?php
                                                if ($book_st == 'wait') {
                                                    $status = 'รอดำเนินการ';
                                                }
                                                ?>
                                                <p class="kanitB"><?php echo $status ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="mb-4">ความคิดเห็น</h6>

                            <div class="container">
                                <div class="form-group">
                                    <div class="row mb-2">
                                        <div class="col-md-4 my-auto">
                                            <label for="" class="kanitB ">ให้คะแนน</label>
                                        </div>
                                        <div class="col-md-8">

                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row mb-2">
                                        <div class="col-md-4  my-auto">
                                            <label for="" class="kanitB ">เเสดงความคิดเห็น</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="container">
                                    <div class="form-group">
                                        <div class="row mb-2">
                                            <div class="col-md-12 my-auto">
                                                <textarea name="" id="" cols="30" rows="10" class="form-control border">

                                                </textarea>
                                            </div>                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-lg-12 text-right">
                                <button type="button" class="btn btn-secondary">ยกเลิก</button>
                                <button type="submit" class="btn btn-primary">บันทึก</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>


    <!-- Footer -->
    <!-- <footer class="bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <p class="text-mired">&copy; Beautiful Salon 2021. All Right Reserved.</p>
                </div>
            </div>
        </div>
    </footer> -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- caledate -->
    <!-- <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/rome.js"></script>
    <script src="js/main.js"></script>
    <script src="js/main1.js"></script> -->
    <!-- datatable -->
    <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

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
            $('#myTable').DataTable();

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