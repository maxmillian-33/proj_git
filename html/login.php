<?php
session_start(); // Start the session

require_once 'dbcon.php';

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare the SQL query to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM `login` WHERE `email` = ?");
    $stmt->bind_param("s", $email);  // 's' means the value is a string
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $value = $result->fetch_assoc();

        // Check the password directly (not secure)
        if ($value['password'] === $password) {
            // Store user details in the session
            $_SESSION['email'] = $email; // Store email
            $_SESSION['user_code'] = $value['user_code']; // Store user code

            // Redirect based on user type
            if ($value['user_code'] == 0) {
                header('Location: candidate_dashboard.php');
                exit();
            } else if ($value['user_code'] == 1) {
                header('Location: user_dashboard.php');
                exit();
            } else {
                header('Location: admindashboard.php');
                exit();
            }
        } else {
            echo "<script>alert('Incorrect Password')</script>";
        }
    } else {
        echo "<script>alert('User Not Found')</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/login.css">
</head>
<body class="dark33">
    <nav class="LoginNav">
        <h1 class="LoginNavHeading">Login</h1>
        <div class="LoginNavContainer">
            <a href="home.php">Home</a>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        </div>
    </nav>
    <div class="LoginContainer">
        <form class="LoginForm" action="" method="post" name="login">
            <h1 class="LoginHeading">Login</h1>
            <input class="LoginInput" type="email" name="email" placeholder="Enter your email" required>
            <input class="LoginInput" type="password" name="password" placeholder="Enter your password" required>
            <input class="LoginSubmit" type="submit" value="Login" name="login">
        </form>
    </div>
</body>
</html>
