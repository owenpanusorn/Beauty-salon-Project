<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<div id="confirmModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Delete?</h3>
    </div>
    <div class="modal-body">
        <p>Are you sure you wish to delete?</p>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
        <button onclick="ok_hit()" class="btn btn-primary">OK</button>
    </div>
</div>
<button class="btn btn-danger" onclick="show_confirm()">Click me</button>

<body>
    <script>
        // function : show_confirm()
        function show_confirm() {
            // shows the modal on button press
            $('#confirmModal').modal('show');
        }

        // function : ok_hit()
        function ok_hit() {
            // hides the modal
            $('#confirmModal').modal('hide');
            alert("OK Pressed");

            // all of the functions to do with the ok button being pressed would go in here
        }
    </script>
</body>

</html>