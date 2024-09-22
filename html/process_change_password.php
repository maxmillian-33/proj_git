<?php
// Start session or grab user ID from form
session_start();
$user_id = $_POST['user_id']; // Usually, user_id should come from session

// Database connection
$conn = mysqli_connect("localhost", "root", "", "online_election_system");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get POST data from form
$current_password = $_POST['current_password'];
$new_password = $_POST['new_password'];
$confirm_password = $_POST['confirm_password'];

// Validate passwords
if ($new_password !== $confirm_password) {
    echo "New passwords do not match.";
    exit;
}

// Fetch the current plain-text password from the database (though it's not secure to store plain-text passwords)
$query = "SELECT password FROM candidates WHERE user_id = $user_id";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    echo "User not found.";
    exit;
}

// Verify current password (direct string comparison since there's no hashing)
if ($current_password !== $user['password']) {
    echo "Current password is incorrect.";
    exit;
}

// Update the password in the database with the new plain-text password
$update_query = "UPDATE candidates SET password = '$new_password' WHERE user_id = $user_id";

if (mysqli_query($conn, $update_query)) {
    echo "Password changed successfully.";
    header('Location: profile.php');
} else {
    echo "Error updating password: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
