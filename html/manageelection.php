<html>
    <head>
        <title>Manage Election</title>
        <link rel="stylesheet" href="../css/register.css">
    </head>
    <body>
        <nav class="ManElectionNav">
            <h1 class="ManElectionNavHeading">Manage Election</h1>
            <div class="ManElectionNavContainer">
                <a href="admindashboard.php">Home</a>
            </div>
        </nav>
        <div class="ManElectionContainer">
            <form class="ManElectionForm" action="" method="post" name="registration">
                <h1 class="ManElectionHeading">Add Election</h1>
                <input class="ManElectionInput" type="text" name="title" placeholder="Enter the title">
                <input class="ManElectionInput" type="text" name="description" placeholder="Enter the description">
                <input class="ManElectionInput" type="date" name="start_date">
                <input class="ManElectionInput" type="date" name="end_date">
                
                <input class="ManElectionSubmit" type="submit" value="Register" name="submit">
            </form>
        </div>
    </body>
</html>