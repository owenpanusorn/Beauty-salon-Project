<?php
session_start();
require_once 'require/config.php';
require_once 'require/session.php';

if (isset($_REQUEST['btn_booking'])) {
    $date = $_REQUEST['startDate'];
    $stime = $_REQUEST['startTime'];
    $etime = $_REQUEST['endTime'];
}

try {
    $select_emp = $db->prepare("SELECT * FROM tb_employee"); //เตรียมคำสั่งที่ query
    // $select_emp -> bindParam(':uuid', $uuid); //ผูกพารามิเตอรฺ์ โดยใช้ชื่อตัวแปร
    $select_emp->execute(); // ประมวลผลคำสัง prepare
    $row = $select_emp->fetch(PDO::FETCH_ASSOC);  //ส่งค่ากลับ array index โดยใช้ชื่อ column ในตาราง
    extract($row);
} catch (PDOException $e) {
    $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learn Bootstrap 5</title>

    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/custom.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.css">
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
    <!-- <link rel="stylesheet" href="css/rome.css"> -->
    <!-- time picker -->
    <link rel="stylesheet" href="jquery/jquery.timepicker.min.css">
    <link rel="stylesheet" href="jquery/jquery.timepicker.css">
    <!-- regisform -->
    <!-- <link rel="stylesheet" href="css/style1.css"> -->
    <!-- Select Employee -->
    <link rel="stylesheet" type="text/css" href="css/select_emp.css">
    <!-- datepicker -->
    <link rel="stylesheet" href="css/bootstrap-datepicker.min.css" />

</head>

<body>
    <!-- Navbar -->
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
            <a href="#" class="navbar-brand">Beautiful Salon</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
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
                        echo '
                    <li class="navbar-item">
                        <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
                            data-bs-target="#exampleModal" data-bs-whatever="@mdo">Sign In</button>

                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header text-center">
                                        <h5 class="modal-title" id="exampleModalLabel">Sign In</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="limiter">
                                            <div class="container-login100">
                                                <div class="wrap-login100 p-t-20 p-b-10">
                                                    <form class="login100-form validate-form" method="post">
                                                        <span class="login100-form-title ">
                                                            Beautiful Salon
                                                        </span>
                                                        <h5 class="text-center welcome-spacing">Welcome</h5>';
                        echo '
                                                        <div class="wrap-input100 validate-input m-t-50 m-b-35" data-validate="Enter username">
                                                            <input class="input100" type="text" name="username">
                                                            <span class="focus-input100"
                                                                data-placeholder="Username"></span>
                                                        </div>

                                                        <div class="wrap-input100 validate-input m-b-50" data-validate="Enter password">
                                                            <input class="input100" type="password" name="pass">
                                                            <span class="focus-input100"
                                                                data-placeholder="Password"></span>
                                                        </div>

                                                        <div class="container-login100-form-btn">
                                                            <button  type="submit" name="btn_login" class="login100-form-btn">
                                                                Login
                                                            </button>
                                                        </div>

                                                        <ul class="login-more p-t-50 ms-auto">
                                                            <li>
                                                                <span class="txt1">
                                                                    Don’t have an account?
                                                                </span>

                                                                <a href="signup.php" class="txt2">
                                                                    Sign up
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
                    ';
                    } else if ($_SESSION["token_loing"] === true) {
                        echo '
                    <li class="nav-item">
                        <a href="#" class="nav-link">Username : ' . $_SESSION["token_username"] .  '</a>
                    </li>
                    <li class="nav-item">
                        <form method="post">
                            <button type="submit" name="btn_logout" class="btn btn-danger">Logout</button>
                        </form>
                    </li>
                    ';
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
                            <li class="active kanitB">เลือกช่างทำผม</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <section class="calen-date">
        <div class="container sel-box">

            <form action="#">
                <div class="row col-12">
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="text" class="form-control-lg selDate" id="datepicker" value="<?php echo $date ?>">
                        </div>
                    </div>

                    <div class="col-12 col-md-4">
                        <div class="form-group text-center">
                            <input type="text" class="form-control-lg" id="startTime" value="<?php echo $stime ?>">
                        </div>
                    </div>

                    <div class="col-12 col-md-4 text-end">
                        <div class="form-group">
                            <input type="text" class="form-control-lg selTime" id="endTime" value="<?php echo $etime ?>">
                        </div>
                    </div>
                </div>

                <div class="row d-flex">
                    <div class="col-12 col-md-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-block btn-lg btn_booking ">Booking</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <section class="bg-light showbarber">
        <div class="container p-0">
            <div class="row">
                <div class="col-12 col-md-12 mb-4">
                    <h3 class="kanitB">เลือกช่างทำผม</h3>
                </div>
                <?php
                $result = $db->prepare('SELECT * from tb_employee');
                $result->execute();

                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

                ?>
                    <div class="col-12 col-md-3 mb-1">
                        <a href="detail_emp.php?uu_id=<?php echo $row['uuid'] ?>&start_date=<?php echo $date ?>&start_time=<?php echo $stime ?>&end_time=<?php echo $etime ?>" target="_blank">
                            <div class="card" style="width: 16rem;">

                                <?php echo '<img src="../Admin/images/employee/' . $row["images"] . '" class="card-img-top" height=225">' ?>
                                <!-- <img src="../Admin/images/" alt="" class="card-img-top"> -->

                                <div class="card-body">
                                    <h5 class="card-title text-center"><?php echo $row["fname"] ?></h5>

                                    <p class="text-warning text-center card-text">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                        </svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                        </svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                        </svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                        </svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                        </svg>
                                    </p>

                                    <p class="kanitB text-center mb-1 fw-bold card-text">( 5.0 คะแนน)</p>
                                    <h5 class="kanitB text-center text-success fw-bolder">ว่าง</h5>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php } ?>
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
    <!-- <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/rome.js"></script>
    <script src="js/main.js"></script>
    <script src="js/main1.js"></script> -->
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
    </script>
</body>

</html>