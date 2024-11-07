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

// Retrieve masked password
$password_query = "SELECT `password` FROM `login` WHERE `email` = '$email'";
$password_result = mysqli_query($conn, $password_query);
$password_row = mysqli_fetch_assoc($password_result);
$masked_password = str_repeat('*', strlen($password_row['password']));

// Retrieve ongoing elections from the "election" table
$elections_query = "
    SELECT * FROM `election` 
    WHERE `start_date` = CURDATE() 
      AND TIME(NOW()) BETWEEN `start_time` AND `end_time`
";
$elections_result = mysqli_query($conn, $elections_query);
$ongoing_elections = mysqli_fetch_all($elections_result, MYSQLI_ASSOC);

// Retrieve upcoming elections from the "election" table
$upcoming_query = "
    SELECT * FROM `election` 
    WHERE `start_date` > CURDATE()
";
$upcoming_result = mysqli_query($conn, $upcoming_query);
$upcoming_elections = mysqli_fetch_all($upcoming_result, MYSQLI_ASSOC);

// Retrieve notifications
$notifications = [];
if (empty($user['address']) || empty($user['dob']) || empty($user['age']) || empty($user['aadhar_number'])) {
    $notifications[] = "Please complete your profile information. <a href='update_user_profile.php' class='update-profile-link'>Update Profile</a>";
}
if (!empty($ongoing_elections)) {
    $notifications[] = "You have ongoing elections! Cast your vote now.";
}
if (!empty($upcoming_elections)) {
    $notifications[] = "You have upcoming elections!";
}

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
            <a href="view_results.php">View Results</a>
            <a href="user_profile.php">View Profile</a>
            <a href="logout.php">Logout</a>
        </div>
    </nav>

    <div class="UserDashboardContainer">
        <!-- Notifications Section -->
        <div class="Notifications">
            <h2>Notifications</h2>
            <?php if (empty($notifications)) : ?>
                <p>No new notifications.</p>
            <?php else : ?>
                <ul>
                    <?php foreach ($notifications as $notification) : ?>
                        <li><?php echo $notification; ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>

        <!-- Ongoing Elections Section -->
        <div class="OngoingElections">
            <h2>Ongoing Election Today</h2> <!-- Updated title -->
            <div class="elections-container">
                <?php if (empty($ongoing_elections)) : ?>
                    <p>No ongoing elections at the moment.</p>
                <?php else : ?>
                    <?php foreach ($ongoing_elections as $election) : ?>
                        <div class="election-card">
                            <h3><?php echo htmlspecialchars($election['title']); ?></h3>
                            <p><?php echo htmlspecialchars($election['description']); ?></p>
                            <p><strong>Start Date:</strong> <?php echo htmlspecialchars($election['start_date']); ?> at <?php echo htmlspecialchars($election['start_time']); ?></p>
                            <p><strong>End Time:</strong> <?php echo htmlspecialchars($election['end_time']); ?></p>
                            <a href="cast_vote.php?election_id=<?php echo $election['election_id']; ?>" class="vote-link">Vote Now</a>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Upcoming Elections Section -->
        <div class="UpcomingElections">
            <h2>Upcoming Elections</h2>
            <div class="elections-container">
                <?php if (empty($upcoming_elections)) : ?>
                    <p>No upcoming elections at the moment.</p>
                <?php else : ?>
                    <?php foreach ($upcoming_elections as $election) : ?>
                        <div class="election-card">
                            <h3><?php echo htmlspecialchars($election['title']); ?></h3>
                            <p><?php echo htmlspecialchars($election['description']); ?></p>
                            <p><strong>Start Date:</strong> <?php echo htmlspecialchars($election['start_date']); ?> at <?php echo htmlspecialchars($election['start_time']); ?></p>
                            <p><strong>End Date:</strong> <?php echo htmlspecialchars($election['result_date']); ?> at <?php echo htmlspecialchars($election['end_time']); ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

</body>

</html>
