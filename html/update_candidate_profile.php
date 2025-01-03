<?php
session_start();

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION['email']) || $_SESSION['user_code'] != 0) {
    header('Location: login.php');
    exit();
}

// Retrieve user information from the session
$email = $_SESSION['email'];

// Connect to the database
require_once 'dbcon.php';

// Retrieve candidate details
$sql = "SELECT * FROM `candidates` WHERE `email` = '$email'";
$result = mysqli_query($conn, $sql);
$candidate = mysqli_fetch_assoc($result);

if (!$candidate) {
    echo "<script>alert('Candidate details not found!')</script>";
    exit();
}

// Handle form submission for updating profile
if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $image = $_FILES['image'];

    // Handle file upload
    if ($image['error'] == 0) {
        $targetDir = "../uploads/";
        $targetFile = $targetDir . basename($image["name"]);
        move_uploaded_file($image["tmp_name"], $targetFile);
        $imageName = basename($image["name"]);
    } else {
        $imageName = $candidate['image']; // keep the old image if no new image is uploaded
    }

    // Update candidate details in the database
    $sql = "UPDATE `candidates` SET `name` = '$name', `phone` = '$phone', `image` = '$imageName' WHERE `email` = '$email'";
    $update = mysqli_query($conn, $sql);

    if ($update) {
        echo "<script>alert('Profile updated successfully!'); window.location.href='candidate_dashboard.php';</script>";
    } else {
        echo "<script>alert('Profile update failed!');</script>";
    }
}

// Handle password change
if (isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_new_password = $_POST['confirm_new_password'];

    // Verify the current password
    if ($candidate['password'] == $current_password) {
        if ($new_password === $confirm_new_password) {
            // Update the password in the login table
            $sql = "UPDATE `login` SET `password` = '$new_password' WHERE `email` = '$email'";
            $update_password = mysqli_query($conn, $sql);

            if ($update_password) {
                echo "<script>alert('Password changed successfully!');</script>";
            } else {
                echo "<script>alert('Password change failed!');</script>";
            }
        } else {
            echo "<script>alert('New passwords do not match!');</script>";
        }
    } else {
        echo "<script>alert('Current password is incorrect!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link rel="stylesheet" href="../css/update_candidate_profile.css"> <!-- Create this CSS file for styling -->
</head>
<body>

    <nav class="UpdateProfileNav">
        <h1 class="UpdateProfileHeading">Update Your Profile</h1>
        <div class="UpdateProfileNavContainer">
            <a href="candidate_dashboard.php">Dashboard</a>
            <a href="login.php">Logout</a>
        </div>
    </nav>

    <div class="UpdateProfileContainer">
        <form class="UpdateProfileForm" action="" method="post" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Enter your name" value="<?php echo htmlspecialchars($candidate['name']); ?>" required>
            <input type="email" name="email" placeholder="Enter your email" value="<?php echo htmlspecialchars($candidate['email']); ?>" readonly>
            <input type="number" name="phone" placeholder="Enter your phone number" value="<?php echo htmlspecialchars($candidate['phone']); ?>" required>
            <input type="file" name="image" placeholder="Upload profile picture">
            <input type="submit" value="Update Profile" name="update">
        </form>

        <!-- <h2>Change Password</h2>
        <form class="UpdatePasswordForm" action="" method="post">
            <input type="password" name="current_password" placeholder="Current Password" required>
            <input type="password" name="new_password" placeholder="New Password" required>
            <input type="password" name="confirm_new_password" placeholder="Confirm New Password" required>
            <input type="submit" value="Change Password" name="change_password">
        </form> -->
    </div>

</body>
</html>
