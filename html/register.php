<html>
    <head>
        <title>Register</title>
        <link rel="stylesheet" href="../css/register.css">
    </head>
    <body>
        <nav class="RegisterNav">
            <h1 class="RegisterNavHeading">Register</h1>
            <div class="RegisterNavContainer">
                <a href="home.html">Home</a>
                <a href="login.html">Login</a>
                <a href="register.php">Register</a>
            </div>
        </nav>
        <div class="RegisterContainer">
            <form class="RegisterForm" action="" method="post" name="registration">
                <h1 class="RegisterHeading"><u>Register</u></h1>
                <input class="RegisterInput" type="text" name="name" placeholder="Enter your name">
                <input class="RegisterInput" type="email" name="email" placeholder="Enter your email">
                <input class="RegisterInput" type="number" name="phone" placeholder="Enter Your phone number">
                <input class="RegisterInput" type="password" name="password" placeholder="Enter your password">
                <input class="RegisterInput" type="password" name="confirm" placeholder="Confirm Password">
                <input class="RegisterSubmit" type="submit" value="Register" name="submit">
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
        $password = $_POST['password'];
        $confirm = $_POST['confirm'];

        if($password === $confirm){
            $sql = "INSERT INTO `users`(`name`, `email`, `phone`, `password`) VALUES ('$name','$email','$phone','$password')";
            $data = mysqli_query($conn, $sql);

            if($data){
                echo "<script>alert('Registration Completed')</script>";
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