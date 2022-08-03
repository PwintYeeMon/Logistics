<?php 

include('connect.php');
session_start();

if(isset($_GET['orderid']))
{
  $orderid = $_GET['orderid'];

  $update = "UPDATE ordertbl SET status = 'ACCEPTED' WHERE orderid = '$orderid'";
  $run = mysqli_query($connect, $update);

  if($run)
  {
  	echo "<script>window.location='OrderList.php'</script>";
  }
}

?>