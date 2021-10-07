<?php 
    header('Content-Type: application/json');

    require_once 'require/config.php';

    // $sqlQuery = "SELECT * FROM student ORDER BY id";
    // $result = mysqli_query($conn, $sqlQuery);

    $sql = "select strftime('%d',cre_bks_date) as Day ,strftime('%m',cre_bks_date) as Month,count(*) as count from tb_booking  group by Day,Month order by Day desc;";
    $result = $db->query($sql);

    $data = array();
    foreach ($result as $row) {
        $data[] = $row;
    }

    // mysqli_close($conn);

    echo json_encode($data);
?>