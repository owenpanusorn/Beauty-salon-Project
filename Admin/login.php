<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">

    <link rel="stylesheet" href="css/fontkanit.css">
    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
    <title>Sing In</title>
</head>

<body>
    <div class="wrapper">
        <form class="form-signin">
            <h2 class="form-signin-heading ms-auto kanitB text-center mt-2">เข้าสู่ระบบ</h2>
            <input type="text" class="form-control" name="username" placeholder="Username" required="" autofocus="" />
            <input type="password" class="form-control" name="password" placeholder="Password" required="" />
            <select class="form-control kanitB role" >
                <option value="1" selected>พนักงาน</option>
                <option value="2">เจ้าของร้าน</option>               
            </select>                  
            <button class="btn btn-primary btn-block" type="submit">Login</button>
        </form>
    </div>
</body>

</html>