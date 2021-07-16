<?php
    try{
        date_default_timezone_set("Asia/Bangkok");
        $db = new PDO('sqlite:require/db_booking.sqlite');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        
        $date = date("d/m/Y");
        $time = date("h:i:sa");
        
    }catch(PDOException $e){
        echo $e->getMessage();
    }
?>