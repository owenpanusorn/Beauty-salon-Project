<?php
// Start the session
session_start();
require_once 'require/config.php';
// require_once 'require/session.php';
?>

<!DOCTYPE html>
<html lang="en">

<?php

// if ($_SESSION["token_loing"] === true) {
//     header("refresh:0;index.php");
// }

if (isset($_REQUEST['btn_login'])) {
    try {

        $username_login = $_REQUEST['username'];
        $password_login = $_REQUEST['pass'];
        if (empty($username_login)) {
            $errorMsg = "กรุณากรอก Username";
            header("refresh:2;");
        } else if (empty($password_login)) {
            $errorMsg = "กรุณากรอก Password";
            header("refresh:2;");
        } else {
            $qry1 = $db->prepare("select * from tb_customer where username = :usernmae_login LIMIT 1");
            $qry1->bindParam(":usernmae_login", $username_login);
            $qry1->execute();
            $row1 = $qry1->fetch(PDO::FETCH_ASSOC);

            if (!empty($row1) && count($row1) > 0) {
                extract($row1);
            }
            if (!empty($password) && !empty($username)) {
                if (!password_verify($password_login, $password)) {
                    $errorMsg = 'รหัสผ่านไม่ถูกต้อง';
                    // header("refresh:2;");
                } else {
                    $_SESSION["token_uuid"] = $uuid;
                    $_SESSION["token_loing"] = true;
                    $_SESSION["token_username"] = $_REQUEST['username'];
                    $seMsg = 'เข้าสูระบบแล้ว';
                    header("refresh:2;index.php");
                }
            } else {
                $errorMsg = 'รหัสผ่านไม่ถูกต้อง';
                // header("refresh:2;");
            }
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

if (isset($_REQUEST['btn_singup'])) {
    try {

        $singup_fname = $_REQUEST['fname'];
        $singup_lname = $_REQUEST['lname'];
        $singup_username = $_REQUEST['username'];
        $singup_pass = $_REQUEST['pass'];
        $hashed_password = password_hash($singup_pass, PASSWORD_DEFAULT);
        $singup_gender = $_REQUEST['gender'];
        $singup_nphon = $_REQUEST['nphon'];
        $singup_adder = $_REQUEST['adder'];
        $uuid_in = uuid();
        $date = date("d/m/Y");
        $time = date("h:i:sa");
        $newtime = str_replace(['pm', 'am'], '', $time);

        if (empty($singup_fname)) $errorMsg = 'Please Enter First Name';
        else if (empty($singup_lname)) $errorMsg = 'Please Enter Last Name';
        else if (empty($singup_username)) $errorMsg = 'Please Enter Username';
        else if (empty($singup_pass)) $errorMsg = 'Please Enter Password';
        else if ($singup_gender == 'null') $errorMsg = 'Please Enter Gender';
        else if (empty($singup_nphon)) $errorMsg = 'Please Enter Number Phone';
        else if (empty($singup_adder)) $errorMsg = 'Please Enter Address';
        else {
            $qry_ch = $db->prepare("select * from tb_customer where 
            fname = :fname_in and
            lname = :lname_in or
            username = :username_in or
            nphone = :nphon_in
            LIMIT 1");
            $qry_ch->bindParam(":fname_in", $singup_fname);
            $qry_ch->bindParam(":lname_in", $singup_lname);
            $qry_ch->bindParam(":username_in", $singup_username);
            $qry_ch->bindParam(":nphon_in", $singup_nphon);

            $qry_ch->execute();
            $row_ch = $qry_ch->fetch(PDO::FETCH_ASSOC);
            if (!empty($row_ch)) extract($row_ch);
            if (empty($row_ch)) {
                $insert_singup = $db->prepare("INSERT INTO tb_customer(uuid, username, password, fname , lname,gender,nphone,address,cre_cus_date, cre_cus_time) 
                VALUES (:uuid, :username, :password_hash, :fname_in,:lname_in,:gender_in,:nphone_in,:adderss_in, :cre_cus_date, :cre_cus_time)");
                $insert_singup->bindParam(":uuid", $uuid_in);
                $insert_singup->bindParam(":username", $singup_username);
                $insert_singup->bindParam(":password_hash", $hashed_password);
                $insert_singup->bindParam(":fname_in", $singup_fname);
                $insert_singup->bindParam(":lname_in", $singup_lname);
                $insert_singup->bindParam(":gender_in", $singup_gender);
                $insert_singup->bindParam(":nphone_in", $singup_nphon);
                $insert_singup->bindParam(":adderss_in", $singup_adder);
                $insert_singup->bindParam(":cre_cus_date", $date);
                $insert_singup->bindParam(":cre_cus_time", $newtime);

                if ($insert_singup->execute()) {
                    $seMsg = "Insert Successfully . . .";
                    $_SESSION["token_uuid"] = $uuid_in;
                    $_SESSION["token_loing"] = true;
                    $_SESSION["token_username"] = $singup_username;
                    return header("refresh:0.5;index.php");
                }
            } else if ($fname == $singup_fname && $lname == $singup_lname) $errorMsg = 'First Name And Last Name is Duplicate';
            else if ($username == $singup_username) $errorMsg = 'Username is Duplicate';
            else if ($nphone == $singup_nphon) $errorMsg = 'Number Phone is Duplicate';
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
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

?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สมัครสมาชิก</title>

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
    <link rel="stylesheet" href="css/style1.css">
    <link rel="icon" href="img/hairsalon-icon.png" type="image/gif" sizes="16x16">


</head>

<body>
    <?php

    ?>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <!-- Main content -->
        <?php
        if (isset($errorMsg)) {
        ?>
            <div class="alert alert-danger alert-dismissible">
                <p class="kanitB"><i class="icon fa fa-ban"></i> <?php echo $errorMsg ?></p>
            </div>
        <?php } ?>

        <?php
        if (isset($seMsg)) {
        ?>
            <div class="alert alert-success alert-dismissible">
                <p class="kanitB"><i class="icon fa fa-check"></i> <?php echo $seMsg ?></p>
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

                    <?php
                    if (empty($_SESSION["token_loing"]) || $_SESSION["token_loing"] === false) { ?>
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
                                            </div>

                                            <div id="dropDownSelect1"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>

                    <?php } else if ($_SESSION["token_loing"] === true) { ?>
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
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid bcrumb">
        <div class="container mt-3 bcrumb-in">
            <div class="row">
                <div class="col-md-12 mt-3">
                    <nav>
                        <ul class=" changcrumb kanitB">
                            <li class=""><a href="index.php">หน้าหลัก / </a></li>
                            <li class="active">สมัครสมาชิก</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>



    <div class="wrapper" style="background-image: url('img/bg-registration-form-1.jpg');">

        <div class="inner">
            <div class="container">
                <div class="row gy-5">
                    <div class="image-holder col-md-6">
                        <img src="img/registration-form-1.jpg" alt="">
                    </div>

                    <div class="col-md-6">
                        <form role="form" method="POST" enctype="multipart/form-data" class="kanitB">
                            <h3>สมัครสมาชิก</h3>
                          
                            <div class="form-group">
                                <input type="text" placeholder="ชื่อ" name="fname" class="form-control kanitB">
                                <input type="text" placeholder="นามสกุล" name="lname" class="form-control kanitB">
                            </div>
                            <div class="form-wrapper">
                                <input type="text" placeholder="ชื่อผู้ใช้" name="username" class="form-control kanitB">
                                <i class="zmdi zmdi-account"></i>
                            </div>
                            <div class="form-wrapper">
                                <input type="password" placeholder="พาสเวิร์ด" name="pass" class="form-control kanitB">
                                <i class="zmdi zmdi-lock"></i>
                            </div>

                            <div class="form-wrapper">
                                <select name="gender" class="form-control kanitB">
                                    <option value="null" selected>เพศ</option>
                                    <option value="male">ชาย</option>
                                    <option value="femal">หญิง</option>                                    
                                </select>
                                <i class="zmdi zmdi-caret-down" style="font-size: 17px"></i>
                            </div>

                            <div class="form-wrapper">
                                <input type="text" placeholder="เบอร์โทร" name="nphon" class="form-control kanitB">
                                <i class="zmdi zmdi-phone"></i>
                            </div>
                            <div class="form-wrapper">
                                <textarea name="adder" cols="30" rows="30" class="form-control kanitB" placeholder="รายละเอียดที่อยู่ . . ."></textarea>
                                <i class="zmdi zmdi-home"></i>
                            </div>

                            <button type="submit" name="btn_singup" class="btn_regis">ยืนยันสมัครสมาชิก
                                <i class="zmdi zmdi-arrow-right"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Features icons -->


    <!-- Footer -->
    <footer class="bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center p-t-45">
                    <p class="text-mired">&copy; Beautiful Salon 2021. All Right Reserved.</p>
                </div>
            </div>
        </div>
    </footer>


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