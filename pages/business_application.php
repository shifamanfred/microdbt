<?php
include "../config/db_connect.php";

if (isset($_POST['submit'])) {

    $business_name = $_POST['business_name'];
    $owner_fullname = $_POST['owner_fullname'];
    $registration_number = $_POST['registration_number'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $office_address = $_POST['office_address'];
    $postal_address = $_POST['postal_address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $postal_code = $_POST['postal_code'];

    $sql = "INSERT INTO business_applications 
           (business_name, owner_fullname, registration_number, email, password,
            office_address, postal_address, city, state, postal_code)
           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($connect, $sql);

    mysqli_stmt_bind_param(
        $stmt, "ssssssssss",
        $business_name, $owner_fullname, $registration_number,
        $email, $password, $office_address, $postal_address,
        $city, $state, $postal_code
    );

    if (mysqli_stmt_execute($stmt)) {
        echo "<div class='alert alert-success'>Application submitted successfully.</div>";
    } else {
        echo "<div class='alert alert-danger'>Failed to submit application.</div>";
    }
}
?>

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
                                    <li><a href="..//about.php">About Us</a></li>
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
            <div class="feature-grids row mt-8">
                <div class="col-lg-6 ab-content-img">
                    <img src="#" alt="" class="img-fluid image1">
                </div>
                            <form method="POST" action="business_application.php">
  <p class="h4 mb-4">A Business Application Form</p>

  <div class="form-row">
    <div class="form-group col-md-6">
      <label>Registered Business Name</label>
      <input type="text" class="form-control" name="business_name">
    </div>

    <div class="form-group col-md-6">
      <label>Owner's Full Names</label>
      <input type="text" class="form-control" name="owner_fullname">
    </div>

    <div class="form-group col-md-6">
      <label>Business Registration Number</label>
      <input type="text" class="form-control" name="registration_number">
    </div>

    <div class="form-group col-md-6">
      <label>Email</label>
      <input type="email" class="form-control" name="email">
    </div>

    <div class="form-group col-md-6">
      <label>Password</label>
      <input type="password" class="form-control" name="password">
    </div>

    <div class="form-group col-md-6">
      <label>Confirm Password</label>
      <input type="password" class="form-control" name="confirm_password">
    </div>
  </div>

  <div class="form-group">
    <label>Office Address</label>
    <input type="text" class="form-control" name="office_address">
  </div>

  <div class="form-group">
    <label>Postal Address</label>
    <input type="text" class="form-control" name="postal_address">
  </div>

  <div class="form-row">
    <div class="form-group col-md-6">
      <label>City</label>
      <input type="text" class="form-control" name="city">
    </div>

    <div class="form-group col-md-4">
      <label>State</label>
      <select class="form-control" name="state">
        <option>Angola</option>
        <option>Botswana</option>
        <option>South Africa</option>
        <option>Namibia</option>
        <option>Zambia</option>
        <option>Zimbabwe</option>
      </select>
    </div>

    <div class="form-group col-md-2">
      <label>Postal Code</label>
      <input type="text" class="form-control" name="postal_code">
    </div>
  </div>

  <button type="submit" name="submit" class="btn btn-primary">Register</button>
</form>

                </div>
            </div>
    </section>
    <!-- //features -->
    
    <?php require "footer.php"; ?>