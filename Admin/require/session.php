<?php
require_once('config.php');

// if (!empty($_SESSION["token_admin_uuid"])) {
//     // header("refresh:0;index.php");
// }

//   if (empty($_SESSION["token_admin_uuid"])) {
//     header("refresh:0;../../../login.php");
//   }

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
                $qry = $db->prepare("select * from tb_manager where username = :username_login");
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
                        $errorMsg = 'ไม่พบ User';
                        // header("refresh:2;");
                    }
               
            } else if ($select_ch == 'USER') {
                $qry = $db->prepare("select * from tb_login where username = :username_login");
                $qry->bindParam(":username_login", $username_login);
                $qry->execute();
                $row = $qry->fetch(PDO::FETCH_ASSOC);               
                echo '<br>';

                    if (!empty($row['password']) && !empty($row['username'])) {
                        if (!password_verify($password_login, $row['password'])) {
                            $errorMsg = 'รหัสผ่านไม่ถูกต้อง';
                            // header("refresh:2;");
                        } else {
                            $_SESSION["token_emp_uuid"] = $row['uuid'];
                            $_SESSION["token_emp_loing"] = true;
                            $_SESSION["token_emp_username"] = $_REQUEST['username'];
                            $seMsg = 'เข้าสูระบบแล้ว';
                            header("refresh:2;emp/index.php");
                        }
                    } else {
                        $errorMsg = 'รหัสผ่านไม่ถูกต้อง';
                        // header("refresh:2;");
                    }        
            }
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
