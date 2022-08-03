<?php 
include('Admin/connect.php');
session_start();

if(isset($_SESSION['customerid']))
{
  $customerid = $_SESSION['customerid'];

  $selectname = "SELECT customername FROM customer WHERE customerid = '$customerid'";
  $runname = mysqli_query($connect, $selectname);
  $arrayname = mysqli_fetch_array($runname);
  $cusname = $arrayname['customername'];
}
else
{
  echo "<script>window.alert('Please Login First')</script>";
  echo "<script>window.location='CustomerLogin.php'</script>";
}

if(isset($_SESSION['trackingid']))
{
  $_SESSION['trackingid'] = '';
}

if(isset($_SESSION['orderid']))
{
  $orderid = $_SESSION['orderid'];
}


if(isset($_POST['btncontinue']))
{
  $name = $_POST['txtname'];
  $card = $_POST['txtcard'];
  $month = $_POST['txtmonth'];
  $year = $_POST['txtyear'];
  $cvv = $_POST['txtcvv'];
  $status = "PENDING";

  $insert = "INSERT INTO payment(orderid, nameoncard, cardno, expmonth, expyear, cvv, checkstatus)
      VALUES ('$orderid', '$name', '$card','$month', '$year', '$cvv', '$status')";
  $run = mysqli_query($connect, $insert);

  echo "<script>window.alert('Payment Successful')</script>";
  echo "<script>window.location='TrackingDetail.php'</script>";
}
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
                <li class="has-children">
                  <a href="CustomerProfile.php">Profile</a>
                  <ul class="dropdown">
                    <li><a href="CustomerProfile.php"><?php echo $cusname ?></a></li>
                    <li><a href="UpdateCustomer.php">Update Profile</a></li>
                    <li><a href="ChangePassword.php">Change Password</a></li>
                    <li><a href="Logout.php">Logout</a></li>
                    <li><a href='OrderDisplay.php'>Orders</a></li>
                  </ul>
                </li>
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
            <h1 class="text-white font-weight-light text-uppercase font-weight-bold">Payment</h1>
            <p class="breadcrumb-custom"><a href="index.html">Services</a> <span class="mx-2">&gt;</span> 
              <a href="ScheduleDisplay.php">Shipping Schedule</a> <span class="mx-2">&gt;</span> 
              <a href="Item.php">Item</a> <span class="mx-2">&gt;</span> <a href="Recipient.php">Recipient</a> 
              <span class="mx-2">&gt;</span> <span>Payment</span></p>
          </div>
        </div>
      </div>
    </div>  

    
    <div class="site-section bg-light">
      <div class="container">
        <div class="row">
          <div class="col-md-7 mb-5">

            <form action="Payment.php" class="p-5 bg-white" method="POST">
              <h1>Payment</h1>

              <div class="row form-group">                
                <div class="col-md-12">
                  <label class="text-black">Accepted Cards</label> 
                  <div>
                    <img src="images/visa.svg" alt="Visa" width="50px" height="50px" title="VISA">
                    <img src="images/american-express.svg" alt="Amex" width="50px" height="50px" title="AMERICAN EXPRESS">
                    <img src="images/discover.svg" alt="Disc" width="50px" height="50px" title="DISCOVER">
                    <img src="images/master-card.svg" alt="Master" width="50px" height="50px" title="MasterCard">
                  </div>
                </div>
              </div>

              <div class="row form-group">                
                <div class="col-md-12">
                  <label class="text-black">Name on Card</label> 
                  <input type="text" class="form-control" name="txtname" required>
                </div>
              </div>

              <div class="row form-group">                
                <div class="col-md-12">
                  <label class="text-black">Credit Card Number</label>
                  <input type="text" class="form-control" maxlength="19" name="txtcard" pattern="[0-9\s]{13,19}" placeholder = "eg. 1111 2222 3333 4444" required>
                </div>
              </div>

              <div class="row form-group">
                <div class="col-md-6 mb-3 mb-md-0">
                  <label class="text-black">Expire Month</label>
                  <select name="txtmonth" class="form-control" required>
                    <option value="" disabled selected hidden>Choose Month</option>
                    <option value="Janauary">Janauary</option>
                    <option value="February">February</option>
                    <option value="March">March</option>
                    <option value="April">April</option>
                    <option value="May">May</option>
                    <option value="June">June</option>
                    <option value="July">July</option>
                    <option value="August">August</option>
                    <option value="September">September</option>
                    <option value="October">October</option>
                    <option value="November">November</option>
                    <option value="December">December</option>
                  </select>
                </div>
                <div class="col-md-6">
                  <label class="text-black">Expire Year</label>
                  <input type="number" class="form-control" name="txtyear" placeholder = "eg. 2020" min="2021" max="2030" required>
                </div>
              </div>

              <div class="row form-group">                
                <div class="col-md-12">
                  <label class="text-black">Card Verification Value (CVV)</label> 
                  <input type="text" class="form-control" name="txtcvv" placeholder = "eg. 111" pattern="[0-9]{3,}" maxlength="3" required>
                </div>
              </div>

              <div class="row form-group">
                <div class="col-md-12">
                  <input type="submit" value="Continue" name = "btncontinue" class="btn btn-primary py-2 px-4 text-white">
                  <input type="reset" value="Cancel" class="btn btn-primary py-2 px-4 text-black" style="background-color:#e9ebee;">
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