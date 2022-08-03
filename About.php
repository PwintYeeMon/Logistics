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
?>
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
                <li class="active"><a href="About.php">About Us</a></li>
                <li class="has-children">
                  <a>Services</a>
                  <ul class="dropdown">
                    <li><a href="ScheduleDisplay.php">Shipping Schedule</a></li>
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
            <h1 class="text-white font-weight-light text-uppercase font-weight-bold">About Us</h1>
            <p class="breadcrumb-custom"><a href="index.html">Home</a> <span class="mx-2">&gt;</span> <span>About Us</span></p>
          </div>
        </div>
      </div>
    </div>  

    

    <div class="site-section">
      <div class="container">
        <div class="row mb-5">
          
          <div class="col-md-5 ml-auto mb-5 order-md-2" data-aos="fade">
            <img src="images/img_1.jpg" alt="Image" class="img-fluid rounded">
          </div>
          <div class="col-md-6 order-md-1" data-aos="fade">
            <div class="text-left pb-1 border-primary mb-4">
              <h2 class="text-primary">Our History</h2>
            </div>
            <p>Logistics shipping and delivery company has been progressing since the early years of twenty-first century and both the scope and size of the company has been improving. </p>
            <p class="mb-5">Our company has two branches in the United Kingdom and Myanmar and provides shipping and delivery service throughout the world. The shipment can be done via air, ocean or road and rail. </p>

            <div class="row">
              <div class="col-md-12 mb-md-5 mb-0 col-lg-6">
                <div class="unit-4">
                  <div class="unit-4-icon mb-3 mr-4"><span class="text-primary flaticon-frontal-truck"></span></div>
                  <div>
                    <h3>Road Shipping</h3>
                    <p>Road Freight is the physical process of transporting cargo by road using motor vehicles.</p>
                  </div>
                </div>
              </div>
              <div class="col-md-12 mb-md-5 mb-0 col-lg-6">
                <div class="unit-4">
                  <div class="unit-4-icon mb-3 mr-4"><span class="text-primary flaticon-travel"></span></div>
                  <div>
                    <h3>Air Freight</h3>
                    <p>Air freight is another term for air cargo that is, the shipment of goods through an air carrier.</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
        </div>
      </div>
    </div>
  
    <div class="site-section bg-image overlay" style="background-image: url('images/hero_bg_4.jpg');">
      <div class="container">
        <div class="row justify-content-center mb-5">
          <div class="col-md-7 text-center border-primary">
            <h2 class="font-weight-light text-primary" data-aos="fade">How It Works</h2>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 col-lg-4 mb-5 mb-lg-0" data-aos="fade" data-aos-delay="100">
            <div class="how-it-work-item">
              <span class="number">1</span>
              <div class="how-it-work-body">
                <h2>Choose Your Service</h2>
                <p class="mb-5">Enter the type of the items and the weight of them before delivering and the cost and prices differ due to the time taken to deliver and the type of transportation.<br>Get EXTRA SERVICE for one of the following.</p>
                <ul class="ul-check list-unstyled white">
                  <li class="text-white">Packaging</li>
                  <li class="text-white">Insurance and </li>
                  <li class="text-white">Express Delivery (Urgent/Fastest form of Shipping)</li>
                </ul>
              </div>
            </div>
          </div>

          <div class="col-md-6 col-lg-4 mb-5 mb-lg-0" data-aos="fade" data-aos-delay="200">
            <div class="how-it-work-item">
              <span class="number">2</span>
              <div class="how-it-work-body">
                <h2>Select Your Payment</h2>
                <p class="mb-5">Payment can be done by credit card. After confirming the money received, the customer will be given a receipt voucher which includes the tracking number.</p>
                <ul class="ul-check list-unstyled white">
                  <li class="text-white">VISA</li>
                  <li class="text-white">AMERICA EXPRESS</li>
                  <li class="text-white">DISCOVER</li>
                  <li class="text-white">MasterCard</li>
                </ul>
              </div>
            </div>
          </div>

          <div class="col-md-6 col-lg-4 mb-5 mb-lg-0" data-aos="fade" data-aos-delay="300">
            <div class="how-it-work-item">
              <span class="number">3</span>
              <div class="how-it-work-body">
                <h2>Track Your Order</h2>
                <p class="mb-5">Tracking will always be informed. This information can be checked anytime by using the tracking number.<br> <br>Always get to know IF ~</p>
                <ul class="ul-check list-unstyled white">
                  <li class="text-white">The shipment has started</li>
                  <li class="text-white">The shipment is still on the way</li>
                  <li class="text-white">The shipment has arrived</li>
                </ul>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

    <div class="site-section border-bottom">
      <div class="container">
        <div class="row justify-content-center mb-5">
          <div class="col-md-7 text-center border-primary">
            <h2 class="font-weight-light text-primary" data-aos="fade">Our Team</h2>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 col-lg-4 mb-5 mb-lg-0" data-aos="fade" data-aos-delay="100">
            <div class="person">
              <img src="images/person_2.jpg" alt="Image" class="img-fluid rounded mb-5">
              <h3>Christine Rooster</h3>
              <p class="position text-muted">Co-Founder, CEO</p>
              <ul class="ul-social-circle">
                <li><a href="https://www.facebook.com"><span class="icon-facebook"></span></a></li>
                <li><a href="https://www.twitter.com"><span class="icon-twitter"></span></a></li>
                <li><a href="https://www.linkedin.com"><span class="icon-linkedin"></span></a></li>
                <li><a href="https://www.instagram.com"><span class="icon-instagram"></span></a></li>
              </ul>
            </div>
          </div>
          <div class="col-md-6 col-lg-4 mb-5 mb-lg-0" data-aos="fade" data-aos-delay="200">
            <div class="person">
              <img src="images/person_3.jpg" alt="Image" class="img-fluid rounded mb-5">
              <h3>Brandon Sharp</h3>
              <p class="position text-muted">Co-Founder, COO</p>
              <ul class="ul-social-circle">
                <li><a href="https://www.facebook.com"><span class="icon-facebook"></span></a></li>
                <li><a href="https://www.twitter.com"><span class="icon-twitter"></span></a></li>
                <li><a href="https://www.linkedin.com"><span class="icon-linkedin"></span></a></li>
                <li><a href="https://www.instagram.com"><span class="icon-instagram"></span></a></li>
              </ul>
            </div>
          </div>
          <div class="col-md-6 col-lg-4 mb-5 mb-lg-0" data-aos="fade" data-aos-delay="300">
            <div class="person">
              <img src="images/person_4.jpg" alt="Image" class="img-fluid rounded mb-5">
              <h3>Connor Hodson</h3>
              <p class="position text-muted">Marketing</p>
              <ul class="ul-social-circle">
                <li><a href="https://www.facebook.com"><span class="icon-facebook"></span></a></li>
                <li><a href="https://www.twitter.com"><span class="icon-twitter"></span></a></li>
                <li><a href="https://www.linkedin.com"><span class="icon-linkedin"></span></a></li>
                <li><a href="https://www.instagram.com"><span class="icon-instagram"></span></a></li>
              </ul>
            </div>
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