<html>
    <head>
        <title>Manage Users</title>
        <link rel="stylesheet" href="../css/viewcandidates.css">
    </head>
    <body>
        <nav class="ViewCandidatesNav">
            <h1 class="ViewCandidatesNavHeading">View Candidates</h1>
            <div class="ViewCandidatesNavContainer">
            <a href="admindashboard.php"><img class="NavHomeImage" src="../images/home.png" alt="">Home</a>
                <a href="addcandidate.php"><img class="NavAddCanImage" src="../images/add_candidates.png" alt="">Add Candidate</a>
                <a href="viewcandidates.php"><img class="NavViewCanImage" src="../images/view_candidate.png" alt=""><u>View Candidates</u></a>
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
            $email = $row['email'];
            echo "<tr>";
            echo "<td>".$row['name']."</td>";
            echo "<td>".$row['email']."</td>";
            echo "<td>".$row['phone']."</td>";
            echo "<td>".$row['user_id']."</td>";
            echo "<td>
                    <form method='POST'>
                        <button value='$email' name='userdel' type='submit'>Delete</button>
                    </form>
                </td>";
            echo "<td>
                    <form method='POST' action='editcandidate.php'>
                        <button value='$email' name='userdel' type='submit'>Edit</button>
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

if(isset($_POST['userdel'])){
    $email = $_POST['userdel'];
    if(!empty($_POST['userdel'])){
        $sql = "DELETE FROM `candidates` WHERE `email`='$email'";
        $data = mysqli_query($conn, $sql);
        $sql1 = "DELETE FROM `login` WHERE `email`='$email'";
        $data1 = mysqli_query($conn, $sql1);
        echo "<script>window.location.replace('../html/viewcandidates.php');</script>";
    }
}
?>