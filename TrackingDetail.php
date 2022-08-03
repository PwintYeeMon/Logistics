<?php 
include('Admin/connect.php');
error_reporting(0);
session_start();
if(isset($_SESSION['customerid']))
{
  $customerid = $_SESSION['customerid'];

  $selectname = "SELECT customerid, customername FROM customer WHERE customerid = '$customerid'";
  $runname = mysqli_query($connect, $selectname);
  $arrayname = mysqli_fetch_array($runname);
  $customername = $arrayname['customername'];
  $customerid = $arrayname['customerid'];
}

function AutoID($tableName,$fieldName,$prefix,$noOfLeadingZeros)
{
  $connection=mysqli_connect('localhost','root','','shippingdb');

  $newID="";
  $sql="";
  $value=1;
  
  $sql="SELECT " . $fieldName . " FROM " . $tableName . " ORDER BY " . $fieldName . " DESC";  
  
  $result = mysqli_query($connection,$sql);
  $noOfRow=mysqli_num_rows($result);
  $row = mysqli_fetch_array($result);   
  
  if ($noOfRow<1)
  {   
    return $prefix . "000001";
  }
  else
  {
    $oldID=$row[$fieldName];  //Reading Last ID
    $oldID=str_replace($prefix,"",$oldID);  //Removing "Prefix"
    $value=(int)$oldID; //Convert to Integer
    $value++; //Increment   
    $newID=$prefix . NumberFormatter($value,$noOfLeadingZeros);     
    return $newID;    
  }
}
function NumberFormatter($number,$n) 
{ 
  return str_pad((int) $number,$n,"0",STR_PAD_LEFT);
}

if(!isset($_SESSION['trackingid']) || $_SESSION['trackingid'] == '')
{
  $orderid = $_SESSION['orderid'];

  $selectitem = "SELECT itemid FROM item WHERE orderid = '$orderid'";
  $runitem = mysqli_query($connect, $selectitem);
  $countitem = mysqli_num_rows($runitem);

  for ($i=0; $i < $countitem; $i++) 
  { 
    $arrayitem = mysqli_fetch_array($runitem);
    $itemid = $arrayitem['itemid'];

    $select = "SELECT * FROM item i, freight f, ordertbl o, recipient r, schedule s
            WHERE f.freightid = s.freightid AND s.scheduleid = o.scheduleid AND o.orderid = i.orderid 
            AND i.recipientid = r.recipientid AND o.orderid = '$orderid' AND i.itemid = '$itemid'";
    $run = mysqli_query($connect, $select);
    $array = mysqli_fetch_array($run);

    $trackingid = AutoID('tracking','trackingid','TRK-',6);
    $departuredate = $array['departuredate'];
    $arrivaldate = $array['arrivaldate'];
    $customerid = $_SESSION['customerid'];

    $insert = "INSERT INTO tracking (trackingid, departuredate, arrivaldate, customerid)
                VALUES ('$trackingid', '$departuredate', '$arrivaldate', '$customerid')";
    $runinsert = mysqli_query($connect,$insert);

    $update = "UPDATE item SET trackingid = '$trackingid' 
                WHERE itemid = '$itemid'";
    $runupdate = mysqli_query($connect,$update);
  }  

  $_SESSION['trackingid'] = $trackingid;  
}  

if(isset($_SESSION['trackingid']))
{
  $trackingid = $_SESSION['trackingid'];

  $date = date("Y-m-d");

  $select = "SELECT * FROM tracking
            WHERE trackingid = '$trackingid'";
  $run = mysqli_query($connect, $select);
  $array = mysqli_fetch_array($run);

  if($date < $array['departuredate'])
  {
    $status = "Your order will be shipped as scheduled.";
    $update1 = "UPDATE tracking SET description = '$status' 
                WHERE trackingid = '$trackingid'";
    $runupdate1 = mysqli_query($connect,$update1);
  }
  elseif($date == $array['departuredate'])
  {
    $status = "Your order has started shipping.";
    $update1 = "UPDATE tracking SET description = '$status' 
                WHERE trackingid = '$trackingid'";
    $runupdate1 = mysqli_query($connect,$update1);
  }
  elseif($date > $array['departuredate'] && $date < $array['arrivaldate'])
  {
    $status = "Your order is on the way.";
    $update1 = "UPDATE tracking SET description = '$status' 
                WHERE trackingid = '$trackingid'";
    $runupdate1 = mysqli_query($connect,$update1);
  }
  elseif($date >= $array['arrivaldate'])
  {
    $status = "Your shipping order has arrived.";
    $update1 = "UPDATE tracking SET description = '$status' 
                WHERE trackingid = '$trackingid'";
    $runupdate1 = mysqli_query($connect,$update1);
  }

  $selecttracking = "SELECT * FROM tracking t, ordertbl o, item i, recipient r
                      WHERE t.trackingid = i.trackingid AND o.orderid = i.orderid 
                      AND i.recipientid = r.recipientid AND t.trackingid = '$trackingid'
                      AND o.customerid = '$customerid'";
  $runtracking = mysqli_query($connect, $selecttracking);
  $counttracking = mysqli_num_rows($runtracking);

  if($counttracking == 1)
  {
    $arraytracking = mysqli_fetch_array($runtracking);
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
                <li class="has-children active">
                  <a>Services</a>
                  <ul class="dropdown">
                    <li><a href="ScheduleDisplay.php">Shipping Schedule</a></li>
                    <li class="active"><a href="Tracking.php">Tracking</a></li>
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
                    <li><a href="CustomerProfile.php"><?php echo $customername; ?></a></li>
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
    <div style="padding-top:50px;"></div>  
    <div class="site-section bg-light">
      <div class="container">
        <div class="row">
          <div class="col-md-12">

            <form action=" " class="p-5 bg-white">
              <div class="row form-group">                
                <div class="col-md-12" style="text-align:center;">
                  <?php 
                    if($counttracking == 0)
                    {
                      echo "<hr>Tracking Number is wrong. Please <a href='Tracking.php'>Try Again</a>.<hr>";
                    }
                    else
                    {
                   ?>

                  <h3 style="color:#f89d13;">Thanks for your order!</h3>
                  <br>
                  <p>Thank you for shipping with LOGISTICS. Your order details are shown below for your preference.</p>
                  <hr>
                  <br>
                    <h4 style="color:#f89d13;">Tracking Information</h4>
                    <br>
                    <table style="width:100%; text-align:center;">
                      <tr>
                        <th style='padding:0px 20px 15px 20px;'>Tracking Number</th>
                        <th style='padding:0px 20px 15px 20px;'>Departure Date</th>
                        <th style='padding:0px 20px 15px 20px;'>Arrival Date</th>
                        <th style='padding:0px 20px 15px 20px;'>Status</th>
                      </tr>
                      <tr>
                        <td><?php echo $arraytracking['trackingid']; ?></td>
                        <td><?php echo $arraytracking['departuredate']; ?></td>
                        <td><?php echo $arraytracking['arrivaldate']; ?></td>
                        <td style="color:blue;"><?php echo $arraytracking['description']; ?></td>
                      </tr>
                    </table>
                    <br>
                    <hr>
                    <br>
                    <h4 style="color:#f89d13;">Order Detail</h4>
                      <p style="text-align:right; color:#4D5C68;"><b>Order Date: <?php echo $arraytracking['orderdate'] ?></b></p>
                      <br>
                      <table style="width:100%;">
                        <tr>
                          <th style="text-align:left; padding:0px 50px 15px 50px;">Weight:</th>
                          <td style="text-align:right; padding:0px 50px 15px 50px;"><?php echo $arraytracking['weight'] ?> kg</td>
                        </tr>
                        <tr>
                          <th style="text-align:left; padding:0px 50px 15px 50px;">Extra Service:</th>
                          <td style="text-align:right; padding:0px 50px 15px 50px;"><?php echo $arraytracking['extraservice'] ?></td>
                        </tr>
                        <tr>
                          <th style="text-align:left; padding:0px 50px 15px 50px;">Price:</th>
                          <td style="text-align:right; padding:0px 50px 15px 50px; color:red;">$ <?php echo $arraytracking['itemprice'] ?></td>
                        </tr>
                      </table>
                    <hr>
                    <br>
                    <h4 style="color:#f89d13;">Shipping Address</h4>
                    <br>
                    <p><?php echo $arraytracking['address1'].",<br> ".$arraytracking['address2'].", 
                                  ".$arraytracking['city'].",<br>  ".$arraytracking['state'].", 
                                  ".$arraytracking['postcode'].", ".$arraytracking['country'] ?></p>
                    <br>
                    <hr>
                    <?php 
                      }
                     ?>
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