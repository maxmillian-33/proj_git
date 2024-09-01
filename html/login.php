<html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" href="../css/login.css">
    </head>
    <body>
        <nav class="LoginNav">
            <h1 class="LoginNavHeading">Login</h1>
            <div class="LoginNavContainer">
            <a href="home.html"><img class="NavHomeImage" src="../images/home.png" alt="">Home</a>
            <!-- <a href="login.php"> <img class="NavLoginImage" src="../images/login.png" alt="">Login</a> -->
            <a href="register.php"><img class="NavRegisterImage" src="../images/register.png" alt="">Register </a>
            </div>
        </nav>
        <div class="LoginContainer">
            <form class="LoginForm" action="" method="post" name="login">
                <h1 class="LoginHeading">Login</h1>
                <input class="LoginInput" type="email" name="email" placeholder="Enter your email">
                <input class="LoginInput" type="password" name="password" placeholder="Enter your password">
                <input class="LoginSubmit" type="submit" value="Login" name="login">
            </form>
        </div>
    </body>
</html>
<?php
    $conn = mysqli_connect("localhost", "root", "", "online_election_system");
    if(!$conn){
        echo "Database not connected";
    }

    if(isset($_POST['login'])){
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM `login` WHERE `email`='$email' AND `password`='$password'";

        $data = mysqli_query($conn, $sql);

        if($data){
            $row = mysqli_num_rows($data);
            if($row > 0){
                $value = mysqli_fetch_assoc($data);
                if($value['user_code'] == 0){
                    header('Location: candidatedashboard.html');
                    exit();
                }
                else if($value['user_code'] == 1){
                    header('Location: userdashboard.html');
                    exit();
                }
                else{
                    header('Location: admindashboard.php');
                    exit();
                }
            } else {
                echo "<script>alert('User Not Found')</script>";
            }
        } else {
            echo "<script>alert('Query Failed')</script>";
        }
    }
?>
