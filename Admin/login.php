<?php
session_start();
require_once 'require/config.php';
require_once 'require/session.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">

    <link rel="stylesheet" href="css/fontkanit.css">
    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
    <title>Sing In</title>
</head>

<body>
    <div class="wrapper">
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
        <form class="form-signin" method="POST" enctype="multipart/form-data">
            <h2 class="form-signin-heading ms-auto kanitB text-center mt-2">เข้าสู่ระบบ</h2>
            <input type="text" class="form-control" name="username" placeholder="Username" required="" autofocus="" />
            <input type="password" class="form-control" name="password" placeholder="Password" required="" />
            <select class="form-control kanitB role" name="select_login">
                <option value="USER" selected>พนักงาน</option>
                <option value="ADMIN">เจ้าของร้าน</option>
            </select>
            <button class="btn btn-primary btn-block" name="btn_login" type="submit">Login</button>
        </form>
    </div>
</body>

</html>