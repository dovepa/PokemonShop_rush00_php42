<?php
	$host = "localhost";
	$user = "root";
	$password = "123456";
	$db = "rush00";

	$mysqli = mysqli_connect($host, $user, $password, $db);

	if (mysqli_connect_errno($mysqli)) {
	   echo "Failed to connect to MySQL: ".mysqli_connect_error();
	}
?>
