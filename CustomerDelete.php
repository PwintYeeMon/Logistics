<?php 

include('connect.php');

if(isset($_REQUEST['customerid']))
{
	$cusid = $_REQUEST['customerid'];
	$delete = "DELETE FROM customer WHERE customerid = $cusid";
	$run = mysqli_query($connect, $delete);

	if($run)
	{
		echo "<script>window.alert('Customer Deleted Successfully')</script>";
		echo "<script>window.location='CustomerList.php'</script>";
	}
}

?>