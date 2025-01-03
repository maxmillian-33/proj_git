<?php
session_start();

require_once 'dbcon.php';

// Get the election_id from the GET request
$election_id = isset($_GET['election_id']) ? intval($_GET['election_id']) : 0;

// Fetch election details
$election_sql = "SELECT * FROM election WHERE election_id = '$election_id'";
$election_result = mysqli_query($conn, $election_sql);
$election = mysqli_fetch_assoc($election_result);

if (!$election) {
    echo "<script>alert('Election not found.'); window.location.href='view_results.php';</script>";
    exit();
}

// Retrieve vote counts for each candidate in this election
$result_sql = "
    SELECT c.name, COUNT(v.candidate_id) AS vote_count, c.user_id
    FROM candidates c
    LEFT JOIN votes v ON c.user_id = v.candidate_id AND v.election_id = '$election_id'
    GROUP BY c.user_id
    ORDER BY vote_count DESC
";
$result_result = mysqli_query($conn, $result_sql);

// Calculate total votes and determine the winner
$total_votes = 0;
$candidates = [];
$winner = null;

while ($row = mysqli_fetch_assoc($result_result)) {
    $candidates[] = $row;
    $total_votes += $row['vote_count'];
}

// Determine the winner
if ($total_votes > 0) {
    $winner = $candidates[0]; // As it's already ordered by vote_count DESC
}

// Fetch the winner's photo from the users table
$winner_sql = "SELECT image FROM candidates WHERE user_id = '" . $winner['user_id'] . "'";
$winner_photo_result = mysqli_query($conn, $winner_sql);
$winner_photo = mysqli_fetch_assoc($winner_photo_result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Election Result</title>
    <link rel="stylesheet" href="../css/election_result.css">
</head>

<body>

    <!-- Navigation Bar -->
    <nav>
        <h1>Election Results</h1>
        <div class="ResultsNavContainer">
            <a href="candidate_view_results.php">Back to Results</a>
        </div>
    </nav>

    <!-- Election Result Content -->
    <div class="election-result-container">
        <h2>Results for <?php echo htmlspecialchars($election['title']); ?></h2>

        <?php if ($total_votes > 0): ?>
            <table class="result-table">
                <thead>
                    <tr>
                        <th>Candidate</th>
                        <th>Votes</th>
                        <th>Percentage</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($candidates as $candidate):
                        $vote_percentage = ($candidate['vote_count'] / $total_votes) * 100;
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($candidate['name']); ?></td>
                            <td><?php echo $candidate['vote_count']; ?></td>
                            <td><?php echo round($vote_percentage, 2); ?>%</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Display the winner's details at the bottom -->
            <div class="winner-section">
                <h3>Winner</h3>
                <?php if ($winner): ?>
                    <div class="winner-details">
                        <p><strong>Name:</strong> <?php echo htmlspecialchars($winner['name']); ?></p>
                        <p><strong>Votes Received:</strong> <?php echo $winner['vote_count']; ?></p>
                        <p><strong>Percentage:</strong> <?php echo round(($winner['vote_count'] / $total_votes) * 100, 2); ?>%</p>
                        <img src="../uploads/<?php echo htmlspecialchars($winner_photo['image']); ?>" alt="Winner's Photo" class="winner-photo">
                    </div>
                <?php else: ?>
                    <p>No votes were cast in this election.</p>
                <?php endif; ?>
            </div>

        <?php else: ?>
            <p>No votes were cast in this election.</p>
        <?php endif; ?>
    </div>

</body>

</html>

<?php
mysqli_close($conn);
?>