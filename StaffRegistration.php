<?php
include('connect.php');

if(isset($_POST['btnregister']))
{
  $staffname = $_POST['txtstaffname'];
  $dob = $_POST['txtdob'];
  $position = $_POST['txtstaffposition'];
  $address = $_POST['txtstaffaddress'];
  $email = $_POST['txtstaffemail'];
  $phoneno = $_POST['txtstaffphoneno'];
  $password = $_POST['txtpassword'];
  $password1 = $_POST['txtpassword1'];
  $hashedpassword = md5($password);
  
  if ($password != $password1)
  {
    echo "<script>window.alert('Passwords do not match. Please try again.')</script>";
    echo "<script>window.location = 'StaffRegistration.php'</script>";
  }
  else
  {
    $select = "SELECT * FROM staff";
    $run = mysqli_query($connect, $select);
    $count = mysqli_num_rows($run);
    $notsame = 0;

    for ($i=0; $i < $count; $i++) 
    { 
      $array = mysqli_fetch_array($run);
      if ($email != $array['email'])
      {
        $notsame++;
      }
    }

    if ($notsame == $count)
    {
      $insert = "INSERT INTO staff(staffname, dob, position, address, email, phoneno, password)
          VALUES ('$staffname', '$dob', '$position', '$address', '$email', '$phoneno', '$hashedpassword')";
      $query = mysqli_query($connect, $insert);

      if($query)
      {
        echo "<script>alert('Staff Registration Successful')</script>";
        echo "<script>window.location = 'StaffLogin.php'</script>";
      }
      else
      {
        mysqli_error($connect);
      }
    }
    else
    {
      echo "<script>window.alert('Email Already Exist')</script>";
      echo "<script>window.location = 'StaffRegistration.php'</script>";
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
                <li><a href="OrderList.php">Order</a></li>
                <li class="has-children">
                  <a href="">Freight</a>
                  <ul class="dropdown">
                    <li><a href="Freight.php">Freight Entry</a></li>
                    <li><a href="FreightList.php">Freight List</a></li>
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
                <li class="active"><a href="StaffLogin.php">Login</a></li>
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

            <form action="StaffRegistration.php" class="p-5 bg-white" method="POST">
              <h1>Staff Registration</h1>
              <div class="row form-group">                
                <div class="col-md-12">
                  <label class="text-black">Name</label> 
                  <input type="text" class="form-control" name="txtstaffname" required>
                </div>
              </div>

              <div class="row form-group">
                <div class="col-md-6 mb-3 mb-md-0">
                  <label class="text-black">Date of Birth</label>
                  <input type="date" class="form-control" name="txtdob" required>
                </div>
                <div class="col-md-6">
                  <label class="text-black">Position</label>
                  <select name = "txtstaffposition" class="form-control" required>
                    <option value="" disabled selected hidden>Choose Position</option>
                    <option value="Admin">Admin</option>
                    <option value="Manager">Manager</option>
                  </select>
                </div>
              </div>

              <div class="row form-group">                
                <div class="col-md-6">
                  <label class="text-black">Email</label>
                  <input type="email" class="form-control" name="txtstaffemail" required>
                </div>
                <div class="col-md-6 mb-3 mb-md-0">
                  <label class="text-black">Phone Number</label>
                  <input type="text" class="form-control" name="txtstaffphoneno" required>
                </div>
              </div>

              <div class="row form-group">
                <div class="col-md-6 mb-3 mb-md-0">
                  <label class="text-black">Address</label>
                  <input type="text" class="form-control" name="txtstaffaddress" required>
                </div>
                <div class="col-md-6">
                  <label class="text-black">Postcode</label>
                  <input type="text" class="form-control" name="txtstaffpostcode" required>
                </div>
              </div>

              <div class="row form-group">
                
                <div class="col-md-12">
                  <label class="text-black">Password</label> 
                  <input type="password" class="form-control" name="txtpassword" required>
                </div>
              </div>

              <div class="row form-group">
                
                <div class="col-md-12">
                  <label class="text-black">Confirm Password</label> 
                  <input type="password" class="form-control" name="txtpassword1" required>
                </div>
              </div>

              <div class="row form-group">
                <div class="col-md-12">
                  <label class="text-black">Already registered? <a href="StaffLogin.php">Sign up now!</a></label>
                </div>
              </div>

              <div class="row form-group">
                <div class="col-md-12">
                  <input type="submit" value="Register" name = "btnregister" class="btn btn-primary py-2 px-4 text-white">
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