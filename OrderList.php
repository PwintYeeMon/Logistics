<?php 
include('connect.php');
session_start();

if(isset($_SESSION['staffid']))
{
  $staffid = $_SESSION['staffid'];

  $select = "SELECT * FROM staff 
              WHERE staffid = '$staffid'";
  $run = mysqli_query($connect, $select);
  $countstaff = mysqli_num_rows($run);

  if($countstaff == 1)
  {
    $array = mysqli_fetch_array($run);
  }
}
else
{
  echo "<script>window.alert('Please Login First')</script>";
  echo "<script>window.location='StaffLogin.php'</script>";
}

if(!isset($_POST['btnSearch']) && !isset($_POST['btnShowAll']))
{

  $query="SELECT * FROM ordertbl o, schedule s, freight f, payment p, customer c
            WHERE f.freightid = s.freightid
            AND s.scheduleid = o.scheduleid
            AND o.orderid = p.orderid
            AND c.customerid = o.customerid";
  $result=mysqli_query($connect, $query);
}
elseif(isset($_POST['btnSearch']))
{
  $rdoSearchType=$_POST['rdoSearchType'];

  if($rdoSearchType==1) 
  {
    $orderid=$_POST['cboOrderID'];

    $query="SELECT * FROM ordertbl o, schedule s, freight f, payment p, customer c
            WHERE o.orderid = '$orderid' 
            AND f.freightid = s.freightid
            AND s.scheduleid = o.scheduleid
            AND o.orderid = p.orderid
            AND c.customerid = o.customerid";
    $result=mysqli_query($connect, $query);
  }
  elseif ($rdoSearchType==2) 
  {
    $txtFrom=$_POST['txtFrom'];
    $txtTo=$_POST['txtTo'];

    $query="SELECT * FROM ordertbl o, schedule s, freight f, payment p, customer c
            WHERE o.orderdate BETWEEN '$txtFrom' AND '$txtTo' 
            AND f.freightid = s.freightid
            AND s.scheduleid = o.scheduleid
            AND o.orderid = p.orderid
            AND c.customerid = o.customerid";
    $result=mysqli_query($connect, $query);
  }
  else
  {
    $query="SELECT * FROM ordertbl o, schedule s, freight f, payment p, customer c
            WHERE f.freightid = s.freightid
            AND s.scheduleid = o.scheduleid
            AND o.orderid = p.orderid
            AND c.customerid = o.customerid";
    $result=mysqli_query($connect, $query);
  }
}
elseif(isset($_POST['btnShowAll']))
{
  $query="SELECT * FROM ordertbl o, schedule s, freight f, payment p, customer c
            WHERE f.freightid = s.freightid
            AND s.scheduleid = o.scheduleid
            AND o.orderid = p.orderid
            AND c.customerid = o.customerid";
  $result=mysqli_query($connect, $query);
}
else
{
  $todayDate=date('Y-m-d');

  $query="SELECT * FROM ordertbl o, schedule s, freight f, payment p, customer c
            WHERE o.orderdate = '$todayDate' 
            AND f.freightid = s.freightid
            AND s.scheduleid = o.scheduleid
            AND o.orderid = p.orderid
            AND c.customerid = o.customerid";
  $result=mysqli_query($connect, $query);
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

    <link rel="stylesheet" type="text/css" href="DatePicker/datepicker.css">
    <script type="text/javascript" src="DatePicker/datepicker.js"></script>

    <script type="text/javascript" src="js/jquery-3.1.1.slim.min.js"></script>

    <link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css"/>
    <script type="text/javascript" src="DataTables/datatables.min.js"></script> 
    <style>
    th, td{
      padding-bottom:20px;
    }
    </style>
    
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
                <li class="active"><a href="OrderList.php">Order</a></li>
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
    <div style="padding-top:50px;"></div>  
    <div class="site-section bg-light">
      <div class="container">
        <div class="row">
          <div class="col-md-12">

            <form action="OrderList.php" class="p-5 bg-white" method="post">
              <script>
              $(document).ready( function () {
                $('#tableid').DataTable();
              } );
              </script>

              
              <h5 style="color:blue;">Search Option:</h5>
              <div style="background-color:#f8f9fa;">
                <hr>
                  <table>
                  <tr>
                    <td style="padding-left:40px;">
                      <input type="radio" name="rdoSearchType" value="1" checked> Search by OrderID
                      <br><br>
                      <select name="cboOrderID">
                        <option disabled selected hidden>Choose OrderID</option>
                        <?php  
                        $query="SELECT o.*, c.customerid, c.customername
                                 FROM ordertbl o, customer c
                                 WHERE o.customerid = c.customerid";
                        $ret=mysqli_query($connect, $query);
                        $count=mysqli_num_rows($ret);

                        for($i=0;$i<$count;$i++) 
                        { 
                          $arraycus=mysqli_fetch_array($ret);
                          $orderid=$arraycus['orderid'];
                          $customername=$arraycus['customername'];

                          echo "<option value='$orderid'>" . $orderid . ' ~ ' . $customername . "</option>";
                        }

                        ?>
                      </select>
                    </td>
                    <td style="padding:20px;">
                    </td>
                    <td>
                      <input type="radio" name="rdoSearchType" value="2"> Search by Date
                      <br><br>
                      From: <input type="date" name="txtFrom" value="<?php echo date("Y-m-d",strtotime("-1 month")) ?>">
                      To  : <input type="date" name="txtTo" value="<?php echo date('Y-m-d') ?>">
                    </td>
                    <td style="padding:20px;">
                    </td>
                    <td><br><br>
                      <input type="submit" name="btnSearch" value="Search">
                      <input type="submit" name="btnShowAll" value="Show All">
                    </td>
                  </tr>
                  </table>
                <hr>
              </div>

              <h5 style="color:blue;">Search Result:</h5>
              <div class="row form-group">                
                <div class="col-md-12">
                  <table id="tableid" style="width:100%; text-align:center;">
                    <hr>
                      <?php 
                      $count=mysqli_num_rows($result);
                      if ($count == 0) 
                      {
                        echo "<td colspan='8'>No orders yet.</td>";
                      }
                      else
                      {
                        echo "
                        <tr>
                          <th>OrderID</th>
                          <th>Order Date</th>
                          <th>Customer</th>
                          <th>Freight</th>
                          <th>From</th>
                          <th>To</th>
                          <th>PaymentID</th>
                          <th>Order Status</th>
                          <th>Action</th>
                        <tr>
                        ";
                        for ($i=0; $i < $count; $i++) 
                        { 
                          $arr = mysqli_fetch_array($result);
                          $orderid = $arr['orderid'];
                          $customerid = $arr['customerid'];
                          $customername = $arr['customername'];

                          $orderdate = $arr['orderdate'];                       
                          $freighttype = $arr['freighttype'];                     
                          $scheduleid = $arr['scheduleid'];                        
                          $freightid = $arr['freightid'];
                          $country = $arr['country'];
                          $destination = $arr['destination'];
                          $paymentid = $arr['paymentid'];
                          $status = $arr['status'];
                      
                          echo"
                          <tr>
                            <td>$orderid</td>
                            <td>$orderdate</td>
                            <td><a href='OrderCustomer.php?customerid=$customerid'>$customername</a></td>
                            <td><a href='OrderSchedule.php?scheduleid=$scheduleid&freightid=$freightid'>$freighttype</a></td>
                            <td>$country</td>
                            <td>$destination</td>
                            <td><a href='OrderPayment.php?paymentid=$paymentid'>$paymentid</a></td>
                            <td style='color:blue;'>$status</td>
                            <td><a href='OrderAccept.php?orderid=$orderid' class='fa fa-check-square-o' title='Accept Order'></a> | 
                            <a href='ItemList.php?orderid=$orderid' class='fa fa-ellipsis-h' title='More'></a></td>
                          <tr>
                          ";
                        }
                      } ?>
                  </table><hr>
                </div>
              </div>

              <script>var pfHeaderImgUrl = '';var pfHeaderTagline = 'Order%20Report';var pfdisableClickToDel = 0;var pfHideImages = 0;var pfImageDisplayStyle = 'right';var pfDisablePDF = 0;var pfDisableEmail = 0;var pfDisablePrint = 0;var pfCustomCSS = '';var pfBtVersion='1';(function(){var js, pf;pf = document.createElement('script');pf.type = 'text/javascript';if('https:' == document.location.protocol){js='https://pf-cdn.printfriendly.com/ssl/main.js'}else{js='http://cdn.printfriendly.com/printfriendly.js'}pf.src=js;document.getElementsByTagName('head')[0].appendChild(pf)})();</script>
              <a href="http://www.printfriendly.com" style="color:#6D9F00;text-decoration:none;" class="printfriendly" onClick="window.print();return false;" title="Printer Friendly and PDF"><img style="border:none;-webkit-box-shadow:none;box-shadow:none;" src="http://cdn.printfriendly.com/button-print-grnw20.png" alt="Print Friendly and PDF"/></a>

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