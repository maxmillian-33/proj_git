<?php
// Database Connection Module

// Define database configuration
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'online_election_system';

// Establish a database connection
$conn = mysqli_connect($host, $user, $password, $dbname);

// Check if the connection is successful
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

?>
