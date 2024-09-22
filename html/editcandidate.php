<html>
    <head>
        <title>Edit Candidate</title>
        <link rel="stylesheet" href="../css/register.css">
    </head>
    <body>
        <nav class="RegisterNav">
            <h1 class="RegisterNavHeading">Edit Candidate</h1>
            <div class="RegisterNavContainer">
            <a href="viewcandidates.php"><img class="NavHomeImage" src="../images/home.png" alt="">Home</a>
            <!-- <a href="login.php"> <img class="NavLoginImage" src="../images/login.png" alt="">Login</a> -->
            <!-- <a href="register.php"><img class="NavRegisterImage" src="../images/register.png" alt="">Register </a> -->
            </div>
        </nav>
        <div class="RegisterContainer">
            <form class="RegisterForm" action="" method="post" name="registration">
                <h1 class="RegisterHeading">Edit Candidate</h1>
                <input class="RegisterInput" type="text" name="name" placeholder="name">
                <input class="RegisterInput" type="email" name="email" placeholder="Enter your email">
                <input class="RegisterInput" type="number" name="phone" placeholder="Enter Your phone number">
                <input class="RegisterSubmit" type="submit" value="Edit" name="submit">
            </form>
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

        // if($password === $confirm){
        //     $sql = "INSERT INTO `users`(`name`, `email`, `phone`, `password`) VALUES ('$name','$email','$phone', '$password')";
        //     $data = mysqli_query($conn, $sql);
        //     $sql2 = "INSERT INTO `login`(`email`, `password`,`user_code`) VALUES ('$email','$password','1')";
        //     $data2 = mysqli_query($conn, $sql2);
        //     if($data){
        //         echo "<script>alert('Registration Completed')</script>";
        //         header('Location: register.php');
        //         exit();
        //     }
        //     else{
        //         echo "<script>alert('Registration Not Completed')</script>";
        //     }
        // }
        // else{
        //     echo "<script>alert('Password Doesnot Match')</script>";
        // }

    }
?>