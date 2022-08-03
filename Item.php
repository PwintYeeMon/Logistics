<?php
include('Admin/connect.php');
session_start();

if(isset($_SESSION['customerid']))
{
  $customerid = $_SESSION['customerid'];

  $selectname = "SELECT customername FROM customer WHERE customerid = '$customerid'";
  $runname = mysqli_query($connect, $selectname);
  $arrayname = mysqli_fetch_array($runname);
  $customername = $arrayname['customername'];
}
else
{
  echo "<script>window.alert('Please Login First')</script>";
  echo "<script>window.location='CustomerLogin.php'</script>";
}

if(isset($_GET['scheduleid']))
{
  $_SESSION['scheduleid']= $_GET['scheduleid'];
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

if(isset($_POST['btndone'])) 
{
  $itemid = AutoID('item','itemid','ITM-',6);
  $itemtype1 = $_POST['txtitemtype1'];
  $itemtype2 = $_POST['txtitemtype2'];
  $weight = $_POST['txtweight'];
  $length = $_POST['txtlength'];
  $width = $_POST['txtwidth'];
  $height = $_POST['txtheight'];
  $extraservice = $_POST['txtextraservice'];
  $customerid = $_POST['txtcustomerid'];
  $scheduleid = $_POST['txtscheduleid'];

  $date = date("Y-m-d");

  $selectcheck = "SELECT * FROM ordertbl";
  $runcheck = mysqli_query($connect, $selectcheck);
  $countcheck = mysqli_num_rows($runcheck);
  $notsame = 0;


  for ($i=0; $i < $countcheck; $i++) 
  { 
    $arraycheck = mysqli_fetch_array($runcheck);
    if ($customerid != $arraycheck['customerid'])
    {
      $notsame++;
    }
    else if($scheduleid != $arraycheck['scheduleid'])
    {
      $notsame++;
    }
    else if($date != $arraycheck['orderdate'])
    {
      $notsame++;
    }
  }

  if ($notsame == $countcheck)
  {
    $status = "PENDING";
    $add = "INSERT INTO ordertbl (customerid, scheduleid, orderdate, status)
            VALUES ('$customerid', '$scheduleid', '$date', '$status')";
    $addrun = mysqli_query($connect, $add); 
  }

  $selectorder = "SELECT orderid FROM ordertbl WHERE customerid = '$customerid' AND scheduleid  = '$scheduleid' 
                  AND orderdate = '$date'";
  $runorder = mysqli_query($connect, $selectorder);
  $ordercount = mysqli_num_rows($runorder);

  if ($ordercount == 1) 
  {
    $arrayorder = mysqli_fetch_array($runorder);
    $orderid = $arrayorder['orderid'];
    $_SESSION['orderid'] = $orderid;

    $selectprice = "SELECT price FROM schedule WHERE scheduleid = '$scheduleid'";
    $runprice = mysqli_query($connect, $selectprice);
    $arrayprice = mysqli_fetch_array($runprice);
    $price = $arrayprice['price'] * $weight;

    $insert = "INSERT INTO item(itemid, itemtype1, itemtype2, weight, length, width, height, extraservice, itemprice, orderid)
                VALUES ('$itemid', '$itemtype1', '$itemtype2', '$weight', '$length', '$width', '$height', '$extraservice', '$price', '$orderid')";
    $query = mysqli_query($connect, $insert);

    if($query)
    {
      echo "<script>window.alert('Item Registration Successful')</script>";

      $_SESSION['itemid'] = $itemid;
      echo "<script>window.location='RecipientRegistration.php'</script>";
    }
    else
    {
      mysqli_error($connect);
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
                    <li><a href="CustomerProfile.php"><?php echo $customername ?></a></li>
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
            <h1 class="text-white font-weight-light text-uppercase font-weight-bold">Item Information</h1>
            <p class="breadcrumb-custom"><a href="Home.php">Services</a> <span class="mx-2">&gt;</span> 
              <a href="ScheduleDisplay.php">Shipping Schedule</a> <span class="mx-2">&gt;</span> 
              <span>Item</span></p>
          </div>
        </div>
      </div>
    </div>  

    
    <div class="site-section bg-light">
      <div class="container">
        <div class="row">
          <div class="col-md-7 mb-5">

            <form action=" " class="p-5 bg-white" method="POST">
              <h1>Item</h1>
              <br>
              <input type="hidden" class="form-control" name="txtcustomerid"  value="<?php echo $customerid; ?>" required>
              
              <div class="row form-group">
                
                <div class="col-md-4  mb-3 mb-md-0">
                  <label class="text-black">Item Type :</label>
                </div>
                <div class="col-md-4">
                  <select name="txtitemtype1" class="form-control" required>
                    <option value="" disabled selected hidden>Choose Type</option>
                    <option value="Document">Document</option>
                    <option value="Parcel">Parcel</option>
                  </select>
                </div>
                <div class="col-md-4">
                  <select name="txtitemtype2" class="form-control" required>
                    <option value="" disabled selected hidden>Choose Type</option>
                    <option value="Normal">Normal</option>
                    <option value="Fragile">Fragile</option>  
                  </select>
                </div>
              </div>

              <div class="row form-group">
                
                <div class="col-md-12">
                  <label class="text-black">Weight (kg)</label> 
                  <input type="number" class="form-control" name="txtweight" step="0.01" min="0.01" required>
                </div>
              </div>

              <div class="row form-group">
                <div class="col-md-4 mb-3 mb-md-0">
                  <label class="text-black">Length (cm)</label>
                  <input type="number" class="form-control" name="txtlength" step="0.01" min="0.01" required>
                </div>
                <div class="col-md-4">
                  <label class="text-black">Width (cm)</label>
                  <input type="number" class="form-control" name="txtwidth" step="0.01" min="0.01" required>
                </div>
                <div class="col-md-4">
                  <label class="text-black">Height (cm)</label>
                  <input type="number" class="form-control" name="txtheight" step="0.01" min="0.01" required>
                </div>
              </div>

              <div class="row form-group">
                <div class="col-md-5 mb-3 mb-md-0">
                  <label class="text-black">Extra Service</label>
                  <select name = "txtextraservice" class="form-control" required>
                    <option value="" disabled selected hidden>Choose Service</option>
                    <option value="None">None</option>
                    <option value="Packaging">Packaging</option>
                    <option value="Insurance">Insurance</option>
                    <option value="ExpressDelivery">Express Delivery</option>
                  </select>
                </div>
                <div class="col-md-7">
                  <label class="text-black">Type of Freight & Duration</label>
                  <?php 
                  $scheduleid = $_SESSION['scheduleid'];
                  $select = "SELECT freighttype, duration FROM freight f, schedule s WHERE f.freightid = s.freightid AND s.scheduleid = '$scheduleid'";
                  $query = mysqli_query($connect, $select);
                  $array = mysqli_fetch_array($query);
                  $freighttype = $array['freighttype'];
                  $duration = $array['duration'];

                  echo "<input type='text' class='form-control' value='$freighttype - $duration' readonly>";
                  echo "<input type='hidden' class='form-control' name='txtscheduleid' value='$scheduleid' readonly>";
                  ?>
                                  
                </div>
              </div>

              <div class="row form-group">
                <div class="col-md-12">
                  <input type="submit" value="Done" name = "btndone" class="btn btn-primary py-2 px-4 text-white">
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