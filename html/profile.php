<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "online_election_system");

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Query to fetch user details
$user_id = 12; // Replace with dynamic user ID
$query = "SELECT * FROM candidates WHERE user_id = $user_id";
$result = mysqli_query($conn, $query);

// Check if the query returned any data
if ($result && mysqli_num_rows($result) > 0) {
    // Fetch user data from database
    $user = mysqli_fetch_assoc($result);
} else {
    echo "No user found with the given ID.";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="profile-container">
        <div class="profile-image">
            <img src="<?php echo !empty($user['image']) ? $user['image'] : 'default.jpg'; ?>" alt="User Picture">
        </div>
        <div class="profile-details">
            <?php echo $user['image']; ?>
            <h1><?php echo $user['name']; ?></h1>
            <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
            <p><strong>Phone:</strong> <?php echo $user['phone']; ?></p>
            <p><strong>Password:</strong> ******** <a href="change_password.php">Change Password</a></p>
        </div>
    </div>
</body>
</html>
