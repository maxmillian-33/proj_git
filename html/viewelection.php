<html>
    <head>
        <title>View Election</title>
        <link rel="stylesheet" href="../css/viewelection.css">
    </head>
    <body>
        <nav class="ViewElectionNav">
            <h1 class="ViewElectionNavHeading">View Election</h1>
            <div class="ViewElectionNavContainer">
                <a href="admindashboard.php"><img class="NavHomeImage" src="../images/home.png" alt="">Home</a>
                <a href="manageelection.php"><img src="../images/add_election.png" alt="" class="NavAddElecImage"> Add Election</a>
                <a href="viewelection.php"><u>View Election</u></a>
            </div>
        </nav>
        <div class="ViewElectionBodyContainer">
            <h1>Elections</h1>

            <?php
            $conn = mysqli_connect("localhost", "root", "", "online_election_system");
            if(!$conn){
                echo "Database not connected";
            }

            $sql = "SELECT * FROM `election`";
            $data=mysqli_query($conn,$sql);
            if(mysqli_num_rows($data)>0){
            
                echo "<table border=1 >";
                echo "<tr>";
                echo "<th>Title</th>";
                echo "<th>Description</th>";
                echo "<th>Start Date</th>";
                echo "<th>Result Date</th>";
                echo "</tr>";

                while($row=mysqli_fetch_assoc($data)){
                    $id = $row['election_id'];
                    echo "<tr>";
                    echo "<td>".$row['title']."</td>";
                    echo "<td>".$row['description']."</td>";
                    echo "<td>".$row['start_date']."</td>";
                    echo "<td>".$row['result_date']."</td>";
                    echo "<td>
                            <form method='POST'>
                                <button value='$id' name='electiondel' type='submit'>Delete</button>
                            </form>
                        </td>";
                    echo "<td><button>Edit</button></td>";
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

    if(isset($_POST['electiondel'])){
        $id = $_POST['electiondel'];
        if(!empty($_POST['electiondel'])){
            $sql = "DELETE FROM `election` WHERE `election_id`='$id'";
            $data = mysqli_query($conn, $sql);
            echo "<script>window.location.replace('../html/viewelection.php');</script>";
        }
    }
?>