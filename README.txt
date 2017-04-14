Oscar Montoya
Phase 3

/******** Files ***************/

create_account.php - Allows user to create an account. Will display form allowing users to input data. File makes 3 insert queries: into the person, customer, and person_phoneNumber tables. 

new_user.html - The html used by create_account.php

home.php - Display items that are currently for sale. Contains two queries: 
	1. Queries database for the name of current user 
	2. Queries for the items currently for sale.

myaccount.php - Displays the items the current user has purchased. Make query to database to retrieve purchased items. 

mysqli_connect.php - Handles connecting to the database. The database connection defaults defined their are as follows:
	DEFINE ('DB_USER', 'user');
	DEFINE ('DB_PASSWORD', 'passwd');
	DEFINE ('DB_HOST', 'localhost');
	DEFINE ('DB_NAME', 'testing');

/*********** RUNNING PHP SCRIPTS *****************/
	Creating Database

	1. Set up database according to the defaults in mysqli_connect.php. You can also just change the defaults in mysqli_connect.php to suit your test environment.

	2. Create and populate the tables using Oscar-Montoya.txt from Phase 2. I added the triggers to Oscar-Montoya.txt. The added code is down below for reference. The first trigger makes sure that email added is valid. The second trigger make sure that the date of birth added to the customer table is in the correct format.

	3. Visit 'create_account.php'. Page displays form that allows user to create an account. The 'Populate with Valid Data' button populates the fields of the forms with valid data.
 		a. Test email trigger integrity contraint by filling email field with email without a '@'. Fill all other fields with valid values. Submit. Should see error message. Go back to 'create_account.php'.


		b. Test phone number trigger integrity contraint by giving dob field a value not in the form '####-##-##'. Fill all other fields with valid values. Submit. Should see error message. Go back to 'create_account.php'. Note: I could not get this trigger to work. It will just successfully insert person.

		c. When you successfully create user. You will see a confirmation message and a link to the home page. Click the link to home page.

	5. At 'home.php', there will be a list of item available for sale. A query is made to the database to retrieve yet unsold item. Click the 'purchase' link for any item to purchase the item. An insert query is made to the `purchase` table upon pressing the link. You can click on the 'My Account' link to visit myaccount.php.

	6. 'myaccount.php' will show all the items which you have bought. Makes query to database to retrieve purchased items.

/************ TRIGGERS CODE **************/

	delimiter //

	CREATE TRIGGER before_insert_person_email BEFORE INSERT ON person FOR EACH ROW BEGIN IF NEW.email NOT LIKE '%@%' THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'invalid email'; END IF; END; //

	delimiter $$

	CREATE TRIGGER before_insert_customer_dob BEFORE INSERT ON customer FOR EACH ROW BEGIN IF NEW.dob REGEXP '[[:digit:]]{4}[-][[:digit:]]{2}[-][[:digit:]]{2}' THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Invalid phone number'; END IF; END; $$

	delimiter ;



