<html lang="en">
    <head>
        <title>Manage Users</title>
        <link rel="stylesheet" href="../css/managevoters.css">
    </head>
    <body class="dark33">
        <nav class="ManVotersNav">
            <h1 class="ManVotersNavHeading">Manage Voters</h1>
            <div class="ManVotersNavContainer">
                <a href="admindashboard.php">Home</a>
            </div>
        </nav>
        <div class="ManVotersBodyContainer">
            <h1 class="ManVotersHeading">Voters</h1>

            <!-- Search Form -->
            <form method="POST" class="ManVotersSearchForm">
                <input type="text" name="search_name" placeholder="Search by name" class="ManVotersSearchInput">
                <input type="submit" name="search" value="Search" class="ManVotersSearchButton">
            </form>

            <?php
                require_once 'dbcon.php';

                // Initialize the query
                $sql = "SELECT * FROM `users`";

                // Check if the search button is clicked and a search term is provided
                if (isset($_POST['search']) && !empty($_POST['search_name'])) {
                    $search_name = $_POST['search_name'];
                    // Modify the query to filter by name
                    $sql .= " WHERE `name` LIKE '%$search_name%'";
                }

                $data = mysqli_query($conn, $sql);

                if (mysqli_num_rows($data) > 0) {
                    echo "<table class='ManVotersTable'>";
                    echo "<tr><th>Name</th><th>Email</th><th>Phone Number</th><th>User ID</th><th>Action</th></tr>";

                    while ($row = mysqli_fetch_assoc($data)) {
                        $email = $row['email'];
                        echo "<tr>";
                        echo "<td>".$row['name']."</td>";
                        echo "<td>".$row['email']."</td>";
                        echo "<td>".$row['phone']."</td>";
                        echo "<td>".$row['user_id']."</td>";
                        echo "<td>
                            <form method='POST'>
                                <button value='$email' name='userdel' type='submit' class='ManVotersDeleteButton'>Delete</button>
                            </form>
                        </td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>No voters found matching the search criteria.</p>";
                }
            ?>
        </div>
    </body>
</html>

<?php
    // Handle user deletion
    if (isset($_POST['userdel'])) {
        $email = $_POST['userdel'];
        if (!empty($email)) {
            $sql = "DELETE FROM `users` WHERE `email`='$email'";
            $data = mysqli_query($conn, $sql);
            $sql1 = "DELETE FROM `login` WHERE `email`='$email'";
            $data1 = mysqli_query($conn, $sql1);
            echo "<script>window.location.replace('managevoters.php');</script>";
        }
    }
?>
