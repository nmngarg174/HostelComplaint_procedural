<?php
//used when data fetching is not dependent on user input

$con=mysqli_connect("localhost","hostelj14","admin14@TU","hostel_complaints");
if(!$con)
{
	echo "Database connection error ". mysqli_connect_error();
	}
	
?>