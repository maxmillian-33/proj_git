<?php
session_start();

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION['email']) || $_SESSION['user_code'] != 1) {
    header('Location: login.php');
    exit();
}

// Retrieve user information from the session
$email = $_SESSION['email'];

// Connect to the database
require_once 'dbcon.php';

// Retrieve user details
$sql = "SELECT * FROM `users` WHERE `email` = '$email'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    echo "<script>alert('User details not found!')</script>";
    exit();
}

// Retrieve masked password
$password_query = "SELECT `password` FROM `login` WHERE `email` = '$email'";
$password_result = mysqli_query($conn, $password_query);
$password_row = mysqli_fetch_assoc($password_result);
$masked_password = str_repeat('*', strlen($password_row['password']));

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Profile</title>
    <link rel="stylesheet" href="../css/user_profile.css">
</head>

<body>

    <nav class="UserProfileNav">
        <h1 class="UserProfileHeading">Your Profile</h1>
        <div class="UserProfileNavContainer">
            <a href="user_dashboard.php">Back to Dashboard</a>
            <a href="update_user_profile.php">Update Profile</a>
            <a href="logout.php">Logout</a>
        </div>
    </nav>

    <div class="UserProfileContainer">
        <h2>Your Details</h2>
        <img src="../uploads/<?php echo htmlspecialchars($user['image']); ?>" alt="Profile Picture" class="profile-picture">
        <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
        <p><strong>Password:</strong> <span id="masked-password"><?php echo $masked_password; ?></span>
            <button class="change-password-button" onclick="window.location.href='change_password.php'">Change Password</button>
        </p>
        <p><strong>Address:</strong> <?php echo htmlspecialchars($user['address']); ?></p>
        <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($user['dob']); ?></p>
        <p><strong>Age:</strong> <?php echo htmlspecialchars($user['age']); ?></p>
        <p><strong>Aadhaar Number:</strong> <?php echo htmlspecialchars($user['aadhar_number']); ?></p>
    </div>

</body>

</html>

