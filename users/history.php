<?php
// Start the session
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
// if(isset($_REQUEST['btn_booking'])){
//     $date = $_REQUEST['startDate'];
//     $stime = $_REQUEST['startTime'];
//     $etime = $_REQUEST['endTime'];

//     print_r($date);
//     print_r($stime);
//     print_r($etime);
// }

if (!empty($_SESSION["token_loing"]) && $_SESSION["token_loing"] === true) {

    $uuid_cus = $_SESSION['token_uuid'];
    // $date = date("d-m-Y"); //thai
    $date = date("Y-m-d");


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
    <title>ประวัติการจอง | Beautiful Salon</title>

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
    <link rel="icon" href="img/hairsalon-icon.png" type="image/gif" sizes="16x16">

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
                        <a href="#p1" class="nav-link">การจองคิว</a>
                    </li>
                    <li class="nav-item">
                        <a href="#p2" class="nav-link ">ประวัติการจอง</a>
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
                                <li><button class="dropdown-item" type="button"><i class="fa fa-book" aria-hidden="true"></i> ประวัติการจอง</button></li>
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
                            <li class="active kanitB">ประวัติการจอง</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>


    <section>
        <div class="container kanitB">
            <a name="p2">
                <h5 class="mt-5">ประวัติการจอง</h5>
            </a>
            <div class="row mt-4">
                <div class="col-lg-12 shadow p-3 mb-5 bg-body rounded">
                    <form action="" method="POST">
                        <table class="table" id="myTable2">
                            <thead>
                                <tr>
                                    <th>ลำดับ</th>
                                    <th>เลขที่รายการ</th>
                                    <th>ช่างทำผม</th>
                                    <th>วันที่จอง</th>
                                    <th>เวลาในการจอง</th>
                                    <th>สถานะ</th>
                                    <th>รายละเอียด</th>
                                </tr>
                            </thead>
                            <?php
                            if (!empty($_SESSION["token_loing"]) && $_SESSION["token_loing"] === true) {
                            ?>
                                <tbody>
                                    <?php
                                    $uuid_cus = $_SESSION["token_uuid"];
                                    // print_r($uuid_cus);
                                    $sql_status = 'success';
                                    $result = $db->prepare('SELECT * from tb_booking where uuid_cus = :uuid_cus and book_st = :book_st order by cre_bks_date desc');
                                    $result->bindParam(":uuid_cus", $uuid_cus);
                                    $result->bindParam(":book_st", $sql_status);
                                    // $result->bindParam(":cre_bks_date", $date);
                                    $result->execute();

                                    $num = 0;
                                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                        $num++;

                                        if ($row['book_st'] == 'wait') {
                                            $status = 'รอดำเนินการ';
                                        } else if ($row['book_st'] == 'success') {
                                            $status = 'จองคิวสำเร็จ';
                                        }
                                    ?>
                                        <tr>
                                            <td><?php echo $num; ?></td>
                                            <td><?php echo $row['books_nlist'] ?></td>
                                            <td><?php echo $row['book_emp'] ?></td>
                                            <td><?php echo $row['cre_bks_date'] ?></td>
                                            <td><?php echo $row['cre_bks_time'] ?> - <?php echo $row['end_bks_time'] ?></td>
                                            <?php
                                            if ($status == 'รอดำเนินการ') {
                                                $txt_color = 'text-warning';
                                                $icon = 'fa fa-clock-o';
                                            } else if ($status == 'จองคิวสำเร็จ') {
                                                $txt_color = 'text-success';
                                                $icon = 'fa fa-check';
                                            } else {
                                                $txt_color = '';
                                            }

                                            echo '<td class="' . $txt_color . '">';
                                            echo '<i class="' . $icon . '"></i>' . ' ' . $status;
                                            echo '</td>';
                                            ?>
                                            <td><a href="detail_history.php?books_num=<?php echo $row['books_nlist'] ?>" class="btn btn-primary"><i class="fa fa-info-circle"></i> รายละเอียด</a></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            <?php
                            }
                            ?>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <button type="button" class="btn btn_booking btn-floating btn-lg" id="btn-back-to-top">
        <i class="fa fa-arrow-up"></i>
    </button>

    <!-- Footer -->
    <footer class="bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
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
            $('#myTable1').DataTable();
            $('#myTable2').DataTable();

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