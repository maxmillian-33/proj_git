<html>
    <head>
        <title>Manage Users</title>
        <link rel="stylesheet" href="../css/managevoters.css">
    </head>
    <body>
        <nav class="ManVotersNav">
            <h1 class="ManVotersHeading">Online Election System</h1>
            <div class="ManVotersContainer">
                <a href="admindashboard.php">Home</a>
                
            </div>
        </nav>
        <div class="ManVotersBodyContainer">
            <h1>Manage Voters</h1>

<?php
    $conn = mysqli_connect("localhost", "root", "", "online_election_system");
    if(!$conn){
        echo "Database not connected";
    }

    $sql = "SELECT * FROM `users`";
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