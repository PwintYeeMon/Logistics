<?php 
include('Admin/connect.php');
session_start();
error_reporting(0);

if(isset($_SESSION['customerid']))
{
  $customerid = $_SESSION['customerid'];

  $select1 = "SELECT * FROM customer 
              WHERE customerid = '$customerid'";
  $run1 = mysqli_query($connect, $select1);
  $count1 = mysqli_num_rows($run1);

  if($count1 == 1)
  {
    $array = mysqli_fetch_array($run1);
    $cusname = $array['customername'];
  }
}

$select = "SELECT * FROM freight f, schedule s WHERE f.freightid = s.freightid";
$run = mysqli_query($connect, $select);
$count = mysqli_num_rows($run);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Logistics</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,700,900|Display+Playfair:200,300,400,700"> 
    <link rel="stylesheet" href="fonts/icomoon/style.css">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">

    <link rel="stylesheet" href="css/bootstrap-datepicker.css">

    <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">



    <link rel="stylesheet" href="css/aos.css">

    <link rel="stylesheet" href="css/style.css">
    
  </head>
  <body>
  
  <div class="site-wrap">

    <div class="site-mobile-menu">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
          <span class="icon-close2 js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div>
    
    <header class="site-navbar py-3" role="banner">

      <div class="container">
        <div class="row align-items-center">
          
          <div class="col-11 col-xl-2">
            <h1 class="mb-0"><a href="index.html" class="text-white h2 mb-0">Logistics</a></h1>
          </div>
          <div class="col-12 col-md-10 d-none d-xl-block">
            <nav class="site-navigation position-relative text-right" role="navigation">

              <ul class="site-menu js-clone-nav mx-auto d-none d-lg-block">
                <li><a href="Home.php">Home</a></li>
                <li><a href="About.php">About Us</a></li>
                <li class="has-children active">
                  <a>Services</a>
                  <ul class="dropdown">
                    <li class="active"><a href="ScheduleDisplay.php">Shipping Schedule</a></li>
                    <li><a href="Tracking.php">Tracking</a></li>  
                  </ul>
                </li>
                <li class="has-children">
                  <a>Contact</a>
                  <ul class="dropdown">   
                    <li><a href="Feedback.php">Feedback</a></li>
                    <li><a href="FAQ.php">FAQ</a></li>
                  </ul>
                </li>
                <?php 
                  if ($customerid == '')
                  {
                    echo "<li class='active'><a href='CustomerRegistration.php'>Register</a></li>";
                  }
                  else
                  {
                    echo "
                    <li class='has-children'>
                      <a href='CustomerProfile.php'>Profile</a>
                      <ul class='dropdown'>
                        <li><a href='CustomerProfile.php'>$cusname</a></li>
                        <li><a href='UpdateCustomer.php'>Update Profile</a></li>
                        <li><a href='ChangePassword.php'>Change Password</a></li>
                        <li><a href='Logout.php'>Logout</a></li>
                        <li><a href='OrderDisplay.php'>Orders</a></li>
                      </ul>
                    </li>";
                  }
                 ?>
              </ul>
            </nav>
          </div>


          <div class="d-inline-block d-xl-none ml-md-0 mr-auto py-3" style="position: relative; top: 3px;"><a href="#" class="site-menu-toggle js-menu-toggle text-white"><span class="icon-menu h3"></span></a></div>

          </div>

        </div>
      </div>
      
    </header>
    <div class="site-blocks-cover inner-page-cover overlay" style="background-image: url(images/hero_bg_1.jpg);" data-aos="fade" data-stellar-background-ratio="0.5">
      <div class="container">
        <div class="row align-items-center justify-content-center text-center">

          <div class="col-md-8" data-aos="fade-up" data-aos-delay="400">
            <h1 class="text-white font-weight-light text-uppercase font-weight-bold">Schedule</h1>
            <p class="breadcrumb-custom"><a href="index.html">Services</a> <span class="mx-2">&gt;</span> <span>Shipping Schedule</span></p>
          </div>
        </div>
      </div>
    </div> 
    <div class="site-section bg-light">
      <div class="container">
        <div class="row">
          <div class="col-md-12">

            <form action=" " class="p-5 bg-white">
              <div class="row form-group">                
                <div class="col-md-12">
                  <h3 style="text-align:center;">Schedule</h3>
                  <table style="width:100%; text-align:center;">
                    <hr>
                      <?php 
                      if ($count == 0) 
                      {
                        echo "<td colspan='7'>No schedule available yet.</td>";
                      }
                      else
                      {
                        echo "
                        <tr>
                          <th style='padding:0px 10px 15px 10px;'>No</th>
                          <th style='padding:0px 10px 15px 10px;'>Freight</th>
                          <th style='padding:0px 10px 15px 10px;'>Departure Date</th>
                          <th style='padding:0px 10px 15px 10px;'>Arrival Date</th>
                          <th style='padding:0px 10px 15px 10px;'>From</th>
                          <th style='padding:0px 10px 15px 10px;'>To</th>
                          <th style='padding:0px 10px 15px 10px;'>Price per kg</th>
                          <th style='padding:0px 10px 15px 10px;'></th>
                        <tr>
                        ";
                        for ($i=0; $i < $count; $i++) 
                        { 
                          $data = mysqli_fetch_array($run);
                          $scheduleid = $data['scheduleid'];
                          $freight = $data['freighttype'];
                          $departuredate = $data['departuredate'];
                          $arrivaldate = $data['arrivaldate'];
                          $from = $data['country'];
                          $to = $data['destination'];
                          $price = $data['price'];
                      
                          echo"
                          <tr>
                            <td>$scheduleid</td>
                            <td>$freight</td>
                            <td>$departuredate</td>
                            <td>$arrivaldate</td>
                            <td>$from</td>
                            <td>$to</td>
                            <td style='color:red;'><b>$price </b>$</td>
                            <td>

                          <a href='Item.php?scheduleid=$scheduleid' class='btn btn-primary py-2 px-3 text-white' style='border-radius:12px; margin-bottom:10px;'>Order</a></td><tr>";
                        }
                      } ?>
                     
                  </table><hr>
                </div>
              </div>

            </form>
            
          </div>
        </div>
      </div>
    </div>
    
    <footer class="site-footer">
      <div class="container">
        <div class="row">
          <div class="col-md-9">
            <div class="row">>
              <div class="col-md-3">
                <h2 class="footer-heading mb-4">Quick Links</h2>
                <ul class="list-unstyled">
                  <li><a href="Home.php">Home</a></li>
                  <li><a href="About.php">About Us</a></li>
                  <li><a href="ScheduleDisplay.php">Schedule</a></li>
                  <li><a href="FAQ.php">FAQ</a></li>
                </ul>
              </div>
              <div class="col-md-3">
                <h2 class="footer-heading mb-4">Follow Us</h2>
                <a href="https://www.facebook.com" class="pl-0 pr-3"><span class="icon-facebook"></span></a>
                <a href="https://www.twitter.com" class="pl-3 pr-3"><span class="icon-twitter"></span></a>
                <a href="https://www.instagram.com" class="pl-3 pr-3"><span class="icon-instagram"></span></a>
                <a href="https://www.linkedin.com" class="pl-3 pr-3"><span class="icon-linkedin"></span></a>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <h2 class="footer-heading mb-4">Subscribe Newsletter</h2>
            <form action="#" method="post">
              <div class="input-group mb-3">
                <input type="text" class="form-control border-secondary text-white bg-transparent" placeholder="Enter Email" aria-label="Enter Email" aria-describedby="button-addon2">
                <div class="input-group-append">
                  <button class="btn btn-primary text-white" type="button" id="button-addon2">Send</button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-md-12" style="text-align:center; color:grey;">
            <hr>Copyright &copy; 2021. LOGISTICS Shipping and Delivery. All rights served. <hr>
          </div>
        </div>
      </div>
    </footer>
  </div>

  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/jquery.countdown.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/bootstrap-datepicker.min.js"></script>
  <script src="js/aos.js"></script>

  <script src="js/main.js"></script>
    
  </body>
</html>