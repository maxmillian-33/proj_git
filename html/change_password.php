<?php
// Ensure user is logged in, or use a session to track logged-in user
session_start();
$user_id = 6; // Example: this would normally come from the session data

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // If form is submitted, handle form logic here
    // Redirect to process_change_password.php for actual password update
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="pc.css"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="password-change-container">
        <h1>Change Password</h1>
        <form action="process_change_password.php" method="POST">
            <label for="current_password">Current Password:</label>
            <input type="password" name="current_password" required><br>

            <label for="new_password">New Password:</label>
            <input type="password" name="new_password" required><br>

            <label for="confirm_password">Confirm New Password:</label>
            <input type="password" name="confirm_password" required><br>

            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>"> <!-- Hidden field to pass the user ID -->

            <button type="submit">Change Password</button>
        </form>
    </div>
</body>
</html>
