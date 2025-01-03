<html>

<head>
    <title>Register</title>
    <link rel="stylesheet" href="../css/register.css">
</head>

<body>
    <nav class="RegisterNav">
        <h1 class="RegisterNavHeading">Register</h1>
        <div class="RegisterNavContainer">
            <a href="home.php">Home</a>
            <a href="login.php"> Login</a>
            <a href="register.php">Register </a>
        </div>
    </nav>
    <div class="RegisterContainer">
        <form class="RegisterForm" action="" method="post" name="registration" enctype="multipart/form-data">
            <h1 class="RegisterHeading">Register</h1>
            <input class="RegisterInput" type="text" name="name" placeholder="Enter your name" required>
            <input class="RegisterInput" type="email" name="email" placeholder="Enter your email" required>
            <input class="RegisterInput" type="number" name="phone" placeholder="Enter Your phone number" required>
            <input class="RegisterInput" type="password" name="password" placeholder="Enter your password" required>
            <input class="RegisterInput" type="password" name="confirm" placeholder="Confirm Password" required>

            <!-- Hidden File Input -->
            <input id="profile_pic" class="RegisterInput" type="file" name="profile_pic" accept="image/*" style="display: none;" required>

            <!-- Custom Label for File Input -->
            <label for="profile_pic" class="CustomFileInput">Choose Profile Picture</label>

            <input class="RegisterSubmit" type="submit" value="Register" name="submit">
        </form>
    </div>
</body>

</html>

<?php
require_once 'dbcon.php';

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    // Check if passwords match
    if ($password === $confirm) {
        $profilePicName = "default.png"; // Default image name

        // Handle file upload if provided
        if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == UPLOAD_ERR_OK) {
            $profilePic = $_FILES['profile_pic'];
            $targetDir = "../uploads/"; // Directory to save uploaded files
            $targetFile = $targetDir . basename($profilePic['name']);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            // Check if image file is an actual image or fake image
            $check = getimagesize($profilePic["tmp_name"]);
            if ($check !== false) {
                // Check file size (limit to 2MB)
                if ($profilePic["size"] > 2000000) {
                    echo "<script>alert('Sorry, your file is too large. Maximum size is 2MB.')</script>";
                    $uploadOk = 0;
                }
            } else {
                echo "<script>alert('File is not an image.')</script>";
                $uploadOk = 0;
            }

            // Allow certain file formats
            if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
                echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.')</script>";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 1) {
                // Try to upload file
                if (move_uploaded_file($profilePic["tmp_name"], $targetFile)) {
                    $profilePicName = basename($profilePic['name']);
                } else {
                    echo "<script>alert('Sorry, there was an error uploading your file.')</script>";
                }
            }
        }

        // Insert user details into the database
        $sql = "INSERT INTO `users`(`name`, `email`, `phone`, `password`, `image`) VALUES ('$name','$email','$phone', '$password', '$profilePicName')";
        $data = mysqli_query($conn, $sql);
        $sql2 = "INSERT INTO `login`(`email`, `password`, `user_code`) VALUES ('$email','$password','1')";
        $data2 = mysqli_query($conn, $sql2);

        if ($data) {
            echo "<script>alert('Registration Completed')</script>";
            header('Location: success_registration.php');
            exit();
        } else {
            echo "<script>alert('Registration Not Completed')</script>";
        }
    } else {
        echo "<script>alert('Password Does not Match')</script>";
    }
}
?>