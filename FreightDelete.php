<?php 

include('connect.php');

if(isset($_REQUEST['freightid']))
{
	$freightid = $_REQUEST['freightid'];
	$delete = "DELETE FROM freight WHERE freightid = $freightid";
	$run = mysqli_query($connect, $delete);

	if($run)
	{
		echo "<script>window.alert('Freight Deleted Successfully')</script>";
		echo "<script>window.location='FreightList.php'</script>";
	}
}

?>