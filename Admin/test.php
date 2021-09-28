<?php
session_start();
require_once 'require/config.php';
require_once 'require/session.php';

$result = $db->prepare("select strftime('%Y',date) as 'Year',strftime('%m',date) as 'Month',count(*) as count,sum(price) as sumprice from tb_data  group by Month,Year order by Year ASC,Month desc ;");
$result->execute();
$lwma = 0;
$sumindex1 = 0;
$arr = $result->fetchAll(PDO::FETCH_ASSOC);
$numcount = count($arr) - 1;
// echo '<br>';


for ($i = $numcount; $i >= 0; $i--) {
    echo '<br>';
    print_r($arr[$i]);
    echo $i;
    // echo $arr[$i]['count'];
    $sumindex1 += $i;
    $lwma += $arr[$i]['count'] * $i;
}
$lwma = $lwma / $sumindex1;

echo '<br>';
echo '<hr>';
echo 'Linear Weighted Moving Average : ' . $lwma;
echo '<hr>';

$result1 = $db->prepare("select strftime('%Y',date) as 'Year',strftime('%m',date) as 'Month',count(*) as count,sum(price) as sumprice from tb_data group by Month,Year order by Year desc,Month asc ;");
$result1->execute();
$sumindex = 0;
$sma = 0;
$index = 0;


while ($row = $result1->fetch(PDO::FETCH_ASSOC)) {
    $index++;
    print_r($row);
    echo '<br>';
    $sma += $row['count'];
    $sumindex += $index;
}
$sma = $sma / $index;
echo '<hr>';

echo  'simple moving average : ' . $sma;

