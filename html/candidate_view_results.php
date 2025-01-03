<?php
session_start();
require_once 'dbcon.php';

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Get current date and time
$current_date = date("Y-m-d");
$current_time = date("H:i:s");

// Fetch completed elections, ordered by result_date in descending order
$completed_elections_sql = "
    SELECT * FROM election 
    WHERE result_date < '$current_date' OR (result_date = '$current_date' AND result_time <= '$current_time')
    ORDER BY result_date DESC, result_time DESC
";
$completed_elections_result = mysqli_query($conn, $completed_elections_sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Results</title>
    <link rel="stylesheet" href="../css/view_results.css">
</head>
<body>

<nav class="ResultsNav">
    <h1>Available Election Results</h1>
    <div class="ResultsNavContainer">
        <a href="candidate_dashboard.php">Back to Dashboard</a>
    </div>
</nav>

<div class="results-container">
    <?php if (mysqli_num_rows($completed_elections_result) > 0): ?>
        <table class="results-table">
            <thead>
                <tr>
                    <th>Election Title</th>
                    <th>Result Date</th>
                    <th>Result Time</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($election = mysqli_fetch_assoc($completed_elections_result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($election['title']); ?></td>
                        <td><?php echo htmlspecialchars($election['result_date']); ?></td>
                        <td><?php echo htmlspecialchars($election['result_time']); ?></td>
                        <td>
                            <a href="candidate_election_result.php?election_id=<?php echo $election['election_id']; ?>" class="view-button">View Result</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No completed election results are available yet.</p>
    <?php endif; ?>
</div>

</body>
</html>

<?php
mysqli_close($conn);
?>
