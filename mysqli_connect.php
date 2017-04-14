<?php 

DEFINE ('DB_USER', 'user');
DEFINE ('DB_PASSWORD', 'passwd');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'testing');

// make connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME); 

if ($conn->connect_error) {
	echo "connection failed";
	die ("Connection failed: " . $conn->connect_error);
}

?>
