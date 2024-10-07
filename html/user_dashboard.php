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
$conn = mysqli_connect("localhost", "root", "", "online_election_system");
if (!$conn) {
    echo "Database not connected";
    exit();
}

// Retrieve user details
$sql = "SELECT * FROM `users` WHERE `email` = '$email'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    echo "<script>alert('User details not found!')</script>";
    exit();
}
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
    <title>User Dashboard</title>
    <link rel="stylesheet" href="../css/user_dashboard.css">
</head>

<body>

    <nav class="UserDashboardNav">
        <h1 class="UserDashboardHeading">Welcome, <?php echo htmlspecialchars($user['name']); ?></h1>
        <div class="UserDashboardNavContainer">
            <a href="update_user_profile.php">Update Profile</a>
            <a href="logout.php">Logout</a>
        </div>
    </nav>

    <div class="UserDashboardContainer">
        <h2>Your Profile</h2>
        <img src="../uploads/<?php echo htmlspecialchars($user['image']); ?>" alt="Profile Picture" class="profile-picture">
        <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
        <p><strong>Password:</strong> <span id="masked-password"><?php echo $masked_password; ?></span>
            <button onclick="window.location.href='change_password.php'" style="margin-left: 10px;">Change Password</button>
        </p>
        <p><strong>Address:</strong> <?php echo htmlspecialchars($user['address']); ?></p>
        <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($user['dob']); ?></p>
        <p><strong>Age:</strong> <?php echo htmlspecialchars($user['age']); ?></p>
        <p><strong>Aadhaar Number:</strong> <?php echo htmlspecialchars($user['aadhar_number']); ?></p>
        <h2>Actions</h2>
        <ul>

        </ul>
    </div>

</body>

</html>