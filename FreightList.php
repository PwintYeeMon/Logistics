<?php 
include('connect.php');

session_start();

if(isset($_SESSION['staffid']))
{
  $staffid = $_SESSION['staffid'];

  $select = "SELECT * FROM staff 
              WHERE staffid = '$staffid'";
  $run = mysqli_query($connect, $select);
  $count = mysqli_num_rows($run);

  if($count == 1)
  {
    $array = mysqli_fetch_array($run);
  }
}
else
{
  echo "<script>window.alert('Please Login First')</script>";
  echo "<script>window.location='StaffLogin.php'</script>";
}

$select = "SELECT * FROM freight";
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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
                <li class="has-children active">
                  <a href="">Freight</a>
                  <ul class="dropdown">
                    <li><a href="Freight.php">Freight Entry</a></li>
                    <li class="active"><a href="FreightList.php">Freight List</a></li>
                  </ul>
                </li>
                <li class="has-children">
                  <a href="">Schedule</a>
                  <ul class="dropdown">
                    <li><a href="Schedule.php">Schedule Entry</a></li>
                    <li><a href="ScheduleList.php">Schedule List</a></li>
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
                    <li><a href=""><?php echo $array['staffname'] ?></a></li>
                    <li><a href=""><?php echo $array['position'] ?></a></li>
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
          <div class="col-md-12">

            <form action=" " class="p-5 bg-white">
              <div class="row form-group">                
                <div class="col-md-12">
                  <h3 style="text-align:center;">Freight</h3>
                  <table style="width:100%; text-align:center;">
                    <hr>
                      <?php 
                      if ($count == 0) 
                      {
                        echo "<td colspan='7'>No freight available yet.</td>";
                      }
                      else
                      {
                        echo "
                        <tr>
                          <th style='padding:0px 10px 15px 10px;'>No</th>
                          <th style='padding:0px 10px 15px 10px;'>Freight Type</th>
                          <th style='padding:0px 10px 15px 10px;'>Duration</th>
                          <th style='padding:0px 10px 15px 10px;'>Action</th>
                        <tr>
                        ";
                        for ($i=0; $i < $count; $i++) 
                        { 
                          $data = mysqli_fetch_array($run);
                          $freightid = $data['freightid'];
                          $freight = $data['freighttype'];
                          $duration = $data['duration'];
                      
                          echo"
                          <tr>
                            <td style='padding-bottom:15px;'>$freightid</td>
                            <td>$freight</td>
                            <td>$duration</td>";

                          if($freightid != '')
                          {
                            echo "<td><a href='FreightUpdate.php?freightid=$freightid' class='fa fa-pencil' title='Edit'></a> | 
                              <a href='FreightDelete.php?freightid=$freightid' class='fa fa-trash' title='Delete'></a></td>
                            </tr>";                      
                          }
                          
                          echo "</tbody>";
                        } ?>
                     
                  </table><hr>
                  <?php } ?>
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