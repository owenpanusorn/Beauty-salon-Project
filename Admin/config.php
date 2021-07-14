<?php
    try{
        $db = new PDO('sqlite:db_booking.sqlite');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);        
    }catch(PDOException $e){
        echo $e->getMessage();
    }
?>