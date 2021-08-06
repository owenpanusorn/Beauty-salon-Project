class Header extends HTMLElement {
    connectedCallback() {
        this.innerHTML =
            `
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
                                <a href="#" class="nav-link active" aria-current="page">Home</a>
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
        
                                                                        <a href="signup.html" class="txt2">
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
             `
    }
}

class Footer extends HTMLElement {
    connectedCallback() {
        this.innerHTML =
            `
        <footer class="bg-light">
             <div class="container">
                 <div class="row">
                     <div class="col-12 text-center mt-5">
                         <p class="text-mired">&copy; Beautiful Salon 2021. All Right Reserved.</p>
                    </div>
              </div>
            </div>
         </footer>
        `
    }
}

customElements.define('main-menubar', Header);
customElements.define('main-footer', Footer);