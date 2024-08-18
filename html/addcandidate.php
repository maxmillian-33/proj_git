<html>
    <head>
        <title>Add Candidate</title>
        <link rel="stylesheet" href="../css/addcandidate.css">
    </head>
    <body>
        <nav class="AddCandidateNav">
            <h1 class="AddCandidateNavHeading">Online Election System</h1>
            <div class="AddCandidateNavContainer">
                <a href="admindashboard.php">Home</a>
            </div>
        </nav>
        <div class="AddCandidateContainer">
            <form class="AddCandidateForm" action="" method="post" name="registration">
                <h1 class="AddCandidateHeading">Add Candidate</h1>
                <input class="AddCandidateInput" type="text" name="name" placeholder="Enter your name">
                <input class="AddCandidateInput" type="email" name="email" placeholder="Enter your email">
                <input class="AddCandidateInput" type="number" name="phone" placeholder="Enter Your phone number">
                <input class="AddCandidateInput" type="password" name="password" placeholder="Enter your password">
                <input class="AddCandidateInput" type="password" name="confirm" placeholder="Confirm Password">
                <input class="AddCandidateSubmit" type="submit" value="Add Candidate" name="submit">
            </form>
        </div>
        <div class="AddCan">
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

<?php
    $conn = mysqli_connect("localhost", "root", "", "online_election_system");
    if(!$conn){
        echo "Database not connected";
    }
    if(isset($_POST['submit'])){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        // $user_type = $_POST['user_type'];
        $password = $_POST['password'];
        $confirm = $_POST['confirm'];

        if($password === $confirm){
            $sql = "INSERT INTO `candidates`(`name`, `email`, `phone`, `password`) VALUES ('$name','$email','$phone', '$password')";
            $data = mysqli_query($conn, $sql);
            $sql2 = "INSERT INTO `login`(`email`, `password`,`user_code`) VALUES ('$email','$password','0')";
            $data2 = mysqli_query($conn, $sql2);
            if($data){
                echo "<script>alert('Registration Completed')</script>";
                header('Location: addcandidate.php');
            }
            else{
                echo "<script>alert('Registration Not Completed')</script>";
            }
        }
        else{
            echo "<script>alert('Password Doesnot Match')</script>";
        }
    }
?>