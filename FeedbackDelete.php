<?php 

include('connect.php');

if(isset($_REQUEST['customerid']))
{
	$cusid = $_REQUEST['customerid'];
	$delete = "UPDATE customer SET feedback = NULL WHERE customerid = $cusid";
	$run = mysqli_query($connect, $delete);

	if($run)
	{
		echo "<script>window.alert('Feedback Deleted Successfully')</script>";
		echo "<script>window.location='FeedbackList.php'</script>";
	}
}

?>