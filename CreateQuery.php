<?php 
include('connect.php');

$staff = "CREATE TABLE staff
			(	
				staffid INT NOT NULL auto_increment PRIMARY KEY,
				staffname VARCHAR(30),
				dob DATE,
				position VARCHAR(30),
				address VARCHAR(50),
				email VARCHAR(50),
				phoneno VARCHAR(30),
				password VARCHAR(50)
			)";
$runstaff = mysqli_query($connect, $staff);
if ($runstaff)
{
	echo "Staff Table Created<br>";
}
else
{
	echo mysqli_error($connect);
}

$freight = "CREATE TABLE freight
			(	
				freightid INT NOT NULL auto_increment PRIMARY KEY,
				freighttype VARCHAR(30),
				duration VARCHAR(30)
			)";
$runfreight = mysqli_query($connect, $freight);
if ($runfreight)
{
	echo "Freight Table Created<br>";
}
else
{
	echo mysqli_error($connect);
}

$schedule = "CREATE TABLE schedule
			(	
				scheduleid INT NOT NULL auto_increment PRIMARY KEY,
				freightid INT,
				departuredate DATE,
				arrivaldate DATE,
				country VARCHAR(50),
				destination VARCHAR(50),
				price FLOAT,
				staffid INT,
				scheduledate DATE
			)";
$runschedule = mysqli_query($connect, $schedule);
if ($runschedule)
{
	echo "Schedule Table Created<br>";
}
else
{
	echo mysqli_error($connect);
}

$customer = "CREATE TABLE customer
			(	
				customerid INT NOT NULL auto_increment PRIMARY KEY,
				customertype VARCHAR(30),
				customername VARCHAR(30),
				username VARCHAR(30),
				dob DATE,
				phoneno VARCHAR(30),
				email VARCHAR(50),
				address1 VARCHAR(30),
				address2 VARCHAR(30),
				city VARCHAR(20),
				state VARCHAR(20),
				country VARCHAR(20),
				postcode VARCHAR(10),
				profile TEXT,
				password VARCHAR(50),
				feedback VARCHAR(255)
			)";
$runcustomer = mysqli_query($connect, $customer);
if ($runcustomer)
{
	echo "Customer Table Created<br>";
}
else
{
	echo mysqli_error($connect);
}

$recipient = "CREATE TABLE recipient
			(	
				recipientid INT NOT NULL auto_increment PRIMARY KEY,
				recipientname VARCHAR(30),
				dob DATE,
				phoneno VARCHAR(30),
				email VARCHAR(50),
				address1 VARCHAR(30),
				address2 VARCHAR(30),
				city VARCHAR(20),
				state VARCHAR(20),
				country VARCHAR(20),
				postcode VARCHAR(10)
			)";
$runrecipient = mysqli_query($connect, $recipient);
if ($runrecipient)
{
	echo "Recipient Table Created<br>";
}
else
{
	echo mysqli_error($connect);
}

$order = "CREATE TABLE ordertbl
			(	
				orderid INT NOT NULL auto_increment PRIMARY KEY,
				customerid INT,
				scheduleid INT,
				orderdate DATE,
				status VARCHAR(20)
			)";
$runorder = mysqli_query($connect, $order);
if ($runorder)
{
	echo "Order Table Created<br>";
}
else
{
	echo mysqli_error($connect);
}

$payment = "CREATE TABLE payment
			(	
				paymentid INT NOT NULL auto_increment PRIMARY KEY,
				orderid INT,
				nameoncard VARCHAR(30),
				cardno VARCHAR(20),
				expmonth VARCHAR(10),
				expyear VARCHAR(5),
				cvv VARCHAR(5),
				checkstatus VARCHAR(20)
			)";
$runpayment = mysqli_query($connect, $payment);
if ($runpayment)
{
	echo "Payment Table Created<br>";
}
else
{
	echo mysqli_error($connect);
}

$tracking = "CREATE TABLE tracking
			(	
				trackingid VARCHAR(20) NOT NULL PRIMARY KEY,
				departuredate DATE,
				arrivaldate DATE,
				description VARCHAR(100),
				customerid INT
			)";
$runtracking = mysqli_query($connect, $tracking);
if ($runtracking)
{
	echo "Tracking Table Created<br>";
}
else
{
	echo mysqli_error($connect);
}

$item = "CREATE TABLE item
			(	
				itemid VARCHAR(10) NOT NULL PRIMARY KEY,
				itemtype1 VARCHAR(30),
				itemtype2 VARCHAR(30),
				weight FLOAT,
				length FLOAT,
				width FLOAT,
				height FLOAT,
				extraservice VARCHAR(50),
				itemprice FLOAT,
				orderid INT,
				recipientid INT,
				trackingid VARCHAR(20)
			)";
$runitem = mysqli_query($connect, $item);
if ($runitem)
{
	echo "Item Table Created<br>";
}
else
{
	echo mysqli_error($connect);
}
?>