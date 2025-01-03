<html>
<head>
    <title>View Election</title>
    <link rel="stylesheet" href="../css/viewelection.css">
</head>
<body>
    <nav class="ViewElectionNav">
        <h1 class="ViewElectionNavHeading">View Election</h1>
        <div class="ViewElectionNavContainer">
            <a href="admindashboard.php">Home</a>
            <a href="manageelection.php">Add Election</a>
            <a href="viewelection.php">View Election</a>
        </div>
    </nav>
    <div class="ViewElectionBodyContainer">
        <h1>Elections</h1>

        <?php
        // Connect to the database
        require_once 'dbcon.php';

        // Retrieve all elections
        $sql = "SELECT * FROM `election`";
        $data = mysqli_query($conn, $sql);
        if (mysqli_num_rows($data) > 0) {

            // Display election data in a table
            echo "<table>";
            echo "<tr>";
            echo "<th>Title</th>";
            echo "<th>Description</th>";
            echo "<th>Start Date</th>";
            echo "<th>Start Time</th>";
            echo "<th>Result Date</th>";
            echo "<th>End Time</th>";
            echo "<th>Result Time</th>"; // New column for Result Time
            echo "<th>Actions</th>";
            echo "</tr>";

            // Loop through each election and display it in the table
            while ($row = mysqli_fetch_assoc($data)) {
                $id = $row['election_id'];
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                echo "<td>" . htmlspecialchars($row['start_date']) . "</td>";
                echo "<td>" . htmlspecialchars($row['start_time']) . "</td>"; // Start Time
                echo "<td>" . htmlspecialchars($row['result_date']) . "</td>";
                echo "<td>" . htmlspecialchars($row['end_time']) . "</td>"; // End Time
                echo "<td>" . htmlspecialchars($row['result_time']) . "</td>"; // Result Time
                echo "<td>
                        <form method='POST' style='display:inline;'>
                            <button value='$id' name='electiondel' type='submit'>Delete</button>
                        </form>
                      </td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No elections found.</p>";
        }
        ?>
    </div>
</body>
</html>

<?php
// Handling the delete election logic
require_once 'dbcon.php';

if (isset($_POST['electiondel'])) {
    $id = $_POST['electiondel'];
    if (!empty($_POST['electiondel'])) {
        $sql = "DELETE FROM `election` WHERE `election_id`='$id'";
        $data = mysqli_query($conn, $sql);
        echo "<script>window.location.replace('../html/viewelection.php');</script>";
    }
}
?>
