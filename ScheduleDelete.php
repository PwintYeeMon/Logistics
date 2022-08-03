<?php 

include('connect.php');

if(isset($_REQUEST['scheduleid']))
{
	$scheduleid = $_REQUEST['scheduleid'];
	$delete = "DELETE FROM schedule WHERE scheduleid = $scheduleid";
	$run = mysqli_query($connect, $delete);

	if($run)
	{
		echo "<script>window.alert('Schedule Deleted Successfully')</script>";
		echo "<script>window.location='ScheduleList.php'</script>";
	}
}

?>