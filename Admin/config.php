<?php
    try{
        $db = new PDO('sqlite:db_booking.sqlite');

        // $sql = "CREATE TABLE IF NOT EXISTS groups(
        //     id INTEGER PRIMARY KEY,
        //     name TEXT,
        //     email TEXT)";

        // $conn->exec($sql);
        // echo "Table created successfully<br>";    
            
        // $db->exec("CREATE TABLE IF NOT EXISTS groups(id INTEGER PRIMARY KEY,name TEXT,email TEXT)");   
        // $db->exec("INSERT INTO tb_login(username,password,role) VALUES('test','12334',201);");
        // echo $db;
        // $db->exec("INSERT INTO groups(id,name,email) VALUES(2,'ANY','ANY@GMAIL.COM');");
        // $db->exec("INSERT INTO groups(id,name,email) VALUES(3,'ANY','ANY@GMAIL.COM');");

        // print "<table border=1>";
        // print "<tr> <td>ID </td> <td>Name </td> <td>Email </td></tr>";

        // $result = $db->query('SELECT * from groups');
        
        // foreach($result as $row){
        //     print "<tr><td>".$row['id']."</td>";
        //     print "<td>".$row['name']."</td>";
        //     print "<td>".$row['email'."</td></tr>";
        // }

        //  print "</table>";
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);        
    }catch(PDOException $e){
        echo $e->getMessage();
    }
?>