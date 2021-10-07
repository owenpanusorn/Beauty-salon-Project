<?php 
    header('Content-Type: application/json');

    require_once '../require/config.php';

    // $sqlQuery = "SELECT * FROM student ORDER BY id";
    // $result = mysqli_query($conn, $sqlQuery);

    $sql = "select strftime('%Y',cre_bks_date) as 'Year',count(*) as count,sum(books_price) as sumprice from tb_booking  group by Year order by Year desc;";
    $result = $db->query($sql);

    $data = array();
    foreach ($result as $row) {
        $data[] = $row;
    }

    // mysqli_close($conn);

    echo json_encode($data);
?>