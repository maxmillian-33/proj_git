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

// Retrieve user ID from the users table
$user_sql = "SELECT user_id FROM users WHERE email = '$email'";
$user_result = mysqli_query($conn, $user_sql);
$user = mysqli_fetch_assoc($user_result);

if (!$user) {
    echo "<script>alert('User details not found!')</script>";
    exit();
}

$user_id = $user['user_id']; // Get the user_id

// Check if the election_id is provided
$election_id = isset($_GET['election_id']) ? intval($_GET['election_id']) : 0;

// Check if the user has already voted in this election
$vote_check_sql = "SELECT * FROM votes WHERE election_id = '$election_id' AND user_id = '$user_id'";
$vote_check_result = mysqli_query($conn, $vote_check_sql);

if (mysqli_num_rows($vote_check_result) > 0) {
    echo "<script>alert('You have already voted in this election.'); window.location.href='user_dashboard.php';</script>";
    exit();
}

// Handle form submission to cast a vote
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $candidate_id = $_POST['candidate_id'];

    // Insert the vote into the database
    $vote_sql = "INSERT INTO votes (election_id, user_id, candidate_id) VALUES ('$election_id', '$user_id', '$candidate_id')";
    if (mysqli_query($conn, $vote_sql)) {
        echo "<script>alert('Vote cast successfully!'); window.location.href='user_dashboard.php';</script>";
    } else {
        echo "<script>alert('Error casting vote: " . mysqli_error($conn) . "');</script>";
    }
}

// Fetch candidates for the selected election
$candidates_sql = "SELECT c.* FROM candidates c INNER JOIN election_candidates ec ON c.user_id = ec.candidate_id WHERE ec.election_id = '$election_id'";
$candidates_result = mysqli_query($conn, $candidates_sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cast Vote</title>
    <link rel="stylesheet" href="../css/cast_vote.css">
</head>

<body>
    <nav class="VoteNav">
        <h1>Cast Your Vote</h1>
        <div class="VoteNavContainer">
            <a href="user_dashboard.php">Back to Dashboard</a>
        </div>
    </nav>

    <div class="candidates-container">
        <h2>Select a Candidate</h2>
        <form action="" method="post">
            <?php
            if (mysqli_num_rows($candidates_result) > 0) {
                while ($candidate = mysqli_fetch_assoc($candidates_result)) {
                    $photo = "../uploads/" . htmlspecialchars($candidate['image']); // Path to the candidate's photo
                    echo "<div class='candidate-card'>
                            <img src='$photo' alt='Candidate Photo for " . htmlspecialchars($candidate['name']) . "' class='candidate-photo'>
                            <h3>" . htmlspecialchars($candidate['name']) . "</h3>
                            <button type='submit' name='candidate_id' value='" . $candidate['user_id'] . "' class='vote-button'>Vote</button>
                          </div>";
                }
            } else {
                echo "<p>No candidates available for this election.</p>";
            }
            ?>
        </form>
    </div>
</body>

</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
