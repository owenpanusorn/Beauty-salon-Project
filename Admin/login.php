<?php
session_start();
?>

<?php
require_once 'require/config.php';

if (!empty($_SESSION["token_admin_uuid"])) {
    header("refresh:0;index.php");
}

if (isset($_REQUEST['btn_login'])) {
    try {
        $select_ch = $_REQUEST['select_login'];
        $username_login = $_REQUEST['username'];
        $password_login = $_REQUEST['password'];

        if (empty($select_ch)) {
            $errorMsg = "Please Enter select login";
        } else if (empty($username_login)) {
            $errorMsg = "Please Enter username";
        } else if (empty($password_login)) {
            $errorMsg = "Please Enter password";
        } else {

            if ($select_ch == 'ADMIN') {
            } else if ($select_ch == 'USER') {
                $qry = $db->prepare("select * from tb_login where username = :username_login limit 1");
                $qry->bindParam(":username_login", $username_login);
                $qry->execute();
                $row = $qry->fetch(PDO::FETCH_ASSOC);
                echo '<br>';

                if (!empty($row['password']) && !empty($row['username'])) {
                    if (!password_verify($password_login, $row['password'])) {
                        $errorMsg = 'รหัสผ่านไม่ถูกต้อง';
                        // header("refresh:2;");
                    } else {
                        $_SESSION["token_admin_uuid"] = $row['uuid'];
                        $_SESSION["token_admin_loing"] = true;
                        $_SESSION["token_admin_username"] = $_REQUEST['username'];
                        $seMsg = 'เข้าสูระบบแล้ว';
                        header("refresh:2;index.php");
                    }
                } else {
                    $errorMsg = 'ไม่พบ user';
                    // header("refresh:2;");
                }
            }
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

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