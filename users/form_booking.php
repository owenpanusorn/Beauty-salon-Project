<?php
// Start the session
session_start();
require_once '../Admin/require/config.php';

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
    <link rel="stylesheet" href="css/rome.css">
    <!-- time picker -->
    <link rel="stylesheet" href="jquery/jquery.timepicker.min.css">
    <link rel="stylesheet" href="jquery/jquery.timepicker.css">
    <!-- regisform -->
    <!-- <link rel="stylesheet" href="css/style1.css"> -->
    <!-- Select Employee -->
    <link rel="stylesheet" type="text/css" href="css/select_emp.css">

</head>

<body>
    <!-- Navbar -->
    <main-menubar></main-menubar>

    <div class="container-fluid bcrumb">
        <div class="container mt-3 bcrumb-in">
            <div class="row">
                <div class="col-md-12 mt-3">
                    <nav>
                        <ul class=" changcrumb">
                            <li class=""><a href="index.html">Home / </a></li>
                            <li class=""><a href="select_employee.html">Hairdresser /</a> </li>
                            <li class="active">Detail Hairdresse</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <section class="">
        <div class="container">
            <h5 class="kanitB fw-bolder mt-5 mb-3">ฟอร์มการจอง</h5>
            <div class="form-booking border rounded-2 p-5 mb-5">
                <form action="" name="frm">
                    <div class="form-group">
                        <div class="row  mb-3">
                            <div class="col-12 col-md-2 my-auto">
                                <label for="" class="kanitB  fw-bold">รายละเอียดการจอง
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-2 text-right my-auto">
                                <label for="" class="kanitB ">เลขที่การจอง</label>
                            </div>
                            <div class="col-12 col-md-3">
                                <input type="text" class="form-control border" name="" id="" placeholder="B123456789" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-12 col-md-2 text-right my-auto">
                                <label for="" class="kanitB ">วันที่จอง</label>
                            </div>
                            <div class="col-12 col-md-3">
                                <input type="text" class="form-control border" name="" id="" placeholder="01/08/2021" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-12 col-md-2 text-right my-auto">
                                <label for="" class="kanitB">เวลาที่จอง</label>
                            </div>
                            <div class="col-12 col-md-3">
                                <input type="text" class="form-control border" name="" id="" placeholder="08:00" disabled>
                            </div>
                            <div class="col-12 col-md-1 text-center my-auto">
                                <label for="" class="kanitB ">ถึง</label>
                            </div>
                            <div class="col-12 col-md-3">
                                <input type="text" class="form-control border" name="" id="" placeholder="08:00" disabled>
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
                                <input type="text" class="form-control border kanitB " name="" id="" placeholder="ภานุสรณ์ ใจกลม" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row mt-5">
                            <div class="col-12 col-md-2 my-auto fw-bold">
                                <label for="" class="kanitB">เลือกบริการ
                                </label>
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
                                    <input class="form-check-input " type="checkbox" value="<?php echo $time ?>" onclick="tick(frm , this,<?php echo $ri ?>)">

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
                                <input type="text" class="kanitB" name="sumtime" id="sumtime" value="0" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-2 text-right">
                                <label for="" class="kanitB">ค่าบริการทั้งหมด</label>
                            </div>
                            <div class="col-12 col-md-2">
                                <input type="text" name="price" id="price" value="0" />
                            </div>
                        </div>
                    </div>


                    <div class="row mt-5">
                        <div class="col-12 col-md-3 ms-auto">
                            <div class="form-group">
                                <button type="submit" class="btn btn-block btn-success kanitB">ตกลง</button>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 me-auto">
                            <div class="form-group">
                                <button class="btn btn-block btn-danger kanitB">ยกเลิก</button>
                            </div>
                        </div>

                    </div>

                </form>
            </div>
        </div>
    </section>
    <!-- Footer -->
    <main-footer></main-footer>

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

    <script>
        function tick(frm, chk, price) {
            // คำนวณบวกหรือลบจากค่าเริ่มต้น
            // console.log('value', chk.value);
            var time = parseFloat(frm.time.value);
            var total = parseFloat(frm.price.value);

            frm.price.value = chk.checked ? total + parseFloat(price) : total - parseFloat(price);
            frm.time.value = chk.checked ? time + parseFloat(chk.value) : time - parseFloat(chk.value);
            // console.log(frm.sum.value);
            let sum_total = frm.time.value
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
            } else {
                frm.sumtime.value = "0 ชั่วโมง"
            }

            if (frm.time.value > 120) {
                alert('จำกัดเวลาเพียง 2 ขั่วโมง')
                frm.price.value -= parseFloat(price)
                frm.time.value -= parseFloat(chk.value)
                chk.checked = false;
            }
        }




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