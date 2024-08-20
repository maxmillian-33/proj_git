<html>
    <head>
        <title>Manage Users</title>
        <link rel="stylesheet" href="../css/viewcandidates.css">
    </head>
    <body>
        <nav class="ViewCandidatesNav">
            <h1 class="ViewCandidatesNavHeading">View Candidates</h1>
            <div class="ViewCandidatesNavContainer">
                <a href="admindashboard.php">Home</a>
                <a href="addcandidate.php">Add Candidate</a>
                <a href="viewcandidates.php"><u>View Candidates</u></a>
            </div>
        </nav>
        <div class="ViewCandidatesBodyContainer">
            <h1>Candidates</h1>

            <?php
    $conn = mysqli_connect("localhost", "root", "", "online_election_system");
    if(!$conn){
        echo "Database not connected";
    }

    $sql = "SELECT * FROM `candidates`";
    $data=mysqli_query($conn,$sql);
    if(mysqli_num_rows($data)>0){
    
        echo "<table border=1 >";
        echo "<tr>";
        echo "<th>Name</th>";
        echo "<th>Email</th>";
        echo "<th>Phone Number</th>";
        echo "<th>User ID</th>";
        echo "</tr>";

        while($row=mysqli_fetch_assoc($data)){
            echo "<tr>";
            echo "<td>".$row['name']."</td>";
            echo "<td>".$row['email']."</td>";
            echo "<td>".$row['phone']."</td>";
            echo "<td>".$row['user_id']."</td>";
            echo "</tr>";

        }
        echo "</table>";

    }
?>
        </div>
    </body>
</html>