<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learn Bootstrap 5</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" href="css/rome.css">
    <!-- time picker -->
    <link rel="stylesheet" href="jquery/jquery.timepicker.min.css">
    <link rel="stylesheet" href="jquery/jquery.timepicker.css">
    <!-- regisform -->
    <link rel="stylesheet" href="css/style1.css">


</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a href="#" class="navbar-brand">Beautiful Salon</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a href="index.html" class="nav-link active" aria-current="page">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link ">About</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link ">Services</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link ">Contact</a>
                    </li>
                    <li class="navbar-item">
                        <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
                            data-bs-target="#exampleModal" data-bs-whatever="@mdo">Sign In</button>

                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header text-center">
                                        <h5 class="modal-title" id="exampleModalLabel">Sign In</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="limiter">
                                            <div class="container-login100">
                                                <div class="wrap-login100 p-t-20 p-b-10">
                                                    <form class="login100-form validate-form">
                                                        <span class="login100-form-title ">
                                                            Beautiful Salon
                                                        </span>
                                                        <h5 class="text-center welcome-spacing">Welcome</h5>
                                                        <div class="wrap-input100 validate-input m-t-50 m-b-35"
                                                            data-validate="Enter username">
                                                            <input class="input100" type="text" name="username">
                                                            <span class="focus-input100"
                                                                data-placeholder="Username"></span>
                                                        </div>

                                                        <div class="wrap-input100 validate-input m-b-50"
                                                            data-validate="Enter password">
                                                            <input class="input100" type="password" name="pass">
                                                            <span class="focus-input100"
                                                                data-placeholder="Password"></span>
                                                        </div>

                                                        <div class="container-login100-form-btn">
                                                            <button class="login100-form-btn">
                                                                Sign In
                                                            </button>
                                                        </div>

                                                        <ul class="login-more p-t-50 ms-auto">
                                                            <li class="m-b-8">
                                                                <span class="txt1">
                                                                    Forgot
                                                                </span>

                                                                <a href="#" class="txt2">
                                                                    Username / Password?
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <span class="txt1">
                                                                    Don’t have an account?
                                                                </span>

                                                                <a href="#" class="txt2">
                                                                    Sign up
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="dropDownSelect1"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

  <div class="container-fluid bcrumb">
    <div class="container mt-3 bcrumb-in">
        <div class="row">
            <div class="col-md-12 mt-3">
                <nav>
                    <ul class=" changcrumb">
                        <li class=""><a href="index.html">Home / </a></li>
                        <li class="active">Sign Up</li>
                    </ul>
                </nav>
            </div>
        </div>              
    </div>
  </div>
        
      
  
      <div class="wrapper" style="background-image: url('img/bg-registration-form-1.jpg');">
                
        <div class="inner">
            <div class="container">    
                <div class="row gy-5">
                    <div class="image-holder col-md-6">
                        <img src="img/registration-form-1.jpg" alt="">
                    </div>

                    <div class="col-md-6">
                        <form action="">
                            <h3>Registration Form</h3>
                            <div class="form-group">
                                <input type="text" placeholder="First Name" class="form-control kanitB">
                                <input type="text" placeholder="Last Name" class="form-control kanitB">
                            </div>
                            <div class="form-wrapper">
                                <input type="text" placeholder="Username" class="form-control kanitB">
                                <i class="zmdi zmdi-account"></i>
                            </div>
                            <div class="form-wrapper">
                                <input type="password" placeholder="Password" class="form-control kanitB">
                                <i class="zmdi zmdi-lock"></i>
                            </div> 
                            
                            <div class="form-wrapper">
                                <select name="" id="" class="form-control">
                                    <option value="" disabled selected>Gender</option>
                                    <option value="male">Male</option>
                                    <option value="femal">Female</option>
                                    <option value="other">Other</option>
                                </select>
                                <i class="zmdi zmdi-caret-down" style="font-size: 17px"></i>
                            </div>                            
                           
                            <div class="form-wrapper">
                                <input type="text" placeholder="Number Phone" class="form-control kanitB">
                                <i class="zmdi zmdi-phone"></i>
                            </div>  
                            <div class="form-wrapper">
                                <textarea name="" id="" cols="30" rows="30" class="form-control kanitB" placeholder="Address . . ."></textarea>   
                                <i class="zmdi zmdi-home"></i>                             
                            </div>
                                                                            
                            <button class="btn_regis">Register
                                <i class="zmdi zmdi-arrow-right"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Features icons -->


    <!-- Footer -->
    <footer class="bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center p-t-45">
                    <p class="text-mired">&copy; Beautiful Salon 2021. All Right Reserved.</p>
                </div>
            </div>
        </div>
    </footer>


    <script src="js/bootstrap.min.js"></script>
    <!-- caledate -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/rome.js"></script>
    <script src="js/main.js"></script>
    <script src="js/main1.js"></script>
    <!-- time picker -->
    <script src="jquery/jquery.timepicker.min.js"></script>
    <script src="jquery/jquery.timepicker.js"></script>
    <!--===============================================================================================-->
    <!-- <script src="vendor/jquery/jquery-3.2.1.min.js"></script> -->
    <!--===============================================================================================-->
    <script src="vendor/animsition/js/animsition.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/bootstrap/js/popper.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/select2/select2.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/daterangepicker/moment.min.js"></script>
    <script src="vendor/daterangepicker/daterangepicker.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/countdowntime/countdowntime.js"></script>
    <!--===============================================================================================-->


    <script>
        $(document).ready(function () {
            $('#startTime').timepicker({
                timeFormat: 'HH:mm',
                interval: 30,
                minTime: '10.30',
                maxTime: '19.00',
                startTime: '10:30',
                dynamic: false,
                dropdown: true,
                scrollbar: true,
            });

            $('#endTime').timepicker({
                timeFormat: 'HH:mm',
                interval: 30,
                minTime: '10.30',
                maxTime: '19.00',
                startTime: '10:30',
                dynamic: false,
                dropdown: true,
                scrollbar: true,
            });
        });

    </script>
</body>

</html>