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


if (isset($_REQUEST['uu_id']) && isset($_REQUEST['fname']) && isset($_REQUEST['start_date']) && isset($_REQUEST['start_time'])) {

    $uuid_emp = $_REQUEST['uu_id'];
    $name_emp = $_REQUEST['fname'];
    $bil = "NOIBEAUTI-";
    $start_date = $_REQUEST['start_date'];
    $start_time = $_REQUEST['start_time'];




    $new_date = str_replace("-", "", $start_date);
    $new_start_time = str_replace(":", "", $start_time);
    $newbil = $bil . $new_date . $new_start_time;
}

if (!empty($_SESSION["token_uuid"])) {
    $uuid_cus = $_SESSION["token_uuid"];

    $select_cus = $db->prepare("select * from tb_customer where uuid = :uuid ");
    $select_cus->bindParam('uuid', $uuid_cus);
    $select_cus->execute(); // ประมวลผลคำสัง prepare
    $row = $select_cus->fetch(PDO::FETCH_ASSOC);  //ส่งค่ากลับ array index โดยใช้ชื่อ column ในตาราง
    extract($row);
} else {
    $uuid_cus = null;
}

if (isset($_REQUEST['btn_booking'])) {
    try {

        $serv = $_REQUEST['services'];
        $total_price = $_REQUEST['price'];
        $total_time = $_REQUEST['time'];
        $status = "wait";
        $endbk = $_REQUEST['timeend'];
        $new_endbk = str_replace(":", "", $endbk);
        $newbil = $newbil . $new_endbk;

        $insert_book = $db->prepare("INSERT INTO tb_booking(uuid_cus, uuid_emp, books_nlist, book_cus, book_emp, book_serv, books_price, books_hours, book_st, cre_bks_date, cre_bks_time, end_bks_time) 
        VALUES (:uuid_cus, :uuid_emp, :books_nlist, :book_cus, :book_emp, :book_serv, :books_price, :books_hours, :book_st, :cre_bks_date, :cre_bks_time, :end_bks_time )");
        $insert_book->bindParam(':uuid_cus', $uuid_cus);
        $insert_book->bindParam(':uuid_emp', $uuid_emp);
        $insert_book->bindParam(':books_nlist', $newbil);
        $insert_book->bindParam(':book_cus', $fname);
        $insert_book->bindParam(':book_emp', $name_emp);
        $insert_book->bindParam(':book_serv', $serv);
        $insert_book->bindParam(':books_price', $total_price);
        $insert_book->bindParam(':books_hours', $total_time);
        $insert_book->bindParam(':book_st', $status);
        $insert_book->bindParam(':cre_bks_date', $start_date);
        $insert_book->bindParam(':cre_bks_time', $start_time);
        $insert_book->bindParam(':end_bks_time', $endbk);


        if ($insert_book->execute()) {
            $insertMsg = "จองสำเร็จ . . .";
            header("refresh:2;index.php");
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

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
    <title>เลือกรายการบริการ | Beautiful Salon</title>

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
    <link rel="stylesheet" href="css/rome.css">
    <!-- time picker -->
    <link rel="stylesheet" href="jquery/jquery.timepicker.min.css">
    <link rel="stylesheet" href="jquery/jquery.timepicker.css">
    <!-- regisform -->
    <!-- <link rel="stylesheet" href="css/style1.css"> -->
    <!-- Select Employee -->
    <link rel="stylesheet" type="text/css" href="css/select_emp.css">
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
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 kanitB">
                    <li class="nav-item">
                        <a href="index.php" class="nav-link active" aria-current="page">หน้าหลัก</a>
                    </li>
                    <li class="nav-item">
                        <a href="#p1" class="nav-link active" aria-current="page">เลือกรายการบริการ</a>
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
                    if ($_SESSION["token_loing"] === true) {

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
                    <?php } ?>
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
                        <ul class=" changcrumb kanitB">
                            <li class=""><a href="index.php">หน้าแรก / </a></li>
                            <li class="active">รายละเอียดการจอง</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <section class="">
        <div class="container">
            <?php
            if (isset($errorMsg)) {
            ?>
                <div class="alert alert-danger alert-dismissible kanitB mt-3">
                    <strong><i class="icon fa fa-ban"></i>Wrong! <?php echo $errorMsg ?></strong>
                </div>

            <?php } ?>

            <?php
            if (isset($insertMsg)) {
            ?>
                <div class="alert alert-success alert-dismissible kanitB mt-3">
                    <strong><i class="icon fa fa-check"></i>Success <?php echo $insertMsg ?></strong>
                </div>
            <?php } ?>
            <a name="p1">
                <h5 class="kanitB fw-bolder mt-5 mb-3">ฟอร์มการจอง</h5>
            </a>
            <div class="form-booking border rounded-2 p-5 mb-5">
                <form role="form" method="POST" enctype="multipart/form-data" name="frm">
                    <div class="form-group">
                        <div class="row  mb-3">
                            <div class="col-12 col-md-2 my-auto">
                                <label for="" class="kanitB  fw-bold">รายละเอียดการจอง
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-2 text-right my-auto">
                                <label for="" class="kanitB ">เลขที่บิลการจอง</label>
                            </div>
                            <div class="col-12 col-md-3">
                                <input type="text" class="form-control border" name="" id="" value=" <?php echo $newbil ?>" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-12 col-md-2 text-right my-auto">
                                <label for="" class="kanitB ">วันที่จอง</label>
                            </div>
                            <div class="col-12 col-md-3">
                                <input type="text" class="form-control border" name="" id="date_set" value=" <?php echo $start_date ?>" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-12 col-md-2 text-right my-auto">
                                <label for="" class="kanitB">เวลาที่จอง</label>
                            </div>
                            <div class="col-12 col-md-3">
                                <input type="text" class="form-control border" name="" id="" value=" <?php echo $start_time ?>" disabled>
                            </div>
                            <div class="col-12 col-md-1 text-right my-auto">
                                <label for="" class="kanitB">ถึง</label>
                            </div>
                            <div class="col-12 col-md-3">
                                <input type="text" class="form-control border" name="end_time" id="end_time" value=" <?php echo $start_time ?>" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-12 col-md-2 text-right my-auto">
                                <label for="" class="kanitB ">โดยช่าง
                                </label>
                            </div>
                            <div class="col-12 col-md-3">
                                <input type="text" class="form-control border kanitB " name="" id="" value=" <?php echo $name_emp ?>" disabled>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn_booking btn-floating btn-lg" id="btn-back-to-top">
                        <i class="fa fa-arrow-up"></i>
                    </button>

                    <div class="form-group">
                        <div class="row mt-5">
                            <div class="col-12 col-md-4 my-auto fw-bold">
                                <label for="" class="kanitB">เลือกบริการ
                                </label>
                                <i class="kanitB fs-6 fw-normal text-secondary">*จำกัดเวลาเพียง 2 ชั่วโมง</i>
                            </div>
                        </div>
                    </div>

                    <div class="form-check">
                        <div class="row">
                            <?php
                            $result = $db->prepare('SELECT * from tb_service');
                            $result->execute();

                            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                if ($row["serv_process_time"] == "02:00:00") {
                                    $process = "2 ชั่วโมง";
                                    $time  = 120;
                                } else if ($row["serv_process_time"] == "01:30:00") {
                                    $process = "1 ชั่วโมง 30 นาที";
                                    $time  = 90;
                                } else if ($row["serv_process_time"] == "01:00:00") {
                                    $process = "1 ชั่วโมง";
                                    $time  = 60;
                                } else {
                                    $process = "30 นาที";
                                    $time  = 30;
                                }
                                $ri = $row["serv_price"];
                            ?>
                                <div class="col-12 col-md-3 mb-2">
                                    <input class="form-check-input " type="checkbox" id="servname" value="<?php echo $row['serv_type'] ?>" onclick="tick(frm , this,<?php echo $ri ?>,<?php echo $time ?>)">


                                    <p class="form-check-label kanitB fw-bold h6 mb-1">
                                        <?php echo $row["serv_type"] ?>
                                    </p>

                                    <p class="form-check-label kanitB">
                                        <?php echo $ri ?> บาท
                                    </p>

                                    <p class="form-check-label kanitB">
                                        <?php echo $process ?>
                                    </p>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-12 col-md-3 my-auto fw-bold">
                                <label for="" class="kanitB">รวมทั้งหมด
                                </label>
                            </div>
                        </div>

                        <div class="col-12 col-md-3">


                        </div>

                        <input type="hidden" class="kanitB" name="time" id="time" value="0" />


                        <div class="row">
                            <div class="col-12 col-md-2 text-right">
                                <label for="" class="kanitB">เวลาทั้งหมด</label>
                            </div>
                            <div class="col-12 col-md-2">
                                <input type="text" class="kanitB" name="sumtime" id="sumtime" value="0" disabled />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-2 text-right">
                                <label for="" class="kanitB">ค่าบริการทั้งหมด</label>
                            </div>
                            <div class="col-12 col-md-2">
                                <input type="hidden" name="price" id="price" value="0" />
                                <input type="text" class="kanitB" name="calprice" id="calprice" value="0" disabled />
                            </div>
                        </div>

                        <input type="hidden" name="services" id="services" value="" />
                        <input type="hidden" name="timeend" id="timeend" value="" />


                    </div>

                    <div class="row mt-5">

                        <div class="col-12 col-md-3 ms-auto">
                            <div class="form-group">
                                <button class="btn btn-block btn-secondary kanitB">ยกเลิก</button>
                            </div>
                        </div>

                        <div class="col-12 col-md-3 me-auto">
                            <div class="form-group">
                                <button type="button" class="btn btn-block btn-primary kanitB" data-bs-toggle="modal" data-bs-target="#cofirmbooking">ตกลง</button>
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="cofirmbooking" tabindex="-1" aria-labelledby="cofirmbookingLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title kanitB" id="cofirmbookingLabel">รายละเอียดการจอง</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <div class="row kanitB">
                                                <div class="col-12 col-md-4">
                                                    <label for="">เลขที่บิลการจอง </label>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <p><?php echo $newbil ?></p>
                                                </div>

                                                <div class="col-12 col-md-4">
                                                    <label for="">วันที่จอง </label>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <p><?php echo $start_date ?></p>
                                                </div>

                                                <div class="col-12 col-md-4">
                                                    <label for="">เวลาที่จอง </label>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <p><?php echo $start_time ?> - <span id="end_time_up" name="end_time_up"> </span></p>

                                                </div>

                                                <div class="col-12 col-md-4">
                                                    <label for="">โดยช่าง</label>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <p><?php echo $name_emp ?></p>
                                                </div>

                                                <div class="col-12 col-md-4">
                                                    <label for="">ชื่อลูกค้า</label>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <p><?php echo $fname ?> <?php echo $lname ?></p>
                                                </div>

                                                <div class="col-12 col-md-4">
                                                    <label for="">บริการ</label>

                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <p id="serv_value" class="kanitB"></p>
                                                </div>

                                                <div class="col-12 col-md-4">
                                                    <label for="">ราคา</label>

                                                </div>
                                                <div class="col-12 col-md-6 ">
                                                    <p id="total_price" name="" class="kanitB"> </p>
                                                </div>

                                                <div class="col-12 col-md-4">
                                                    <label for="">เวลาการในบริการ</label>

                                                </div>
                                                <div class="col-12 col-md-6 ">
                                                    <p id="total_time" name="" class="kanitB"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer kanitB">
                                        <a herf="index.php" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</a>
                                        <button type="submit" class="btn btn-primary" name="btn_booking">ยืนยัน</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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

    <script src="script.js"></script>
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
    <script src="https://momentjs.com/downloads/moment.js"></script>
    <script>
        let arr = [];

        function addMinutes(date, minutes) {
            date = new Date(date.getTime() + minutes * 60000);
            return date.getHours() + ':' + ("0" + date.getMinutes()).slice(-2)
        }

        function deMinutes(date, minutes) {
            date = new Date(date.getTime() - minutes * 60000);
            return date.getHours() + ':' + ("0" + date.getMinutes()).slice(-2)
        }

        function tick(frm, chk, price, minute) {
            // คำนวณบวกหรือลบจากค่าเริ่มต้น
            // console.log('value', chk.value);
            var time = parseFloat(frm.time.value);
            var total = parseFloat(frm.price.value);
            var list = String(frm.servname.value);

            let timeset = frm.end_time.value
            timeset = new Date(moment(timeset, 'HH:mm'))
            frm.price.value = chk.checked ? total + parseFloat(price) : total - parseFloat(price);
            frm.time.value = chk.checked ? time + parseFloat(minute) : time - parseFloat(minute);
            frm.end_time.value = chk.checked ? addMinutes(timeset, minute) : deMinutes(timeset, minute);
            let newtime = new Date(moment(frm.end_time.value, 'HH:mm'))


            // console.log('time', test);
            // test = addMinutes(test, 60)
            // console.log(test);
            // test = deMinutes(test, 60)
            // console.log(test);


            if (frm.time.value <= 120) {
                if (chk.checked) {
                    // console.log('if');
                    list += String(chk.value)
                    frm.services.value = list
                    arr.push(String(chk.value));
                } else {
                    for (let index = 0; index < arr.length; index++) {
                        const element = arr[index];
                        if (element == String(chk.value)) {
                            if (arr.length <= 1) arr = []
                            // console.log('element', element, String(chk.value));
                            arr.splice(index, index);
                        }
                    }
                }
            }

            let e = ""
            for (let index = 0; index < arr.length; index++) {
                let element = arr[index];


                e += element + ", "
            }

            frm.services.value = e

            // let html_show = '<inpue type="text" name="serv_value_show" id = "serv_value_show" value="' + e + '" class="kanitB fs-6 fw-normal">'
            document.getElementById("serv_value").innerHTML = e;


            // console.log(frm.sum.value);
            let sum_total = frm.time.value

            console.log(frm.time.value);

            if (frm.time.value > 120) {
                frm.price.value -= parseFloat(price)
                frm.time.value -= parseFloat(minute)
                chk.checked = false;
                frm.end_time.value = deMinutes(newtime, minute)
                alert('จำกัดเวลาเพียง 2 ขั่วโมง');
            } else {
                if (frm.time.value > 0) {
                    let hours = 0
                    while (sum_total >= 60) {
                        sum_total -= 60
                        hours++
                    }
                    text = ''
                    if (hours > 0) text += hours + " ชั่วโมง "
                    if (sum_total > 0 && sum_total < 60) text += sum_total + ' นาที'
                    frm.sumtime.value = text
                    document.getElementById("total_time").innerHTML = frm.sumtime.value;
                } else {
                    frm.sumtime.value = "0 ชั่วโมง"
                    document.getElementById("total_time").innerHTML = frm.sumtime.value;
                }
            }

            let cal_price = frm.price.value
            var commas = cal_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            document.getElementById("end_time_up").innerHTML = frm.end_time.value
            frm.timeend.value = frm.end_time.value
            if (frm.price.value > 0) {
                frm.calprice.value = commas + " บาท"
                document.getElementById("total_price").innerHTML = frm.calprice.value
            } else {
                frm.calprice.value = "0 บาท"
                document.getElementById("total_price").innerHTML = frm.calprice.value
            }

        }


        // document.getElementById("demoserv").innerHTML = result;






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