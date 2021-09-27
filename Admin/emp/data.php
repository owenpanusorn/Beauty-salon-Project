<?php 
   header('Content-Type: application/json; charset=utf-8');

    require_once('../require/config.php');

  $sql = "select * from tb_booking order by cre_bks_date";
  $res = $db->query($sql);
  $res->execute();

  while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
    $data[] = $row;
  }

  echo json_encode($data);

echo 'test';

?>

