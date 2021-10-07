<?php 
    header('Content-Type: application/json');

    require_once '../require/config.php';

    // $sqlQuery = "SELECT * FROM student ORDER BY id";
    // $result = mysqli_query($conn, $sqlQuery);

    $sql = "select strftime('%Y',cre_bks_date) as 'Year',strftime('%m',cre_bks_date) as 'Month',count(*) as count,sum(books_price) as sumprice from tb_booking group by Month,Year order by Year desc,Month asc ;";
    $result = $db->query($sql);

    $data1 = array();
    foreach ($result as $row) {
        $data1[] = $row;
    }

    // mysqli_close($conn);

    echo json_encode($data1);
?>