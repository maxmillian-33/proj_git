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

// Retrieve ongoing elections
$election_query = "
    SELECT e.election_id, e.start_date, e.title, e.description 
    FROM election e
    WHERE e.start_date >= CURDATE()
    ORDER BY e.start_date
";

$election_result = mysqli_query($conn, $election_query);
if (!$election_result) {
    die("Error in election query: " . mysqli_error($conn));
}
$elections = mysqli_fetch_all($election_result, MYSQLI_ASSOC);

// Prepare calendar
$calendar = [];
foreach ($elections as $election) {
    $date = date('Y-m-d', strtotime($election['start_date']));
    $calendar[$date][] = $election;
}

// Create a simple calendar for the current month
$month = date('m');
$year = date('Y');
$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
$firstDay = date('w', strtotime("$year-$month-01"));
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
        
        <h2>Election Calendar</h2>
        <div class="calendar">
            <div class="header">Sun</div>
            <div class="header">Mon</div>
            <div class="header">Tue</div>
            <div class="header">Wed</div>
            <div class="header">Thu</div>
            <div class="header">Fri</div>
            <div class="header">Sat</div>

            <?php for ($i = 0; $i < $firstDay; $i++): ?>
                <div></div>
            <?php endfor; ?>

            <?php for ($day = 1; $day <= $daysInMonth; $day++): ?>
                <?php 
                $currentDate = "$year-$month-" . str_pad($day, 2, '0', STR_PAD_LEFT);
                ?>
                <div>
                    <?php echo $day; ?>
                    <?php if (isset($calendar[$currentDate])): ?>
                        <?php foreach ($calendar[$currentDate] as $election): ?>
                            <div class="election">
                                <strong><?php echo htmlspecialchars($election['title']); ?></strong><br>
                                <?php echo htmlspecialchars($election['description']); ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            <?php endfor; ?>
        </div>
    </div>

</body>

</html>
