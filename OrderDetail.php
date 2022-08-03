<?php
include('Admin/connect.php');
session_start();
if(isset($_SESSION['customerid']))
{
  $customerid = $_SESSION['customerid'];

  $select1 = "SELECT * FROM customer 
              WHERE customerid = '$customerid'";
  $run1 = mysqli_query($connect, $select1);
  $count1 = mysqli_num_rows($run1);

  if($count1 == 1)
  {
    $arraycustomer = mysqli_fetch_array($run1);
    $cusname = $arraycustomer['customername'];
  }
}
if(isset($_GET['orderid']))
{
  $_SESSION['orderid'] = $_GET['orderid'];
}
if(isset($_GET['itemid']))
{
  $_SESSION['itemid'] = $_GET['itemid'];
}
else
{
  $_SESSION['itemid'] = '';
}
if(isset($_SESSION['orderid']))
{
  $orderid = $_SESSION['orderid'];
  
  if(isset($_SESSION['itemid']) && $_SESSION['itemid'] != '')
  {
    $itemid = $_SESSION['itemid'];
    $select = "SELECT * FROM item i, freight f, ordertbl o, recipient r, schedule s 
              WHERE f.freightid = s.freightid AND s.scheduleid = o.scheduleid AND o.orderid = i.orderid 
              AND i.recipientid = r.recipientid AND o.orderid = '$orderid' AND i.itemid = '$itemid'";
    $run = mysqli_query($connect, $select);
    $count = mysqli_num_rows($run);

    if($count == 1)
    {
      $array = mysqli_fetch_array($run);
    }
  }
  else
  {
    $select = "SELECT * FROM item i, freight f, ordertbl o, recipient r, schedule s 
              WHERE f.freightid = s.freightid AND s.scheduleid = o.scheduleid AND o.orderid = i.orderid 
              AND i.recipientid = r.recipientid AND o.orderid = '$orderid'";
    $run = mysqli_query($connect, $select);
    $count = mysqli_num_rows($run);

    if($count == 1)
    {
      $array = mysqli_fetch_array($run);
    }
  }
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
    
    <header class="site-navbar py-3" role="banner" style="background-image: url(images/header.png);">

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
                <li class="has-children active">
                  <a href="CustomerProfile.php">Profile</a>
                  <ul class="dropdown">
                    <li><a href="CustomerProfile.php"><?php echo $cusname ?></a></li>
                    <li><a href="UpdateCustomer.php">Update Profile</a></li>
                    <li><a href="ChangePassword.php">Change Password</a></li>
                    <li><a href="Logout.php">Logout</a></li>
                    <li class="active"><a href='OrderDisplay.php'>Orders</a></li>
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
    <div style="padding-top:100px;"></div>

    <div class="site-section bg-light">
      <div class="container">
        <div class="row">
          <div class="col-md-6 mb-5">

            <form action=" " class="p-5 bg-white" method="POST">
             
              <h3>Order</h3>
              <br>
              <div class="row form-group">
                
                <div class="col-md-12">
                  <label class="text-black">Tracking Number</label>
                  <input type="text" class="form-control" value="<?php 
                    if($array['trackingid'] != '')
                    {
                      echo $array['trackingid'];
                    }
                    else
                    {
                      echo "*will be shown after payment is done*";
                    } 
                  ?>" readonly> 
                </div>
              </div>
              <div class="row form-group">
                <div class="col-md-6 mb-3 mb-md-0">
                  <label class="text-black">Price ($)</label>
                  <input type="number" class="form-control" value="<?php echo $array['itemprice']; ?>" readonly>
                </div>
                
                <div class="col-md-6">
                  <label class="text-black">Date</label> 
                  <input type="text" class="form-control" value="<?php echo $array['orderdate']; ?>" readonly>
                </div>
              </div>
              <div class="row form-group">
                
                <div class="col-md-12">
                  <label class="text-black">Order Status</label> 
                  <input type="text" class="form-control" value="<?php echo $array['status']; ?>" readonly>
                </div>
              </div>
            </form>
            <br>
            <form action=" " class="p-5 bg-white" method="POST">
             
              <h3>Item</h3>
              <br>
              
              <div class="row form-group">
                
                <div class="col-md-4  mb-3 mb-md-0">
                  <label class="text-black">Item Type :</label>
                </div>
                <div class="col-md-4">
                  <input type="text" class="form-control" value="<?php echo $array['itemtype1']; ?>" readonly>
                </div>
                <div class="col-md-4">
                  <input type="text" class="form-control" value="<?php echo $array['itemtype2']; ?>" readonly>
                </div>
              </div>

              <div class="row form-group">
                
                <div class="col-md-12">
                  <label class="text-black">Weight (kg)</label> 
                  <input type="text" class="form-control" value="<?php echo $array['weight']; ?>" readonly>
                </div>
              </div>

              <div class="row form-group">
                <div class="col-md-4 mb-3 mb-md-0">
                  <label class="text-black">Length (cm)</label>
                  <input type="text" class="form-control" value="<?php echo $array['length']; ?>" readonly>
                </div>
                <div class="col-md-4">
                  <label class="text-black">Width (cm)</label>
                  <input type="text" class="form-control" value="<?php echo $array['width']; ?>" readonly>
                </div>
                <div class="col-md-4">
                  <label class="text-black">Height (cm)</label>
                  <input type="text" class="form-control" value="<?php echo $array['height']; ?>" readonly>
                </div>
              </div>

              <div class="row form-group">
                <div class="col-md-12 mb-3 mb-md-0">
                  <label class="text-black">Extra Service</label>
                  <input type="text" class="form-control" value="<?php echo $array['extraservice']; ?>" readonly>
                </div>
              </div>

            </form>
          </div>

          <div class="col-md-6">
            
            <form action=" " class="p-5 bg-white" method="POST">
              
              <h3>Recipient</h3>
              <div class="row form-group">
                
                <div class="col-md-12">
                  <label class="text-black">Name</label> 
                  <input type="text" class="form-control" value="<?php echo $array['recipientname']; ?>" readonly>
                </div>
              </div>

              <div class="row form-group">
                <div class="col-md-12 mb-3 mb-md-0">
                  <label class="text-black">Phone Number</label>
                  <input type="text" class="form-control" value="<?php echo $array['phoneno']; ?>" readonly>
                </div>
              </div>

              <div class="row form-group">
                <div class="col-md-12 mb-3 mb-md-0">
                  <label class="text-black">Email</label>
                  <input type="text" class="form-control" value="<?php echo $array['email']; ?>" readonly>
                </div>
              </div>

              <div class="row form-group">
                
                <div class="col-md-12">
                  <label class="text-black">Address</label> 
                  <textarea class="form-control" readonly><?php echo $array['address1'].", ".$array['address2'].", ".$array['city'].", ".$array['state'].", ".$array['postcode'].", ".$array['destination']; ?> 
                  </textarea>
                </div>
              </div>
            </form>
            <br>           
            <form action=" " class="p-5 bg-white" method="POST">              
              <h3>Freight</h3>
              <div class="row form-group">
                <div class="col-md-6 mb-3 mb-md-0">
                  <label class="text-black">Freight Type</label>
                  <input type="text" class="form-control" value="<?php echo $array['freighttype']; ?>" readonly>
                </div>
                
                <div class="col-md-6">
                  <label class="text-black">Duration</label> 
                  <input type="text" class="form-control" value="<?php echo $array['duration']; ?>" readonly>
                </div>
              </div>

              <div class="row form-group">
                <div class="col-md-6 mb-3 mb-md-0">
                  <label class="text-black">Departure Date</label>
                  <input type="date" class="form-control" value="<?php echo $array['departuredate']; ?>" readonly>
                </div>
                
                <div class="col-md-6">
                  <label class="text-black">Arrival Date</label> 
                  <input type="date" class="form-control" value="<?php echo $array['arrivaldate']; ?>" readonly>
                </div>
              </div>

              <div class="row form-group">
                <div class="col-md-6 mb-3 mb-md-0">
                  <label class="text-black">From</label>
                  <input type="text" class="form-control" value="<?php echo $array['country']; ?>" readonly>
                </div>
                
                <div class="col-md-6">
                  <label class="text-black">To</label> 
                  <input type="text" class="form-control" value="<?php echo $array['destination']; ?>" readonly>
                </div>
              </div>              
            </form>
        
          </div>
          <?php 
          if($array['trackingid'] == '')
          {
            if(!isset($_SESSION['itemid']) || $_SESSION['itemid'] = '')
            {
              $select = "SELECT i.itemid FROM item i, freight f, ordertbl o, recipient r, schedule s 
                        WHERE f.freightid = s.freightid AND s.scheduleid = o.scheduleid AND o.orderid = i.orderid 
                        AND i.recipientid = r.recipientid AND o.orderid = '$orderid'";
              $run = mysqli_query($connect, $select);
              $arrayitem = mysqli_fetch_array($run);
              $_SESSION['itemid'] = $arrayitem['itemid'];
            }   
                        
            echo "<div class='row form-group'>
                    <div class='col-md-12'>
                      <a href='Payment.php' class='btn btn-primary py-2 px-4 text-white'>Checkout</a> 
                      <a href='Item.php' class='btn btn-primary py-2 px-4 text-white'>Continue</a>                     
                    </div>
                  </div>";
          }
          else
          {
            $_SESSION['trackingid'] = $array['trackingid'];
            echo "<div class='row form-group'>
                    <div class='col-md-12'>
                      <a href='TrackingDetail.php' class='btn btn-primary py-2 px-4 text-white'>Tracking</a>&nbsp";
            if(isset($_GET['itemid']))
            {
              echo "<a href='Order.php?orderid=$orderid&itemid=$itemid' class='btn btn-primary py-2 px-4 text-white'>Back</a>";
            }         
            else 
            {
              echo "<a href='OrderDisplay.php' class='btn btn-primary py-2 px-4 text-white'>Back</a>";
            }     
            echo "</div>
                  </div>"; 
          }
          ?>
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