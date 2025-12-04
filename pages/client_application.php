<!DOCTYPE html>
<html lang="en">

<head>
    <title>Micro Debt | About Us | Welcome</title>
    <!-- Meta tag Keywords -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />
    <meta name="keywords" content="Micro-Lenders Management System, Cashloan System, Customer Application, Loan Management, Namibia, Gestured, Moneyflux, Manfred Shifafure," />
    <script>
        addEventListener("load", function() {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }

    </script>
    <!-- //Meta tag Keywords -->
    <!-- Custom-Files -->
    <link rel="stylesheet" href="..//css/bootstrap.css">
    <!-- Bootstrap-Core-CSS -->
    <link rel="stylesheet" href="..//css/style.css" type="text/css" media="all" />
    <link rel="stylesheet" href="..//css/slider.css" type="text/css" media="all" />
    <!-- Style-CSS -->
    <!-- font-awesome-icons -->
    <link href="css/font-awesome.css" rel="stylesheet">
    <!-- //font-awesome-icons -->
    <!-- /Fonts -->
    <link href="//fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800" rel="stylesheet">

    <!-- //Fonts -->
</head>

<body>
    <!-- mian-content -->
    <div class="main-w3-pvt-header-sec page-w3pvt-inner" id="home">
        <div class="overlay-innerpage">
            <!-- header -->
            <header>
                <div class="container">
                    <div class="header d-lg-flex justify-content-between align-items-center py-lg-3 px-lg-3">
                        <!-- logo -->
                        <div id="logo">
                            <h2><a href="..//index.php"><span class="fa fa-recycle mr-2"></span>Microdbt</a></h2>
                        </div>
                        <!-- //logo -->
                        <div class="w3pvt-bg">
                            <!-- nav -->
                            <div class="nav_w3pvt">
                                <nav>
                                <label for="drop" class="toggle">Menu</label>
                                <input type="checkbox" id="drop" />
                                <ul class="menu">
                                    <li class="active"><a href="..//index.php">Home</a></li>
                                    <li><a href="about.php">About Us</a></li>
                                    <li>
                                        <!-- First Tier Drop Down -->
                                        <label for="drop-2" class="toggle toogle-2">MicroDBT <span class="fa fa-angle-down" aria-hidden="true"></span>
                                        </label>
                                        <a href="#">MicroDBT <span class="fa fa-angle-down" aria-hidden="true"></span></a>
                                        <input type="checkbox" id="drop-2" />
                                        <ul>
                                            <li><a href="#process" class="drop-text">Process</a></li>
                                            <li><a href="#stats" class="drop-text">Statistics</a></li>
                                            <li><a href="#services" class="drop-text">Services</a></li>
                                            <li><a href="about.php" class="drop-text">Our Team</a></li>
                                            <li><a href="#test" class="drop-text">Clients</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="https://microdbt.com/admin/login.php">Login</a></li>
                                    <li><a href="..//contact.php">Contact Us</a></li>
                                </ul>
                            </nav>
                            </div>
                            <!-- //nav -->
                            <div class="justify-content-center">
                                <!-- search -->
                                <div class="apply-w3-pvt ml-lg-3">
                                    <a class="btn read" href="..//contact.php" role="button">Apply Now</a>
                                </div>
                                <!-- //search -->

                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <!-- //header -->
        </div>
    </div>
    
    <section class="about py-md-5 py-5" id="loans">
        <div class="container py-md-5">
            <div class="feature-grids row mt-3">
                <div class="col-lg-6 ab-content-img">
                    <img src="#" alt="" class="img-fluid image1">
                </div>
                    <form>
                        <p class="h4 mb-4">Registration Form</p>
                        <p>By Joing the Micro Debt (Micro-lenders Management System, You are agree to the terms and conditions of use, information sharing as well as well to adhere to the policy of privacy.</p>
                      <div class="form-row">
                          <div class="form-group col-md-6">
                          <label for="inputZip">ID</label>
                          <input type="text" class="form-control" id="inputZip">
                        </div>
                        <div class="form-group col-md-6">
                          <label for="inputEmail4">Email</label>
                          <input type="email" class="form-control" id="inputEmail4" placeholder="Email">
                        </div>
                        <div class="form-group col-md-6">
                          <label for="inputPassword4">Password</label>
                          <input type="password" class="form-control" id="inputPassword4" placeholder="Password">
                        </div>
                          <div class="form-group col-md-6">
                          <label for="inputPassword4">Confirm Password</label>
                          <input type="password" class="form-control" id="inputPassword4" placeholder="Password">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputAddress">Address</label>
                        <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
                      </div>
                      <div class="form-group">
                        <label for="inputAddress2">Address 2</label>
                        <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="inputCity">City</label>
                          <input type="text" class="form-control" id="inputCity">
                        </div>
                        <div class="form-group col-md-4">
                          <label for="inputState">State</label>
                          <select id="inputState" class="form-control">
                            <option selected>Choose...</option>
                            <option>Angola</option>
                              <option>Botswana</option>
                              <option>South Africa</option>
                              <option>Namibia</option>
                              <option>Zambia</option>
                              <option>Zimbabwe</option>
                          </select>
                        </div>
                        <div class="form-group col-md-2">
                          <label for="inputZip">Postal Code</label>
                          <input type="text" class="form-control" id="inputZip">
                        </div>
                      </div>
                      <button type="submit" class="btn btn-primary">Register</button>
                    </form>
                </div>
            </div>
    </section>
    <!-- //features -->
    
    <?php require "footer.php"; ?>