<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title></title>
</head>
<body>

<h1>Online Store</h1>


<?php 

	session_start();
	
	// get current user
  if (isset($_SESSION['user_id']))
	{
		$currUserId = $_SESSION['user_id'];
	}
	else {
		// default to user 1
		$currUserId = 1;
	}
  
  

	// connect to sql database
	require('mysqli_connect.php');

	welcomeUser($currUserId);
?>

<a href="myaccount.php">My Account</a>
<br><br>


<?php
	processPurchase();
	
	echo "<h2>Items for Sale:</h2><hr>";

	displayItemsForSale($currUserId);


	function welcomeUser($userId) {
		global $conn;

		$queryFormat = "SELECT `first_name`, `last_name` FROM `person` WHERE `id`= '%d'";
		$query = sprintf($queryFormat, $userId);

		if ($result = $conn->query($query)) {
			$row = $result->fetch_assoc();
			echo "<h4>Welcome " . $row['first_name'] . " " . $row['last_name'] . "</h4>";
		}

	}

	function processPurchase() {
		global $conn;

		$purchaseQueryFormat = "INSERT INTO `purchase` (`item_id`, `customer_id`, `time_purchased`, `status`) VALUES ('%d', '%d', '%s', 'processing')";
		$dateTimeStr = date("Y-m-d h:i:s");

		// if purchase request made
		if (($_SERVER['REQUEST_METHOD'] == 'GET') && isset($_GET['uid']) && isset($_GET['itemId'])) {
			$userId = $_GET['uid'];
			$itemId = $_GET['itemId'];

			$query = sprintf($purchaseQueryFormat, $itemId, $userId, $dateTimeStr);

			// error inserting purchase
			if (!($conn->query($query))) {
				die($conn->error);
			}
		}
	}

	function displayItemsForSale($userId) {
		global $conn;

			// Query that fetch products that are for sale
		$query = "SELECT `id`, `name`, `description`, `item_condition`, `price`, `shipping_cost` FROM `item` NATURAL JOIN `product_info` WHERE `item`.`id` NOT IN (SELECT `item_id` FROM `purchase`);";


		if ($result = $conn->query($query)) {

			// if nothing is for sale
			if ($result->num_rows === 0) {
				echo "<h3>No item for sale</h3>";
			}

			while ($row = $result->fetch_assoc()) {
				echo "<h3>" . $row['name'] . "</h3>";

				echo "<p>" . $row['description'] . "</p>";

				echo "<p>Item Condition: " . strtoupper($row['item_condition']) . "</p>";

				echo "<p>Price: " . $row['price'] . str_repeat(" ", 10)." Shipping Cost: " . $row['shipping_cost']
					. "</p>";

				echo sprintf("<a href='./home.php?uid=%d&itemId=%d'>Purchase</a>", $userId, $row['id']);

				echo "<hr>";
			}
		}
	}
?>

</body>
</html>
