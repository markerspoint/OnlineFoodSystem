<?php
$servername = "localhost";
$username = "root"; // Adjust if needed
$password = ""; // Adjust if needed
$dbname = "foodhub";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>