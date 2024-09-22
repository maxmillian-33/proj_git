<html>
    <head>
        <title>Manage Election</title>
        <link rel="stylesheet" href="../css/manageelection.css">
    </head>
    <body>
        <nav class="ManElectionNav">
            <h1 class="ManElectionNavHeading">Manage Election</h1>
            <div class="ManElectionNavContainer">
            <a href="admindashboard.php"><img class="NavHomeImage" src="../images/home.png" alt="">Home</a>
            <a href="manageelection.php"><img src="../images/add_election.png" alt="" class="NavAddElecImage"> Add Election</a>
                <a href="viewelection.php">View Election</a>
            </div>
        </nav>
        <div class="ManElectionContainer">
            <form class="ManElectionForm" action="" method="post" name="registration">
                <h1 class="ManElectionHeading">Add Election</h1>
                <input class="ManElectionInput" type="text" name="title" placeholder="Enter the title">
                <input class="ManElectionInput" type="text" name="description" placeholder="Enter the description">
                <input class="ManElectionInput" type="text" name="start_date" placeholder="Enter the starting date" onfocus="(this.type='date')">
                <input class="ManElectionInput" type="text" name="result_date" placeholder="Enter the result date" onfocus="(this.type='date')">
                
                <input class="ManElectionSubmit" type="submit" value="Register" name="submit">
            </form>
        </div>
    </body>
</html><?php
    $conn = mysqli_connect("localhost", "root", "", "online_election_system");
    if(!$conn){
        echo "Database not connected";
    }
    if(isset($_POST['submit'])){
        $title = $_POST['title'];
        $description = $_POST['description'];
        $start_date = $_POST['start_date'];
        $result_date = $_POST['result_date'];

        $sql = "INSERT INTO `election`(`title`, `description`, `start_date`, `result_date`) VALUES ('$title','$description','$start_date', '$result_date')";
        $data = mysqli_query($conn, $sql);

        if($data){
            echo "<script>alert('Election Added')</script>";
        }
        else{
            echo "<script>alert('Election not Added')</script>";
        }
    }
?>