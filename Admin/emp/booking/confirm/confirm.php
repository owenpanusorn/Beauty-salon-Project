<?php
session_start();
require_once('../../../require/config.php');
require_once('../../../require/session.php');

if(empty($_SESSION["token_admin_uuid"])){
    session_unset();
    header("refresh:0;../../../login.php");
  }

if (isset($_REQUEST['num_list'])) {
    $numlist = $_REQUEST['num_list'];

    try {
        $date = date("d-m-Y");
        $time = date("h:i:sa");
        $newtime = str_replace(['pm', 'am'], '', $time);

        $book_status = 'success';
        $update_book = $db->prepare('update tb_booking set book_st = :book_st, up_bks_date = :up_bks_date, up_bks_time = :up_bks_time where books_nlist = :books_nlist');
        $update_book->bindParam(':book_st', $book_status);
        $update_book->bindParam(':up_bks_date', $date);
        $update_book->bindParam(':up_bks_time', $newtime);
        $update_book->bindParam(':books_nlist', $numlist);

        if ($update_book->execute()) {

            // $insertMsg = "ยืนยันสำเร็จ . . .";
            header("refresh:0;index.php");
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
