<?php
$host = "localhost";  // Add your SQL Server host here
$user = "root";       // SQL Username
$pass = "";           // SQL Password
$dbname = "mydb";     // SQL Database Name

// Create a connection
$con = mysqli_connect($host, $user, $pass, $dbname);

// Check if the connection was successful
if (mysqli_connect_errno()) {
    echo "<h1>Failed to connect to MySQL: " . mysqli_connect_error() . "</h1>";
    exit();
}

// Retrieve form data
$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];

// SQL query to insert the data into the database
$sql = "INSERT INTO guestbook (name, email, message) VALUES ('$name', '$email', '$message')";

// Execute the query
if (!mysqli_query($con, $sql)) {
    die('Error: ' . mysqli_error($con));
} else {
    echo "Values Stored in our Database!";
}

// Close the connection
mysqli_close($con);
?>
