<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title></title>
</head>
<body>
	<h1>My Account</h1>
	<h2><a href="home.php">Home</a></h2>
	<br>

	<h2>Items Purchased</h2>

	<?php
		require('mysqli_connect.php');

		session_start();

		$userId = getCurrentUser();

		// display items purchased by curr user
		displayBoughtItems($userId);
		

	
		


		function getCurrentUser() {
			// get current user
			if (isset($_SESSION['user_id']))
			{
				$currUserId = $_SESSION['user_id'];
			}
			else {
				// default to user 1
				$currUserId = 1;
			}

			return $currUserId;
		}

		function displayBoughtItems($userId) {
			global $conn;

			$query = "SELECT `name`, `description`, `item_condition`, `price`, `shipping_cost` FROM `item` NATURAL JOIN `product_info` WHERE `item`.`id` IN (SELECT `item_id` FROM `purchase` WHERE `customer_id` = " . $userId . ");"; 

			if ($result = $conn->query($query)) {
				// if nothing bought
				if ($result->num_rows === 0) {
					echo "<h2>You haven't bought anything yet.</h2>";
				}

				// display purchases
				else {
					while ($row = $result->fetch_assoc()) {
						echo "<h3>" . $row['name'] . "</h3>";

						echo "<p>" . $row['description'] . "</p>";

						echo "<p>Item Condition: " . strtoupper($row['item_condition']) . "</p>";

						echo "<p>Price: " . $row['price'] . str_repeat(" ", 10)." Shipping Cost: " . $row['shipping_cost']
							. "</p>";

						echo "<hr>";
					}
				}
			}

			

		}
	

	?>
</body>
</html>
