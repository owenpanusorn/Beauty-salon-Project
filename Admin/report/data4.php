<?php 
    header('Content-Type: application/json');

    require_once '../require/config.php';

    // $sqlQuery = "SELECT * FROM student ORDER BY id";
    // $result = mysqli_query($conn, $sqlQuery);

    $sql = "select strftime('%Y',date) as 'Year',count(*) as count,sum(price) as sumprice from tb_data  group by Year order by Year desc;";
    $result = $db->query($sql);

    $data1 = array();
    foreach ($result as $row) {
        $data1[] = $row;
    }

    // mysqli_close($conn);

    echo json_encode($data1);
?>