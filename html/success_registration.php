<?php
session_start();
// Optionally clear the registration session variables if needed
unset($_SESSION['registration_success']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Successful</title>
    <link rel="stylesheet" href="../css/success_registration.css">
</head>
<body>
    <div class="success-container">
        <h1>Registration Successful!</h1>
        <p>Your account has been created successfully. You can now log in to your account.</p>
        <a href="login.php" class="login-button">Go to Login</a>
    </div>
</body>
</html>
