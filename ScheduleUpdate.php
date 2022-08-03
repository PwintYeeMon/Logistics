<?php
include('connect.php');
session_start();

if(!isset($_SESSION['staffid']))
{
  echo "<script>window.alert('Please Login First')</script>";
  echo "<script>window.location='StaffLogin.php'</script>";
}
else
{
  $staffid = $_SESSION['staffid'];

  $selectstaff = "SELECT staffname FROM staff WHERE staffid = '$staffid'";
  $runstaff = mysqli_query($connect, $selectstaff);
  $arraystaff = mysqli_fetch_array($runstaff);
  $staffname = $arraystaff['staffname'];
}

if(isset($_REQUEST['scheduleid']))
{
  $scheduleid = $_REQUEST['scheduleid'];
  $select = "SELECT * FROM schedule s, freight f WHERE s.freightid = f.freightid AND s.scheduleid = $scheduleid";
  $run = mysqli_query($connect, $select);
  $data = mysqli_fetch_array($run);
  $freightid = $data['freightid'];
  $freighttype = $data['freighttype'];
  $duration = $data['duration'];
  $departure = $data['departuredate'];
  $arrival = $data['arrivaldate'];
  $from = $data['country'];
  $to = $data['destination'];
  $price = $data['price'];
}

if(isset($_POST['btnupdate']))
{
  $scheduleid = $_POST['txtscheduleid'];
  $freightid = $_POST['txtfreightid'];
  $departure = $_POST['txtdeparture'];
  $arrival = $_POST['txtarrival'];
  $from = $_POST['txtcountry'];
  $to = $_POST['txtdestination'];
  $price = $_POST['txtprice'];

  $date = date("Y-m-d");

  $update = "UPDATE schedule 
        SET freightid = '$freightid', 
        departuredate = '$departure',
        arrivaldate = '$arrival',
        country = '$from',
        destination = '$to',
        price = '$price',
        staffid = '$staffid',
        scheduledate = '$date'        
        WHERE scheduleid = '$scheduleid'";
  $query = mysqli_query($connect, $update);
  if($query)
  {
    echo "<script>window.alert('Schedule Update Successful')</script>";
    echo "<script>window.location='ScheduleList.php'</script>";
  }
}

if(isset($_POST['btnback']))
{
  echo "<script>window.location='ScheduleList.php'</script>";
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
                <li><a href="OrderList.php">Order</a></li>
                <li class="has-children">
                  <a href="">Freight</a>
                  <ul class="dropdown">
                    <li><a href="Freight.php">Freight Entry</a></li>
                    <li><a href="FreightList.php">Freight List</a></li>
                  </ul>
                </li>
                <li class="has-children active">
                  <a href="">Schedule</a>
                  <ul class="dropdown">
                    <li><a href="Schedule.php">Schedule Entry</a></li>
                    <li class="active"><a href="ScheduleList.php">Schedule List</a></li>
                  </ul>
                </li>
                <li class="has-children">
                  <a href="">Customer</a>
                  <ul class="dropdown">
                    <li><a href="CustomerList.php">Customer List</a></li>
                    <li><a href="FeedbackList.php">Customer Feedback</a></li>
                  </ul>
                </li>
                <li class="has-children">
                  <a>Profile</a>
                  <ul class="dropdown">
                    <li><a href=""><?php echo $staffname ?></a></li>
                    <li><a href=""><?php echo $position ?></a></li>
                    <li><a href="StaffLogout.php">Logout</a></li>
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
          <div class="col-md-7 mb-5">

            <form action=" " class="p-5 bg-white" method="POST">
             
              <input type="hidden" name="txtscheduleid" value="<?php echo $scheduleid ?>">
              <h1>Schedule Update</h1>
              <br>
              
              <div class="row form-group">
                
                <div class="col-md-12">
                  <label class="text-black">Type of Freight & Duration</label>
                  <?php 

                  $select = "SELECT * FROM freight";
                  $query = mysqli_query($connect, $select);
                  $count = mysqli_num_rows($query);
                  if($count>0)
                  {
                    echo "<select name='txtfreightid' class='form-control' required>";
                    echo "<option value='$freightid' selected hidden>$freighttype &nbsp; $duration</option>";

                    for ($i=0; $i < $count; $i++) 
                    { 
                      $array = mysqli_fetch_array($query);
                      $freightid = $array['freightid'];
                      $freighttype = $array['freighttype'];
                      $duration = $array['duration'];
                      
                      echo "<option value='$freightid'>$freighttype &nbsp; $duration</option>";
                    }

                    echo "</select>";
                  }

                  ?>                
                </div>
              </div>

              <div class="row form-group">
                
                <div class="col-md-6 mb-3 mb-md-0">
                  <label class="text-black">Departure Date</label> 
                  <input type="date" class="form-control" name="txtdeparture" value="<?php echo $departure ?>" required>
                  
                </div>
              
                <div class="col-md-6">
                  <label class="text-black">Arrival Date</label>
                  <input type="date" class="form-control" name="txtarrival" value="<?php echo $arrival ?>" required>
                </div>
                
              </div>

              <div class="row form-group">
                
                <div class="col-md-6 mb-3 mb-md-0">
                  <label class="text-black">Country</label> 
                  <select name="txtcountry" class="form-control" required>
                    <option value="<?php echo $from ?>" selected hidden><?php echo $from ?></option>
                    <option value="Australia">Australia</option>
                    <option value="Myanmar">Myanmar</option>
                    <option value="Singapore">Singapore</option>
                    <option value="United Kingdom">United Kingdom</option>
                    <option value="United States">United States</option>
                  </select>
                </div>
                              
                <div class="col-md-6">
                  <label class="text-black">Destination</label> 
                  <select name="txtdestination" class="form-control" required>
                    <option value="<?php echo $to ?>" selected hidden><?php echo $to ?></option>
                    <option value="Australia">Australia</option>
                    <option value="Myanmar">Myanmar</option>
                    <option value="Singapore">Singapore</option>
                    <option value="United Kingdom">United Kingdom</option>
                    <option value="United States">United States</option>
                  </select>
                </div>
              </div>

              <div class="row form-group">
                
                <div class="col-md-12">
                  <label class="text-black">Price per kg ($)</label> 
                  <input type="integer" class="form-control" name="txtprice" value="<?php echo $price ?>" required>
                </div>
              </div>

              <div class="row form-group">
                <div class="col-md-12">
                  <input type="submit" value="Update" name = "btnupdate" class="btn btn-primary py-2 px-4 text-white">
                  <input type="submit" value="Back" name="btnback" class="btn btn-primary py-2 px-4 text-black" style="background-color:#e9ebee;">
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