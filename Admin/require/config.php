<?php
    try{
        date_default_timezone_set("Asia/Bangkok");
        $dl = 'sqlite:'.dirname(__FILE__) . '\db_booking.sqlite';
        $db = new PDO($dl);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        
        $date = date("d/m/Y");
        $time = date("h:i:sa");
        // echo $dl;

    }catch(PDOException $e){
        echo $e->getMessage();
    }
?>