<?php
// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "online_election_system");
if (!$conn) {
    echo "Database not connected";
    exit();
}

// Fetch the election ID from the URL
$election_id = isset($_GET['election_id']) ? intval($_GET['election_id']) : 0;

// Fetch specific election details
$election_sql = "SELECT * FROM election WHERE election_id = '$election_id'";
$election_result = mysqli_query($conn, $election_sql);
$election = mysqli_fetch_assoc($election_result);

// Fetch all candidates from the database
$candidates_sql = "SELECT * FROM candidates";
$candidates_result = mysqli_query($conn, $candidates_sql);

// Handle form submission to assign candidate to election
if (isset($_POST['assign'])) {
    $candidate_id = $_POST['candidate_id'];

    // Check if the candidate is already assigned to the election
    $check_sql = "SELECT * FROM election_candidates WHERE election_id = '$election_id' AND candidate_id = '$candidate_id'";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('This candidate is already assigned to the selected election.');</script>";
    } else {
        // Insert into election_candidates table (without foreign keys)
        $assign_sql = "INSERT INTO election_candidates (election_id, candidate_id) VALUES ('$election_id', '$candidate_id')";
        if (mysqli_query($conn, $assign_sql)) {
            echo "<script>alert('Candidate assigned to election successfully!'); window.location.href='assign_candidate.php?election_id=$election_id';</script>";
        } else {
            echo "<script>alert('Error assigning candidate: " . mysqli_error($conn) . "');</script>";
        }
    }
}

// Handle form submission to remove candidate from election
if (isset($_POST['remove'])) {
    $candidate_id_to_remove = $_POST['candidate_id_to_remove'];

    // Remove candidate from election_candidates table
    $remove_sql = "DELETE FROM election_candidates WHERE election_id = '$election_id' AND candidate_id = '$candidate_id_to_remove'";
    if (mysqli_query($conn, $remove_sql)) {
        echo "<script>alert('Candidate removed from election successfully!'); window.location.href='assign_candidate.php?election_id=$election_id';</script>";
    } else {
        echo "<script>alert('Error removing candidate: " . mysqli_error($conn) . "');</script>";
    }
}

// Fetch assigned candidates for this election
$assigned_candidates_sql = "SELECT c.user_id, c.name FROM election_candidates ec 
                            JOIN candidates c ON ec.candidate_id = c.user_id
                            WHERE ec.election_id = '$election_id'";
$assigned_candidates_result = mysqli_query($conn, $assigned_candidates_sql);
?>

<html>
<head>
    <title>Assign Candidate</title>
    <link rel="stylesheet" href="../css/assign_candidate.css">
</head>
<body>
    <nav class="AdminNav">
        <h1 class="AdminNavHeading">Assign Candidate</h1>
        <div class="AdminNavContainer">
            <a href="admindashboard.php">Back to Dashboard</a>
        </div>
    </nav>

    <div class="AdminBodyContainer">
        <!-- Display election details -->
        <h2>Election Details</h2>
        <p><strong>Election ID:</strong> <?php echo $election['election_id']; ?></p>
        <p><strong>Title:</strong> <?php echo htmlspecialchars($election['title']); ?></p>
        <p><strong>Description:</strong> <?php echo htmlspecialchars($election['description']); ?></p>
        <p><strong>Start Date:</strong> <?php echo htmlspecialchars($election['start_date']); ?></p>
        <p><strong>Result Date:</strong> <?php echo htmlspecialchars($election['result_date']); ?></p>

        <!-- Section to assign a new candidate -->
        <h2>Assign Candidate to Election</h2>
        <form action="" method="post">
            <label for="candidate">Select Candidate:</label>
            <select name="candidate_id" required>
                <?php
                if (mysqli_num_rows($candidates_result) > 0) {
                    while ($candidate = mysqli_fetch_assoc($candidates_result)) {
                        echo "<option value='" . $candidate['user_id'] . "'>" . htmlspecialchars($candidate['name']) . "</option>"; // Use user_id for value
                    }
                } else {
                    echo "<option>No Candidates Available</option>";
                }
                ?>
            </select>
            <input type="submit" name="assign" value="Assign Candidate">
        </form>

        <!-- Display list of already assigned candidates -->
        <h2>Assigned Candidates</h2>
        <div class="assigned-candidates">
            <?php
            if (mysqli_num_rows($assigned_candidates_result) > 0) {
                echo "<ul>";
                while ($candidate = mysqli_fetch_assoc($assigned_candidates_result)) {
                    echo "<li style='display: flex; justify-content: space-between; align-items: center;'>
                            <span>" . htmlspecialchars($candidate['name']) . "</span>
                            <form action='' method='post' style='margin-left: 10px;'>
                                <input type='hidden' name='candidate_id_to_remove' value='" . htmlspecialchars($candidate['user_id']) . "'>
                                <input type='submit' name='remove' value='Remove' class='remove-button' onclick='return confirm(\"Are you sure you want to remove this candidate?\");'>
                            </form>
                          </li>";
                }
                echo "</ul>";
            } else {
                echo "<p>No candidates have been assigned to this election yet.</p>";
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
