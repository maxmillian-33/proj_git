<html>
<head>
    <title>Add Candidate</title>
    <link rel="stylesheet" href="../css/addcandidate.css">
</head>
<body>
    <nav class="AddCandidateNav">
        <h1 class="AddCandidateNavHeading">Add Candidate</h1>
        <div class="AddCandidateNavContainer">
            <a href="admindashboard.php"><img class="NavHomeImage" src="../images/home.png" alt="">Home</a>
            <a href="addcandidate.php"><img class="NavAddCanImage" src="../images/add_candidates.png" alt=""><u>Add Candidate</u></a>
            <a href="viewcandidates.php"><img class="NavViewCanImage" src="../images/view_candidate.png" alt="">View Candidates</a>
        </div>
    </nav>
    <div class="AddCandidateContainer">
        <form class="AddCandidateForm" action="" method="post" name="registration" enctype="multipart/form-data">
            <h1 class="AddCandidateHeading">Add Candidate</h1>
            <input class="AddCandidateInput" type="text" name="name" placeholder="Enter your name" required>
            <input class="AddCandidateInput" type="email" name="email" placeholder="Enter your email" required>
            <input class="AddCandidateInput" type="number" name="phone" placeholder="Enter Your phone number" required>
            <input class="AddCandidateInput" type="password" name="password" placeholder="Enter your password" required>
            <input class="AddCandidateInput" type="password" name="confirm" placeholder="Confirm Password" required>
            <input class="AddCandidateInput" type="file" name="image" accept="image/*" required>
            <input class="AddCandidateSubmit" type="submit" value="Add Candidate" name="submit">
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

    // Handle the image upload
    $image = $_FILES['image']['name'];
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($image);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES['image']['tmp_name']);
    if ($check === false) {
        echo "<script>alert('File is not an image.')</script>";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "<script>alert('Sorry, file already exists.')</script>";
        $uploadOk = 0;
    }

    // Check file size (optional)
    if ($_FILES['image']['size'] > 500000) { // Limit file size to 500KB
        echo "<script>alert('Sorry, your file is too large.')</script>";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.')</script>";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "<script>alert('Sorry, your file was not uploaded.')</script>";
    } else {
        // If everything is ok, try to upload file
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            if ($password === $confirm) {
                $sql = "INSERT INTO `candidates`(`name`, `email`, `phone`, `password`, `image`) VALUES ('$name','$email','$phone', '$password', '$image')";
                $data = mysqli_query($conn, $sql);
                $sql2 = "INSERT INTO `login`(`email`, `password`,`user_code`) VALUES ('$email','$password','0')";
                $data2 = mysqli_query($conn, $sql2);
                if ($data) {
                    echo "<script>alert('Registration Completed')</script>";
                    header('Location: addcandidate.php');
                } else {
                    echo "<script>alert('Registration Not Completed')</script>";
                }
            } else {
                echo "<script>alert('Password Does not Match')</script>";
            }
        } else {
            echo "<script>alert('Sorry, there was an error uploading your file.')</script>";
        }
    }
}
?>
