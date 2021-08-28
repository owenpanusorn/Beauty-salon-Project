<?php

require_once 'config.php';

if (isset($_REQUEST['btn_login'])) {
    try {

        $username_login = $_REQUEST['username'];
        $password_login = $_REQUEST['pass'];
        if (empty($username_login)) {
            $errorMsg = "กรุณากรอก Usernaem";
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
                    header("refresh:2;");
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