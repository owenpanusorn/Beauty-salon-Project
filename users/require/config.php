<?php
try {
    date_default_timezone_set("Asia/Bangkok");
    $dl = 'sqlite:' . dirname(__FILE__,3)  .'\Admin\require\db_booking.sqlite';
    // echo $dl;
    $db = new PDO($dl);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    
    $date = date("d/m/Y");
    $time = date("h:i:sa");

} catch (PDOException $e) {
    echo $e->getMessage();
}
