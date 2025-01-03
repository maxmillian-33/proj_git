<?php
session_start(); // Start session at the beginning of the script

// Check if the user is logged in and if the user_code is 2 (admin)
if (!isset($_SESSION['user_code']) || $_SESSION['user_code'] != 2) {
    // If not logged in or not an admin, redirect to login page
    header("Location: login.php");
    exit();
}

// Connect to the database
require_once 'dbcon.php';

// Fetch the elections from the database
$sql = "SELECT * FROM election";
$result = mysqli_query($conn, $sql);
?>

<html>

<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/admindashboard.css">
</head>

<body class="dark33">
    <nav class="AdminNav">
        <h1 class="AdminNavHeading">Admin Dashboard</h1>
        <div class="AdminNavContainer">
            <a href="manageelection.php">Manage Election</a>
            <a href="managevoters.php">Manage Voters</a>
            <a href="addcandidate.php">Manage Candidates</a>
            <a href="logout.php">Logout</a>
        </div>
    </nav>


    <div class="AdminBodyContainer">
        <h1>Current Elections</h1>
        <div class="card-container">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='card'>";
                    echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
                    echo "<p><strong>Description:</strong> " . htmlspecialchars($row['description']) . "</p>";
                    echo "<p><strong>Start Date:</strong> " . htmlspecialchars($row['start_date']) . "</p>";
                    echo "<p><strong>Result Date:</strong> " . htmlspecialchars($row['result_date']) . "</p>";
                    echo "<a href='assign_candidate.php?election_id=" . $row['election_id'] . "' class='btn'>Assign Candidate</a>";
                    echo "</div>";
                }
            } else {
                echo "<p>No elections found.</p>";
            }
            ?>
        </div>
    </div>
</body>

</html>

<?php
// Close the database connection
mysqli_close($conn);
?>