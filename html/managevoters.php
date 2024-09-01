<html>
    <head>
        <title>Manage Users</title>
        <link rel="stylesheet" href="../css/managevoters.css">
    </head>
    <body>
        <nav class="ManVotersNav">
            <h1 class="ManVotersNavHeading">Manage Voters</h1>
            <div class="ManVotersNavContainer">
                <a href="admindashboard.php"><img class="NavHomeImage" src="../images/home.png" alt="">Home</a>
            </div>
        </nav>
        <div class="ManVotersBodyContainer">
            <h1>Voters</h1>

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
            $email=$row['email'];
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
            echo "</tr>";

        }
        echo "</table>";

    }
?>
        </div>
    </body>
</html>

<?php
    $conn = mysqli_connect("localhost", "root", "", "online_election_system");
    if(!$conn){
        echo "Database not connected";
    }

    if(isset($_POST['userdel'])){
        $email = $_POST['userdel'];
        if(!empty($_POST['userdel'])){
            $sql = "DELETE FROM `users` WHERE `email`='$email'";
            $data = mysqli_query($conn, $sql);
            $sql1 = "DELETE FROM `login` WHERE `email`='$email'";
            $data1 = mysqli_query($conn, $sql1);
            echo "<script>window.location.replace('../html/managevoters.php');</script>";
        }
    }
?>