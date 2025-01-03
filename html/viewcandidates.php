<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Candidates</title>
    <link rel="stylesheet" href="../css/viewcandidates.css">
</head>
<body class="dark33">
    <nav class="ViewCandidatesNav">
        <h1 class="ViewCandidatesNavHeading">View Candidates</h1>
        <div class="ViewCandidatesNavContainer">
            <a href="admindashboard.php">Home</a>
            <a href="addcandidate.php">Add Candidate</a>
            <a href="viewcandidates.php">View Candidates</a>
        </div>
    </nav>
    <div class="ViewCandidatesBodyContainer">
        <h1 class="ViewCandidatesHeading">Candidates List</h1>

        <?php
        $conn = mysqli_connect("localhost", "root", "", "online_election_system");
        if(!$conn){
            echo "Database not connected";
        }

        $sql = "SELECT * FROM `candidates`";
        $data = mysqli_query($conn, $sql);
        if (mysqli_num_rows($data) > 0) {
            echo "<table>";
            echo "<tr><th>Name</th><th>Email</th><th>Phone Number</th><th>User ID</th><th>Actions</th></tr>";

            while ($row = mysqli_fetch_assoc($data)) {
                $email = $row['email'];
                echo "<tr>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['phone'] . "</td>";
                echo "<td>" . $row['user_id'] . "</td>";
                echo "<td>
                    <form method='POST'>
                        <button class='delete-btn' value='$email' name='userdel' type='submit'>Delete</button>
                    </form>
                </td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        ?>
    </div>
</body>
</html>

<?php
require_once 'dbcon.php';

if (isset($_POST['userdel'])) {
    $email = $_POST['userdel'];
    if (!empty($email)) {
        $sql = "DELETE FROM `candidates` WHERE `email`='$email'";
        $data = mysqli_query($conn, $sql);
        $sql1 = "DELETE FROM `login` WHERE `email`='$email'";
        $data1 = mysqli_query($conn, $sql1);
        echo "<script>window.location.replace('viewcandidates.php');</script>";
    }
}
?>
