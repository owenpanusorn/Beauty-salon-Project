<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <div class="chart-container">
        <canvas id="grahCanvas"></canvas>
    </div>

    <script scr="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script scr="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            showGraph();
        });

        function showGraph() {
            $.post('data.php', function(data) {
                console.log(data);
            });
        }
    </script>
</body>

</html>