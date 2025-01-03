<?php
session_start();

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

// Retrieve user information from the session
$email = $_SESSION['email'];
$user_code = $_SESSION['user_code'];

// Connect to the database
require_once 'dbcon.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Verify current password
    $password_query = "SELECT `password` FROM `login` WHERE `email` = '$email'";
    $password_result = mysqli_query($conn, $password_query);
    $password_row = mysqli_fetch_assoc($password_result);

    if ($password_row['password'] === $current_password) {
        if ($new_password === $confirm_password) {
            // Update the password in the login table
            $update_login_query = "UPDATE `login` SET `password` = '$new_password' WHERE `email` = '$email'";
            mysqli_query($conn, $update_login_query);

            // Update the password in the appropriate table based on user_code
            if ($user_code == 0) {
                // Candidate
                $update_candidate_query = "UPDATE `candidates` SET `password` = '$new_password' WHERE `email` = '$email'";
                mysqli_query($conn, $update_candidate_query);
            } else if ($user_code == 1) {
                // User
                $update_user_query = "UPDATE `users` SET `password` = '$new_password' WHERE `email` = '$email'";
                mysqli_query($conn, $update_user_query);
            }
            if ($user_code == 0){
                echo "<script>alert('Password changed successfully!'); window.location.href='candidate_dashboard.php';</script>";
            }
            else if($user_code == 1){
                echo "<script>alert('Password changed successfully!'); window.location.href='user_dashboard.php';</script>";
            }
        } else {
            echo "<script>alert('New passwords do not match.');</script>";
        }
    } else {
        echo "<script>alert('Current password is incorrect.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="../css/change_password.css">
</head>
<body>

    <nav class="ChangePasswordNav">
        <h1>Change Password</h1>
        <a href="<?php echo $user_code == 0 ? 'candidate_dashboard.php' : 'user_profile.php'; ?>">Back to Profile</a>
    </nav>

    <div class="ChangePasswordContainer">
        <form action="" method="post" class="ChangePasswordForm">
            <label for="current_password">Current Password:</label>
            <input type="password" name="current_password" required>
            
            <label for="new_password">New Password:</label>
            <input type="password" name="new_password" required>

            <label for="confirm_password">Confirm New Password:</label>
            <input type="password" name="confirm_password" required>

            <input type="submit" value="Change Password">
        </form>
    </div>

</body>
</html>
