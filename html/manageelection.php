<?php
require_once 'dbcon.php';

if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $start_date = $_POST['start_date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $result_date = $_POST['result_date'];
    $result_time = $_POST['result_time']; // Retrieve this field

    // Insert the election with start time and end time
    $sql = "INSERT INTO election (title, description, start_date, start_time, end_time, result_date, result_time)
        VALUES ('$title', '$description', '$start_date', '$start_time', '$end_time', '$result_date', '$result_time')";
    
    $data = mysqli_query($conn, $sql);

    if ($data) {
        echo "<script>alert('Election Added')</script>";
    } else {
        echo "<script>alert('Election not Added')</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Election</title>
    <link rel="stylesheet" href="../css/manageelection.css">
</head>
<body class="dark33">
    <nav class="ManElectionNav">
        <h1 class="ManElectionNavHeading">Manage Election</h1>
        <div class="ManElectionNavContainer">
            <a href="admindashboard.php">Home</a>
            <a href="manageelection.php">Add Election</a>
            <a href="viewelection.php">View Election</a>
        </div>
    </nav>
    <div class="ManElectionContainer">
        <form class="ManElectionForm" action="" method="post" name="registration">
            <h1 class="ManElectionHeading">Add Election</h1>
            <input class="ManElectionInput" type="text" name="title" placeholder="Enter the title" required>
            <input class="ManElectionInput" type="text" name="description" placeholder="Enter the description" required>
            <input class="ManElectionInput" type="text" name="start_date" placeholder="Enter the starting date" onfocus="(this.type='date');" required>
            <input class="ManElectionInput" type="text" name="start_time" placeholder="Enter the starting time" onfocus="(this.type='time');" required>
            <input class="ManElectionInput" type="text" name="end_time" placeholder="Enter the ending time" onfocus="(this.type='time');" required>
            <input class="ManElectionInput" type="text" name="result_date" placeholder="Enter the result date" onfocus="(this.type='date');" required>
            <input class="ManElectionInput" type="text" name="result_time" placeholder="Enter the result time" onfocus="(this.type='time');" required>

            <input class="ManElectionSubmit" type="submit" value="Register" name="submit">
        </form>
    </div>
</body>
</html>
