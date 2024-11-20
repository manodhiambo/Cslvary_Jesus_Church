<?php
// Database connection configuration
$username = 'manodhiambo';
$password = 'Mycat@95';
$dsn = "mysql:host=127.0.0.1;dbname=calvary_church;charset=utf8mb4";


try {
	    // Create PDO instance and set error mode to exception
	$conn = new PDO($dsn, $username, $password);
	// Set the PDO error mode to exception
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
	// Catch and display any errors during the connection attempt
	die("Connection failed: " . $e->getMessage());
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// Get form values and sanitize them
	$full_name = $_POST['full_name'];
	$phone_number = isset($_POST['phone_number']) ? $_POST['phone_number'] : NULL;
	$prayer_request = $_POST['prayer_request'];
	$is_secret = isset($_POST['is_secret']) ? 1 : 0;
	$allow_contact = isset($_POST['allow_contact']) ? 1 : 0;

	try {
		// Prepare SQL query with placeholders
		 $sql = "INSERT INTO prayer_requests (full_name, phone_number, prayer_request, is_secret, allow_contact) 
			 VALUES (:full_name, :phone_number, :prayer_request, :is_secret, :allow_contact)";
		
		// Prepare statement
		$stmt = $conn->prepare($sql);

		// Bind parameters to the placeholders
		$stmt->bindParam(':full_name', $full_name, PDO::PARAM_STR);
		$stmt->bindParam(':phone_number', $phone_number, PDO::PARAM_STR);
		$stmt->bindParam(':prayer_request', $prayer_request, PDO::PARAM_STR);
		$stmt->bindParam(':is_secret', $is_secret, PDO::PARAM_INT);
		$stmt->bindParam(':allow_contact', $allow_contact, PDO::PARAM_INT);

		// Execute the query
		$stmt->execute();

		// Redirect or display success message
		echo "<script>alert('Prayer request submitted successfully!'); window.location.href = 'index.php';</script>";

		    } catch (PDOException $e) {
			    // Catch and display any errors during query execution
			    echo "Error: " . $e->getMessage();
			        }
}
?>