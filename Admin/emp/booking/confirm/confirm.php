<?php
session_start();
require_once('../../../require/config.php');
require_once('../../../require/session.php');

if (isset($_REQUEST['num_list'])) {
    $numlist = $_REQUEST['num_list'];

    try {
        $book_status = 'success';
        $update_book = $db->prepare('update tb_booking set book_st = :book_st where books_nlist = :books_nlist');
        $update_book->bindParam(':book_st', $book_status);
        $update_book->bindParam(':books_nlist', $numlist);

        if ($update_book->execute()) {

            // $insertMsg = "ยืนยันสำเร็จ . . .";
            header("refresh:0;index.php");
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

?>
