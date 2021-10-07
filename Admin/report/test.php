<?php
  require_once '../require/config.php';
?>
<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Year', 'sumprice'],
         <?php
         $sql = "select strftime('%Y',date) as 'Year',count(*) as count,sum(price) as sumprice from tb_data  group by Year order by Year desc;";
         $fire = $db->query($sql);
        //  $fire = mysqli_query($con,$sql);
          while ($result = $fire->fetch(PDO::FETCH_ASSOC)) {
            echo"['".$result['Year']."',".$result['sumprice']."],";
          }

         ?>
        ]);

        var options = {
          title: 'Students and their contribution'
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('barchart'));

        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="barchart" style="width: 900px; height: 500px;"></div>
  </body>
</html>