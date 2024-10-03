<?php
session_start();

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION['email']) || $_SESSION['user_code'] != 1) {
    header('Location: login.php');
    exit();
}

// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "online_election_system");
if (!$conn) {
    echo "Database not connected";
    exit();
}

// Retrieve user information from the session
$email = $_SESSION['email'];

// Retrieve user details
$sql = "SELECT * FROM `users` WHERE `email` = '$email'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

// Update profile logic
if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];

    // Handle profile picture upload
    if ($_FILES['image']['name']) {
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["image"]["tmp_name"]);

        if ($check !== false) {
            // Move the uploaded file to the uploads directory
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image_path = basename($_FILES["image"]["name"]);
                // Update user details in the database
                $update_sql = "UPDATE `users` SET `name` = '$name', `phone` = '$phone', `image` = '$image_path' WHERE `email` = '$email'";
            } else {
                echo "<script>alert('Sorry, there was an error uploading your file.')</script>";
            }
        } else {
            echo "<script>alert('File is not an image.')</script>";
        }
    } else {
        // Update user details without changing the image
        $update_sql = "UPDATE `users` SET `name` = '$name', `phone` = '$phone' WHERE `email` = '$email'";
    }

    // Execute the update query
    if (mysqli_query($conn, $update_sql)) {
        echo "<script>alert('Profile updated successfully!');</script>";
        // Refresh user information
        $result = mysqli_query($conn, $sql);
        $user = mysqli_fetch_assoc($result);
    } else {
        echo "<script>alert('Error updating profile: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link rel="stylesheet" href="../css/update_candidate_profile.css">
</head>
<body>

    <nav class="UpdateProfileNav">
        <h1 class="UpdateProfileHeading">Update Your Profile</h1>
        <div class="UpdateProfileNavContainer">
            <a href="user_dashboard.php">Back to Dashboard</a>
            <a href="login.php">Logout</a>
        </div>
    </nav>

    <div class="UpdateProfileContainer">
        <form class="UpdateProfileForm" action="" method="post" enctype="multipart/form-data">
            <h2>Edit Your Information</h2>
            <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
            <input type="number" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
            <input type="file" name="image" accept="image/*">
            <input type="submit" value="Update Profile" name="update">
        </form>
    </div>

</body>
</html>
