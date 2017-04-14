<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title></title>
</head>
<body>
	<h1> Online Store </h1>
	

	<?php

		if ($_SERVER['REQUEST_METHOD'] === 'POST') 
		{
			require('mysqli_connect.php');

			$id = insertPerson();
			insertCustomer($id);

			// 'log in user'
			session_start();

			$_SESSION['user_id'] = $id;


			echo "<h3>User sucessfully created</h3>";
			echo "<h3><a href='home.php'>Home Page</a></h3>";
			
		}

		// if form has not been submitted, show form.
		else 
		{
			echo file_get_contents('new_user.html');
		}


		function insertPerson() {
			global $conn;

			$firstName = $_REQUEST['firstname'];
			$lastName = $_REQUEST['lastname'];
			$street = $_REQUEST['street'];
			$city = $_REQUEST['city'];
			$state = $_REQUEST['state'];
			$zip = $_REQUEST['zip'];
			$email = $_REQUEST['email'];
			$phoneNumber = $_REQUEST['phone_number'];


			
			$insertPersonFormat = "INSERT INTO `person` (`first_name`, `last_name`, `street`, `city`, `state`, `zip`, `email`) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s');";


			$insertPersonQuery = sprintf($insertPersonFormat, $firstName, $lastName, $street, $city, $state, $zip, $email);

			if ($conn->query($insertPersonQuery) === TRUE)
			{
				$lastId = $conn->insert_id;
			}
			else 
			{
				die("Unable to insert person. " . $conn->error);
			}

			insertPhoneNumber($lastId, $phoneNumber);

			return $lastId;
		}

		function insertPhoneNumber($userId, $phoneNumber) {
			global $conn;

			$insertPhoneNumQuery = sprintf("INSERT INTO `person_phoneNumber` (`person_id`, `phone_number`) VALUES (%d, '%s');", $userId, $phoneNumber);


			$result = $conn->query($insertPhoneNumQuery);

		}

		function insertCustomer($id) {
			global $conn;

			$isPrime = isset($_REQUEST['is_prime']) && $_REQUEST['is_prime'] === 'on' ? 'true' : 'false';
			$dob = $_REQUEST['dob'];

			$query = sprintf("INSERT INTO `customer` VALUES (%d, %s, '%s')", $id, $isPrime, $dob);



			if ($conn->query($query) !== TRUE)
			{
				die ("Unable to make insertion into customer table. " + $conn->error);
			}
		}

		
		



	?>
</body>
</html>
