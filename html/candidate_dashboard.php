<?php
session_start();

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION['email']) || $_SESSION['user_code'] != 0) {
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

// Retrieve candidate details
$sql = "SELECT * FROM `candidates` WHERE `email` = '$email'";
$result = mysqli_query($conn, $sql);
$candidate = mysqli_fetch_assoc($result);

if (!$candidate) {
    echo "<script>alert('Candidate details not found!')</script>";
    exit();
}

// Retrieve the password (this should ideally be done with caution, considering security)
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
    <title>Candidate Dashboard</title>
    <link rel="stylesheet" href="../css/candidate_dashboard.css">
</head>
<body>

    <nav class="CandidateDashboardNav">
        <h1 class="CandidateDashboardHeading">Welcome, <?php echo htmlspecialchars($candidate['name']); ?></h1>
        <div class="CandidateDashboardNavContainer">
            <a href="update_candidate_profile.php"> Update Profile</a>
            <a href="login.php">Logout</a>
        </div>
    </nav>

    <div class="CandidateDashboardContainer">
        <h2>Your Profile</h2>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($candidate['name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($candidate['email']); ?></p>
        <p><strong>Phone:</strong> <?php echo htmlspecialchars($candidate['phone']); ?></p>
        <p><strong>Password:</strong> <span id="masked-password"><?php echo $masked_password; ?></span> 
            <button onclick="window.location.href='change_password.php'" style="margin-left: 10px;">Change Password</button>
        </p>
        <img src="../uploads/<?php echo htmlspecialchars($candidate['image']); ?>" alt="Profile Picture" width="150px">

        <h2>Actions</h2>
        <ul>
            <!-- Add other actions here -->
        </ul>
    </div>

</body>
</html>
